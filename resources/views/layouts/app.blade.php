<!doctype html>
<html lang="en">
  <head>
        @include('partials.head')
  </head>
  <body class="vertical  light  ">
    <div class="wrapper">
      @include('partials.navbar')
      @include('partials.sidebar')
      <main role="main" class="main-content">
        <div class="container-fluid">

            @yield('content')
         
        </div>
      </main>
    </div>
    <!-- Scripts -->
    @include('partials.scripts')
    @stack('scripts')
</body>
</html>