<header class="header" style="background-color: #2F3649;">
    <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-placement="bottom"><i class="icon_menu"></i></div>
    </div>

    <div class="top-nav notification-row">
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">
            <li class="dropdown-item">
                <a href="#" style="color:gray">Kako koristiti?</a>
            </li>

            <li class="dropdown-item">
                <a style="color:gray;" href="#">Naša podrška</a>
            </li>
            <!-- alert notification end-->
            <!-- user login dropdown start-->
            @if(Auth::user())
                <li style="background-color: #16A4FA; margin:0px !important; margin-left:40px !important; padding: 0px !important; border-radius: 2px;" class="dropdown-item">

                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                        <span style="color:white;" class="username">{{auth()->user()->name}} {{auth()->user()->last_name}}</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>
                        <li class="eborder-top">
                            <a class="dropdown-item" style="background-color: #FFF !important; color: #000;" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                {{ __('Odjavi se') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            @endif
            <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->
    </div>
</header>
<!--header end-->