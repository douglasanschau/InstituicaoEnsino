$(document).ready(function(){
    $('#table-matriculas').DataTable({
        "language": {
           "url" : '//cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json',
        },
        "ajax":{
          "url" : '/matriculas/listagem_alunos',
          "type": 'GET',
        },
        "columns": [ 
           {'name': "aluno", 'data': "aluno"},
           {'name': "email", 'data': "email"},
           {'name': "curso", 'data': "curso"},
           {'name': "situacao", 'data': "situacao"},
        ],
        "columnDefs": [
            {
                "targets": 4,
                "render": function(row, type, data){
                   return acoesAlunos(data.id);
                }
            }
        ]
    });
});

function acoesAlunos(id){
 let buttons = `<div class='acoes'> 
                    <button type='button' class='btn btn-info editar-curso' ref='${id}' title='Informações do Aluno'>
                        <i class='material-icons'>info</i>
                    </button>
                    <button type='button' class='btn btn-secondary' ref='${id}' title='Editar'>
                        <i class='material-icons'>edit</i>
                    </button>
                    <button type='button' class='btn btn-danger' ref='${id}' title='Editar'>
                        <i class='material-icons'>delete</i>
                    </button>
                </div>`;
 return buttons;
} 


$('.change-tabs').on('click', function(){
    let id_tab = $(this).attr('id');
    $('.change-tabs').removeClass('active');
    $(`#${id_tab}`).addClass('active');
    $('.tab').hide();
    $(`#tab${id_tab}`).show();
})