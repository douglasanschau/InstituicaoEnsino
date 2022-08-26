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

    getAlunos();
    $('#cpf_aluno').mask('000.000.000.00');
    $('#nascimento_aluno').mask('00/00/0000');
});

function acoesDataTable(id, id_matricula){
 let buttons = `<div class='acoes'> 
                    <button type='button' class='btn btn-info edita-matricula' ref='${id}' ref-matricula="${id_matricula}" title='Editar'>
                        <i class='material-icons'>edit</i>
                    </button>
                    <button type='button' class='btn btn-danger exclui-matricula' ref='${id}' ref-matricula="${id_matricula}" title='Excluir'>
                        <i class='material-icons'>delete</i>
                    </button>
                </div>`;
 return buttons;
} 

function getAlunos(id_aluno = null){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }, 
        url: '/matriculas/alunos',
        type: 'GET', 
        dataType: 'json',
        success:function(response){
          selectAlunos(response, id_aluno);
        }
    });
}

function selectAlunos(alunos, id = null){
    let html = "";
    $.each(alunos, function(index, aluno){
      let selected = aluno.id == id ? 'selected' : '';
      html += `<option  ${selected} value="${aluno.id}">${aluno.nome} ${aluno.sobrenome}</option>`;
    })
    $('#aluno optgroup[label="Alunos Cadastrados"]').html(html);
}

$('.nova-matricula').on('click', function(){
  $('#modalCadastrarMatricula #form-cadastra-matricula input[name="acao"]').val('cadastrar');
  $('#modalCadastrarMatricula #form-cadastra-matricula #aluno').val('');
  etapaAluno();
  $('.aluno_selected, .curso_selected').hide();
  $('.aluno_select, .curso_select').show();
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
    $('#modalCadastrarMatricula input:not(:input[type="hidden"])').val('');
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
   $('#modalCadastrarMatricula #aluno_selected').val(info_aluno.nome + " " + info_aluno.sobrenome);
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
    $('#modalCadastrarMatricula #curso_selected').val($('#modalCadastrarMatricula #curso option:selected').text());
    $('#modalCadastrarMatricula #situacao').val(info_matricula.situacao);
    $('#modalCadastrarMatricula #semestre').val(info_matricula.semestre);
}

$('#salvar_matricula').on('click', function(){
    let etapa = etapaAtual();
    verificaCamposMatricula(etapa);
});

function etapaAtual(){
    let etapa = $('#form-cadastra-matricula input[name="etapa-cadastro"]').val();
    return etapa;
}

function verificaCamposMatricula(etapa) {
    let salvar = true;
    let campos_ignorar = {'curso_selected' : true, 'aluno_selected' : true};

    $(`#form-cadastra-matricula .etapa-${etapa} .form-control`).each(function(){
      if($('#' + this.id).val() == "" && campos_ignorar[this.id] == undefined){
         modalCampoVazio(this.id);
         salvar = false; 
         return false;
      } 
    });

    if(salvar) {
        let form = $(`#form-cadastra-matricula`).serialize();
        atualizaMatricula(form);
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

function getUrlMatricula(){
   let etapa = etapaAtual();
   switch(etapa){
        case 'endereco':
          url = "/matriculas/instituicao_endereco";
        break;
        case 'matricula':
          url = "/matriculas/instituicao_matricula";
        break;
        default:
          url = "/matriculas/instituicao_aluno";
        break; 
   }
   return url;
}

function atualizaMatricula(form){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }, 
        url: getUrlMatricula(),
        type: 'POST', 
        data: form,
        dataType: 'json',
        success:function(response){
           if(response.validator_fails){
              modalMessageErro(response.validator_fails);
           } else {
               Swal.fire({
                   title: response.title,
                   message: response.message,
                   icon: 'success',
               });
               proximaEtapa();
               if(response.id_aluno){
                   getAlunos(response.id_aluno);
               }
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

function proximaEtapa(){
    let etapa = etapaAtual(); 
    etapa = $("#form-cadastra-matricula input[name='acao']").val() == 'editar' && etapa == 'matricula' ? 'fechar_modal' : etapa;
    switch(etapa){
        case 'aluno':
            etapaEndereco();        
        break;
        case 'endereco':
            etapaMatricula();              
        break;
        case 'matricula': 
          etapaAluno();
          $('#modalCadastrarMatricula #form-cadastra-matricula #aluno').val('');
          $('#table-matriculas').DataTable().ajax.reload();
        break;
        default: 
          $('#modalCadastrarMatricula').modal('hide');
          $('#table-matriculas').DataTable().ajax.reload();
        break;
    }
}

function etapaAluno(cadastrar = true){
    $('.etapas-matricula').hide();
    $('.etapa-aluno').show();   
    $('#modalCadastrarMatricula #form-cadastra-matricula input[name="etapa-cadastro"]').val('aluno');
    $('#modalCadastrarMatricula .btn-voltar').hide();
    $('#modalCadastrarMatricula button[data-dismiss="modal"]').show();
    $('#modalCadastrarMatricula .title-modal').html("Dados do Aluno");     
    if(cadastrar){
        limparModalMatriculas();
    }  
}

function etapaEndereco(){
    $('.etapas-matricula').hide();
    $('.etapa-endereco').show();   
    $('#modalCadastrarMatricula #form-cadastra-matricula input[name="etapa-cadastro"]').val('endereco');
    $('#modalCadastrarMatricula button[data-dismiss="modal"]').hide();
    $('#modalCadastrarMatricula .btn-voltar').show();
    $('#modalCadastrarMatricula .title-modal').html("Endereço");       
}


function etapaMatricula(){
    $('.etapas-matricula').hide();
    $('.etapa-matricula').show();
    $('#modalCadastrarMatricula #form-cadastra-matricula input[name="etapa-cadastro"]').val('matricula');
    $('#modalCadastrarMatricula button[data-dismiss="modal"]').hide();
    $('#modalCadastrarMatricula .btn-voltar').show();
    $('#modalCadastrarMatricula .title-modal').html("Matricula");      
}

$('.btn-voltar').on('click', function(){
   etapaAnterior();
});

function etapaAnterior(){
    let etapa = etapaAtual(); 
    switch(etapa){
        case 'matricula':
           etapaEndereco();     
        break;
        default:
           etapaAluno(false);
        break;
    }
}

$(document).on('click', '.edita-matricula', function(){
  let id = $(this).attr('ref');
  let id_matricula = $(this).attr('ref-matricula');
  infoAlunoMatricula(id, id_matricula);
  etapaAluno(false);
  $('#modalCadastrarMatricula #form-cadastra-matricula #aluno').val(id);
  $('#modalCadastrarMatricula #form-cadastra-matricula input[name="acao"]').val('editar');
  $('.aluno_select, .curso_select').hide();
  $('.aluno_selected, .curso_selected').show();
  $('#modalCadastrarMatricula').modal('show');
});

$(document).on('click', '.exclui-matricula', function(){
   let id_matricula = $(this).attr('ref-matricula');
   Swal.fire({
       title: 'Atenção!',
       text: 'Deseja excluír definitivamente esta matricula?',
       icon: 'warning',
       showCancelButton: true, 
       cancelButtonText: "Não",
       confirmButtonText: 'Sim',
       cancelButtonColor: "#d9534f",
       confirmButtonColor: "#5cb85c",
   }).then((result) => {
       if(result.value){
           excluirMatricula(id_matricula);
       }
   });
});

function excluirMatricula(id_matricula){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }, 
        url: '/matriculas/exclui_matricula',
        type: 'POST', 
        data: 'id_matricula=' + id_matricula,
        dataType: 'json',
        success:function(response){
            Swal.fire({
                title: 'Matricula Excluída!',
                message: 'A matricula foi excluída com sucesso.',
                icon: 'success',
            }); 
            $('#table-matriculas').DataTable().ajax.reload();
        }
    })
}

 