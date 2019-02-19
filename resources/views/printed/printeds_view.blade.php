@extends('layouts.app')

@section('content')

    <div class="jumbotron" style="background-color:#EEF1F8;padding-top:0px !important; margin-bottom:0px !important;padding-bottom:0px">
        <div class="row">
            <div class="col-sm-10">
                @if($neprocitani == 0)
                    <h4 style="padding:15px;">Štampane novosti: <strong style="color:#3660D9">{{ucwords(str_replace('-', ' ', session('printeds_view')[0]->media_slug))}} / Izdanje {{session('printeds_view')[0]->broj_izdanja}} / {{session('printeds_view')[0]->created_at->format('Y-m-d')}}</strong></h4>
                @else
                    <h4 style="padding:15px;">Štampane novosti: <strong style="color:#3660D9">{{ucwords(str_replace('-', ' ', session('printeds_view')[0]->media_slug))}} / Izdanje {{session('printeds_view')[0]->broj_izdanja}} / {{session('printeds_view')[0]->created_at->format('Y-m-d')}} / <span style="color:#FFAB00;">Nepročitane objave ({{$neprocitani}})</span></strong></h4>
                @endif

            </div>
            <div class="col-sm-2">
                <form action="{{route('printeds_back')}}" method="POST">
                    @csrf
                    <p style="text-align: right;"><button style="margin: 15px; background-color: #337ab7; border-color: #2e6da4;" type="submit" class="btn btn-primary nazad">Nazad</button></p>
                </form>
            </div>

        </div>
        <hr style="opacity: 0.1;">
    </div>

    <style>
        a {
            color: #0254EB
        }
        a.morelink {
            text-decoration: none;
            outline: none;
        }
        .morecontent span {
            display: none;
        }
    </style>
    <div class="row media-row" style="padding-bottom:15px;margin-left: 0px !important; margin-right: 0px !important;">
        @if(session('printeds_view'))

            @foreach(session('printeds_view') as $printed)
                <div class="col-xs-10" style="padding: 10px; border-top: 1px solid silver;border-left: 1px solid silver;border-bottom: 1px solid silver; border-right: 3px solid silver; border-radius: 5px; margin-bottom: 30px;">
                    <div class="row" style="margin-left: 0px !important; margin-right: 0px !important;">
                        <div class="col-xs-9" style="padding: 0px;">
                            <h1 style="color: #062945 !important; font-family: 'Anton';">{{$printed['naslov']}}</h1>
                            <h4 style="color: gray !important;">{{$printed['podnaslov']}}</h4>
                            <h4 style="color:#FFAB00 !important;"> <strong>Nađenje klučne reči : {{$printed['found_keywords']}}</strong></h4>
                        </div>
                        <div class="col-xs-3" style="padding: 0 !important;">
                            <a href="http://192.169.189.202/gs/public/javascripts/output_archive/{{$printed['single_page_src']}}" target="_blank"><p style="text-align: right;"><img src="http://192.169.189.202/gs/public/javascripts/output_images/{{substr($printed['single_page_src'], 0, -4)}}.jpg" style="width:100px;" /></p></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">



                            <div class="comment more">
                               <p style="font-size: 18px; color:black;">

                                   <?php
                                    //$text = explode('</div>',$printed['text']);
                                    //echo $text[1];
                                        echo $printed['new_text'];
                                    ?>

                               </p>
                            </div>
                            <div class="buttons_action">
                                <button style="margin-right:15px" form="izdvoji_pdf_stampani" type="submit" class="btn btn-secondary pull-right">Štampaj PDF</button>
                                <input style="width:200px" type="text" placeholder="Unesi imejl adresu" class="pull-left form-control" />
                                <button type="button" style="margin-left:20px" class="btn pull-left">Pošalji mejl</button>
                            </div>
                            <form class="form-group" id="izdvoji_pdf_stampani" action="/izdvojiPDF" method="POST">
                                @csrf
                                <input type="hidden"  name="media_id" value="{{ $printed['id'] }}" />
                                <input type="hidden" name="pressType" value="stampani" />
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

        @endif
    </div>
    <!--/row-->
    <script>
        $(document).ready(function () {
            var chars = 500;
            var moretext = "<br/><button type=\"button\" class=\"btn btn-primary pull-right prikazi-vise\" style=\";background-color: #337ab7; border-color: #2e6da4;\">Prikaži više</button>";
            var lesstext = "<br/><button type=\"button\" class=\"btn btn-primary pull-right prikazi-manje\" style=\";background-color: #337ab7; border-color: #2e6da4;\">Prikaži manje</button>";
            $('.more').each(function () {
                var content = $(this).html();
                if (content.length > chars) {

                    var visibleText = content.substr(0, chars);

                    var formated = '<div>' + visibleText + '<span style="color:#000">...</span></div><div class="more content" style="display:none">' + content + '</div><a href="#" class="morelink">' + moretext + '</a></span>';

                    $(this).html(formated);
                }

            });

            $(".morelink").click(function () {
                if ($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).prev('.content').prev().toggle();
                $(this).prev().toggle();
                return false;
            });
        });
    </script>
@endsection
