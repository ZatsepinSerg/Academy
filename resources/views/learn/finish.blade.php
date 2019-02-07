@extends('layout_parts.layout')
@include('layout_parts.errors')

@section('content')
    <div>
        <img src="{{$test}}" class="rounded mx-auto d-block" alt="MyImage">
    </div>
    <div>
        <p>
            Поздравляем!!!, {{$email}}
        </p>
        <p>
            Твоя оценка -{{$result}} баллов
        </p>
        <p>
            Общее время прохождения теста - {{$total_time}} сек.
        </p>

    </div>
    <div class="col-sm-8 col-lg-8"></div>
    <div class="col-sm-2 col-lg-2">
        <button class="btn btn-info">Перейти в начало
        </button>
    </div>
@endsection