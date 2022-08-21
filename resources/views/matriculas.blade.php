<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Home</title>
        <meta charset="utf-8">
        <link href="{{ asset('css/matriculas.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="col-md-10 mx-auto">
                <div class="row">
                    @include('layouts.navegacao')
                </div>
                <div class="row mt-5">   
                    <div class="card p-4">
                        <div class="col-md-2">
                            <button class="btn btn-success float-right">Nova Matricula</button>
                        </div>
                        <div class="col-md-12 mt-5 table-responsive">
                            <table id="table-matriculas" class='table'>
                                <thead class='bg-dark text-white' >
                                    <tr>
                                        <th>Aluno</th>
                                        <th>E-mail</th>
                                        <th>Curso</th>
                                        <th>Situação</th>
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
<script type="text/JavaScript" src="{{ asset('js/instituicaoEnsino/matriculas.js') }}"></script>