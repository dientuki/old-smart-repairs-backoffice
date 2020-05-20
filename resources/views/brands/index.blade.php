@extends('layouts.admin')

@section ('content')

<div class="header-sticky row has-FS">
  <div class="col">{{ ucfirst(trans_choice('fields.brand', 2)) }}</div>

  @include ('widgets/order')
</div>

@if (isset($brands))
<table class="table table-striped table-bordered table-hover table-sm">
    <thead class="thead-dark">
        <tr>
            <th>{{ ucfirst(trans_choice('fields.brand',1)) }}</th>
            <th class="column-action">{{ ucfirst(__('fields.action')) }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($brands as $brand)
        <tr>
            <td>{{ $brand->brand }}</td>

            <td class="column-action px-4">
                <div class="row">
                <a href="{{route('brands.edit', $brand->id)}}" class="btn btn-primary col" title="{{__('buttons.edit')}} {{ $brand->brand }}">{{__('buttons.edit')}}</a>
                
                {!! Form::open(array('route' => array('brands.destroy', $brand->id), 'method' => 'DELETE', 'class' => 'col modalOpener', 'id' => 'id-' . $brand->id)) !!}
                <button id="button-{{ $brand->id }}" type="submit" class="btn btn-danger modalDelete"
                    title="{{__('buttons.delete')}} {{ $brand->brand }}">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    {{__('buttons.delete') }}</button>
                {!! Form::close() !!}
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="row">
  <div class="col-sm">
    <a href="{{route('brands.create')}}" class="btn btn-primary" title="{{__('buttons.create')}} {{ ucfirst(trans_choice('fields.brand',1)) }}">{{__('buttons.create')}} {{ ucfirst(trans_choice('fields.brand',1)) }}</a>
  </div>
  <div class="col-sm d-flex">
    {{ $brands->links() }}
  </div>
</div>

@include ('widgets/modal-delete')

@endif

@endsection