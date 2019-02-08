@extends('layout_parts.layout')
@include('layout_parts.errors')

@section('content')

    <div class="col-lg-2"></div>
    <div class="col-lg-8"
         style="border: 1px solid #ddd;margin-top: 40px;border-radius: 5px;padding: 20px 20px 20px 20px;background: aliceblue;">
        <form action="/start" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
                <div class="form-group">
                    <label for="input-email">Email address</label>
                    <input type="email" class="form-control"  name="email" id="input-email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="file">File input</label>
                    <input type="file" name="image" id="file">
                </div>
                    <button type="submit" class="btn btn-success pull-right">Next</button>
        </form>
    </div>

    <div class="col-lg-2"></div>

    <div class="col-lg-12" style="height: 30px"></div>
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <table class="table table-bordered">
                <thead>
                <tr class="active">
                    <th>Email</th>
                    <th>Grades</th>
                    <th>Total time(sec.)</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $lastResult AS $info)
                    <tr>
                        <td>{{$info->email}}</td>
                        <td>{{$info->grades}}</td>
                        <td>{{$info->total_time}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-2"></div>

@endsection