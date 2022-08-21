<!DOCTYPE html>
<html>
  <head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script type="text/JavaScript" src="{{ asset('js/app.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
  </head>
  <body>
      <nav class="navbar navbar-navegacao navbar-expand-lg navbar-dark bg-dark text-white">
        <div class="navbar-collapse" id="barraNavegacao">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="{{route('painel')}}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('cursos')}}">Cursos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('matriculas')}}">Matriculas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#">Logout</a>
            </li>
          </ul>
        </div>
      </nav>
  </body>
</html>