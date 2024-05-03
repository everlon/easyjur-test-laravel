<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Editar Tarefa</h5>
        </div>
        <form action="{{ url('agenda/' . $agenda->id) }}" method="post">
            @csrf
            @method("PATCH")
            <div class="modal-body">
                <input type="hidden" name="id" value="{{ $agenda->id }}">
                <input type="hidden" name="status" value="{{ $agenda->status }}">
                <label for="nome">Nome</label><br>
                <input type="text" name="nome" id="nome" class="form-control" value="{{ $agenda->nome }}" required><br>

                <label for="descricao">Descrição</label><br>
                <input type="text" name="descricao" id="descricao" class="form-control" value="{{ $agenda->descricao }}"><br>
            </div>
            <div class="modal-footer">
                <input type="submit" value="Salvar" class="btn btn-success"><br>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
            </div>
        </form>
    </div>
</div>
