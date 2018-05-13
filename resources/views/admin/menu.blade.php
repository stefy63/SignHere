
<nav class="nav navbar-default navbar-static-side" role="navigation" id="app">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <a href="{{url('admin')}}"><strong class="font-bold">{{ucwords(strtolower(Auth::user()->name.' '.Auth::user()->surname))}}</strong></a>
                            </span>
                        </span>
                    </a>
                    @if(env('VUE_CHAT_ENABLE'))
                    <operator
                            skey='{{env('VUE_CHAT_KEY')}}'
                            shost='{{env('VUE_CHAT_HOST')}}'
                            sport='{{env('VUE_CHAT_PORT')}}'
                            spath='{{env('VUE_CHAT_PATH')}}'
                            ssecure='{{env('VUE_CHAT_SECURE')}}'
                            suser='{{Auth::user()->id}}'
                            slocation='{{Auth::user()->locations()->get()->pluck('id')}}'
                            ></operator>

                    <video-operator
                            skey='{{env('VUE_CHAT_KEY')}}'
                            shost='{{env('VUE_CHAT_HOST')}}'
                            sport='{{env('VUE_CHAT_PORT')}}'
                            spath='{{env('VUE_CHAT_PATH')}}'
                            ssecure='{{env('VUE_CHAT_SECURE')}}'
                            suser='{{Auth::user()->id}}'
                            slocation='{{Auth::user()->locations()->get()->pluck('id')}}'
                            ></video-operator>
                    @endif
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li>
                            <a class="confirm-toast"  data-message="{{__('menu.confirmLogout')}}"  data-location="{{url('logout')}}">
                            <i class='fa fa-sign-out'></i><span class='nav-label'>{{__('menu.logout')}}</span></a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element" data-toggle='tooltip' title='{{ucwords(strtolower(Auth::user()->name.' '.Auth::user()->surname))}}'>
                    3.6
                </div>
            </li>
            @foreach(Auth::user()->profile->getModules()->get() as $menu)
                <li data-toggle='tooltip' title='{{__($menu->short_name.".".$menu->short_name.'_tooltip')}}'>
                    <a href='{{url($menu->short_name)}}'><i class='{{$menu->icon}}'></i>
                    <span class='nav-label'>{{__($menu->short_name.".".$menu->short_name)}}</span></a>
                </li>
            @endforeach
            <li data-toggle='tooltip' title='{{__('menu.logout_tooltip')}}'>
                <a class="confirm-toast"  data-message="{{__('menu.confirmLogout')}}"  data-location="{{url('logout')}}">
                <i class='fa fa-sign-out'></i><span class='nav-label'>{{__('menu.logout')}}</span></a>
            </li>
        </ul>

    </div>
</nav>

