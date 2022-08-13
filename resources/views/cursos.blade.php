<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Home</title>
        <meta charset="utf-8">
        <link href="{{ asset('css/cursos.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <div class="col-md-10 mx-auto ">
                <div class="row">
                    @include('layouts.navegacao')
                </div>
                <div class="row mt-5">   
                    <div class="card p-4">
                        <div class='col-md-12 table-responsive'>
                            <table id="table-cursos" class='table'>
                                <thead class='bg-dark text-white' >
                                    <tr>
                                        <th>Curso</th>
                                        <th>Carga Horária</th>
                                        <th>Data de Cadastro</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script type="text/JavaScript" src="{{ asset('js/instituicaoEnsino/cursos.js') }}"></script>