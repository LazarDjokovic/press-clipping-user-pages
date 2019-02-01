<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
            <li>
                <img src="/images/logo.png" style="max-width:100%;max-height:100%;" id="img-logo">
            </li>
            <li class="sub-menu">
                <a href="/printed"><i class="fa fa-newspaper-o" style="color:#FFF;"></i> Štampani mediji</a>
            </li>
            <li class="sub-menu">
                <a href="/digital"><i class="fa fa-globe" style="color:#FFF;"></i> Digitalni mediji</a>
            </li>
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