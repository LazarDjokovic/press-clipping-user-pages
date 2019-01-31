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
                @if(session('search_data'))
                    <form class="form-inline" action="/printeds/search" method="POST">
                        @csrf
                        <div class="form-group block">

                            Od: <input type="date" class="form-control" id="from" name="from" style="width:80%;" value="{{ session('search_data')['from'] }}">


                        </div>
                        <div class="form-group">

                            Do: <input class="form-control toDate" type="date" name="to" style="width:80%;" value="{{ session('search_data')['to'] }}">
                        </div>
                        <div class="form-group">

                            <select name="publisher" class="form-control publisher" id="sel2">
                                <option selected value="svi">Svi</option>
                                @foreach($media as $oneMedia)
                                    @if($oneMedia->slug == session('search_data')['publisher'])
                                        <option value="{{$oneMedia->slug}}" selected>{{$oneMedia->name}}</option>
                                    @endif
                                    <option value="{{$oneMedia->slug}}">{{$oneMedia->name}}</option>
                                @endforeach
                            </select><br/>
                        </div>


                        <button type="submit" class="btn btn-primary" style="margin-top:3px">Pretraži</button>
                        <div class="form-group">
                            @if(session('printeds'))
                                <?php
                                $objave = 0;

                                for($i=0;$i<count(session('printeds'));$i++){
                                    $objave += session('printeds')[0][$i]->objave;
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
                    <form class="form-inline" action="/printeds/search" method="POST">
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
                                    @if($oneMedia->slug == session('search_data')['publisher'])
                                        <option value="{{$oneMedia->slug}}" selected>{{$oneMedia->name}}</option>
                                    @endif
                                    <option value="{{$oneMedia->slug}}">{{$oneMedia->name}}</option>
                                @endforeach
                            </select><br/>
                        </div>


                        <button type="submit" class="btn btn-primary" style="margin-top:3px">Pretraži</button>
                        <div class="form-group">
                            @if(session('printeds'))
                                <?php
                                $objave = 0;

                                for($i=0;$i<count(session('printeds'));$i++){
                                    $objave += session('printeds')[0][$i]->objave;
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
    <div class="row media-row" style="padding-bottom:15px;">
        @if(session('printeds'))
            <ul>
                @foreach(session('printeds')[0] as $printed)
                    <iframe src="http://192.169.189.202/gs/public/javascripts/archive/alo~2019-01-24~3919~61746.pdf=2" id="media-image"></iframe>
                    <h4>{{$printed->media_slug}} - Izdanje {{$printed->broj_izdanja}}</h4>
                    <p>Objavljeno: {{$printed->created_at}}</p>
                    <p>
                        <?php
                        $neprocitani =  $printed->objave - $printed->procitani;
                        ?>
                        @if($neprocitani > 0)
                            Neprocitane objave: {{$neprocitani}}
                        @endif
                    </p>
                    <p>
                        <form action="/printeds/view" method="POST">
                            @csrf
                            <input type="hidden" name="media_slug" value="{{$printed->media_slug}}"/>
                            <input type="hidden" name="broj_izdanja" value="{{$printed->broj_izdanja}}"/>
                            <input type="hidden" name="date" value="{{$printed->created_at}}"/>
                            @if($neprocitani > 0)
                                <input type="hidden" name="neprocitani" value="1"/>
                            @endif
                            <button type="submit" class="btn btn-primary">Primary</button>
                        </form>
                    </p>
                @endforeach
            </ul>
        @endif


    </div>
    <!--/row-->
@endsection
