<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('category', compact('categories'));
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
            'name' => 'required|min:2|max:20'
        ], $message);

        Category::create($validationData);

        return redirect()->back()->with('success', 'Successfully added Category');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $category = Category::find($category->id);
        return $category;
        // dd($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $message = [
            'required'  => ':attribute need to be filled',
            'min'       => ':attribute minimum :min character',
            'max'       => ':attribute maximal :max character',
        ];

        $validationData = $request->validate([
            'name' => 'required|min:2|max:20'
        ], $message);

        Category::where('id', $category->id)->update($validationData);

        return redirect()->back()->with('success', 'Successfully edited Category');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Category::find($category->id)->delete();

        return redirect()->back()->with('success', 'Successfully deleted Category');
    }
}
