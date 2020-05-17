<?php use App\Http\Helpers\Helpers; ?>

<!-- Vertical navbar -->
<div class="vertical-nav" id="sidebar">

  <div class="main-nav__title-wrapper vertical-nav__action" >
    <div class="main-nav__title"><img src="{{ asset('images/logo.png') }}" width="200"></div>    
  </div>

  <nav class="main-nav">
    <ul>
      <!-- {{ trans_choice('fields.package', 2)}}  -->
      <li class="main-nav__item {{ Helpers::main_menu(['packages']) }}">
        <div class="main-nav__title-wrapper must-expand">
          <div class="main-nav__icon">{!! Helpers::load_svg('ico-package') !!}</div>
          <div class="main-nav__title">{{ ucfirst(trans_choice('fields.package', 2)) }}</div>
        </div>
        <ul class="main-nav__submenu">
          <li class="main-nav__li {{ Helpers::sub_menu('packages', 'create') }}"><a href="{{route('admin.packages.index')}}" class="main-nav__link">{{ ucfirst(__('buttons.show')) }} {{ trans_choice('fields.package', 2)}} </a></li>
          <li class="main-nav__li {{ Helpers::sub_menu_only('packages.create') }}"><a href="{{route('admin.packages.create')}}" class="main-nav__link">{{ ucfirst(trans_choice('buttons.new', 1))}} {{ trans_choice('fields.package', 1)}} </a></li>
        </ul>
      </li>
      
      <!-- cruceros -->
      <li class="main-nav__item {{ Helpers::main_menu(['cruiseships', 'cruiseships-types']) }}">
        <div class="main-nav__title-wrapper must-expand">
          <div class="main-nav__icon">{!! Helpers::load_svg('ico-cruise') !!}</div>
          <div class="main-nav__title">{{ ucfirst(trans_choice('fields.cruiseship', 2)) }}</div>
        </div>
        <ul class="main-nav__submenu">
          <li class="main-nav__li {{ Helpers::sub_menu('cruiseships', 'create') }}"><a href="{{route('admin.cruiseships.index')}}" class="main-nav__link">{{ ucfirst(__('buttons.show')) }} {{ trans_choice('fields.cruiseship', 2) }}</a></li>
          <li class="main-nav__li {{ Helpers::sub_menu_only('cruiseships.create') }}"><a href="{{route('admin.cruiseships.create')}}" class="main-nav__link">{{ ucfirst(trans_choice('buttons.new', 1))}} {{ trans_choice('fields.cruiseship', 1) }}</a></li>
          <li class="main-nav__li {{ Helpers::sub_menu('cruiseships-types') }}"><a href="{{route('admin.cruiseships-types.index')}}" class="main-nav__link">{{ ucfirst(__('buttons.show')) }} {{ trans_choice('fields.cruiseshipType', 2) }}</a></li>            
        </ul>
      </li>

      <!-- excursiones -->
      <li class="main-nav__item {{ Helpers::main_menu(['excursions', 'availability', 'duration', 'excursions-types']) }}">
        <div class="main-nav__title-wrapper must-expand">
          <div class="main-nav__icon">{!! Helpers::load_svg('ico-excursion') !!}</div>
          <div class="main-nav__title">{{ ucfirst(trans_choice('fields.excursion', 2)) }}</div>
        </div>
        <ul class="main-nav__submenu">
          <li class="main-nav__li {{ Helpers::sub_menu('excursions', 'create') }}"><a href="{{route('admin.excursions.index')}}" class="main-nav__link ">{{ ucfirst(__('buttons.show')) }} {{ trans_choice('fields.excursion', 2) }}</a></li>
          <li class="main-nav__li {{ Helpers::sub_menu_only('excursions.create') }}"><a href="{{route('admin.excursions.create')}}" class="main-nav__link ">{{ ucfirst(trans_choice('buttons.new', 2))}} {{ trans_choice('fields.excursion', 1) }}</a></li>
          <li class="main-nav__li {{ Helpers::sub_menu('duration') }}"><a href="{{route('admin.duration.index')}}" class="main-nav__link ">{{ ucfirst(__('buttons.show')) }} {{ __('fields.duration') }}</a></li>
          <li class="main-nav__li {{ Helpers::sub_menu('availability') }}"><a href="{{route('admin.availability.index')}}" class="main-nav__link">{{ ucfirst(__('buttons.show')) }} {{ trans_choice('fields.availability', 1) }}</a></li>  
          <li class="main-nav__li {{ Helpers::sub_menu('excursions-types') }}"><a href="{{route('admin.excursions-types.index')}}" class="main-nav__link ">{{ ucfirst(__('buttons.show')) }} {{ trans_choice('fields.excursionType', 2) }}</a></li>
        </ul>
      </li>   
      
      <!-- lugares -->
      <li class="main-nav__item {{ Helpers::main_menu(['inquiries']) }}">
        <div class="main-nav__title-wrapper">
          <div class="main-nav__icon">{!! Helpers::load_svg('ico-inquiries') !!}</div>
          <div class="main-nav__title"><a href="{{route('admin.inquiries.index')}}" class="main-nav__link">{{ ucfirst(trans_choice('fields.inquiry', 2)) }}</a></div>
        </div>
      </li> 
      
      <!-- slider -->
      <li class="main-nav__item {{ Helpers::main_menu(['homeslider']) }}">
        <div class="main-nav__title-wrapper">
          <div class="main-nav__icon">{!! Helpers::load_svg('ico-slider') !!}</div>
          <div class="main-nav__title"><a href="{{route('admin.homeslider.index')}}" class="main-nav__link">{{ ucfirst(__('fields.homeslider')) }}</a></div>
        </div>
      </li>      
      
      <!-- configuracion -->
      <li class="main-nav__item {{ Helpers::main_menu(['users', 'destinations', 'regions', 'languages', 'currencies']) }}">
        <div class="main-nav__title-wrapper must-expand">
          <div class="main-nav__icon">{!! Helpers::load_svg('ico-settings') !!}</div>
          <div class="main-nav__title">Configuracion</div>
        </div>
        <ul class="main-nav__submenu">
          <li class="main-nav__li {{ Helpers::sub_menu('users') }}"><a href="{{route('admin.users.index')}}" class="main-nav__link">{{ ucfirst(trans_choice('fields.user', 2)) }}</a></li>
          <li class="main-nav__li {{ Helpers::sub_menu('pages') }}"><a href="{{route('admin.pages.index')}}" class="main-nav__link">{{ ucfirst(trans_choice('fields.page', 2)) }}</a></li>
          <li class="main-nav__li {{ Helpers::sub_menu('regions') }}"><a href="{{route('admin.regions.index')}}" class="main-nav__link">{{ ucfirst(trans_choice('fields.region', 2)) }}</a></li>  
          <li class="main-nav__li {{ Helpers::sub_menu('destinations') }}"><a href="{{route('admin.destinations.index')}}" class="main-nav__link">{{ ucfirst(trans_choice('fields.destination', 2)) }}</a></li>
          <li class="main-nav__li {{ Helpers::sub_menu('languages') }}"><a href="{{route('admin.languages.index')}}" class="main-nav__link">{{ ucfirst(trans_choice('fields.language', 2)) }}</a></li>  
          <li class="main-nav__li {{ Helpers::sub_menu('currencies') }}"><a href="{{route('admin.currencies.index')}}" class="main-nav__link">{{ ucfirst(trans_choice('fields.currency', 2)) }}</a></li>
          <li class="main-nav__li {{ Helpers::sub_menu('third-parties') }}"><a href="{{route('admin.third-parties.index')}}" class="main-nav__link">{{ ucfirst(trans_choice('fields.thirdParty', 2)) }}</a></li>
          <li class="main-nav__li {{ Helpers::sub_menu('currencies') }}"><a href="{{route('admin.currencies.index')}}" class="main-nav__link">{{ ucfirst(__('buttons.edit')) }} footer</a></li>
        </ul>
      </li>    
      
      <li class="main-nav__item">
        <form action="{{ route('logout') }}" method="POST">
          {{ csrf_field() }}
          <button class="main-nav__title-wrapper">
            <div class="main-nav__icon">{!! Helpers::load_svg('ico-logout') !!}</div>
            <div class="main-nav__title">Salir</div>            
          </button>
        </form>
      </li>
    </ul>
  </nav>
</div>

<!-- End vertical navbar -->