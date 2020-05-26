<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Brands\StoreBrand;
use App\Http\Requests\Brands\UpdateBrand;

class BrandsController extends Controller
{
    /**
     * Brands model
     *
     * @var \App\Brand
     */
    protected $brand;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->brand = new Brand();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $brands = $this->brand->getAll();
        return view('brands/index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $brand = $this->brand;
        $action = 'create';
        $formData = array('route' => 'brands.store', 'method' => 'POST');

        return view('brands/form', compact('action', 'brand', 'formData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Brands\StoreBrand  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBrand $request)
    {
        $data = $request->validated();

        $this->brand->create($data);

        Alert::success(__('brands.store'))->flash();

        return redirect()->route('brands.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\View\View
     */
    public function edit(Brand $brand)
    {
        $action    = 'update';
        $formData = array('route' => array('brands.update', $brand->id), 'method' => 'PATCH');

        return view('brands/form', compact('action', 'brand', 'formData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Brands\UpdateBrand  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateBrand $request, Brand $brand)
    {
        $brand->update($request->validated());
        Alert::success(__('brands.update'))->flash();
        return redirect()->route('brands.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        Alert::success(__('brands.destroy'))->flash();
        return redirect()->route('brands.index');
    }
}
