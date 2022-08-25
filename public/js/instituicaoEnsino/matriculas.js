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
                   return acoesDataTable(data.id, data.id_matricula);
                }
            }
        ]
    });

    $('#cpf_aluno').mask('000.000.000.00');
    $('#nascimento_aluno').mask('00/00/0000');
});

function acoesDataTable(id, id_matricula){
 let buttons = `<div class='acoes'> 
                    <button type='button' class='btn btn-info edita-matricula' ref='${id}' ref-matricula="${id_matricula}" title='Editar'>
                        <i class='material-icons'>edit</i>
                    </button>
                    <button type='button' class='btn btn-danger' ref='${id}' ref-matricula="${id_matricula}" title='Editar'>
                        <i class='material-icons'>delete</i>
                    </button>
                </div>`;
 return buttons;
} 

$('.nova-matricula').on('click', function(){
  $('#modalCadastrarMatricula #form-cadastra-matricula #aluno').val('');
  $('#modalCadastrarMatricula #form-cadastra-matricula #aluno').attr('disabled', false);
  $('#modalCadastrarMatricula #form-cadastra-matricula input[name="acao"]').val('cadastrar');
  limparModalMatriculas();
  $('#modalCadastrarMatricula').modal('show');
});

$('button[data-dismiss="modal"]').on('click', function(){
    $('.modal').modal('hide');
});

$('#aluno').on('change', function(){
  if($(this).val() == "0"){
    limparModalMatriculas();
  } else {
    infoAlunoMatricula($(this).val());
  }
});

function limparModalMatriculas(){
    $('#modalCadastrarMatricula input').val('');
    $('#modalCadastrarMatricula select:not(#aluno)').val('');
}

function infoAlunoMatricula(id_aluno, id_matricula = null){
    $.ajax({
        url: '/matriculas/info_aluno',
        type: 'GET',
        data: 'id=' + id_aluno + '&id_matricula=' + id_matricula,
        dataType: 'json',
        success:function(response){
            atualizaDadosAluno(response.aluno);
            atualizaEnderecoAluno(response.endereco);
            if(response.matricula){
                atualizaMatriculaAluno(response.matricula);
            }
        }
    });
}

function atualizaDadosAluno(info_aluno){
   $('#modalCadastrarMatricula #nome_aluno').val(info_aluno.nome);
   $('#modalCadastrarMatricula #sobrenome_aluno').val(info_aluno.sobrenome);
   $('#modalCadastrarMatricula #nascimento_aluno').val(info_aluno.data_nascimento);
   $('#modalCadastrarMatricula #email_aluno').val(info_aluno.email);
   $('#modalCadastrarMatricula #rg_aluno').val(info_aluno.rg);
   $('#modalCadastrarMatricula #cpf_aluno').val(info_aluno.cpf).trigger('input');
   $('#modalCadastrarMatricula #mae_aluno').val(info_aluno.nome_mae);
   $('#modalCadastrarMatricula #pai_aluno').val(info_aluno.nome_pai);
}

function atualizaEnderecoAluno(info_endereco){
  $('#modalCadastrarMatricula #logradouro').val(info_endereco.logradouro);
  $('#modalCadastrarMatricula #numero').val(info_endereco.numero);
  $('#modalCadastrarMatricula #bairro').val(info_endereco.bairro);
  $('#modalCadastrarMatricula #cidade').val(info_endereco.cidade);
  $('#modalCadastrarMatricula #estado').val(info_endereco.estado);
}

function atualizaMatriculaAluno(info_matricula){
    $('#modalCadastrarMatricula #curso').val(info_matricula.curso);
    $('#modalCadastrarMatricula #situacao').val(info_matricula.situacao);
    $('#modalCadastrarMatricula #semestre').val(info_matricula.semestre);
}

$('#salvar_matricula').on('click', function(){
   verificaCamposMatricula();
});

function verificaCamposMatricula() {
    let salvar = true;

    $('#form-cadastra-matricula .form-control').each(function(){
      if($('#' + this.id).val() == ""){
         modalCampoVazio(this.id);
         salvar = false; 
         return false;
      } 
    });

    if(salvar) {
        let form = $('#form-cadastra-matricula').serialize();
        let acao = $('#form-cadastra-matricula input[name="acao"]').val();
        if(acao == "cadastrar"){
            cadastraMatricula(form);
        } else {
            editarMatricula(form);
        }
    }
}

function modalCampoVazio(id_campo){
    let nome_campo = $(`#${id_campo}`).parent().find('label').first().text();
    Swal.fire({
      title: 'Atenção!',
      html: `O campo <b>${nome_campo}</b> não foi preenchido.`,
      icon: 'error'
    });
    $(`#${id_campo}`).focus();
}

function cadastraMatricula(form){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }, 
        url: '/matriculas/instituicao_matriculas',
        type: 'POST', 
        data: form,
        dataType: 'json',
        success:function(response){
           if(response.validator_fails){
              modalMessageErro(response.validator_fails);
           } else {
               Swal.fire({
                   title: 'Matricula Cadastrada!',
                   message: 'Matricula cadastrada com sucesso.',
                   icon: 'success',
               });
               $('#table-matriculas').DataTable().ajax.reload();
               limparModalMatriculas();
               $('#modalCadastrarMatricula #aluno').val('');
           }
        }
    })
}

function modalMessageErro(message){
    Swal.fire({
        title: 'Atenção!',
        text: message, 
        icon: 'error',
    });
}

$(document).on('click', '.edita-matricula', function(){
  let id = $(this).attr('ref');
  let id_matricula = $(this).attr('ref-matricula');
  infoAlunoMatricula(id, id_matricula);
  $('#modalCadastrarMatricula #form-cadastra-matricula #aluno').val(id);
  $('#modalCadastrarMatricula #form-cadastra-matricula #aluno').attr('disabled', true);
  $('#modalCadastrarMatricula #form-cadastra-matricula input[name="acao"]').val('editar');
  $('#modalCadastrarMatricula').modal('show');
});

 