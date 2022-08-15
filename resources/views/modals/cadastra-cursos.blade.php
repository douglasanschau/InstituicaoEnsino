<div class="modal" tabindex="-1" id="modalCadastrarCursos" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="title-modal">Novo Curso</h5>
        </div>
        <div class="modal-body">
          <form id="form-cadastra-cursos">
             <div class="row">
                 <div class="col-md-6"> 
                    <label for="curso"> Curso </label>
                    <input type="text" class="form-control" name="curso" id="curso" maxlength="100">
                 </div>
                <div class="col-md-6"> 
                    <label for="carga_horaria"> Carga Horária </label>
                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="carga_horaria" id="carga_horaria" maxlength="5">
                </div>
             </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="salvar_curso" class="btn btn-success">Salvar</button>
          <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>