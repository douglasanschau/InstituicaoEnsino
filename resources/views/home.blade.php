<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Home</title>
        <meta charset="utf-8">
        <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    </head>
    <body>

        <div class="container-fluid">
            <div class="col-md-10 mx-auto ">
               <div class="row">
                  @include('layouts.navegacao')
               </div>
               <div class="row mt-5">   
                  <div class="card p-4">
                     <div class="row mb-4">
                          <div class="col-md-4 mx-auto">
                             <div class="card ">
                                <h5 class="card-dash card-header">
                                    <i class="material-icons icons-dash">
                                        people
                                    </i>
                                     Total de Alunos
                                </h5>
                                <span class="info-dash info-dash-alunos"> </span>
                             </div>
                          </div>
                          <div class="col-md-4 mx-auto">
                            <div class="card ">
                               <h5 class="card-dash card-header">
                                    <i class="material-icons icons-dash">
                                        local_library
                                    </i>
                                   Total de Cursos
                                </h5>
                                <span class="info-dash info-dash-cursos"> </span>
                            </div>
                         </div>
                     </div>
                     <div class="row">
                        <div class="col-md-5 mt-5 mx-auto">
                            <div id="chart-matriculas">

                            </div>
                        </div>
                        <div class="col-md-5 mt-5 mx-auto">
                            <div id="chart-semestres">

                            </div>
                        </div>
                     </div>
                     <div class="col-md-11 mt-5 mx-auto">
                        <div id="chart-cursos">

                        </div>
                     </div>
                  </div>
               </div>
            </div>
        </div>

    </body>
</html>
<script type="text/JavaScript" src="{{ asset('js/instituicaoEnsino/home.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
