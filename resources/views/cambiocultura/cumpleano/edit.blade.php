<div wire:ignore.self data-backdrop="static" class="modal fade edit" id="edit-{{ $objFil->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Editar: {{ $objFil->id }} 
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-row">
                    
                    @livewire('cumpleano.form', ['Filiaciones' => $objFil, 'method' => 'update'], key($objFil->id))

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>