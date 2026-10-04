<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Concerns\ManagesTrashedRecords;
use App\Models\Attribute;
use App\Support\AdminFormResponse;
use App\Support\AdminResourceCounts;
use App\Support\AttributeTermSync;
use App\Support\IndexListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AttributeController extends Controller
{
    use ManagesTrashedRecords;

    public function __construct()
    {
        $this->middleware('permission:view attributes', ['only' => ['index', 'show']]);
        $this->middleware('permission:add attributes', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit attributes', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete attributes', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $filterKeys = ['search'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Attribute::query()->count(),
        ];

        $query = Attribute::query()->orderBy('attribute_key');

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('attribute_key', 'like', '%'.$search.'%')
                    ->orWhere('attribute_value', 'like', '%'.$search.'%');
            });
        }

        $attributeList = $query->get();

        return view('admin.attributes.index', compact('attributeList', 'counts', 'filters'));
    }

    public function create()
    {
        return view('admin.attributes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            AttributeTermSync::termRules(),
            [],
            AttributeTermSync::validationAttributeNames()
        );

        AttributeTermSync::assertColorValues($validated);
        AttributeTermSync::assertAttributeKeyAvailableForStore($validated['attribute_key']);

        DB::transaction(function () use ($validated) {
            AttributeTermSync::storeTerms($validated);
        });

        return AdminFormResponse::saved(
            $request,
            'Attribute created.',
            fn () => redirect()->route('admin.attributes.index')
        );
    }

    public function show(Attribute $attribute)
    {
        $attribute->load(['productAttributesAsFirst.product', 'productAttributesAsSecond.product']);

        return view('admin.attributes.show', compact('attribute'));
    }

    public function edit(Attribute $attribute)
    {
        $terms = Attribute::query()
            ->where('attribute_key', $attribute->attribute_key)
            ->orderBy('id')
            ->get();

        return view('admin.attributes.edit', compact('attribute', 'terms'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $siblings = Attribute::query()
            ->where('attribute_key', $attribute->attribute_key)
            ->orderBy('id')
            ->get();

        AttributeTermSync::assertTermIdsAreSiblings($request, $siblings->pluck('id')->all());

        $validated = $request->validate(
            AttributeTermSync::termRules(),
            [],
            AttributeTermSync::validationAttributeNames()
        );

        AttributeTermSync::assertColorValues($validated);

        AttributeTermSync::syncUpdate($attribute, $validated);

        return AdminFormResponse::saved(
            $request,
            'Attribute updated.',
            fn () => redirect()->route('admin.attributes.index')
        );
    }

    public function destroy(Request $request, Attribute $attribute)
    {
        try {
            AttributeTermSync::assertDestroyAllowed($attribute);
        } catch (ValidationException $exception) {
            if ($request->expectsJson()) {
                throw $exception;
            }

            return redirect()
                ->back()
                ->withErrors($exception->errors());
        }

        $attribute->delete();

        return $this->destroyActionResponse(
            $request,
            'admin.attributes.index',
            'Attribute deleted.',
            AdminResourceCounts::attributes()
        );
    }
}
