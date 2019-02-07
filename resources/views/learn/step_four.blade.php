@extends('layout_parts.layout')
@include('layout_parts.errors')

@section('content')
    <form action="/step-three" method="get" name="next">
        {{csrf_field()}}
        <div>
            <p>
                Какой сегодня день недели?
            </p>
            @foreach( $tasks AS $key =>$task )
                <input type="radio" name="day[]" value="{{$key}}" placeholder="{{$task}}">
                <label>{{$task}}</label>
                </br>
            @endforeach

        </div>
        <input type="submit" placeholder="Next">
    </form>
@endsection
