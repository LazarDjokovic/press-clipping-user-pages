@extends('layouts.app')

@section('content')
    <div class="jumbotron" style="background-color:#EEF1F8;padding-top:0px !important; margin-bottom:0px !important;padding-bottom:0px">
        <div class="row">
            <div class="col-sm-12">
                <h3 style="padding:15px;">Digitalne novosti</h3>
            </div>

        </div>
        <hr style="background-color:black;">
    </div>
    <div class="row media-row" style="padding-bottom:15px;">
        @if(session('printeds_view'))

            @foreach(session('printeds_view') as $printed)
                <div class="col-sm-6 col-md-3 col-lg-3 media-image text-center">
                    <img src="/images/logo.png" style="max-width:100%;max-height:100%;" id="img-logo">
                    <h4>{{$printed['media_slug']}} - Izdanje {{$printed['broj_izdanja']}}</h4>
                    <p>Objavljeno: {{$printed['text']}}</p>
                    <p>Objavljeno: {{$printed['created_at']}}</p>
                </div>
            @endforeach

            {{session('printeds_view')->links()}}

        @endif
    </div>
    <!--/row-->
@endsection
