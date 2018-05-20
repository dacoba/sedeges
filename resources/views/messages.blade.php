@if(isset($message['success']) and $message['success'])
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Satisfactorio!</strong> {{ $message['success_message'] }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(isset($message['warning']) and $message['warning'])
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Advertecia!</strong> {{ $message['warning_message'] }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(isset($message['error']) and $message['error'])
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Fallo!</strong> {{ $message['error_message'] }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif