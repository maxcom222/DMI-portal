@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@section('content')
    <h3 class="page-title">Field receipt</h3>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">List</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
		{{ Auth::user()->roles()->pluck('name')[0] }}
			@if(Auth::user()->roles()->pluck('name')[0] != "sub admin")
            <table id="example2" class="table table-bordered table-striped {{ count($result) > 0 ? 'datatable' : '' }} dt-select">
            @else
				<table id="example2" class="table table-bordered table-striped {{ count($result) > 0 ? 'datatable' : '' }}">
			@endif
				<thead>
                <tr>
                    <th width="100px" style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                    <th width="290px">Field</th>
                    <th width="190px">Receipts</th>
                    <th width="190px">DateTime</th>
                    <th width="100px">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($result as $one)
                    <tr data-entry-id="{{ $one->id }}">
                        <td></td>
                        <td>{{ $one->field }}</td>
                        <td style="vertical-align: middle">
                            <a class="btn btn-xs btn-danger" href="{{ route('receipt.downfile', [$one->id]) }}">
                                {{ $one->basefilename }}
                            </a>
                        </td>
                        <td>{{ $one->update_dt }}</td>
                        <td style="text-align: center">
                            @if($one->ch == 0)
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
	@if(Auth::user()->roles()->pluck('name')[0] != "sub admin")
        window.route_mass_crud_entries_destroy = '{{ route('receipt.delete') }}';
	@endif
    </script>
@endsection