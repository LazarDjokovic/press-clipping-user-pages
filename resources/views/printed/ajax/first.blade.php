@foreach($printeds as $printed)
    <div class="col-sm-6 col-md-2 col-lg-2 media-image text-center" style="margin-top: 40px;">
        <img width="200px" src="/images/book.jpg" style="max-width:100%;max-height:100%; border-radius: 5px;" id="img-logo">
        <h4>{{ucwords(str_replace('-', ' ', $printed->media_slug))}} - Izdanje {{$printed->broj_izdanja}}</h4>
        <p>Objavljeno: {{$printed->created_at}}</p>
        <?php
            $neprocitani =  $printed->objave - $printed->procitani;
        ?>
        @if($neprocitani > 0)
            <a href="/printeds/view/{{$printed->media_slug}}/{{$printed->broj_izdanja}}/{{$printed->created_at}}/1" style="color:#FFAB00;">Nepročitane objave ({{$neprocitani}})</a>
        @else
            <a href="/printeds/view/{{$printed->media_slug}}/{{$printed->broj_izdanja}}/{{$printed->created_at}}/0">Sve objave pročitane({{ $printed->objave }})</a>
        @endif
    </div>
@endforeach
<?php
    $objave = 0;
    for($i=0; $i<count($printeds); $i++){
        $objave += $printeds[$i]->objave;
    }
?>
<input type="hidden" value="{{$objave}}" id="nove-objave">
