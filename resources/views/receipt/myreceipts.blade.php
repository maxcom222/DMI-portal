@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@section('content')
    <h3 class="page-title">My receipt</h3>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">List</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example2" class="table table-bordered table-striped {{ count($result) > 0 ? 'datatable' : '' }}">
                <thead>
                <tr>
                    <th width="290px">Sender</th>
                    <th width="290px">Sender E-mail</th>
                    <th width="190px">Receipts</th>
                    <th width="190px">Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($result as $one)
                    <tr>
                        <td>{{ $one->sender }}</td>
                        <td>{{ $one->admin_email }}</td>
                        <td>
{{--                            @if($one->ch == 0)--}}
{{--                            <a class="btn btn-xs btn-danger" href="{{ route('receipt.downfile', [$one->id]) }}">--}}
{{--                                {{ $one->basefilename }}--}}
{{--                            </a>--}}
{{--                            @else--}}
{{--                            <a class="btn btn-xs btn-success" href="{{ route('receipt.downfile', [$one->id]) }}">--}}
{{--                                {{ $one->basefilename }}--}}
{{--                            </a>--}}
{{--                            @endif--}}
                            <a class="btn btn-xs btn-danger" href="{{ route('receipt.downfile', [$one->id]) }}">
                                {{ $one->basefilename }}
                            </a>
                        </td>
                        <td>{{ $one->update_dt }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@stop

@section('javascript')
    <script>
    </script>
@endsection