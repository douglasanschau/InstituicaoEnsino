$(document).ready(function(){

    $('#table-cursos').DataTable({
        "language": {
           "url" : '//cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json',
        },
        "ajax":{
          "url" : '/cursos/listagem',
          "type": 'GET',
        },
        "columns": [ 
           {'name': "curso", 'data': "curso"},
           {'name': "carga_horaria", 'data': "carga_horaria"},
           {'name': "data_cadastro", 'data': "data_cadastro"},
        ],
        "columnDefs": [
            {
                "targets": 3,
                "render": function(row, type, data){
                    return acoesDataTable(data.id);
                }
            }
        ]
    });

});

function acoesDataTable(id){
    let buttons = `<div class='acoes'> 
                      <button type='button' class='btn btn-info' ref='${id}' title='Editar'>
                        <i class='material-icons'>edit</i>
                      </button>
                      <button type='button' class='btn btn-danger' ref='${id}' title='Excluir'>
                         <i class='material-icons'>delete</i>
                      </button>
                </div>`;
    return buttons;
}

$('.cadastra-cursos').on('click', function(){
    $("#modalCadastrarCursos").modal('show');
})

$('button[data-dismiss="modal"]').on('click', function(){
   $('.modal').modal('hide');
});

$('#salvar_curso').on('click', function(){
   let valida = validarFormCursos();
   if(valida){
    let dados  = $('#orm-cadastra-cursos').serialize();
    cadastraNovoCurso(dados);
   } 
});

function validarFormCursos(){
    let curso = $('#form-cadastra-cursos #curso').val();
    let carga_horaria = $('#form-cadastra-cursos #carga_horaria').val();
    if(curso == "" || carga_horaria == ""){
        let campo = curso == "" ? 'Curso' : "Carga Horária";
        Swal.fire({
          title : 'Atenção!',
          html  : `O campo <b>${campo}</b> deve ser preenchido.`,
          icon  : 'error',
        });
    }
}

function cadastraNovoCurso(form){

}