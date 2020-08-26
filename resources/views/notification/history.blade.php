@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@section('content')
    <h3 class="page-title">Overview acknowledgement transfers</h3>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">List</h3>
        </div>
        <!-- /.box-header -->
        <input type="hidden" id="chsubadmin" value="{{ Auth::user()->roles()->pluck('name')[0] == "sub admin"?0:1 }}" />
        <div class="box-body">
            <table id="example2" class="table table-bordered table-striped {{ count($result) > 0 ? 'datatable' : '' }}">
                <thead>
                <tr>
                    <th width="190px">Sender</th>
                    <th width="190px">Email</th>
                    <th width="190px">Subject</th>
                    <th width="190px">Date</th>
                    <th width="100px" style="text-align:center;">Status</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($result as $one)
                    <tr>
                        <td>{{ $one->sender }}</td>
                        <td>{{ $one->admin_email }}</td>
                        <td>{{ $one->subject }}</td>
                        <td>{{ $one->update_dt }}</td>
                        <td style="text-align:center;">
                            @if($one->chconfirm == 0)
                                <i class="fa fa-remove text-danger"></i>
                            @else
                                <i class="fa fa-check text-success"></i>
                            @endif
                        </td>
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
               $('.actions').css('display', 'none');
    </script>
@endsection