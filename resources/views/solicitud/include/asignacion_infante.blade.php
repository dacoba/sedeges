<div class="form-group">
    <div class="form-row">
        <div class="col-md-6{{ $errors->has('infante') ? ' has-error' : '' }} {{ $errors->has('infante_id') ? ' has-error' : '' }}">
            <label for="infante">Infante</label>
            <input id="infante_search" name="infante" class="form-control" type="text" placeholder="Ingrese el CI del infante" value="{{ old('infante') }}">
            @if ($errors->has('infante'))
                <span class="help-block"><strong>{{ $errors->first('infante') }}</strong></span>
            @endif
            @if ($errors->has('infante_id'))
                <span class="help-block"><strong>{{ $errors->first('infante_id') }}</strong></span>
            @endif
        </div>
        <input type="hidden" name="infante_id" id="infante_id" value="{{ old('infante_id') }}">
        <div class="col-md-3{{ $errors->has('infante_age') ? ' has-error' : '' }}">
            <label for="infante_age">Edad</label>
            <input id="infante_age" name="infante_age" class="form-control" type="text" placeholder="-" value="{{ old('infante_age') }}" readonly>
        </div>
        <div class="col-md-3{{ $errors->has('infante_centro') ? ' has-error' : '' }}">
            <label for="infante_centro">Centro</label>
            <input id="infante_centro" name="infante_centro" class="form-control" type="text" placeholder="-" value="{{ old('infante_centro') }}" readonly>
        </div>
    </div>
</div>
<button type="submit" class="btn btn-primary btn-block">
    Asignar Niño
</button>