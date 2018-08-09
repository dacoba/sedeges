<div class="form-group mt-3{{ $errors->has('observacion_requisitos') ? ' has-error' : '' }}">
    <label for="observacion_requisitos">Observacion</label>
    <textarea class="form-control" id="observacion_requisitos" name="observacion_requisitos" rows="3" placeholder="Observaciones en la Verificacion de Requisitos.">@if(old('observacion_requisitos')){{ old('observacion_requisitos') }}@else{{ $solicitud['observacion_requisitos'] }}@endif</textarea>
    @if ($errors->has('observacion_requisitos'))
        <span class="help-block">
                                    <strong>{{ $errors->first('observacion_requisitos') }}</strong>
                                </span>
    @endif
</div>
<input type="hidden" name="verificacion_requisitos" id="verificacion_requisitos" value="false">
<div class="row">
    <div class="col-6">
        <button type="submit" class="btn btn-danger btn-block">
            Rechasar Solicitud
        </button>
    </div>
    <div class="col-6">
        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModalCenter">
            Confirmar Solicitud
        </button>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Equipo Tecnico Encargado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="trabajador_social_id">Trabajador Social</label>
                    <select class="form-control" name="trabajador_social_id">
                        @foreach($equipo['trabajador_socials'] as $trabajador_social)
                            <option value="{{ $trabajador_social['id'] }}">{{ $trabajador_social['nombres'] }} {{ $trabajador_social['apellido_paterno'] }} {{ $trabajador_social['apellido_materno'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="psicologo_id">Psicólogo</label>
                    <select class="form-control" name="psicologo_id">
                        @foreach($equipo['psicologos'] as $psicologo)
                            <option value="{{ $psicologo['id'] }}">{{ $psicologo['nombres'] }} {{ $psicologo['apellido_paterno'] }} {{ $psicologo['apellido_materno'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="doctor_id">Doctor</label>
                    <select class="form-control" name="doctor_id">
                        @foreach($equipo['doctors'] as $doctor)
                            <option value="{{ $doctor['id'] }}">{{ $doctor['nombres'] }} {{ $doctor['apellido_paterno'] }} {{ $doctor['apellido_materno'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success" onclick="ConfirmVerificacionRequisitos();">Asignar Solicitud</button>
            </div>
        </div>
    </div>
</div>