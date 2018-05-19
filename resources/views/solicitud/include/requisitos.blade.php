@if(count($DocumentsTypes['requisitos']) != count($DocumentsTypesStored))
    <div class="form-group mt-2">
        <div class="form-row">
            <div class="col-md-4{{ $errors->has('doc_type') ? ' has-error' : '' }}">
                <label for="doc_type">Documento</label>
                <select class="form-control" name="doc_type">
                    @while($item = current($DocumentsTypes['requisitos']))
                        @if (!in_array(key($DocumentsTypes['requisitos']), $DocumentsTypesStored))
                            <option value="{{key($DocumentsTypes['requisitos'])}}" @if(old('doc_type') == key($DocumentsTypes['requisitos'])) selected @endif>{{ $item }}</option>
                        @endif
                        <?php next($DocumentsTypes['requisitos']) ?>
                    @endwhile
                </select>
            </div>
            <div class="col-md-8{{ $errors->has('doc_file') ? ' has-error' : '' }}">
                <label for="doc_file">Archivo</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="doc_file" name="doc_file" lang="es">
                    <label class="custom-file-label" for="doc_file">Seleccionar Archivo</label>
                </div>
                @if ($errors->has('doc_file'))
                    <span class="help-block">
                                                <strong>{{ $errors->first('doc_file') }}</strong>
                                            </span>
                @endif
            </div>
        </div>
    </div>
@endif
<div class="form-group mt-3{{ $errors->has('observacion_registro') ? ' has-error' : '' }}">
    <label for="observacion_registro">Observacion</label>
    <textarea class="form-control" id="observacion_registro" name="observacion_registro" rows="3" placeholder="Observaciones de la Solicitud de Adopcion.">@if(old('observacion_registro')) {{ old('observacion_registro') }} @else {{ $solicitud['observacion_registro'] }} @endif</textarea>
    @if ($errors->has('observacion_registro'))
        <span class="help-block">
                                    <strong>{{ $errors->first('observacion_registro') }}</strong>
                                </span>
    @endif
</div>
@if(count($DocumentsTypes['requisitos']) != count($DocumentsTypesStored))
    <button type="submit" class="btn btn-primary btn-block">
        Actualizar Solicitud
    </button>
@else
    <button type="submit" class="btn btn-success btn-block">
        Confirmar Solicitud
    </button>
@endif