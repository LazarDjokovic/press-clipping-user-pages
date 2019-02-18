@foreach($digitals as $digital)
    <div class="col-sm-6 col-md-2 col-lg-2 media-image text-center" style="margin-top: 40px;">
        <h4>{{ucwords(str_replace('-', ' ', $digital->media_slug))}}</h4>
        <p>Objavljeno: {{$digital->created_at}}</p>
        <?php
        $neprocitani =  $digital->objave - $digital->procitani;
        ?>
        @if($neprocitani > 0)
            <a href="/digitals/view/{{$digital->media_slug}}/{{$digital->created_at}}/{{$neprocitani}}" style="color:#FFAB00;">Nepročitane objave ({{$neprocitani}})</a>
        @else
            <a href="/digitals/view/{{$digital->media_slug}}/{{$digital->created_at}}/0">Sve objave pročitane({{ $digital->objave }})</a>
        @endif
    </div>
@endforeach
<?php
    $objave = 0;
    for($i=0; $i<count($digitals); $i++){
        $objave += $digitals[$i]->objave;
    }
?>
<input type="hidden" value="{{$objave}}" id="nove-objave">
