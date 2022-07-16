<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Home</title>
        <meta charset="utf-8">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/home.css') }}" rel="stylesheet">
        <script type="text/JavaScript" src="{{ asset('js/app.js') }}"></script>
        <script type="text/JavaScript" src="{{ asset('js/instituicaoEnsino/home.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </head>
    <body>

        <div class="container-fluid">
            <div class="col-md-10 mx-auto ">
               <div class="row">
                  @include('layouts.navegacao')
               </div>
               <div class="row mt-5">
                  <div class="card p-4">
                     <div class="card-title mb-4">
                        <h4 class="titulo">Indicadores Anuais</h4>
                     </div>
                     <div class="col-md-6">
                         <div id="chart-matriculas">

                         </div>
                     </div>
                     <div class="col-md-6">
                       
                     </div>
                  </div>
               </div>
            </div>
        </div>

    </body>
</html>