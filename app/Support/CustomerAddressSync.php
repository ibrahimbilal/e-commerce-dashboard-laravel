<?php

namespace App\Support;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CustomerAddressSync
{
    /**
     * @return array<string, mixed>
     */
    public static function customerRules(): array
    {
        return [
            'addresses_sync' => ['sometimes', 'boolean'],
            'addresses' => ['nullable', 'array'],
            'addresses.*.id' => ['nullable', 'integer'],
            'addresses.*.address_title' => ['nullable', 'string', 'max:100'],
            'addresses.*.mobile' => ['nullable', 'string', 'max:50'],
            'addresses.*.country' => ['nullable', 'string', 'max:100'],
            'addresses.*.state' => ['nullable', 'string', 'max:100'],
            'addresses.*.city' => ['nullable', 'string', 'max:100'],
            'addresses.*.address_1' => ['nullable', 'string', 'max:100'],
            'addresses.*.address_2' => ['nullable', 'string', 'max:100'],
            'addresses.*.postcode' => ['nullable', 'string', 'max:5'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function validationAttributeNames(): array
    {
        return [
            'addresses' => __('validation.attributes.addresses'),
            'addresses.*.id' => __('validation.attributes.address_id'),
            'addresses.*.address_title' => __('validation.attributes.address_title'),
            'addresses.*.mobile' => __('validation.attributes.address_mobile'),
            'addresses.*.country' => __('validation.attributes.address_country'),
            'addresses.*.state' => __('validation.attributes.address_state'),
            'addresses.*.city' => __('validation.attributes.address_city'),
            'addresses.*.address_1' => __('validation.attributes.address_1'),
            'addresses.*.address_2' => __('validation.attributes.address_2'),
            'addresses.*.postcode' => __('validation.attributes.address_postcode'),
        ];
    }

    public static function assertAddressIdsBelongToCustomer(Request $request, Customer $customer): void
    {
        $messages = [];

        foreach ((array) $request->input('addresses', []) as $index => $row) {
            if (! is_array($row) || empty($row['id'])) {
                continue;
            }

            $belongs = Address::query()
                ->where('customer_id', $customer->id)
                ->whereKey($row['id'])
                ->exists();

            if (! $belongs) {
                $messages["addresses.{$index}.id"] = [__('validation.custom.addresses.id.invalid')];
            }
        }

        if ($messages !== []) {
            throw ValidationException::withMessages($messages);
        }
    }

    public static function shouldSync(Request $request): bool
    {
        if ($request->has('addresses')) {
            return true;
        }

        return $request->has('addresses_sync') && $request->boolean('addresses_sync');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function normalizedRows(Request $request): array
    {
        $rows = $request->input('addresses', []);

        if (! is_array($rows)) {
            return [];
        }

        return array_values(array_filter($rows, function ($row) {
            return is_array($row) && ! self::isEmptyRow($row);
        }));
    }

    /**
     * @param  array<string, mixed>  $row
     */
    public static function isEmptyRow(array $row): bool
    {
        if (! empty($row['id'])) {
            return false;
        }

        foreach (['address_title', 'mobile', 'country', 'state', 'city', 'address_1', 'address_2', 'postcode'] as $field) {
            if (filled($row[$field] ?? null)) {
                return false;
            }
        }

        return true;
    }

    public static function syncForCustomer(Customer $customer, Request $request): void
    {
        if (! self::shouldSync($request)) {
            return;
        }

        $rows = self::normalizedRows($request);
        $keptIds = [];

        foreach ($rows as $row) {
            $payload = self::addressPayload($row);

            if (! empty($row['id'])) {
                Address::query()
                    ->where('customer_id', $customer->id)
                    ->whereKey($row['id'])
                    ->update($payload);
                $keptIds[] = (int) $row['id'];

                continue;
            }

            $created = $customer->addresses()->create($payload);
            $keptIds[] = $created->id;
        }

        Address::query()
            ->where('customer_id', $customer->id)
            ->when($keptIds !== [], fn ($query) => $query->whereNotIn('id', $keptIds))
            ->delete();
    }

    public static function createForCustomer(Customer $customer, Request $request): void
    {
        foreach (self::normalizedRows($request) as $row) {
            $customer->addresses()->create(self::addressPayload($row));
        }
    }

    /**
     * @param  array<string, mixed>  $row
     * @return array<string, mixed>
     */
    private static function addressPayload(array $row): array
    {
        return [
            'address_title' => $row['address_title'] ?? null,
            'mobile' => $row['mobile'] ?? null,
            'country' => $row['country'] ?? null,
            'state' => $row['state'] ?? null,
            'city' => $row['city'] ?? null,
            'address_1' => $row['address_1'] ?? null,
            'address_2' => $row['address_2'] ?? null,
            'postcode' => $row['postcode'] ?? null,
        ];
    }
}
