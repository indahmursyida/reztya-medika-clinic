<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manage_services', [
            'services' => Service::all(),
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
        return view('add_service', [
            'services' => Service::all(),
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
        $validatedData = $request->validate(
            [
                'category_id' => 'required',
                'name' => 'required|unique:services|max:255',
                'description' => 'required',
                'duration' => 'required|numeric',
                'price' => 'required|numeric',
                'image_path' => 'required|image'
            ],
            [
                'category_id.required' => 'Kategori perawatan wajib diisi',
                'name.required' => 'Nama perawatan wajib diisi',
                'name.unique' => 'Nama perawatan tidak boleh sama dengan nama perawatan lainnya',
                'name.max' => 'Nama perawatan tidak boleh lebih dari 255 karakter',
                'description.required' => 'Deskripsi perawatan perawatan wajib diisi',
                'duration.required' => 'Durasi perawatan wajib diisi',
                'duration.numeric' => 'Durasi perawatan harus angka',
                'price.required' => 'Harga perawatan wajib diisi',
                'price.numeric' => 'Harga perawatan harus angka',
                'image_path.required' => 'Foto perawatan wajib diisi',
                'image_path.image' => 'Foto perawatan harus berbentuk jpeg, jpg, atau png'
            ]
        );

        if ($request->file('image_path')) {
            $validatedData['image_path'] = $request->file('image_path')->store('service-images');
        }

        Service::create($validatedData);

        return redirect('manage-services')->with('success', 'Service succsessfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::find($id);
        return view('service_detail', [
            'service' => $service,
            'schedules' => Schedule::all()
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
        $service = Service::find($id);
        return view('edit_service', [
            'service' => $service,
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
        $validatedData = $request->validate(
            [
                'category_id' => 'required',
                'name' => 'required|unique:services|max:255',
                'description' => 'required',
                'duration' => 'required|numeric',
                'price' => 'required|numeric',
                'image_path' => 'required|image'
            ],
            [
                'category_id.required' => 'Kategori perawatan wajib diisi',
                'name.required' => 'Nama perawatan wajib diisi',
                'name.unique' => 'Nama perawatan tidak boleh sama dengan nama perawatan lainnya',
                'name.max' => 'Nama perawatan tidak boleh lebih dari 255 karakter',
                'description.required' => 'Deskripsi perawatan perawatan wajib diisi',
                'duration.required' => 'Durasi perawatan wajib diisi',
                'duration.numeric' => 'Durasi perawatan harus angka',
                'price.required' => 'Harga perawatan wajib diisi',
                'price.numeric' => 'Harga perawatan harus angka',
                'image_path.required' => 'Foto perawatan wajib diisi',
                'image_path.image' => 'Foto perawatan harus berbentuk jpeg, jpg, atau png'
            ]
        );

        if ($request->file('image_path')) {
            if ($request->old_image) {
                Storage::delete($request->old_image);
            }
            $validatedData['image_path'] = $request->file('image_path')->store('service-images');
        }
        Service::find($id)
            ->update($validatedData);

        return redirect('/manage-services')->with('success', 'Service succsessfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        if ($service->image_path) {
            Storage::delete($service->image_path);
        }

        Service::destroy($id);

        return redirect('/manage-services')->with('Service successfully deleted');
    }
}