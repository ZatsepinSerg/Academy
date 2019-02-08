@extends('layout_parts.layout')
@include('layout_parts.errors')

@section('content')
    <div class="col-sm-3 col-lg-3"></div>
    <div class="col-sm-5 col-lg-5" style="border: 1px solid #ddd;margin-top: 40px;border-radius: 5px;padding: 20px 20px 20px 20px;background: aliceblue;">
        @if(!empty($resultTest['image']))
        <img src="{{URL::asset("storage/".$resultTest['image'])}}"
             class="img-thumbnail">
        @else
            <img src="{{URL::asset("default.png")}}"
                 class="img-thumbnail">
         @endif
        <p>
            Поздравляем!!!,<b> {{$resultTest['email']}}</b>
        </p>
        <p>
            Твоя оценка: <b>{{$resultTest['result']}}</b> балла
        </p>
        <p>
            Общее время прохождения теста:<b> {{$resultTest['totalTime']}} </b>сек.
        </p>
        <form action="/" method="get">
            <button type="submit" class="btn btn-success center-block" style="width: 150px;margin-top: 10px">Перейти в
                начало
            </button>
        </form>
    </div>

@endsection