<div wire:ignore.self data-backdrop="static" class="modal fade edit" id="edit-{{ $objTicket->id }}" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(216, 228, 231)">
                <h5 class="modal-title">
                    Editar: {{ $objTicket->titulo }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-bold-close icon-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                @livewire('soporte.ticketusertramite.form', ['Tickets' => $objTicket, 'method' => 'update'], key($objTicket->id))
            </div>
        </div>
    </div>
</div>
