@extends('layouts.app')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@section('content')
    <h3 class="page-title">Acknowledgment transfers</h3>
    @if(isset($success))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            You have acknowledged.
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading">
            Acknowledgment
        </div>

        <div class="panel-body">
            <form method="POST" action="{{ route('notification.acknowledgment.confirm') }}" accept-charset="UTF-8">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label for="field[]">Transfer</label>
                        <select class="form-control select2" onchange="getContent()" id="field" name="field" required="" data-placeholder="Choose Sender"
                                style="width: 100%;">
                            @foreach($result as $user)
                                <option value="{{ $user->sender.'##'.$user->update_dt.'##'.$user->id }}">{{ $user->sender.' ('.$user->update_dt.') - '.$user->email }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" readonly required="" id="subject" name="subject" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" rows="8" readonly required="" id="message" name="message"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label for="message">Comment</label>
                        <textarea class="form-control" rows="3" id="comment" name="comment"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label>
                            <input type="checkbox" required=""> I confirm that I have seen the receipt and received the money, hereby I am acknowledging the transfer.
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3 form-group">
                        <button type="submit" style="display:none;" class="btn btn-block btn-primary btn-md">SEND</button>
                    </div>
                </div>
                <input type="hidden" id="sender" name="sender" />
                <input type="hidden" id="time" name="time" />
                <input type="hidden" id="rowid" name="rowid" />
            </form>
        </div>
    </div>
@stop
<script>
    $(document).ready(function () {
        getContent();
    });
    function getContent(){
        var value = $('#field').val();
        var sender = value.split('##')[0];
        var time = value.split('##')[1];
        var id = value.split('##')[2];
        var request = $.ajax({
            url: "{{ route('notification.acknowledgment.get') }}",
            type: "GET",
            data: {sender : sender, time : time, id : id},
            dataType: "html",
        });
        request.done(function(msg) {
            var subject = msg.split('##')[0];
            var message = msg.split('##')[1];
            $('#subject').val(subject);
            $('#message').val(message);
            $('#sender').val(sender);
            $('#time').val(time);
            $('#rowid').val(id);
            $('button').css('display', 'block');
        });
        request.fail(function(jqXHR, textStatus) {

        });
    }
</script>