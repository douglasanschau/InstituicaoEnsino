<div class="modal" tabindex="-1" id="modalCadastrarMatricula" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="card">
            <div class="modal-header">
                 <h5 class="title-modal">Dados do Aluno</h5>
            </div>
            <div class="modal-body">
                <form id="form-cadastra-matricula">
                    <input type="hidden" name="acao" value="">
                    <input type="hidden" name="etapa-cadastro" value="aluno">
                    <div class="row p-3 etapas-matricula etapa-aluno">
                            <div class="col-md-6 mt-1 aluno_select">
                                <label for="aluno"> Aluno </label>
                                <select class="form-control" name="aluno" id="aluno">
                                    <option value=""></option>
                                    <optgroup label="Alunos Cadastrados">
                                      
                                    </optgroup>
                                    <optgroup label="Cadastrar Aluno">
                                        <option value="0">Novo Aluno</option>
                                    </optgroup>  
                                </select>
                            </div>
                            <div class="col-md-6 mt-1 aluno_selected" style="display:none;">
                                <label for="aluno_selected"> Aluno </label>
                                <input type="text" class="form-control" id="aluno_selected" name="aluno_selected" value="" disabled>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <label for="nome_aluno"> Nome </label>
                                <input type="text" name="nome_aluno" id="nome_aluno" class="form-control" maxlength="80">
                             </div>
                             <div class="col-md-6">
                                <label for="sobrenome_aluno"> Sobrenome </label>
                                <input type="text" name="sobrenome_aluno" id="sobrenome_aluno" class="form-control" maxlength="150">
                            </div>
                            <div class="col-md-6">
                                <label for="nascimento_aluno"> Data de Nascimento </label>
                                <input type="text" name="nascimento_aluno" id="nascimento_aluno" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="email_aluno"> E-mail </label>
                                <input type="email" name="email_aluno" id="email_aluno" class="form-control" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label for="rg_aluno"> RG </label>
                                <input type="text" name="rg_aluno" id="rg_aluno" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" maxlength="11">
                            </div>
                            <div class="col-md-6">
                                <label for="cpf_aluno"> CPF </label>
                                <input type="text" name="cpf_aluno" id="cpf_aluno" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="mae_aluno"> Nome Completo da Mãe </label>
                                <input type="text" name="mae_aluno" id="mae_aluno" class="form-control" maxlength="150">
                            </div>
                            <div class="col-md-6">
                                <label for="pai_aluno"> Nome Completo do Pai </label>
                                <input type="text" name="pai_aluno" id="pai_aluno" class="form-control" maxlength="150">
                            </div>
                    </div>
                    <div class="row p-3 etapas-matricula etapa-endereco" style="display:none;">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-9">
                                    <label for="logradouro"> Logradouro </label>
                                    <input type="text" class="form-control" name="logradouro" id="logradouro" maxlength="100">
                                </div>
                                <div class="col-md-3">
                                    <label for="numero"> Número </label>
                                    <input type="text" class="form-control" name="numero" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="numero" maxlength="11">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="bairro"> Bairro </label>
                            <input type="text" class="form-control" name="bairro" id="bairro" maxlength="100">
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-9">
                                    <label for="cidade"> Cidade </label>
                                    <input type="text" class="form-control" name="cidade" id="cidade" maxlength="100">
                                </div>
                                <div class="col-md-3">
                                    <label for="estado"> Estado </label>
                                    <select class="form-control" name="estado" id="estado">
                                        <option value=""></option>
                                        @foreach($info['estados'] as $estado)
                                           <option value="{{$estado->id}}">{{$estado->sigla}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-3 etapas-matricula etapa-matricula" style="display:none;">
                        <div class="col-md-6 curso_select">
                            <label for="curso"> Curso </label>
                            <select class="form-control" name="curso" id="curso">
                                <option value=""></option>
                                @foreach($info['cursos'] as $curso)
                                  <option value="{{$curso->id}}">{{$curso->nome}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="col-md-6 curso_selected" style="display:none;">
                            <label for="curso"> Curso </label>
                            <input type="text" class="form-control" id="curso_selected" name="curso_selected" value="" disabled>
                        </div>
                        <div class="col-md-6">
                           <div class="row">
                                <div class="col-md-8">
                                    <label for=""> Situação </label>
                                    <select class="form-control" name="situacao" id="situacao">
                                        <option value=""></option>
                                        @foreach($info['matriculas_situacao'] as $matricula)
                                            <option value="{{$matricula->sigla}}">{{$matricula->situacao}}</option>
                                        @endforeach 
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="semestre"> Semestre </label>
                                    <select class="form-control" name="semestre" id="semestre">
                                        <option value=""></option>
                                        @for($i = 1; $i <= 8; $i++)
                                        <option value="{{$i}}">{{$i."º"}}</option>
                                        @endfor
                                    </select>
                                </div>
                           </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="salvar_matricula" class="btn btn-success">Avançar</button>
          <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-light btn-voltar" style="display:none;">Voltar</button>
        </div>
      </div>
    </div>
  </div>