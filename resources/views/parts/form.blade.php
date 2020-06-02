@extends('layouts.admin')

@section ('content')

<div class="header-sticky">{{ __('buttons.' . $action) . ' ' . trans_choice('parts.part', 1) }}</div>

{!! Form::model($part, array_merge($formData, array('role' => 'form', 'class' => 'form-horizontal'))) !!}

  <div class="form-group">
    <?php $class = $errors->has('name') != null ? 'form-control is-invalid' : 'form-control'; ?>
    {!! Form::label('name', ucfirst(trans_choice('parts.part',1))) !!}
    {!! Form::text('name', null, array('placeholder' => ucfirst(__('parts.name')), 'class'=>$class, 'required' => true, 'maxlength' => 190))  !!}
    @error('name')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
    @enderror
  </div>

  <div class="form-group">
    <?php $class = $errors->has('code') != null ? 'form-control is-invalid' : 'form-control'; ?>
    {!! Form::label('code', ucfirst(trans_choice('parts.part',1))) !!}
    {!! Form::text('code', null, array('placeholder' => ucfirst(__('parts.code')), 'class'=>$class, 'required' => true, 'maxlength' => 190))  !!}
    @error('code')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
    @enderror
  </div>  

  {!! Form::submit(__('buttons.' . $action) . ' ' . trans_choice('parts.part',1), array('class'=>'btn btn-primary') ) !!}


{!! Form::close() !!}

@endsection