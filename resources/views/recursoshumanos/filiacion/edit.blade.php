<div wire:ignore.self data-backdrop="static" class="modal fade edit" id="edit-{{ $objFil->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(216, 228, 231)">
                <h5 class="modal-title">
                    Editar: {{ $objFil->id }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-bold-close icon-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-row">
                    @livewire('recursoshumanos.filiacion.form', ['Filiaciones' => $objFil, 'method' => 'update'], key($objFil->id))
                </div>
            </div>
        </div>
    </div>
</div>
