<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Criar nova Tarefa</h5>
    </div>
        <form action="{{ url('agenda') }}" method="post">
            <div class="modal-body">
            <p>
                {!! csrf_field() !!}
                <label>Nome</label></br>
                <input type="text" name="nome" id="nome" class="form-control" required></br>

                <label>Descrição</label></br>
                <input type="text" name="descricao" id="descricao" class="form-control" required></br></br>
            </p>
            </div>
            <div class="modal-footer">
                <input type="submit" value="Salvar" class="btn btn-success">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
            </div>
        </form>
  </div>
</div>
