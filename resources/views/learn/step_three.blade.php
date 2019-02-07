@extends('layout_parts.layout')
@include('layout_parts.errors')

@section('content')
    <form action="/step-three" method="get" name="next">
        {{csrf_field()}}
        <div>
            <p>
                Какие языки программирования ты знаешь?
            </p>
            @foreach( $tasks AS $key =>$param )
                <input type="checkbox" name="lang[]" value="{{$key}}" placeholder="{{$param}}">
                <label>{{$param}}</label>
                </br>
            @endforeach

        </div>
        <input type="submit" placeholder="Next">
    </form>
@endsection

