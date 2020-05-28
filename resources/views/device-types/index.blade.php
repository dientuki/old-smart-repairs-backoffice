@extends('layouts.admin')

@section ('content')

<div class="header-sticky row">
  <div class="col">{{ ucfirst(trans_choice('device-types.device_type', 2)) }}</div>

  @include ('widgets/order')
</div>

@if (count($deviceTypes) > 0)
  <table class="table table-striped table-bordered table-hover table-sm">
      <thead class="thead-dark">
          <tr>
              <th>{{ ucfirst(trans_choice('device-types.device_type',1)) }}</th>
              <th class="column-action">{{ ucfirst(__('buttons.action')) }}</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($deviceTypes as $deviceType)
          <tr>
              <td>{{ $deviceType->device_type }}</td>

              <td class="column-action px-4">
                  <div class="row">
                  <a href="{{route('device-types.edit', $deviceType->id)}}" class="btn btn-primary col" title="{{__('buttons.edit')}} {{ $deviceType->device_type }}">{!! load_svg('pencil') !!}{{__('buttons.edit')}}</a>
                  
                  {!! Form::open(array('route' => array('device-types.destroy', $deviceType->id), 'method' => 'DELETE', 'class' => 'col modalOpener')) !!}
                    <button id="button-{{ $deviceType->id }}" type="submit" class="btn btn-danger modalDelete" title="{{__('buttons.delete')}} {{ $deviceType->device_type }}">
                        {!! load_svg('trash') !!}
                        {{__('buttons.delete') }}
                    </button>
                  {!! Form::close() !!}
                  </div>
              </td>
          </tr>
          @endforeach
      </tbody>
  </table>

  <div class="row">
    <div class="col-sm">
      <a href="{{route('device-types.create')}}" class="btn btn-primary" title="{{__('buttons.create')}} {{ ucfirst(trans_choice('device-types.device_type',1)) }}">{{__('buttons.create')}} {{ ucfirst(trans_choice('device-types.device_type',1)) }}</a>
    </div>
    <div class="col-sm d-flex">
      {{ $deviceTypes->links() }}
    </div>
  </div>

  @include ('widgets/modal-delete')
@else
  @include ('widgets/empty', ['content' => $deviceTypes])
@endif

@endsection