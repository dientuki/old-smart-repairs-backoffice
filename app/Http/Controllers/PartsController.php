<?php

namespace App\Http\Controllers;

use Exception;
use App\Part;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Parts\StorePart;
use App\Http\Requests\Parts\UpdatePart;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PartsController extends Controller
{
    /**
     * Parts model
     *
     * @var \App\Part
     */
    protected $part;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->part = new Part();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $parts = $this->part->getAll();
        return view('parts/index', compact('parts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $part = $this->part;
        $action = 'create';
        $formData = array('route' => 'parts.store', 'method' => 'POST');

        return view('parts/form', compact('action', 'part', 'formData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Parts\StorePart  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePart $request)
    {
        $data = $request->validated();

        $this->part = $this->part->create($data);

        $this->storeImage($data);

        Alert::success(__('parts.store'))->flash();

        return redirect()->route('parts.index');
    }

    /**
     * Store a new image in media library
     *
     * @param  array  $data
     * @return void
     */
    private function storeImage($data)
    {
        if (isset($data['image'])) {
            $this->part->addMedia(storage_path('tmp/uploads/' . $data['image']))->toMediaCollection('parts');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Part  $part
     * @return \Illuminate\View\View
     */
    public function edit(Part $part)
    {
        $action    = 'update';
        $formData = array('route' => array('parts.update', $part->id), 'method' => 'PATCH');

        return view('parts/form', compact('action', 'part', 'formData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Parts\UpdatePart  $request
     * @param  \App\Part  $part
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePart $request, Part $part)
    {
        $data = $request->validated();
        $part->update($data);
        $this->part = $part;
        $this->updateImage($data);
        $this->storeImage($data);

        Alert::success(__('parts.update'))->flash();
        return redirect()->route('parts.index');
    }

    /**
     * Update an image in media library
     *
     * @param  array  $data
     * @return void
     */
    private function updateImage($data)
    {
        if (isset($data['delete'])) {
            try {
                Media::where('id', $data['delete'])->delete();
            } catch (Exception $e) {
                Alert::error('No puedes eliminar las imagenes!')->flash();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Part  $part
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Part $part)
    {
        $part->delete();
        Alert::success(__('parts.destroy'))->flash();
        return redirect()->route('parts.index');
    }
}
