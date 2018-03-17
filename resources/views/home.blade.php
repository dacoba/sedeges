@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4 mb-3">Home
        <small>Principal</small>
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.html">Home</a>
        </li>
        <li class="breadcrumb-item active">Principal</li>
    </ol>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
</div>
@endsection
