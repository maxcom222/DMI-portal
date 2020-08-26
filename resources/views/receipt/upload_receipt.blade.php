@extends('layouts.app')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style>

    .input-container {
        margin-left: 15px;
        margin-top: 0px;
        margin-bottom: 15px;
        max-width: 300px;
        background-color: #EDEDED;
        border: 1px solid #DFDFDF;
        border-radius: 5px;
    }
    input[type='file'] {
        opacity: 0;
        position: absolute;
    }
    .file-info {
        font-size: 0.9em;
    }
    .browse-btn {
        background: #03A595;
        color: #fff;
        min-height: 35px;
        padding: 10px;
        border: none;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }
    .browse-btn:hover {
        background: #4ec0b4;
    }
    @media (max-width: 300px) {
        button {
            width: 100%;
            border-top-right-radius: 5px;
            border-bottom-left-radius: 0;
        }

        .file-info {
            display: block;
            margin: 10px 5px;
        }
    }
</style>
@section('content')
    <h3 class="page-title">Upload receipts</h3>
    @if(isset($receiver))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            It was correctly transmitted to {{ $receiver }}.
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading">
            Upload
        </div>

        <div class="panel-body">
            <form enctype="multipart/form-data" method="POST" action="{{ route('receipt.upload.upload') }}" accept-charset="UTF-8">
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
                    <div class="input-container">
                        <input type="file" required="" name="selectfile" onchange="changeFile(this)" id="selectfile">
                        <button class="browse-btn" onclick="onclickbrowse()" type="button">
                            Upload a file
                        </button>
                        <span class="file-info">Upload a file</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label>
                            <input type="checkbox" required=""> The receipt is for the right field.
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

<script>
    const fileInfo = document.querySelector('.file-info');
    function onclickbrowse() {
        document.getElementById('selectfile').click();
    }
    function changeFile(evt) {
        const name = evt.value.split(/\\|\//).pop();
        const truncated = name.length > 20
            ? name.substr(name.length - 20)
            : name;
        $('.file-info').html(truncated);
    }
</script>