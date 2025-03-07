<div wire:ignore.self data-backdrop="static" class="modal fade edit" id="edit-{{ $objVacuna->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Editar: {{ $objVacuna->nombre }} 
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                
                @livewire('vacuna.form', ['Vacunas' => $objVacuna, 'method' => 'update'], key($objVacuna->id))
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>