<div>
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">       
            </div>
            <div class="card-toolbar">
                <button 
                    wire:click="{{ $method }}"
                    wire:loading.class="spinner spinner-white spinner-right" 
                    wire:loading.attr="disabled" 
                    wire:target="{{ $method }}" 
                    class="btn font-weight-bolder mr-2 btn-success">
                    <i class="fa fa-save"></i>
                    Guardar
                </button>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Form-->
            <form class="form" wire:submit.prevent="{{ $method }}">
                <div class="row">
                    <div class="col-xl-12">
                        
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Nombre Actividad <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Revisiones.nombreactividad" 
                                            type="text" 
                                            disabled
                                            class="form-control form-control-solid @error('Revisiones.nombreactividad') is-invalid @enderror"  
                                            placeholder="Ej: Gestión de redes sociales" /> 
                                    </div>
                                    @error('Revisiones.nombreactividad') 
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Resumen <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Revisiones.resumen" 
                                            type="text"
                                            disabled 
                                            class="form-control form-control-solid @error('Revisiones.resumen') is-invalid @enderror"  
                                            placeholder="Ej: Funciones de la Dirección" /> 
                                    </div>
                                    @error('Revisiones.resumen') 
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                
                                </div>
                            </div>
                            <label for="inputCodigo">Medios a publicar <span class="text-danger">*</label>
                            <div class="form-row" align="center">
                                <div class="form-group col-2">
                                    <div class="form-check form-switch">
                                        <input 
                                            wire:model.defer="Revisiones.whatsapp"
                                            class="form-control form-control-solid" 
                                            type="checkbox" 
                                            id="whatsapp">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Whatsapp</label>
                                    </div>
                                </div>
                                <div class="form-group col-2">
                                    <div class="form-check form-switch">
                                        <input 
                                            wire:model.defer="Revisiones.facebook"
                                            class="form-control form-control-solid" 
                                            type="checkbox" 
                                            id="facebook">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Facebook</label>
                                    </div>
                                </div>
                                <div class="form-group col-2">
                                    <div class="form-check form-switch">
                                        <input 
                                            wire:model.defer="Revisiones.twitter"
                                            class="form-control form-control-solid" 
                                            type="checkbox" id="twitter">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Twitter</label>
                                    </div>
                                </div>
                                <div class="form-group col-2">
                                    <div class="form-check form-switch">
                                        <input 
                                            wire:model.defer="Revisiones.instagram"
                                            class="form-control form-control-solid" 
                                            type="checkbox" 
                                            id="instagram">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Instagram</label>
                                    </div>
                                </div>
                                <div class="form-group col-2">
                                    <div class="form-check form-switch">
                                        <input 
                                            wire:model.defer="Revisiones.correo"
                                            class="form-control form-control-solid" 
                                            type="checkbox" id="correo">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Correo</label>
                                    </div>
                                </div>
                                <div class="form-group col-2">
                                    <div class="form-check form-switch">
                                        <input 
                                            wire:model.defer="Revisiones.web"
                                            class="form-control form-control-solid" 
                                            type="checkbox" id="web">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Sitio web</label>
                                    </div>
                                </div>
                            </div>
                            <label for="inputCodigo">Marque si desea cerrar el proyecto <span class="text-danger"></label>
                            <div class="form-row" align="center">
                                <div class="form-group col-3">
                                    <div class="form-check form-switch">
                                        <input 
                                            wire:model.defer="Revisiones.cerrado"
                                            class="form-control form-control-solid" 
                                            type="checkbox" 
                                            id="cerrado">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Cerrar Evento</label>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>