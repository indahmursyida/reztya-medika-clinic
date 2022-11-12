<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manage_categories', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ],[
            'category_name.required' => 'Nama kategori wajib diisi',
            'category_name.unique' => 'Nama kategori tidak boleh sama dengan nama kategori lainnya',
            'category_name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter'
        ]);
        
        Category::create($validatedData);

        return redirect('manage-categories')->with('success','Category succsessfully added!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('edit_category', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ],[
            'category_name.required' => 'Nama kategori wajib diisi',
            'category_name.unique' => 'Nama kategori tidak boleh sama dengan nama kategori lainnya',
            'category_name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter'
        ]);
        
        Category::find($id)
        ->update($validatedData);

        return redirect('manage-categories')->with('success','Category succsessfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);

        return redirect('/manage-categories')->with('Category successfully deleted');
    }
}
