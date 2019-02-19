<!--sidebar start-->
<aside >
    <div style="background-color: #1F2638;" id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
            <li style="margin-bottom: 20px;">
                <img src="/images/logo.png" style="max-width:100%;max-height:100%;" id="img-logo">
            </li>
            <li class="sub-menu">
                <a class="linkovi" href="/printed" style="font-size:12px;border: 0px !important;"><i class="fa fa-newspaper-o" style="color:#FFF;"></i> Štampane novosti</a>
            </li>
            <li class="sub-menu">
                <a class="linkovi" href="/digital" style="font-size:12px;border: 0px !important;"><i class="fa fa-globe" style="color:#FFF;"></i> Digitalne novosti</a>
            </li>
            <li class="sub-menu">
                <a class="linkovi" href="/radio" style="font-size:12px;border: 0px !important;"><i class="fa fa-bullhorn" style="color:#FFF;"></i> Radio novosti</a>
            </li>



            <hr style="margin-top:20px; background-color:#192121; border: 1px solid #29243E; height:5px;">



            <div id="two_latest_news">

            </div>

            <li class="sub-menu" style="display:none;" id="logout-link">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->