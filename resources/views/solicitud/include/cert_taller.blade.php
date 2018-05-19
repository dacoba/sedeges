@if(!in_array(202, $DocumentsTypesStored))
    <div class="form-group mt-2{{ $errors->has('doc_file') ? ' mb-1' : '' }}">
        <div class="form-row">
            <div class="col-md-4">
                <label for="doc_type">Documento</label>
                <select class="form-control" name="doc_type" readonly>
                    <option value="202">Taller de Preparacion</option>
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
    <button type="submit" class="btn btn-primary btn-block mb-4">
        Adjuntar Certificado de Taller de Preparacion
    </button>
@endif