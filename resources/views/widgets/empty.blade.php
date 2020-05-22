<div class="">
  @if (app('request')->has('page'))
    {{ __('pagination.empty') }}
  @else
    {{ __('error.no-record') }}
  @endif
</div>