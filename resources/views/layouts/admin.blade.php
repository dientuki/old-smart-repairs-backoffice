<!DOCTYPE html>
<html lang="es">
  <head>
    @include ('main-parts.head')
  </head>

  <body >
    @include ('widgets/alerts')

    @include ('main-parts.nav-bar')

    <main class="page-content p-5" id="content">

      @yield('content')

    </main>

  </body>

</html>