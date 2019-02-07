@extends('layout_parts.layout')
@include('layout_parts.errors')

@section('content')
    <form  action="/start" method="post" enctype="multipart/form-data" class="form-horizontal">
        {{csrf_field()}}
        <fieldset>
            <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-email">E-Mail</label>
                <div class="col-sm-10">
                    <input name="email" placeholder="E-Mail" id="input-email" class="form-control"
                           type="email">
                </div>
            </div>

            <input type="file" name="image">
            <div class="form-group required">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="buttons">
                        <div>
                            <input value="Next" class="btn btn-primary" type="submit">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
<div class="col-lg-2"></div>
<div class="col-lg-8 col-sm-8">
    <table  class="table">
        <thead >
        <td>email</td>
        <td>grades</td>
        <td>total_time(min.)</td>
        </thead>
        @foreach( $lastResult AS $info)
            <tbody>
            <td>{{$info->email}}</td>
            <td>{{$info->grades}}</td>
            <td>{{$info->total_time}}</td>
            </tbody>
        @endforeach
    </table>

</div>
<div class="col-lg-2"></div>

@endsection