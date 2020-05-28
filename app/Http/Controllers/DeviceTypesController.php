<?php

namespace App\Http\Controllers;

use App\DeviceType;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeviceType\StoreDeviceType;
use App\Http\Requests\DeviceType\UpdateDeviceType;

class DeviceTypeController extends Controller
{
    /**
     * Device type model
     *
     * @var \App\DeviceType
     */
    protected $deviceType;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->deviceType = new DeviceType();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $deviceTypes = $this->deviceType->getAll();
        return view('device-types/index', compact('deviceTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $deviceType = $this->deviceType;
        $action = 'create';
        $formData = array('route' => 'device-types.store', 'method' => 'POST');

        return view('device-types/form', compact('action', 'deviceType', 'formData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DeviceType\StoreDeviceType  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDeviceType $request)
    {
        $data = $request->validated();

        $this->deviceType->create($data);

        Alert::success(__('device-types.store'))->flash();

        return redirect()->route('device-types.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DeviceType  $deviceType
     * @return \Illuminate\View\View
     */
    public function edit(DeviceType $deviceType)
    {
        $action    = 'update';
        $formData = array('route' => array('device-types.update', $deviceType->id), 'method' => 'PATCH');

        return view('device-types/form', compact('action', 'deviceType', 'formData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DeviceType\UpdateDeviceType  $request
     * @param  \App\DeviceType  $deviceType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateDeviceType $request, DeviceType $deviceType)
    {
        $deviceType->update($request->validated());
        Alert::success(__('device-types.update'))->flash();
        return redirect()->route('device-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DeviceType  $deviceType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DeviceType $deviceType)
    {
        $deviceType->delete();
        Alert::success(__('device-types.destroy'))->flash();
        return redirect()->route('device-types.index');
    }
}
