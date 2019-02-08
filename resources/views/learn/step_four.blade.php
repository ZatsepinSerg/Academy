@extends('layout_parts.layout')
@include('layout_parts.errors')

@section('content')
    <div class="col-lg-2"></div>
    <div class="col-lg-8"
         style="border: 1px solid #ddd;margin-top: 40px;border-radius: 5px;padding: 20px 20px 20px 20px;background: aliceblue;">
        <form action="/step-four" method="post" name="next">
            {{csrf_field()}}
            <h2> Какой сегодня день недели?</h2>

                @foreach( $tasks AS $key =>$task )
                <div class="radio">
                    <label> <input type="radio" name="day" value="{{$key}}" placeholder="{{$task}}">
                        {{$task}}</label>
                </div>
                @endforeach

            <button type="submit" class="btn btn-success pull-right" style="width: 20%;margin-top: 10px">Next</button>
        </form>
    </div>
    <div class="col-lg-2"></div>
@endsection
