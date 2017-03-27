
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> 
                        <strong class="font-bold">{{ucwords(strtolower(Auth::user()->name.' '.Auth::user()->surname))}}</strong>
                         </span></span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href='{{route('logout')}}' onClick="return confirm('{{__('menu.confirmLogout')}}')">{{__('menu.logout')}}</a></li>
                        </ul>
                </div>
                <div class="logo-element">
                    SH+
                </div>
            </li>
            <li class="active">
                <a href="{{url('home')}}"><i class="fa fa-th-large"></i><span class="nav-label">{{__('menu.main')}}</span></a>
            </li>
            @menu
        </ul>

    </div>
</nav>

