@extends('layouts.admin')

@section ('content')

<div class="header-sticky row">
  <div class="col">{{ ucfirst(trans_choice('parts.part', 2)) }}</div>

  @include ('widgets/order')
</div>

@if (count($parts) > 0)
  <table class="table table-striped table-bordered table-hover table-sm">
      <thead class="thead-dark">
          <tr>
              <th>{{ ucfirst(__('parts.name')) }}</th>
              <th>{{ ucfirst(__('parts.code')) }}</th>
              <th class="column-action">{{ ucfirst(__('buttons.action')) }}</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($parts as $part)
          <tr>
              <td>{{ $part->name }}</td>
              <td>{{ $part->code }}</td>

              <td class="column-action px-4">
                  <div class="row">
                  <a href="{{route('parts.edit', $part->id)}}" class="btn btn-primary col" title="{{__('buttons.edit')}} {{ $part->name }}">{!! load_svg('pencil') !!}{{__('buttons.edit')}}</a>
                  
                  {!! Form::open(array('route' => array('parts.destroy', $part->id), 'method' => 'DELETE', 'class' => 'col modalOpener')) !!}
                    <button id="button-{{ $part->id }}" type="submit" class="btn btn-danger modalDelete" title="{{__('buttons.delete')}} {{ $part->name }}">
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
  @include ('widgets/modal-delete')

@else

  @include ('widgets/empty', ['content' => $parts])

@endif

<div class="row">
  <div class="col-sm">
    <a href="{{route('parts.create')}}" class="btn btn-primary" title="{{__('buttons.create')}} {{ ucfirst(trans_choice('parts.part',1)) }}">{{__('buttons.create')}} {{ ucfirst(trans_choice('parts.part',1)) }}</a>
  </div>
  @if (count($parts) > 0)
  <div class="col-sm d-flex">
    {{ $parts->links() }}
  </div>
  @endif
</div>

  


@endsection