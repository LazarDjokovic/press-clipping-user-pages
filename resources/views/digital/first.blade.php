@extends('layouts.app')

@section('content')
    <div class="jumbotron" style="background-color:#EEF1F8;padding-top:0px !important; margin-bottom:0px !important;padding-bottom:0px">
        <div class="row">
            <div class="col-sm-12">
                <h3 style="padding:15px;">Digitalne novosti</h3>
            </div>

        </div>
        <hr style="background-color:black;">

        <div class="row" style="margin-top:10px !important;">
            <div class="col-lg-12 text-center" id="search-div">
                <?php
                use Carbon\Carbon;
                $carbon = new Carbon();
                $carbonFormat = $carbon->format('Y-m-d');
                ?>
                @if(session('search_data_digital'))
                    <form class="form-inline" action="/digitals/search" method="POST">
                        @csrf
                        <div class="form-group block">

                            Od: <input type="date" class="form-control" id="from" name="from" style="width:80%;" value="{{ session('search_data_digital')['from'] }}">


                        </div>
                        <div class="form-group">

                            Do: <input class="form-control toDate" type="date" name="to" style="width:80%;" value="{{ session('search_data_digital')['to'] }}">
                        </div>
                        <div class="form-group">

                            <select name="publisher" class="form-control publisher" id="sel2">
                                <option selected value="svi">Svi</option>
                                @foreach($media as $oneMedia)
                                    @if($oneMedia->slug == session('search_data_digital')['publisher'])
                                        <option value="{{$oneMedia->slug}}" selected>{{$oneMedia->name}}</option>
                                    @endif
                                    <option value="{{$oneMedia->slug}}">{{$oneMedia->name}}</option>
                                @endforeach
                            </select><br/>
                        </div>


                        <button type="submit" class="btn btn-primary" style="margin-top:3px">Pretraži</button>
                        <div class="form-group">
                            @if(session('digitals'))
                                <?php
                                $objave = 0;
                                for($i=0;$i<count(session('digitals')[0]);$i++){
                                    $objave += session('digitals')[0][$i]->objave;
                                }
                                ?>
                                <h3 style="margin-bottom: 15px; padding-left:15px">Broj objava: {{$objave}}</h3>
                            @else
                                <h3 style="margin-bottom: 15px; padding-left:15px">Broj objava: 0</h3>
                            @endif


                        </div>
                        <div class="form-group" style="margin-top:10px;">
                            <!--<i class="fa fa-table fa-2x" aria-hidden="true"></i>
                            <i class="fa fa-table fa-2x" aria-hidden="true"></i>-->
                        </div>
                    </form>
                @else
                    <form class="form-inline" action="/digitals/search" method="POST">
                        @csrf
                        <div class="form-group block">

                            Od: <input type="date" class="form-control" id="from" name="from" style="width:80%;" value="{{ $carbonFormat }}">


                        </div>
                        <div class="form-group">

                            Do: <input class="form-control toDate" type="date" name="to" style="width:80%;" value="{{ $carbonFormat }}">
                        </div>
                        <div class="form-group">

                            <select name="publisher" class="form-control publisher" id="sel2">
                                <option selected value="svi">Svi</option>
                                @foreach($media as $oneMedia)
                                    @if($oneMedia->slug == session('search_data_digital')['publisher'])
                                        <option value="{{$oneMedia->slug}}" selected>{{$oneMedia->name}}</option>
                                    @endif
                                    <option value="{{$oneMedia->slug}}">{{$oneMedia->name}}</option>
                                @endforeach
                            </select><br/>
                        </div>


                        <button type="submit" class="btn btn-primary" style="margin-top:3px">Pretraži</button>
                        <div class="form-group">
                            @if(session('digitals'))
                                <?php
                                $objave = 0;
                                for($i=0;$i<count(session('digitals')[0]);$i++){
                                    $objave += session('digitals')[0][$i]->objave;
                                }
                                ?>
                                <h3 style="margin-bottom: 15px; padding-left:15px">Broj objava: {{$objave}}</h3>
                            @else
                                <h3 style="margin-bottom: 15px; padding-left:15px">Broj objava: 0</h3>
                            @endif


                        </div>
                        <div class="form-group" style="margin-top:10px;">
                            <i class="fa fa-table fa-2x" aria-hidden="true"></i>
                            <i class="fa fa-table fa-2x" aria-hidden="true"></i>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    </div>
    <div class="row media-row" style="padding-bottom:15px;">
        @if(session('digitals'))

            @foreach(session('digitals')[0] as $digital)
                <div class="col-sm-6 col-md-3 col-lg-3 media-image text-center">
                    <img src="/images/logo.png" style="max-width:100%;max-height:100%;" id="img-logo">
                    <h4>{{$digital->media_slug}} - Izdanje {{$digital->broj_izdanja}}</h4>
                    <p>Objave: {{$digital->objave}}</p>
                    <p>Objavljeno: {{$digital->created_at}}</p>
                    <?php
                    $neprocitani =  $digital->objave - $digital->procitani;
                    ?>
                    @if($neprocitani > 0)
                        <a href="/digitals/view/{{$digital->media_slug}}/{{$digital->created_at}}/1" style="color:#FF4500;">Pročitaj objave ({{$objave}})</a>
                    @else
                        <a href="/digitals/view/{{$digital->media_slug}}/{{$digital->created_at}}/0">Pročitaj objave</a>
                    @endif

                </div>
            @endforeach


        @endif


    </div>
    <script>

    </script>
    <!--/row-->
@endsection
