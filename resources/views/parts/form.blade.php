@extends('layouts.admin')

@section ('content')

<div class="header-sticky">{{ __('buttons.' . $action) . ' ' . trans_choice('parts.part', 1) }}</div>

{!! Form::model($part, array_merge($formData, array('role' => 'form', 'class' => 'form-horizontal'))) !!}
  <fieldset class="sticky-wrapper">
    <h2 class="sticky-head">Datos tecnicos</h2>
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
      {!! Form::text('code', null, array('placeholder' => ucfirst(__('parts.code')), 'class'=>$class, 'maxlength' => 190))  !!}
      @error('code')
        <div class="invalid-feedback">
          <strong>{{ $message }}</strong>
        </div>
      @enderror
    </div>  
  </fieldset>

  <fieldset class="sticky-wrapper">
    <h2 class="sticky-head">Imagen</h2>
    <div id="actions" class="row">

      <div class="col-lg-7">
        <!-- The fileinput-button span is used to style the file input field as button -->
        <div class="btn btn-success fileinput-button" id="dropzone" data-url="{{ route('images.store') }}" data-maxfiles="1">
          <span>Add file...</span>
        </div>
        <div type="reset" class="btn btn-warning cancel">
          <span>Cancel upload</span>
        </div>
      </div>

    </div>  

    <div class="table table-striped files" id="previews">
      @if ( request()->old('image') !== null)
          <div class="file-row template old-image row">
            <!-- This is used as the file preview template -->
            <input type="text" class="image" name="image" value="{{ request()->old('image') }}" />
            <div class="col-2">
              <span class="preview"><img class="thumbnail" data-dz-thumbnail /></span>
            </div>
            <div class="col">

            </div>
            <div class="col-2">
              <div data-dz-remove class="btn btn-danger delete">
                <i class="glyphicon glyphicon-trash"></i>
                <span>Delete</span>
              </div>
            </div>
          </div>
      @else
        @foreach ($part->getMedia('parts') as $image)
          <div class="file-row template image-row db-image">
            <!-- This is used as the file preview template -->

            <input type="hidden" name="delete_{{ $image->id }}" value="{{ $image->id }}" />

            <div class="col-image" >
              <div class="preview aspect-1-1">
                <img class="thumbnail " src="{{ $image->getFullUrl('backoffice') }}" />
              </div>
            </div>

            <div class="col">
              <div class="row">
                <p class="name col">{{$image->name}}</p>
                <p class="size col">{{$image->human_readable_size}}</p>
              </div>
            </div>

            <div class="col-action">
              <div data-dz-remove class="btn btn-danger delete">
                <i class="glyphicon glyphicon-trash"></i>
                <span>Delete</span>
              </div>
            </div>
          </div>        
        @endforeach  
      @endif

    </div>
  </fieldset>

  {!! Form::submit(__('buttons.' . $action) . ' ' . trans_choice('parts.part',1), array('class'=>'btn btn-primary') ) !!}


{!! Form::close() !!}
@include('parts.template')

@endsection