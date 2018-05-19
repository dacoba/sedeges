<div class="form-group">
    <div class="form-row">
        <div class="col-sm-8 offset-sm-2 col-lg-4 offset-lg-4 text-center">
            <label for="informe_psicosocial" class="mr-3">Resultado del Informe</label>
            <input type="checkbox" class="d-none" checked id="informe_psicosocial" name="informe_psicosocial" data-toggle="toggle" data-on="Favorable" data-off="Desfavorable" data-onstyle="success" data-offstyle="danger">
        </div>
    </div>
</div>
<div class="form-group mt-2{{ $errors->has('doc_file') ? ' mb-0' : '' }}">
    <div class="form-row">
        <div class="col-md-4">
            <label for="doc_type">Documento</label>
            <select class="form-control" name="doc_type" readonly>
                <option value="203">Informe Psicosocial</option>
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
<div class="form-group{{ $errors->has('observacion_informe_psiosocial') ? ' has-error' : '' }}">
    <label for="observacion_informe_psiosocial">Observacion</label>
    <textarea class="form-control" id="observacion_informe_psiosocial" name="observacion_informe_psiosocial" rows="3" placeholder="Observaciones del Informe Psicosocial.">@if(old('observacion_informe_psiosocial')) {{ old('observacion_informe_psiosocial') }} @else{{ $solicitud['observacion_informe_psiosocial'] }}@endif</textarea>
    @if ($errors->has('observacion_informe_psiosocial'))
        <span class="help-block"><strong>{{ $errors->first('observacion_informe_psiosocial') }}</strong></span>
    @endif
</div>
<button type="submit" class="btn btn-primary btn-block">
    Subir Informe Psicosocial
</button>