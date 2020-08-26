@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        if ($('#chconfirm').val() == 1) {
            var request = $.ajax({
                url: "{{ route('notification.count') }}",
                type: "GET",
                data: {id:0},
                dataType: "html",
            });
            request.done(function(msg) {
                if (msg > 0)
                    $('#span').html(msg);
                else
                    $('#span_container').css('display', 'none');
            });
            var request1 = $.ajax({
                url: "{{ route('receipt.count') }}",
                type: "GET",
                data: {id:0},
                dataType: "html",
            });
            request1.done(function(msg) {
                if (msg > 0)
                    $('#span1').html(msg);
                else
                    $('#span_container1').css('display', 'none');
            });
            $('#span_container1').css('display', 'none');
        }else{
            $('#span_container').css('display', 'none');
            $('#span_container1').css('display', 'none');
        }
    })
</script>
<?php
$path = '';
$path1 = ('users/'.Auth::user()->id.'.png');
$path2 = ('users/'.Auth::user()->id.'.jpg');
if (file_exists($path1)) $path = url('/users/'.Auth::user()->id.'.png');
else if (file_exists($path2)) $path = url('/users/'.Auth::user()->id.'.jpg');
else $path = url('/users/user.png');
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <input type="hidden" id="chconfirm" value="{{ Auth::user()->roles()->pluck('name')[0]=="field"?1:0 }}" />
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">

                <img src="{{ $path }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info" style="padding-top: 15px;">
                <p>{{ Auth::user()->name }}</p>
            </div>
        </div>
        <ul class="sidebar-menu">

{{--            <li class="{{ $request->segment(2) == 'home' ? 'active' : '' }}">--}}
{{--                <a href="{{ url('/') }}">--}}
{{--                    <i class="fa fa-wrench"></i>--}}
{{--                    <span class="title">@lang('global.app_dashboard')</span>--}}
{{--                </a>--}}
{{--            </li>--}}
            
            @can('users_manage')
                <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                    <a href="{{ route('admin.users.index') }}">
                        <i class="fa fa-user"></i>
                        <span class="title">
                            @lang('global.users.title')
                        </span>
                    </a>
                </li>
            @elsecan('sub users manage')
                <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                    <a href="{{ route('admin.users.index') }}">
                        <i class="fa fa-user"></i>
                        <span class="title">
                            @lang('global.users.title')
                        </span>
                    </a>
                </li>
            @elsecan('customers_manage')
                <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                    <a href="{{ route('admin.users.index') }}">
                        <i class="fa fa-user"></i>
                        <span class="title">
                            @lang('global.users.title')
                        </span>
                    </a>
                </li>
            @endcan
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bell-o"></i>
                    <span class="title">Notification</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    <span id="span_container" class="pull-right-container">
                      <small id="span" class="label pull-right bg-red"></small>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if(Auth::user()->roles()->pluck('name')[0] == 'administrator'
                     || Auth::user()->roles()->pluck('name')[0] == 'super admin'
                     || Auth::user()->roles()->pluck('name')[0] == 'sub admin')
                    <li class="{{ $request->segment(2) == 'send' && $request->segment(1) == 'notification' ? 'active active-sub' : '' }}">
                        <a href="{{ route('notification.send.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span class="title">
                                Send notification
                            </span>
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->roles()->pluck('name')[0] == 'administrator'
                     || Auth::user()->roles()->pluck('name')[0] == 'super admin'
                     || Auth::user()->roles()->pluck('name')[0] == 'sub admin')
                    <li class="{{ $request->segment(2) == 'overview' ? 'active active-sub' : '' }}">
                        <a href="{{ route('notification.overview.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span class="title">
                                Overview notification
                            </span>
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->roles()->pluck('name')[0] == 'field')
                    <li class="{{ $request->segment(2) == 'acknowledgment' ? 'active active-sub' : '' }}">
                        <a href="{{ route('notification.acknowledgment') }}">
                            <i class="fa fa-circle-o"></i>
                            <span class="title">
                                Acknowledgment transfers
                            </span>
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->roles()->pluck('name')[0] == 'field')
                    <li class="{{ $request->segment(2) == 'history' ? 'active active-sub' : '' }}">
                        <a href="{{ route('notification.history') }}">
                            <i class="fa fa-circle-o"></i>
                            <span class="title">
                                Acknowledgment history
                            </span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span class="title">Receipts</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    <span id="span_container1" class="pull-right-container">
                      <small id="span1" class="label pull-right bg-red"></small>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if(Auth::user()->roles()->pluck('name')[0] == 'administrator'
                     || Auth::user()->roles()->pluck('name')[0] == 'super admin'
                     || Auth::user()->roles()->pluck('name')[0] == 'sub admin')
                    <li class="{{ $request->segment(2) == 'upload' ? 'active active-sub' : '' }}">
                        <a href="{{ route('receipt.upload.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span class="title">
                                Upload Receipts
                            </span>
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->roles()->pluck('name')[0] == 'field')
                    <li class="{{ $request->segment(2) == 'myreceipt' ? 'active active-sub' : '' }}">
                        <a href="{{ route('receipt.myreceipt') }}">
                            <i class="fa fa-circle-o"></i>
                            <span class="title">
                                My Receipts
                            </span>
                        </a>
                    </li>
                    @endif
                        @if(Auth::user()->roles()->pluck('name')[0] == 'administrator'
                         || Auth::user()->roles()->pluck('name')[0] == 'super admin'
                         || Auth::user()->roles()->pluck('name')[0] == 'sub admin')
                    <li class="{{ $request->segment(2) == 'fieldreceipt' ? 'active active-sub' : '' }}">
                        <a href="{{ route('receipt.fieldreceipt') }}">
                            <i class="fa fa-circle-o"></i>
                            <span class="title">
                                Field Receipts
                            </span>
                        </a>
                    </li>
                    @endif

                </ul>
            </li>
        </ul>
    </section>
</aside>
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('global.logout')</button>
{!! Form::close() !!}
