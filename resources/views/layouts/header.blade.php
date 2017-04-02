

    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <!--<form role="search" class="navbar-form-custom" method="post" action="#">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>-->
        </div>
        @if(Auth::check())
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a class="confirm-toast"  data-message="{{__('menu.confirmLogout')}}"  data-location="{{url('logout')}}">
                    <i class='fa fa-sign-out'></i><span class='nav-label'>{{__('menu.logout')}}</span></a>
            </li>
        </ul>
        @endif

    </nav>
