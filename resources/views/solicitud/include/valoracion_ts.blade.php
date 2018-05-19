@if (is_null($solicitud['valoracion_trabajador_social_id']))
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Fecha de Valoracion</label>
                <input type="date" class="form-control text-right" id="fecha_valoracion" name="fecha_valoracion" aria-describedby="fecha_valoracionHelp" placeholder="Ingrese la fecha de valoracion">
                <small id="fecha_valoracionHelp" class="form-text text-muted">Fecha en la que sera realizada la valoracion respectiva.</small>
            </div>
            <button type="submit" class="btn btn-primary btn-block mb-2">Confirmar Fecha</button>
        </div>
    </div>
@else
    @if($solicitud['valoracion_trabajador_social']['estado'] == 0)
        @if($solicitud['valoracion_trabajador_social']['fecha_valoracion'] <= date('Y-m-d h:m:s'))
            <div class="mb-4">
                <div class="form-group jumbotron jumbotron-fluid">
                    <div class="form-row">
                        <div class="col-sm-8 offset-sm-2 col-lg-4 offset-lg-4 text-center">
                            <div class="row">
                                <label for="condiciones_vivienda" class="col-sm-7 text-right mt-auto">Condiciones de Vivienda</label>
                                <div class="col-sm-5">
                                    <input type="checkbox" name="condiciones_vivienda" checked data-toggle="toggle" data-on="Favorable" data-off="Desfavorable" data-onstyle="success" data-offstyle="danger" style="display: none;">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <label for="estructura_familiar" class="col-sm-7 text-right mt-auto">Estructura Familiar</label>
                                <div class="col-sm-5">
                                    <input type="checkbox" name="estructura_familiar" checked data-toggle="toggle" data-on="Favorable" data-off="Desfavorable" data-onstyle="success" data-offstyle="danger" style="display: none;">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <label for="situacion_actual" class="col-sm-7 text-right mt-auto">Situacion Actual</label>
                                <div class="col-sm-5">
                                    <input type="checkbox" name="situacion_actual" checked data-toggle="toggle" data-on="Favorable" data-off="Desfavorable" data-onstyle="success" data-offstyle="danger" style="display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-2{{ $errors->has('doc_file') ? ' mb-0' : '' }}">
                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="doc_type">Documento</label>
                            <select class="form-control" name="doc_type" readonly>
                                <option value="101">Informe Social</option>
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
                <div class="form-group{{ $errors->has('observacion_trabajador_social') ? ' has-error' : '' }}">
                    <label for="observacion_trabajador_social">Observacion</label>
                    <textarea class="form-control" id="observacion_trabajador_social" name="observacion_trabajador_social" rows="3" placeholder="Observaciones de la Valoracion Social.">@if(old('observacion_trabajador_social')) {{ old('observacion_trabajador_social') }} @else{{ $solicitud['observacion_trabajador_social'] }}@endif</textarea>
                    @if ($errors->has('observacion_trabajador_social'))
                        <span class="help-block"><strong>{{ $errors->first('observacion_trabajador_social') }}</strong></span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    Registrar Valoracion
                </button>
            </div>
        @else
            <div class="text-center jumbotron jumbotron-fluid">
                <h5>Valoracion Social Programada</h5>
                <h4>{{ $solicitud['valoracion_trabajador_social']['fecha_valoracion']->format('d \d\e F \d\e\l Y') }}</h4>
            </div>
        @endif
    @endif
@endif