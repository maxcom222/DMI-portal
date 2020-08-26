
<?php
$path = '';
$path1 = ('users/'.Auth::user()->id.'.png');
$path2 = ('users/'.Auth::user()->id.'.jpg');
if (file_exists($path1)) $path = url('/users/'.Auth::user()->id.'.png');
else if (file_exists($path2)) $path = url('/users/'.Auth::user()->id.'.jpg');
else $path = url('/users/user.png');
?>

<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/admin/home') }}" class="logo"
       style="font-size: 16px;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
           </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="/logo.png" width="100%" height="98%" /></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{ $path }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="height: auto;">
                            <img src="{{ $path }}" class="img-circle" alt="User Image">

                            <p>
                                {{ Auth::user()->name }}
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-6 text-center">
                                    <a href="{{ route('auth.change_password') }}" class="btn btn-default btn-flat">Change Password</a>
                                </div>
                                <div class="col-xs-6 text-center">
                                    <a href="{{ route('change_photo') }}" class="btn btn-default btn-flat">Change My Photo</a>
                                </div>
                                <div class="col-xs-2 text-center" style="margin-top: 5px; margin-right: 0px;">
                                    <a href="#logout" onclick="$('#logout').submit();" class="btn btn-default btn-flat">Logout</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
{{--                        <li class="user-footer">--}}
{{--                            <div class="pull-left">--}}
{{--                                <a href="{{ route('auth.change_password') }}" class="btn btn-default btn-flat">Change Password</a>--}}
{{--                            </div>--}}
{{--                            <div class="pull-left">--}}
{{--                                <a href="{{ route('auth.change_photo') }}" class="btn btn-default btn-flat">Change My Photo</a>--}}
{{--                            </div>--}}
{{--                            <div class="pull-right">--}}
{{--                                <a href="#logout" onclick="$('#logout').submit();" class="btn btn-default btn-flat">Logout</a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
                    </ul>
                </li>
            </ul>
        </div>

    </nav>
</header>
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('global.logout')</button>
{!! Form::close() !!}

