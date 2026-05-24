@php
use Illuminate\Support\Facades\Route;
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" style="background-color:azure;">

  <div class="app-brand demo">
    <span class="app-brand-text demo menu-text fw-bold ms-2">{{ __('Dashboard') }}</span>
  </div>

  <div class="menu-divider mt-0"></div>
  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">

    @foreach ($menuData[0]->menu as $menu)

    @php
    $currentRouteName = Route::currentRouteName();

    // active logic (كما هو عندك)
    $activeClass = null;

    if ($currentRouteName === $menu->slug) {
    $activeClass = 'active';
    } elseif (isset($menu->submenu)) {
    if (gettype($menu->slug) === 'array') {
    foreach($menu->slug as $slug){
    if (str_contains($currentRouteName,$slug) && strpos($currentRouteName,$slug) === 0) {
    $activeClass = 'active open';
    }
    }
    } else {
    if (str_contains($currentRouteName,$menu->slug) && strpos($currentRouteName,$menu->slug) === 0) {
    $activeClass = 'active open';
    }
    }
    }

    // 🔥 Permission check for main menu
    $canShowMenu = true;

    if (isset($menu->permissions)) {
    $canShowMenu = false;

    foreach ($menu->permissions as $permission) {
    if (auth()->user()->can($permission)) {
    $canShowMenu = true;
    break;
    }
    }
    }
    @endphp

    @if($canShowMenu)

    {{-- menu headers --}}
    @if (isset($menu->menuHeader))
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
    </li>
    @else

    <li class="menu-item {{$activeClass}}">
      <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
        class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}">

        @isset($menu->icon)
        <i class="{{ $menu->icon }}"></i>
        @endisset

        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>

      </a>

      {{-- 🔥 submenu --}}
      @isset($menu->submenu)
      <ul class="menu-sub">

        @foreach ($menu->submenu as $sub)

        @php
        $canShowSub = true;

        if (isset($sub->permissions)) {
        $canShowSub = false;

        foreach ($sub->permissions as $permission) {
        if (auth()->user()->can($permission)) {
        $canShowSub = true;
        break;
        }
        }
        }
        @endphp

        @if($canShowSub)
        <li class="menu-item">
          <a href="{{ url($sub->url) }}" class="menu-link">
            @isset($sub->icon)
            <i class="{{ $sub->icon }}"></i>
            @endisset
            <div>{{ __($sub->name) }}</div>
          </a>
        </li>
        @endif

        @endforeach

      </ul>
      @endisset

    </li>

    @endif

    @endif

    @endforeach

  </ul>

  <!-- Logout -->
  <div style="padding: 15px; border-top: 1px solid rgba(255,255,255,0.2);">
    <form method="POST" action="{{ route('admin.logout') }}">
      @csrf
      <button type="submit"
        style="width:100%; padding:10px; background-color:darkgrey; color:black; border:none; border-radius:5px; font-weight:bold; cursor:pointer; display:flex; align-items:center; justify-content:center;">
        <i class="bx bx-log-out" style="margin-right:8px;"></i>
        {{ __('Logout') }}
      </button>
    </form>
  </div>

</aside>
