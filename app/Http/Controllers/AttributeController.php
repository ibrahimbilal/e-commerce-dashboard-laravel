<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
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

    public function index()
    {
        $attributeList = Attribute::orderBy('attribute_key')->paginate(20);

        return view('attributes.index', compact('attributeList'));
    }

    public function create()
    {
        return view('attributes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'attribute_key' => ['required', 'string', 'max:100'],
            'attribute_value' => ['required', 'string', 'max:100'],
        ]);

        $attribute = Attribute::create($data);

        return redirect()->route('attributes.index')->with('status', 'Attribute created.');
    }

    public function show(Attribute $attribute)
    {
        $attribute->load(['productAttributesAsFirst.product', 'productAttributesAsSecond.product']);

        return view('attributes.show', compact('attribute'));
    }

    public function edit(Attribute $attribute)
    {
        return view('attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $data = $request->validate([
            'attribute_key' => ['required', 'string', 'max:100'],
            'attribute_value' => ['required', 'string', 'max:100'],
        ]);

        $attribute->update($data);

        return redirect()->route('attributes.index')->with('status', 'Attribute updated.');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()->route('attributes.index')->with('status', 'Attribute deleted.');
    }
}
