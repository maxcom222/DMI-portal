@extends('layouts.app')

@section('content')
    <h3 class="page-title">Send Notification</h3>
    @if(isset($receiver))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            The notification has been sent to {{ $receiver }} successfully.
        </div>
    @endif
    <div class="panel panel-default">
{{--        <div class="panel-heading">--}}
{{--            send--}}
{{--        </div>--}}

        <div class="panel-body">
            <form method="POST" action="{{ route('notification.send.save') }}" accept-charset="UTF-8">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label for="field[]">Field*</label>
                        <select class="form-control select2" multiple="multiple" id="field[]" name="field[]" required="" data-placeholder="Choose field"
                                style="width: 100%;">
                            @foreach($users as $user)
                                @if($user->roles()->pluck('name')[0] == "field")
                                    <option>{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label for="subject">Subject*</label>
                        <input type="text" class="form-control" required="" id="subject" name="subject" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label for="message">Message*</label>
                        <textarea class="form-control" rows="3" required="" id="message" name="message"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label>
                            <input type="checkbox" required=""> Send reminder after 21 days by no acknowledging this notification.
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3 form-group">
                        <button type="submit" class="btn btn-block btn-primary btn-md">SEND</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop

