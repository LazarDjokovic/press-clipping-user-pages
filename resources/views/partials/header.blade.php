<header class="header" style="background-color: #2F3649;">
    <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-placement="bottom"><i class="icon_menu"></i></div>
    </div>

    <div class="top-nav notification-row">
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">
            <!-- alert notification end-->
            <!-- user login dropdown start-->
            @if(Auth::user())
                <li class="dropdown-item">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                        <span class="username">{{auth()->user()->name}} {{auth()->user()->last_name}}</span>
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