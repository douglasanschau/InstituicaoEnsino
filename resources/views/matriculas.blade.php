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
                            <button class="btn btn-success float-right nova-matricula">Nova Matricula</button>
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
@include('modals.cadastra-matricula')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/JavaScript" src="{{ asset('js/instituicaoEnsino/matriculas.js') }}"></script>