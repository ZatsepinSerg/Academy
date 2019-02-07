@extends('layout_parts.layout')
@include('layout_parts.errors')

@section('content')

    <div>
        <p>
            {{$numberOne}} + {{$numberTwo}}
        </p>
        <input class="input-group" name="sum" type="number" required>
    </div>

    <div class="col-sm-8 col-lg-8"></div>
    <div class="col-sm-2 col-lg-2">
        <button class="btn btn-info">Next
        </button>
    </div>
@endsection



