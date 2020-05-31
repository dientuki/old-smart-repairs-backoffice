@extends('layouts.admin')

@section ('content')

<div class="header-sticky row">
  <div class="col">{{ ucfirst(trans_choice('devices.device', 2)) }}</div>

  @include ('widgets/order')
</div>

@if (count($devices) > 0)
  <table class="table table-striped table-bordered table-hover table-sm">
      <thead class="thead-dark">
          <tr>
              <th>{{ ucfirst(trans_choice('devices.tradename', 1)) }}</th>
              <th>{{ ucfirst(trans_choice('devices.technical_name', 1)) }}</th>
              <th>{{ ucfirst(trans_choice('device-types.device_type', 1)) }}</th>
              <th>{{ ucfirst(trans_choice('brands.brand', 1)) }}</th>
              <th class="column-action">{{ ucfirst(__('buttons.action')) }}</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($devices as $device)
          <tr>
              <td>{{ $device->tradename }}</td>
              <td>{{ $device->technical_name }}</td>
              <td>{{ $device->deviceType->device_type }}</td>
              <td>{{ $device->brand->brand }}</td>

              <td class="column-action px-4">
                  <div class="row">
                  <a href="{{route('devices.edit', $device->id)}}" class="btn btn-primary col" title="{{__('buttons.edit')}} {{ $device->tradename }}">{!! load_svg('pencil') !!}{{__('buttons.edit')}}</a>
                  
                  {!! Form::open(array('route' => array('devices.destroy', $device->id), 'method' => 'DELETE', 'class' => 'col modalOpener')) !!}
                    <button id="button-{{ $device->id }}" type="submit" class="btn btn-danger modalDelete" title="{{__('buttons.delete')}} {{ $device->tradename }}">
                        {!! load_svg('trash') !!}
                        {{ __('buttons.delete') }}
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
      <a href="{{route('devices.create')}}" class="btn btn-primary" title="{{__('buttons.create')}} {{ ucfirst(trans_choice('devices.device',1)) }}">{{__('buttons.create')}} {{ ucfirst(trans_choice('devices.device', 1)) }}</a>
    </div>
    <div class="col-sm d-flex">
      {{ $devices->links() }}
    </div>
  </div>

  @include ('widgets/modal-delete')
@else
  @include ('widgets/empty', ['content' => $devices])
@endif

@endsection