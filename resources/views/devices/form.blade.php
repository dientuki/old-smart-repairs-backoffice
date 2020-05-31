@extends('layouts.admin')

@section ('content')

<div class="header-sticky">{{ __('buttons.' . $action) . ' ' . trans_choice('devices.device', 1) }}</div>

{!! Form::model($device, array_merge($formData, array('role' => 'form', 'class' => 'form-horizontal'))) !!}

  <div class="form-group">
    <?php $class = $errors->has('tradename') != null ? 'form-control is-invalid' : 'form-control'; ?>
    {!! Form::label('tradename', ucfirst(__('devices.tradename'))) !!}
    {!! Form::text('tradename', null, array('placeholder' => ucfirst(__('devices.tradename')), 'class'=>$class, 'required' => true, 'maxlength' => 190))  !!}
    @error('tradename')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
    @enderror
  </div>

  <div class="form-group">
    <?php $class = $errors->has('technical_name') != null ? 'form-control is-invalid' : 'form-control'; ?>
    {!! Form::label('technical_name', ucfirst(__('devices.technical_name'))) !!}
    {!! Form::text('technical_name', null, array('placeholder' => ucfirst(__('devices.technical_name')), 'class'=>$class, 'required' => true, 'maxlength' => 190))  !!}
    @error('technical_name')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
    @enderror
  </div>  

  <div class="form-group">
    <?php $class = $errors->has('device_type_id') != null ? 'form-control is-invalid' : 'form-control'; ?>
    {!! Form::label('device_type_id', ucfirst(trans_choice('device-types.device_type',1))) !!}
    {!! Form::select('device_type_id', $deviceTypes, $device->device_type_id, array('placeholder' => ucfirst(__('device-types.select_placeholder')), 'required' => true, 'class' => $class) ) !!}
    @error('device_type_id')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
    @enderror
  </div>      

  <div class="form-group">
    <?php $class = $errors->has('brand_id') != null ? 'form-control is-invalid' : 'form-control'; ?>
    {!! Form::label('brand_id', ucfirst(trans_choice('brands.brand',1))) !!}
    {!! Form::select('brand_id', $brands, $device->brand_id, array('placeholder' => ucfirst(__('brands.select_placeholder')), 'required' => true, 'class' => $class) ) !!}
    @error('brand_id')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
    @enderror
  </div>   

  <div class="form-group">
    <?php $class = $errors->has('url') != null ? 'form-control is-invalid' : 'form-control'; ?>
    {!! Form::label('url', ucfirst(__('devices.url'))) !!}
    {!! Form::url('url', null, array('placeholder' => ucfirst(__('devices.url')), 'class'=>$class))  !!}
    @error('url')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
    @enderror
  </div>   

  {!! Form::submit(__('buttons.' . $action) . ' ' . trans_choice('devices.device', 1), array('class'=>'btn btn-primary') ) !!}


{!! Form::close() !!}

@endsection