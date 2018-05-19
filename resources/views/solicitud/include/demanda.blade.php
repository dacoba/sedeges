<div class="form-group{{ $errors->has('observacion_demanda') ? ' has-error' : '' }}">
    <label for="observacion_demanda">Observacion</label>
    <textarea class="form-control" id="observacion_demanda" name="observacion_demanda" rows="3" placeholder="Observaciones de la Demanada.">@if(old('observacion_demanda')) {{ old('observacion_demanda') }} @else{{ $solicitud['observacion_demanda'] }}@endif</textarea>
    @if ($errors->has('observacion_demanda'))
        <span class="help-block"><strong>{{ $errors->first('observacion_demanda') }}</strong></span>
    @endif
</div>
<button type="submit" class="btn btn-primary btn-block">
    Demanda de Adopcion Recibida
</button>