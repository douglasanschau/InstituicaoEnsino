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
                      <button type='button' class='btn btn-info editar-curso' ref='${id}' title='Editar'>
                        <i class='material-icons'>edit</i>
                      </button>
                      <button type='button' class='btn btn-warning desativar-curso' ref='${id}' title='Desativar'>
                         <i class='material-icons'>remove_circle</i>
                      </button>
                  </div>`;
    return buttons;
}

$('.cadastra-cursos').on('click', function(){
    $('#modalCadastrarCursos #form-cadastra-cursos input[name="acao"]').val('cadastrar');
    $("#modalCadastrarCursos").modal('show');
})

$('button[data-dismiss="modal"]').on('click', function(){
   $('.modal').modal('hide');
});

$('#salvar_curso').on('click', function(){
   let valida = validarFormCursos();
   if(valida){
    let dados  = $('#form-cadastra-cursos').serialize();
        cadastraNovoCurso(dados);
   } 
});

function validarFormCursos(){
    let valida = true;
    let curso = $('#form-cadastra-cursos #curso').val();
    let carga_horaria = $('#form-cadastra-cursos #carga_horaria').val();
    if(curso == "" || carga_horaria == ""){
        let campo = curso == "" ? 'Curso' : "Carga Horária";
        campoVazio(campo);
        valida = false;
        return valida;
    }
    return valida;
}

function campoVazio(campo){
    Swal.fire({
        title : 'Atenção!',
        html  : `O campo <b>${campo}</b> deve ser preenchido.`,
        icon  : 'error',
    });
}

function cadastraNovoCurso(form){
   $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/cursos/instituicao_cursos',
        type: 'POST',
        data: form,
        dataType:'json',
        success:function(response){
           if(response.validator_fail){
               mensagemErro(response.validator_fail);
           } else {
               mensagemSucesso(response.cadastro);
               fecharModal();
               $('#table-cursos').DataTable().ajax.reload();
           }
        }
   })
}

function mensagemErro(mensagem){
    Swal.fire({
        title: 'Atenção!',
        text: mensagem,
        icon: 'error',
    })
}

function mensagemSucesso(swal){
    Swal.fire({
        title: swal['titulo'],
        text: swal['mensagem'],
        icon: 'success',
    })
}

function fecharModal(){
    $('#form-cadastra-cursos input').val('');
    $("#modalCadastrarCursos button[data-dismiss='modal']").trigger('click');
}

$(document).on('click', '.editar-curso', function(){
    let curso = {
        'id'   : $(this).attr('ref'),
        'nome' : $(this).parent().parent().parent().find('td:nth-child(1)').text(),
        'carga_horaria' : $(this).parent().parent().parent().find('td:nth-child(2)').text(),
    };
    let campo_editar = campoEditar(curso);
    $(this).attr('title', 'Voltar');
    $(this).find('i').html('keyboard_return');
    $(this).addClass('voltar-curso');
    $(this).removeClass('editar-curso');
});

function campoEditar(curso){
    html = "";
    html += `<tr class='edita_curso_${curso.id}'>
                <td>
                  <input type="text" class="form-control" maxlength="100" value="${curso.nome}">
                </td>
                <td>
                  <input type="text" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="5" value="${curso.carga_horaria}">
                </td>
                <td colspan='2'>
                   <button class='btn btn-success edita-curso' ref='${curso.id}'>Salvar</button>
                </td>
             </tr>`;

    $(`.editar-curso[ref="${curso.id}"]`).closest('tr').after(html);
}

$(document).on('click', '.voltar-curso', function(){
    $(this).find('i').html('edit');
    $('.edita_curso_' + $(this).attr('ref')).remove();
    $(this).addClass('editar-curso');
    $(this).removeClass('voltar-curso');
});

$(document).on('click', '.edita-curso', function(){
    Swal.fire({
       title: 'Atenção!',
       text: 'Deseja prosseguir com a edição deste curso?',
       icon: 'question',
       showCancelButton: true, 
       cancelButtonText: "Não",
       confirmButtonText: 'Sim',
       cancelButtonColor: "#d9534f",
       confirmButtonColor: "#5cb85c",
    }).then((result) => {
        if(result.value){
            validaEditarCurso($(this).attr('ref'))
        }
    });
});

function validaEditarCurso(id){
    let form = {
       'id' : id,
       'acao': 'editar',
       'curso': $(`.edita_curso_${id} td:nth-child(1) input`).val(),
       'carga_horaria': $(`.edita_curso_${id} td:nth-child(2) input`).val(),
    }

    if(form.nome == "" || form.carga_horaria == ""){
       let campo = form.nome == "" ? 'Curso' : 'Carga Horária';
       campoVazio(campo);
    } else {
        editarCurso(form);
    }
}

function editarCurso(form){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/cursos/instituicao_cursos',
        type: 'POST',
        data: form,
        dataType:'json',
        success:function(response){
           if(response.validator_fail){
               mensagemErro(response.validator_fail);
           } else {
               mensagemSucesso(response.editado);
               $('#table-cursos').DataTable().ajax.reload();
           }
        }
    })
} 

$(document).on('click', '.desativar-curso', function(){
    Swal.fire({
        title: 'Atenção!',
        text: 'Deseja desativar este curso?',
        icon: 'warning',
        showCancelButton: true, 
        cancelButtonText: "Não",
        confirmButtonText: 'Sim',
        cancelButtonColor: "#d9534f",
        confirmButtonColor: "#5cb85c",
    }).then((result) => {
        if(result.value){
            desativarCurso($(this).attr('ref'));
        }
    });
})

function desativarCurso(id){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/cursos/instituicao_cursos',
        type: 'POST',
        data: 'id=' + id + '&acao=desativar',
        dataType:'json',
        success:function(response){
           if(response.validator_fail){
               mensagemErro(response.validator_fail);
           } else {
               mensagemSucesso(response.desativado);
               $('#table-cursos').DataTable().ajax.reload();
           }
        }
    })
}