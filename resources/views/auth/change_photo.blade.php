@extends('layouts.app')
<?php
$path = '';
$path1 = ('users/png');
$path2 = ('users/jpg');
if (file_exists($path1)) $path = url('/users/png');
else if (file_exists($path2)) $path = url('/users/jpg');
else $path = url('/users/user.png');
?>
<style type="text/css">
    .file {
        position: relative;
        overflow: hidden;
        padding: 0.45rem 0.9rem;
        font-size: 0.875rem;
    }
    .inputfile {
        position: absolute;
        opacity: 0;
        right: 0;
        top: 0;
    }
</style>
@section('content')

    @if(session('success'))
        <!-- If password successfully show message -->
        <h3 class="page-title">Change photo</h3>
        <div class="row">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @else
        <div class="col-md-4 col-md-offset-4">
            <h3 class="page-title">Change photo</h3>
            <div class="box box-primary">
                <div class="box-body box-profile">
                        <form method="POST" action="{{ route('change_photo_submit') }}" enctype="multipart/form-data" accept-charset="UTF-8">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <img id="myphoto" class="profile-user-img img-responsive img-circle" src="{{ $path }}" alt="User profile picture">
                        <ul class="list-group list-group-unbordered" style="margin-top: 15px;">
                            <li class="list-group-item">
                                <b>Username</b> <a class="pull-right"></a>
                            </li>
                            <li class="list-group-item">
                                <b>E-Mail</b> <a class="pull-right"></a>
                            </li>
                            <li class="list-group-item">
                                <div class="file btn btn-primary">
                                    Change photo
                                    <input type="file" class="inputfile" onchange="previewImage(this)" name="file"/>
                                </div>
                            </li>
                        </ul>
                        <input type="submit" class="btn btn-danger" value="Save" />
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
        </div>

    @endif
@stop

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(e)
        {
            document.querySelector("#myphoto").src = e.target.result;

            Session("reload") = "yes";
        }
        reader.readAsDataURL(event.files[0]);
    }
</script>