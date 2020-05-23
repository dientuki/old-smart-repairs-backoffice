@extends('layouts.admin')

@section ('content')

<div class="header-sticky">{{ __('buttons.' . $action) . ' ' . trans_choice('brands.brand', 1) }}</div>

{!! Form::model($brand, array_merge($formData, array('role' => 'form', 'class' => 'form-horizontal'))) !!}

  <div class="form-group">
    <?php $class = $errors->has('brand') != null ? 'form-control is-invalid' : 'form-control'; ?>
    {!! Form::label('brand', ucfirst(trans_choice('brands.brand',1))) !!}
    {!! Form::text('brand', null, array('placeholder' => ucfirst(trans_choice('brands.brand',1)), 'class'=>$class, 'required' => true, 'maxlength' => 190))  !!}
    @error('brand')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
    @enderror
  </div>

  {!! Form::submit(__('buttons.' . $action) . ' ' . trans_choice('brands.brand',1), array('class'=>'btn btn-primary') ) !!}


{!! Form::close() !!}

@endsection