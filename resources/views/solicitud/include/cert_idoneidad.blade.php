@if (in_array(202, $DocumentsTypesStored) and $solicitud['demanda_adopcion'])
    @if (!in_array(201, $DocumentsTypesStored))
        <div class="form-group mt-2{{ $errors->has('doc_file') ? ' mb-0' : '' }}">
            <div class="form-row">
                <div class="col-md-4">
                    <label for="doc_type">Documento</label>
                    <select class="form-control" name="doc_type" readonly>
                        <option value="201">Certificado de Idoneidad</option>
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
    @endif
    <div class="form-group{{ $errors->has('observacion_documentos') ? ' has-error' : '' }}">
        <label for="observacion_documentos">Observacion</label>
        <textarea class="form-control" id="observacion_documentos" name="observacion_documentos" rows="3" placeholder="Observaciones de la Revision de Documentos.">@if(old('observacion_documentos')) {{ old('observacion_documentos') }} @else{{ $solicitud['observacion_documentos'] }}@endif</textarea>
        @if ($errors->has('observacion_documentos'))
            <span class="help-block"><strong>{{ $errors->first('observacion_documentos') }}</strong></span>
        @endif
    </div>
    <button type="submit" class="btn btn-primary btn-block">
        Enviar Documentos a Area Juridica
    </button>
@elseif(!in_array(202, $DocumentsTypesStored))
    <h6 class="text-center text-danger mb-4">Sin Certificado de Taller de Preparacion a Madres y Padres en Proceso de Adopcion</h6>
@endif