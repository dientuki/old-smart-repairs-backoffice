@extends('layouts.admin')

@section ('content')

<div class="header-sticky">{{ __('buttons.' . $action) . ' ' . trans_choice('device-types.device_type', 1) }}</div>

{!! Form::model($deviceType, array_merge($formData, array('role' => 'form', 'class' => 'form-horizontal'))) !!}

  <div class="form-group">
    <?php $class = $errors->has('device_type') != null ? 'form-control is-invalid' : 'form-control'; ?>
    {!! Form::label('device_type', ucfirst(trans_choice('device-types.device_type',1))) !!}
    {!! Form::text('device_type', null, array('placeholder' => ucfirst(trans_choice('device-types.device_type',1)), 'class'=>$class, 'required' => true, 'maxlength' => 190))  !!}
    @error('device_type')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
    @enderror
  </div>

  {!! Form::submit(__('buttons.' . $action) . ' ' . trans_choice('device-types.device_type',1), array('class'=>'btn btn-primary') ) !!}


{!! Form::close() !!}

@endsection