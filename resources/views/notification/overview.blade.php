@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@section('content')
    <h3 class="page-title">Confirmed</h3>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">List</h3>
        </div>
        <!-- /.box-header -->
        <input type="hidden" id="chsubadmin" value="{{ Auth::user()->roles()->pluck('name')[0] == "sub admin"?0:1 }}" />
        <div class="box-body">
            <table id="example2" class="table table-bordered table-striped {{ count($result) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                <tr>
                    <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                    <th width="190px">Sender</th>
                    <th width="190px">Subject</th>
                    <th width="190px">Comment</th>
                    <th width="290px">Field</th>
                    <th width="190px">Email</th>
                    <th width="190px">Date</th>
                    <th width="100px" style="text-align:center;">Confirmed</th>
                    <th width="100px">Reminder</th>
                    <th width="100px">Down PDF</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($result as $one)
                    <tr data-entry-id="{{ $one->id }}">
                        <td></td>
                        <td>{{ $one->sender }}</td>
                        <td>{{ $one->subject }}</td>
                        <td>{{ $one->comment }}</td>
                        <td>{{ $one->field }}</td>
                        <td>{{ $one->field_email }}</td>
                        <td>{{ $one->update_dt }}</td>
                        <td style="text-align:center;">
                            @if($one->chconfirm == 0)
                                <i class="fa fa-remove text-danger"></i>
                            @else
                                <i class="fa fa-check text-success"></i>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($one->chconfirm == 1)
                            <a href="#">
                                <i class="fa fa-clock-o text-success"></i>
                            </a>
                            @else
                            <a href="{{ route('notification.overview.reminder', [$one->id]) }}">
                                <i class="fa fa-clock-o text-danger"></i>
                            </a>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <a href="{{ route('notification.pdf', [$one->id]) }}">
                                <i class="fa fa-download text-primary"></i>
                            </a>
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
        window.route_mass_crud_entries_destroy = '{{ route('notification.delete') }}';
        $(document).ready(function(){
           if ($('#chsubadmin').val() == 1)
           {

           }else{
               $('.actions').css('display', 'none');
           }
        });
    </script>
@endsection