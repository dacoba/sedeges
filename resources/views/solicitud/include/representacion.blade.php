<div class="form-group{{ $errors->has('observacion_representacion') ? ' has-error' : '' }}">
    <label for="observacion_representacion">Observacion</label>
    <textarea class="form-control" id="observacion_representacion" name="observacion_representacion" rows="3" placeholder="Observaciones de la Representacion.">@if(old('observacion_representacion')) {{ old('observacion_representacion') }} @else{{ $solicitud['observacion_representacion'] }}@endif</textarea>
    @if ($errors->has('observacion_representacion'))
        <span class="help-block"><strong>{{ $errors->first('observacion_representacion') }}</strong></span>
    @endif
</div>
<button type="submit" class="btn btn-primary btn-block">
    Iniciar Representacion
</button>