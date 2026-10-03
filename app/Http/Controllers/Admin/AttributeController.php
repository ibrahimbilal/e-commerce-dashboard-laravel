<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Attribute;
use App\Support\IndexListing;
use App\Support\ReferentialDeleteGuard;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
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
        $data = $request->validate([
            'attribute_key' => ['required', 'string', 'max:100'],
            'attribute_value' => ['required', 'string', 'max:100'],
        ]);

        $attribute = Attribute::create($data);

        return redirect()->route('admin.attributes.index')->with('status', 'Attribute created.');
    }

    public function show(Attribute $attribute)
    {
        $attribute->load(['productAttributesAsFirst.product', 'productAttributesAsSecond.product']);

        return view('admin.attributes.show', compact('attribute'));
    }

    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $data = $request->validate([
            'attribute_key' => ['required', 'string', 'max:100'],
            'attribute_value' => ['required', 'string', 'max:100'],
        ]);

        $attribute->update($data);

        return redirect()->route('admin.attributes.index')->with('status', 'Attribute updated.');
    }

    public function destroy(Request $request, Attribute $attribute)
    {
        if ($blocked = ReferentialDeleteGuard::blockIfInUse(
            $request,
            $attribute,
            'Cannot delete this attribute because it is used on order line items.'
        )) {
            return $blocked;
        }

        $attribute->delete();

        return redirect()->route('admin.attributes.index')->with('status', 'Attribute deleted.');
    }
}
