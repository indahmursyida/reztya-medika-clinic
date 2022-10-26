<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manage_products', [
            'products' => Product::all(),
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
        return view('add_product', [
            'products' => Product::all(),
            'categories' => Category::all()
        ]);
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
            'category_id' => 'required',
            'name' => 'required|unique:products|max:255',
            'description' => 'required',
            'size' => 'nullable',
            'price' => 'required|numeric',
            'expired_date' => 'required|date|after:now',
            'stock' => 'required|min:1|max:1000',
            'image_path' => 'required|image'
        ],[
            'category_id.required' => 'Kategori produk wajib diisi',
            'name.required' => 'Nama produk wajib diisi',
            'name.unique' => 'Nama produk tidak boleh sama dengan nama produk lainnya',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter',
            'description.required'=> 'Deskripsi produk produk wajib diisi',
            'price.required' => 'Harga produk wajib diisi',
            'price.numeric' => 'Harga produk harus angka',
            'expired_date.required' => 'Tanggal kadaluarsa produk wajib diisi',
            'expired_date.date' => 'Tanggal kadaluarsa produk tidak valid',
            'expired_date.after' => 'Produk sudah kadaluarsa!',
            'stock.required' => 'Stok produk wajib diisi',
            'stock.min' => 'Stok produk minimal 1',
            'stock.max' => 'Stok produk maksimal 1000',
            'image_path.required' => 'Foto produk wajib diisi',
            'image_path.image' => 'Foto produk tidak valid'
        ]);

        if($request->file('image_path')){
            $validatedData['image_path'] = $request->file('image_path')->store('product-images');
        }
        
        Product::create($validatedData);

        return redirect('manage-products')->with('success','Product succsessfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('product_detail', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('edit_product', [
            'product' => $product,
            'categories' => Category::all()
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
            'category_id' => 'required',
            'name' => 'required|unique:products|max:255',
            'description' => 'required',
            'size' => 'nullable',
            'price' => 'required|numeric',
            'expired_date' => 'required|date|after:now',
            'stock' => 'required|min:1|max:1000',
            'image_path' => 'required|image'
        ],[
            'category_id.required' => 'Kategori produk wajib diisi',
            'name.required' => 'Nama produk wajib diisi',
            'name.unique' => 'Nama produk tidak boleh sama dengan nama produk lainnya',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter',
            'description.required'=> 'Deskripsi produk produk wajib diisi',
            'price.required' => 'Harga produk wajib diisi',
            'price.numeric' => 'Harga produk harus angka',
            'expired_date.required' => 'Tanggal kadaluarsa produk wajib diisi',
            'expired_date.date' => 'Tanggal kadaluarsa produk tidak valid',
            'expired_date.after' => 'Produk sudah kadaluarsa!',
            'stock.required' => 'Stok produk wajib diisi',
            'stock.min' => 'Stok produk minimal 1',
            'stock.max' => 'Stok produk maksimal 1000',
            'image_path.required' => 'Foto produk wajib diisi',
            'image_path.image' => 'Foto produk harus berbentuk jpeg, jpg, atau png'
        ]);

        if($request->file('image_path')){
            if($request->old_image){
                Storage::delete($request->old_image);
            }
            $validatedData['image_path'] = $request->file('image_path')->store('product-images');
        }
        Product::find($id)
            ->update($validatedData);

        return redirect('/manage-products')->with('success','Product succsessfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product->image_path){
            Storage::delete($product->image_path);
        }
        
        Product::destroy($id);

        return redirect('/manage-products')->with('Product successfully deleted');
    }
}