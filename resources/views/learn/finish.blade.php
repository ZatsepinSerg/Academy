@extends('layout_parts.layout')
@include('layout_parts.errors')

@section('content')
    <div>
        <img  src="{{URL::asset("storage/".$resultTest['image']}}" class="rounded mx-auto d-block" >
    </div>
    <div>
        <p>
            Поздравляем,{{$resultTest['email']}}!!!
        </p>
        <p>
            Твоя оценка :{{$resultTest['result']}} баллов
        </p>
        <p>
            Общее время прохождения теста :{{$resultTest['totalTime']}} сек.
        </p>

    </div>
    <div class="col-sm-8 col-lg-8"></div>
    <div class="col-sm-2 col-lg-2">
        <form action="/" method="get">
            <input type="submit" class="btn btn-info" value="Перейти в начало">
        </form>
    </div>

@endsection