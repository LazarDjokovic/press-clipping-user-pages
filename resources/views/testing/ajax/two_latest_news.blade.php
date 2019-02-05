<?php
    use Carbon\Carbon;
    Carbon::setLocale('sr');
?>
@foreach($two_latest_news as $news)
    <div class="col-xs-12">
        <strong>{{$news->name}}</strong> najnovije izdanje <strong>{{$news->broj_izdanja}}</strong> je odobreno!
        <br/>
        <strong>{{\Carbon\Carbon::parse($news->created_at)->diffForHumans()}}</strong>
    </div>
    <br/>
@endforeach