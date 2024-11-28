<div wire:ignore.self data-backdrop="static" class="modal fade edit" id="edit-{{ $objDir->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(216, 228, 231)">
                <h5 class="modal-title">
                    Editar: {{ $objDir->nombre }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-bold-close icon-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                @livewire('corebase.direccion.form', ['Direcciones' => $objDir, 'method' => 'update'], key($objDir->id))
            </div>
        </div>
    </div>
</div>
