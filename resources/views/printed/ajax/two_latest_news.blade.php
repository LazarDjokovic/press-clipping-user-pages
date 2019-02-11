<?php
use Carbon\Carbon;
Carbon::setLocale('sr');
?>
@foreach($two_latest_news as $news)
    <li class="sub-menu">
        <p style="padding: 5px;">
            <a style="font-size:12px;border: 0px !important;"> <span class="fa fa-clock-o"></span>

                <strong>{{$news->name}}</strong> najnovije izdanje {{$news->broj_izdanja}} je odobreno!

                <br><span>{{\Carbon\Carbon::parse($news->created_at)->diffForHumans()}}</span>

            </a>
        </p>
    </li>
@endforeach