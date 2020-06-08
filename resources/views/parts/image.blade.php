@php 
  if (is_string($image)) {
    $class = 'old-image';
    $src = 'about:blank';
  } else {
    $class = 'db-image';
    $src = $image->getFullUrl('backoffice');
  }
@endphp

<div class="file-row template image-row {{ $class }}">
  @if (is_string($image))
    <input type="hidden" class="image" name="image" value="{{ request()->old('image') }}" />
  @else
    <input type="hidden" name="delete_{{ $image->id }}" value="{{ $image->id }}" />
  @endif
  <div class="col-image" >
    <div class="preview aspect-1-1">
      <img class="thumbnail" src="{{ $src }}"/>
    </div>
  </div>

  <div class="col">
    @if (!is_string($image))
      <div class="row">
        <p class="name col">{{$image->name}}</p>
        <p class="size col">{{$image->human_readable_size}}</p>
      </div>        
    @endif
  </div>

  <div class="col-action">
    <div data-dz-remove class="btn btn-danger delete">
      <i class="glyphicon glyphicon-trash"></i>
      <span>Delete</span>
    </div>
  </div>
</div>