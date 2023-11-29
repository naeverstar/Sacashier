<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('item', [
            'categories'    => Category::all(),
            'items'         => Item::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = [
            'required'  => ':attribute need to be filled',
            'min'       => ':attribute minimum :min character',
            'max'       => ':attribute maximal :max character',
        ];

        $validationData = $request->validate([
            'category_id'   => 'required',
            'name'          => 'required|min:2|max:20',
            'price'         => 'required',
            'stock'         => 'required',
        ], $message);

        Item::create($validationData);

        return redirect()->back()->with('success', 'Successfully added Item');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $item = Item::find($item->id);
        return $item;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $message = [
            'required'  => ':attribute need to be filled',
            'min'       => ':attribute minimum :min character',
            'max'       => ':attribute maximal :max character',
        ];

        $validationData = $request->validate([
            'category_id'   => 'required',
            'name'          => 'required|min:2|max:20',
            'price'         => 'required',
            'stock'         => 'required',
        ], $message);

        Item::where('id', $item->id)->update($validationData);

        return redirect()->back()->with('success', 'Successfully edited Item');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        Item::find($item->id)->delete();

        return redirect()->back()->with('success', 'Successfully deleted Item');
    }
}
