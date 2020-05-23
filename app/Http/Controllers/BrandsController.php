<?php

namespace App\Http\Controllers;

use App\Brands;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Brands\StoreBrand;

class BrandsController extends Controller
{
    /**
     * Brands model
     *
     * @var \App\Brands
     */
    protected $brands;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->brands = new Brands();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = $this->brands->getAll();
        return view('brands/index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand = $this->brands;
        $action = 'create';
        $formData = array('route' => 'brands.store', 'method' => 'POST');
        
        return view('brands/form', compact('action', 'brand', 'formData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Brands\StoreBrand  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrand $request)
    {
        $data = $request->validated();

        $this->brands->create($data);

        return redirect()->route('brands.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brands  $brands
     * @return \Illuminate\Http\Response
     */
    //public function edit(Brands $brands)
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brands  $brands
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, Brands $brands)
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brands  $brands
     * @return \Illuminate\Http\Response
     */
    //public function destroy(Brands $brands)
    public function destroy()
    {
        //
    }
}
