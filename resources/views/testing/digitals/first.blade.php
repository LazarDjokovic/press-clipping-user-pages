@extends('layouts.app')

@section('content')
    <div class="jumbotron" style="background-color:#EEF1F8; border-radius: 5px; padding-top:0px !important; margin-bottom:0px !important;padding-bottom:0px">
        <div class="row">
            <div class="col-sm-12">
                <h3 style="padding:15px;">Digitalne novosti</h3>
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
                @if(session('search_data_digital'))
                    <form class="form-inline" action="{{route('digitals_search')}}" method="POST">
                        @csrf
                        <div class="form-group block">

                            Od: <input type="date" class="form-control" id="from" name="from" style="width:200px;" value="{{ session('search_data_digital')['from'] }}">


                        </div>
                        <div style="margin-left: 70px;" class="form-group">

                            Do: <input class="form-control toDate" type="date" name="to" style="width:200px;" value="{{ session('search_data_digital')['to'] }}">
                        </div>
                        <div class="form-group" style="margin-left: 50px;">

                            <select  name="publisher" class="form-control publisher" id="sel2">
                                <option selected value="svi">Sve novine</option>
                                @foreach($media as $oneMedia)
                                    @if($oneMedia->slug == session('search_data_digital')['publisher'])
                                        <option value="{{$oneMedia->slug}}" selected>{{$oneMedia->name}}</option>
                                    @endif
                                    <option value="{{$oneMedia->slug}}">{{$oneMedia->name}}</option>
                                @endforeach
                            </select><br/>
                        </div>


                        <button style="margin-left: 80px" type="submit" class="btn btn-primary" style="margin-top:3px;">Pretraži</button>
                        <div class="form-group">
                            @if(session('digitals'))

                                <?php
                                $objave = 0;
                                for($i=0;$i<count(session('digitals')[0]);$i++){
                                    $objave += session('digitals')[0][$i]->objave;
                                }
                                ?>

                                <h3 style="margin-bottom: 15px; padding-left:50px">Broj objava: {{$objave}}</h3>
                            @else
                                <h3 style="margin-bottom: 15px; padding-left:50px">Broj objava: 0</h3>
                            @endif


                        </div>
                        <div class="form-group" style="margin-top:10px;">
                            <!--<i class="fa fa-table fa-2x" aria-hidden="true"></i>
                            <i class="fa fa-table fa-2x" aria-hidden="true"></i>-->
                        </div>
                    </form>
                @else
                    <form class="form-inline" action="{{route('digitals_search')}}" method="POST">
                        @csrf
                        <div class="form-group block">

                            Od: <input type="date" class="form-control" id="from" name="from" style="width:200px;" value="{{ $carbonFormat }}">


                        </div>
                        <div style="margin-left: 70px;" class="form-group">

                            Do: <input class="form-control toDate" type="date" name="to" style="width:200px;" value="{{ $carbonFormat }}">
                        </div>
                        <div class="form-group" style="margin-left: 50px;">

                            <select  name="publisher" class="form-control publisher" id="sel2">
                                <option selected value="svi">Sve novine</option>
                                @foreach($media as $oneMedia)
                                    @if($oneMedia->slug == session('search_data_digital')['publisher'])
                                        <option value="{{$oneMedia->slug}}" selected>{{$oneMedia->name}}</option>
                                    @endif
                                    <option value="{{$oneMedia->slug}}">{{$oneMedia->name}}</option>
                                @endforeach
                            </select><br/>
                        </div>


                        <button style="margin-left: 80px" type="submit" class="btn btn-primary" style="margin-top:3px">Pretraži</button>
                        <div class="form-group">
                            @if(session('digitals'))
                                <?php
                                $objave = 0;
                                for($i=0;$i<count(session('digitals')[0]);$i++){
                                    $objave += session('digitals')[0][$i]->objave;
                                }
                                ?>
                                <h3 style="margin-bottom: 15px; padding-left:50px">Broj objava: {{$objave}}</h3>
                            @else
                                <h3 style="margin-bottom: 15px; padding-left:50px">Broj objava: 0</h3>
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
    <div class="row media-row" style="padding-bottom:15px;">
        @if(session('digitals'))

            @foreach(session('digitals')[0] as $printed)
                <div class="col-sm-6 col-md-2 col-lg-2 media-image text-center" style="margin-top: 40px;">
                    <img width="200px" src="/images/book.jpg" style="max-width:100%;max-height:100%; border-radius: 5px;" id="img-logo">
                    <p>Objavljeno: {{$printed->created_at}}</p>
                    <h4>{{ucwords(str_replace('-', ' ', $printed->media_slug))}}</h4>
                    <?php
                    $neprocitani =  $printed->objave - $printed->procitani;
                    ?>
                    @if($neprocitani > 0)
                        <a href="/digitals/view/{{$printed->media_slug}}/{{$printed->created_at}}/{{$neprocitani}}/1" style="color:#FFAB00;">Nepročitane objave ({{$neprocitani}})</a>
                    @else
                        <a href="/digitals/view/{{$printed->media_slug}}/{{$printed->created_at}}/{{$neprocitani}}/0">Sve objave pročitane({{ $printed->objave }})</a>
                    @endif

                </div>
            @endforeach


        @endif


    </div>
    <script>

        $(document).ready(function () {

            /* $( "#search_printeds" ).click(function() {

                 var fromDate = $('#fromDate').val();
                 var toDate = $('#toDate').val();


                 var token =  $('input[name="_token"]').attr('value');

                 var publisher = $('#publisher').val();





                 $.ajax({
                     type:'POST',
                     url:'/printeds/search',
                     data:{
                         'from': fromDate,
                         'to' : toDate,
                         'publisher' : publisher
                     },
                     headers:{
                         'X-CSRF-Token' : token,
                         'accept': 'application/json',
                         'Access-Control-Allow-Headers':'*'
                     },
                     success:function (data) {
                         console.log(data);
                         //$('.mediji_izlistavanje').html(data);
                         //console.log(data);
                     },
                     error: function(xhr, status, error) {
                         alert('Kontaktirajte programere, nesto nije u redu.');
                     }
                 })

             });*/



        })
    </script>
    <!--/row-->
@endsection
