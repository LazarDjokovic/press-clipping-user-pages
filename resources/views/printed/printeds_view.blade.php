@extends('layouts.app')

@section('content')

    <div class="jumbotron" style="background-color:#EEF1F8;padding-top:0px !important; margin-bottom:0px !important;padding-bottom:0px">
        <div class="row">
            <div class="col-sm-12">
                <h3 style="padding:15px;">Digitalne novosti <strong>{{session('printeds_view')[0]->media_slug}} / Izdanje {{session('printeds_view')[0]->broj_izdanja}} / {{session('printeds_view')[0]->created_at->format('Y-m-d')}}</strong></h3>
            </div>

        </div>
        <hr style="background-color:black;">
    </div>
    <div class="row">
        <div class="col-xs-12">
            <form action="{{route('printeds_back')}}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Nazad</button>
            </form>
        </div>
    </div>
    <div class="row media-row" style="padding-bottom:15px;margin-left: 0px !important; margin-right: 0px !important;">
        @if(session('printeds_view'))

            @foreach(session('printeds_view') as $printed)
                <div class="col-xs-12">
                    <div class="row" style="margin-left: 0px !important; margin-right: 0px !important;">
                        <div class="col-xs-10">
                            <h1>{{$printed['naslov']}}</h1>
                            <h4>{{$printed['podnaslov']}}</h4>
                        </div>
                        <div class="col-xs-2">
                            <img src="/images/logo.png" style="height:100px; width:100px;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                        <h4>Nađenje klučne reči: {{$printed['found_keywords']}}</h4>
                        <div class="row" style="margin-left: 0px !important; margin-right: 0px !important;">
                            <div class="col">
                                <?php
                                    $first_text = substr($printed['text'],0,500);
                                    if($first_text != strip_tags($first_text)){
                                        $first_text = substr($printed['text'],0,600);
                                    }
                                    echo $first_text;
                                ?>
                                <div class="collapse multi-collapse" id="multiCollapseExample{{$printed['id']}}">
                                    <div class="card card-body">
                                        <?php
                                            $second_text = substr($printed['text'],501);
                                            echo $second_text;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <br/>
                        <div class="row" style="margin-left: 0px !important; margin-right: 0px !important;">
                            <div class="col-xs-12">
                            <button class="btn btn-primary pull-right" type="button" data-toggle="collapse" data-target="#multiCollapseExample{{$printed['id']}}" aria-expanded="false" aria-controls="multiCollapseExample2">Pročitaj više</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        @endif
    </div>
    <!--/row-->
@endsection
<script>

</script>
