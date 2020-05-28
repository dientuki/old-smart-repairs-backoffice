<div class="vertical-nav" id="sidebar">

  <div class="main-nav__title-wrapper vertical-nav__action" >
    <div class="main-nav__title"><img src="http://fixmymobilebedford.com/wp-content/uploads/2018/11/Transparent.png" width="200"></div>
  </div>

  <nav class="main-nav">
    <ul>
      <li class="main-nav__item">
        <div class="main-nav__title-wrapper must-expand">
          <div class="main-nav__icon">{!! load_svg('phone') !!}</div>
          <div class="main-nav__title">Equipos</div>
        </div>
        <ul class="main-nav__submenu">
          <li class="main-nav__li"><a href="{{route('brands.index')}}" class="main-nav__link">{{ ucfirst(trans_choice('brands.brand', 2)) }}</a></li>
          <li class="main-nav__li"><a href="{{route('device-types.index')}}" class="main-nav__link">{{ ucfirst(trans_choice('device-types.device_type', 2)) }}</a></li>
        </ul>
      </li>

      <li class="main-nav__item">
        <form action="{{ route('logout') }}" method="POST">
          {{ csrf_field() }}
          <button class="main-nav__title-wrapper">
            <div class="main-nav__icon">{!! load_svg('box-arrow-right') !!}</div>
            <div class="main-nav__title">{{__('Logout')}}</div>            
          </button>
        </form>
      </li>      
    </ul>
  </nav>
</div>