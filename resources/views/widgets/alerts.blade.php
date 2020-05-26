@foreach (Alert::getMessages() as $type => $messages)
  <div class="alert-wrapper animated pulse" data-open="pulse" data-close="backOutUp">
    @foreach ($messages as $message)
      <div class="alert alert-{{ $type }}">
        <strong>{{ ucfirst(__('alerts.' . $type)) }}!</strong>
        {{ $message }}
        <button type="button" class="close alert-close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endforeach
  </div>
@endforeach