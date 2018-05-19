@foreach($DocumentsTypes['requisitos'] as $item)
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-5"></div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="requisitos" disabled @if (in_array(array_search($item, $DocumentsTypes['requisitos']), $DocumentsTypesStored)) checked @endif>
                <label class="custom-control-label" for="requisitos">{{ $item }}</label>
            </div>
        </div>
    </div>
@endforeach