@extends('layout_parts.layout')
@include('layout_parts.errors')

@section('content')
    <div class="col-lg-2"></div>
    <div class="col-lg-8"
         style="border: 1px solid #ddd;margin-top: 40px;border-radius: 5px;padding: 20px 20px 20px 20px;background: aliceblue;">
        <h1>Азорские острова</h1>

        <p>
            Название островов, скорее всего, происходит от устаревшего португальского слова «azures»
            (созвучно русскому «лазурь»), что буквально означает «голубые». Есть и более поэтичная версия,
            утверждающая, что своё название острова взяли от слова «Açor» — ястреб («Ястребиными» острова называли
            арабы).
            По легенде мореходов, ястребы летели к своим гнёздам и указали путь к островам.
            Однако, поскольку в реальности эта птица никогда не обитала в данном регионе,
            учёные считают эту версию наименее вероятной.
        </p>
        <form method="get" action="/step-two">
            {{csrf_field()}}
            <button type="submit" class="btn btn-success pull-right" style="width: 20%;margin-top: 10px">Next</button>
        </form>
    </div>

    <div class="col-lg-2"></div>


@endsection