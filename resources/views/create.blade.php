@extends('layouts.app')

@section('content')
<div class="card mb-5">
    <div class="card-body">
        <form class="form-horizontal" id="form_solicitud" method="POST" action="{{ url('/document') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-4{{ $errors->has('doc_type') ? ' has-error' : '' }}">
                        <label for="doc_type">Documento</label>
                        <select class="form-control" name="doc_type">
                            @while($item = current($doc_registro))
                                <option value="{{key($doc_registro)}}" @if(old('doc_type') == key($doc_registro)) selected @endif>{{ $item }}</option>
                                <?php next($doc_registro) ?>
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
            <button type="submit" class="btn btn-primary btn-block">
                Registrar Solicitud
            </button>
        </form>
        <h2>Files</h2>
        <ul>
        @foreach($documents as $document)
            <li><a href="{{ url('/document') }}/{{$document['id']}}">{{$document['name']}}</a></li>
        @endforeach
        </ul>
    </div>
</div>
@endsection