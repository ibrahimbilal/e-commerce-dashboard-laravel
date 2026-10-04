<?php

namespace App\Support;

use App\Models\Attribute;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AttributeTermSync
{
    /**
     * @return array<string, mixed>
     */
    public static function termRules(): array
    {
        return [
            'attribute_key' => ['required', 'string', 'max:100'],
            'terms' => ['required', 'array', 'min:1'],
            'terms.*.id' => ['nullable', 'integer'],
            'terms.*.title' => ['required', 'string', 'max:100'],
            'terms.*.type' => ['required', 'string', Rule::in(['text', 'color'])],
            'terms.*.value' => ['required', 'string', 'max:100'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function validationAttributeNames(): array
    {
        return [
            'attribute_key' => __('validation.attributes.attribute_key'),
            'terms' => __('validation.attributes.terms'),
            'terms.*.id' => __('validation.attributes.term_id'),
            'terms.*.title' => __('validation.attributes.term_title'),
            'terms.*.type' => __('validation.attributes.term_type'),
            'terms.*.value' => __('validation.attributes.term_value'),
        ];
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    public static function assertColorValues(array $validated): void
    {
        $messages = [];

        foreach ($validated['terms'] as $index => $term) {
            if (($term['type'] ?? '') !== 'color') {
                continue;
            }

            $value = (string) ($term['value'] ?? '');
            if (! preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $value)) {
                $messages["terms.{$index}.value"] = [__('validation.custom.terms.value.color_hex')];
            }
        }

        if ($messages !== []) {
            throw ValidationException::withMessages($messages);
        }
    }

    public static function assertAttributeKeyAvailableForStore(string $attributeKey): void
    {
        if (Attribute::query()->where('attribute_key', $attributeKey)->exists()) {
            throw ValidationException::withMessages([
                'attribute_key' => [__('validation.custom.attribute_key.duplicate')],
            ]);
        }
    }

    /**
     * @param  array<int, int>  $siblingIds
     */
    public static function assertAttributeKeyAvailableForUpdate(string $newKey, Attribute $attribute, array $siblingIds): void
    {
        if ($newKey === $attribute->attribute_key) {
            return;
        }

        $conflict = Attribute::query()
            ->where('attribute_key', $newKey)
            ->whereNotIn('id', $siblingIds)
            ->exists();

        if ($conflict) {
            throw ValidationException::withMessages([
                'attribute_key' => [__('validation.custom.attribute_key.duplicate')],
            ]);
        }
    }

    /**
     * @param  array<int, int>  $siblingIds
     */
    public static function assertTermIdsAreSiblings(Request $request, array $siblingIds): void
    {
        $messages = [];

        foreach ((array) $request->input('terms', []) as $index => $term) {
            if (! is_array($term) || empty($term['id'])) {
                continue;
            }

            if (! in_array((int) $term['id'], $siblingIds, true)) {
                $messages["terms.{$index}.id"] = [__('validation.custom.terms.id.invalid')];
            }
        }

        if ($messages !== []) {
            throw ValidationException::withMessages($messages);
        }
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    public static function storeTerms(array $validated): void
    {
        foreach ($validated['terms'] as $term) {
            Attribute::query()->create(self::termToRow($validated['attribute_key'], $term));
        }
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    public static function syncUpdate(Attribute $attribute, array $validated): void
    {
        $originalKey = $attribute->attribute_key;
        $siblings = Attribute::query()->where('attribute_key', $originalKey)->get();
        $siblingIds = $siblings->pluck('id')->all();
        $newKey = $validated['attribute_key'];

        self::assertAttributeKeyAvailableForUpdate($newKey, $attribute, $siblingIds);

        $postedIds = collect($validated['terms'])
            ->pluck('id')
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->all();

        foreach ($siblings->whereNotIn('id', $postedIds) as $removed) {
            self::assertTermNotUsedOnVariants($removed);
        }

        DB::transaction(function () use ($validated, $newKey, $postedIds, $siblings) {
            foreach ($siblings->whereNotIn('id', $postedIds) as $removed) {
                $removed->delete();
            }

            foreach ($validated['terms'] as $term) {
                $row = self::termToRow($newKey, $term);

                if (! empty($term['id'])) {
                    Attribute::query()->whereKey($term['id'])->update($row);

                    continue;
                }

                Attribute::query()->create($row);
            }
        });
    }

    public static function assertTermNotUsedOnVariants(Attribute $term): void
    {
        $used = ProductAttribute::query()
            ->where(function ($query) use ($term) {
                $query->where('attribute_1_id', $term->id)
                    ->orWhere('attribute_2_id', $term->id);
            })
            ->exists();

        if (! $used) {
            return;
        }

        $label = $term->term_title ?: $term->attribute_value;

        throw ValidationException::withMessages([
            'terms' => [__('validation.custom.terms.in_use', ['term' => $label])],
        ]);
    }

    public static function assertDestroyAllowed(Attribute $attribute): void
    {
        self::assertTermNotUsedOnVariants($attribute);
    }

    /**
     * @param  array<string, mixed>  $term
     * @return array<string, mixed>
     */
    private static function termToRow(string $attributeKey, array $term): array
    {
        return [
            'attribute_key' => $attributeKey,
            'attribute_value' => $term['value'],
            'term_title' => $term['title'],
            'term_type' => $term['type'],
        ];
    }
}
