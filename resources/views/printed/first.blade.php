@extends('layouts.app')

@section('content')
    <div class="jumbotron" style="background-color:#EEF1F8; border-radius: 5px; padding-top:0px !important; margin-bottom:0px !important;padding-bottom:0px">
        <div class="row">
            <div class="col-sm-12">
                <h3 style="padding:15px;">Štampane novosti</h3>
            </div>

        </div>
        <hr style="opacity: 0.1;">

        <div class="row" style="margin-top:10px !important;">
            <div class="col-lg-12 text-left" style="padding-left: 40px;" id="search-div">
                <?php
                use Carbon\Carbon;
                $carbon = new Carbon();
                $carbonFormat = $carbon->format('Y-m-d');
                ?>
                @if(session('search_data'))
                     <form class="form-inline" action="{{route('printeds_search')}}" method="POST">
                        @csrf
                        <div class="form-group block">

                            Od: <input type="date" class="form-control fromDate" id="from" name="from" style="width:200px;" value="{{ session('search_data')['from'] }}">


                        </div>
                        <div style="margin-left: 70px;" class="form-group">

                            Do: <input class="form-control toDate" type="date" name="to" style="width:200px;" value="{{ session('search_data')['to'] }}">
                        </div>
                        <div class="form-group" style="margin-left: 50px;">

                            <select  name="publisher" class="form-control publisher" id="sel2">
                                <option selected value="svi">Sve novine</option>
                                @foreach($media as $oneMedia)
                                    @if($oneMedia->slug == session('search_data')['publisher'])
                                        <option value="{{$oneMedia->slug}}" selected>{{$oneMedia->name}}</option>
                                    @endif
                                    <option value="{{$oneMedia->slug}}">{{$oneMedia->name}}</option>
                                @endforeach
                            </select><br/>
                        </div>


                        <button style="margin-left: 80px" type="submit" class="btn btn-primary" style="margin-top:3px;">Pretraži</button>
                        <div class="form-group">
                            @if(session('printeds'))
                                <?php
                                $objave = 0;
                                for($i=0;$i<count(session('printeds')[0]);$i++){
                                    $objave += session('printeds')[0][$i]->objave;
                                }
                                ?>

                                <h3 style="margin-bottom: 15px; padding-left:50px">Broj objava: <span id="prikaz-objava">{{$objave}}</span></h3>
                                <input type="hidden" value="{{$objave}}" id="broj-objava">
                            @else
                                <h3 style="margin-bottom: 15px; padding-left:50px">Broj objava: <span id="prikaz-objava">0</span></h3>
                                <input type="hidden" value="0" id="broj-objava">
                            @endif


                        </div>
                        <div class="form-group" style="margin-top:10px;">
                            <!--<i class="fa fa-table fa-2x" aria-hidden="true"></i>
                            <i class="fa fa-table fa-2x" aria-hidden="true"></i>-->
                        </div>
                     </form>
                @else
                    <form class="form-inline" action="{{route('printeds_search')}}" method="POST">
                        @csrf
                        <div class="form-group block">

                            Od: <input type="date" class="form-control fromDate" id="from" name="from" style="width:200px;" value="{{ $carbonFormat }}">


                        </div>
                        <div style="margin-left: 70px;" class="form-group">

                            Do: <input class="form-control toDate" type="date" name="to" style="width:200px;" value="{{ $carbonFormat }}">
                        </div>
                        <div class="form-group" style="margin-left: 50px;">

                            <select  name="publisher" class="form-control publisher" id="sel2">
                                <option selected value="svi">Sve novine</option>
                                @foreach($media as $oneMedia)
                                    @if($oneMedia->slug == session('search_data')['publisher'])
                                        <option value="{{$oneMedia->slug}}" selected>{{$oneMedia->name}}</option>
                                    @endif
                                    <option value="{{$oneMedia->slug}}">{{$oneMedia->name}}</option>
                                @endforeach
                            </select><br/>
                        </div>


                        <button style="margin-left: 80px" type="submit" class="btn btn-primary" style="margin-top:3px">Pretraži</button>
                        <div class="form-group">
                            @if(session('printeds'))
                                <?php
                                $objave = 0;
                                for($i=0;$i<count(session('printeds')[0]);$i++){
                                    $objave += session('printeds')[0][$i]->objave;
                                }
                                ?>
                                <h3 style="margin-bottom: 15px; padding-left:50px">Broj objava: <span id="prikaz-objava">{{$objave}}</span></h3>
                                <input type="hidden" value="{{$objave}}" id="broj-objava">
                            @else
                                <h3 style="margin-bottom: 15px; padding-left:50px">Broj objava: <span id="prikaz-objava">0</span></h3>
                                <input type="hidden" value="0" id="broj-objava">
                            @endif


                        </div>
                        <div class="form-group" style="margin-top:10px;">
                            <!--<i class="fa fa-table fa-2x" aria-hidden="true"></i>
                            <i class="fa fa-table fa-2x" aria-hidden="true"></i>-->
                        </div>
                    </form>
                @endif
            </div>
        </div>
        </div>
    </div>
    <div class="row media-row" style="padding-bottom:15px;" id="load-more-items">
        @if(session('printeds'))
            @if(count(session('printeds')[0]) >= 10)
                @for($i=0; $i<10; $i++)
                    <div class="col-sm-6 col-md-2 col-lg-2 media-image text-center" style="margin-top: 40px;">
                        <img width="200px" src="http://192.169.189.202/gs/public/javascripts/output_images/{{session('printeds')[0][$i]->original_src}}.png" style="max-width:100%;max-height:100%; border-radius: 5px;" id="img-logo">
                        <h4>{{ucwords(str_replace('-', ' ', session('printeds')[0][$i]->media_slug))}} - Izdanje {{session('printeds')[0][$i]->broj_izdanja}}</h4>
                        <p>Objavljeno: {{session('printeds')[0][$i]->created_at}}</p>
                        <?php
                            $neprocitani =  session('printeds')[0][$i]->objave - session('printeds')[0][$i]->procitani;
                        ?>
                        @if($neprocitani > 0)
                            <a href="/printeds/view/{{session('printeds')[0][$i]->media_slug}}/{{session('printeds')[0][$i]->broj_izdanja}}/{{session('printeds')[0][$i]->created_at}}/1" style="color:#FFAB00;">Nepročitane objave ({{$neprocitani}})</a>
                        @else
                            <a href="/printeds/view/{{session('printeds')[0][$i]->media_slug}}/{{session('printeds')[0][$i]->broj_izdanja}}/{{session('printeds')[0][$i]->created_at}}/0">Sve objave pročitane({{ session('printeds')[0][$i]->objave }})</a>
                        @endif
                    </div>
                @endfor
            @elseif(count(session('printeds')[0]) > 0 && count(session('printeds')[0]) < 10)
                @for($i=0; $i<count(session('printeds')[0]); $i++)
                    <div class="col-sm-6 col-md-2 col-lg-2 media-image text-center" style="margin-top: 40px;">
                        <img width="200px" src="http://192.169.189.202/gs/public/javascripts/output_images/{{session('printeds')[0][$i]->original_src}}.png" style="max-width:100%;max-height:100%; border-radius: 5px;" id="img-logo">
                        <h4>{{ucwords(str_replace('-', ' ', session('printeds')[0][$i]->media_slug))}} - Izdanje {{session('printeds')[0][$i]->broj_izdanja}}</h4>
                        <p>Objavljeno: {{session('printeds')[0][$i]->created_at}}</p>
                        <?php
                        $neprocitani =  session('printeds')[0][$i]->objave - session('printeds')[0][$i]->procitani;
                        ?>
                        @if($neprocitani > 0)
                            <a href="/printeds/view/{{session('printeds')[0][$i]->media_slug}}/{{session('printeds')[0][$i]->broj_izdanja}}/{{session('printeds')[0][$i]->created_at}}/1" style="color:#FFAB00;">Nepročitane objave ({{$neprocitani}})</a>
                        @else
                            <a href="/printeds/view/{{session('printeds')[0][$i]->media_slug}}/{{session('printeds')[0][$i]->broj_izdanja}}/{{session('printeds')[0][$i]->created_at}}/0">Sve objave pročitane({{ session('printeds')[0][$i]->objave }})</a>
                        @endif
                    </div>
                @endfor
            @else
                <div class="col-xs-12 text-center" style="margin-top: 40px;">
                    <h3>Nema medija za unete podatke</h3>
                </div>
            @endif
        @endif
    </div>
    <div class="row" style="margin-bottom: 20px;">
        <div style="display:none;  margin: auto;" class="loader" id="loader"></div>
    </div>
    @if(session('printeds'))
        @if(count(session('printeds')[0]) >= 10)
            <div class="row">
                <div class="col-xs-12 text-center">
                    <button  type="button" class="btn btn-primary read-more" style="margin-bottom: 50px;">Učitaj još</button>
                </div>
            </div>
        @endif
    @endif
    <script>

        $(document).ready(function () {

            $(document).ajaxStart(function () {
                //ajax request went so show the loading image
                $('.loader').show();
            });
            $(document).ajaxStop(function () {
                //got response so hide the loading image
                $('.loader').hide();
            });

           $( ".read-more" ).click(function() {

                var fromDate = $('.fromDate').val();
                var toDate = $('.toDate').val();
                var publisher = $('.publisher').val();

                var token =  $('input[name="_token"]').attr('value');

                var broj_objava = $('#broj-objava').val();

                var numItems = $('.media-image').length;

                $.ajax({
                    type:'POST',
                    url:'/printeds/search_ajax',
                    data:{
                        'from': fromDate,
                        'to' : toDate,
                        'publisher' : publisher,
                        'numItems' : numItems
                    },
                    headers:{
                        'X-CSRF-Token' : token,
                        'accept': 'application/json',
                        'Access-Control-Allow-Headers':'*'
                    },
                    success:function (data) {
                        var number = $(data).filter(".media-image").length;
                        if(number < 4)
                            $( ".read-more" ).hide();
                        else
                            $( ".read-more" ).show();

                        var nove_objave = $(data).filter("#nove-objave").val();
                        if(nove_objave > 0){
                            $('#prikaz-objava').html(parseInt(nove_objave) + parseInt(broj_objava));
                            $( ".read-more" ).hide();
                        }

                        $('#load-more-items').append(data);
                        //console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        //alert('Kontaktirajte programere, nesto nije u redu.');
                    }
                })

            });
        })
    </script>
    <!--/row-->
@endsection
