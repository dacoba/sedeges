@if (is_null($solicitud['valoracion_doctor_id']))
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Fecha de Valoración</label>
                <input type="date" class="form-control text-right" id="fecha_valoracion" name="fecha_valoracion" aria-describedby="fecha_valoracionHelp" placeholder="Ingrese la fecha de valoración">
                <small id="fecha_valoracionHelp" class="form-text text-muted">Fecha en la que será realizada la valoración respectiva.</small>
            </div>
            <button type="submit" class="btn btn-primary btn-block mb-2">Confirmar Fecha</button>
        </div>
    </div>
@else
    @if ($solicitud['valoracion_doctor']['estado'] == 0)
        @if ($solicitud['valoracion_doctor']['fecha_valoracion'] <= date('Y-m-d h:m:s'))
            <div class="mb-4">
                <div class="form-group jumbotron jumbotron-fluid">
                    <div class="form-row">
                        <div class="col-sm-8 offset-sm-2 col-lg-4 offset-lg-4 text-center">
                            <label for="condicion_medica" class="mr-3">Condicion Medica</label>
                            <input type="checkbox" class="d-none" checked id="condicion_medica" name="condicion_medica" data-toggle="toggle" data-on="Favorable" data-off="Desfavorable" data-onstyle="success" data-offstyle="danger">
                        </div>
                    </div>
                </div>
                <div class="form-group mt-2{{ $errors->has('doc_file') ? ' mb-0' : '' }}">
                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="doc_type">Documento</label>
                            <select class="form-control" name="doc_type" readonly>
                                <option value="103">Certificado Medico</option>
                            </select>
                        </div>
                        <div class="col-md-8{{ $errors->has('doc_file') ? ' has-error' : '' }}">
                            <label for="doc_file">Archivo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input cursor-pointer" id="doc_file" name="doc_file" lang="es">
                                <label class="custom-file-label" for="doc_file">Seleccionar Archivo</label>
                            </div>
                            @if ($errors->has('doc_file'))
                                <span class="help-block"><strong>{{ $errors->first('doc_file') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('observacion_doctor') ? ' has-error' : '' }}">
                    <label for="observacion_doctor">Observacion</label>
                    <textarea class="form-control" id="observacion_doctor" name="observacion_doctor" rows="3" placeholder="Observaciones de la Valoración Medica.">@if(old('observacion_doctor')) {{ old('observacion_doctor') }} @else{{ $solicitud['observacion_doctor'] }}@endif</textarea>
                    @if ($errors->has('observacion_doctor'))
                        <span class="help-block"><strong>{{ $errors->first('observacion_doctor') }}</strong></span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    Registrar Valoración
                </button>
            </div>
        @else
            <div class="text-center jumbotron jumbotron-fluid">
                <h5>Valoración Medica Programada</h5>
                <h4>{{ $solicitud['valoracion_doctor']['fecha_valoracion']->format('d \d\e F \d\e\l Y') }}</h4>
            </div>
        @endif
    @endif
@endif