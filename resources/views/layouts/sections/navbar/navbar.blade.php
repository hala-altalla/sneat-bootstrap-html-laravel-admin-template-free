@if (isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar"
  style="background-color:azure">

  @include('layouts/sections/navbar/navbar-partial')

</nav>
@else

<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar"
  style="background-color:bisque">

  <div class="container-fluid px-0">
    @include('layouts/sections/navbar/navbar-partial')
  </div>

</nav>

@endif