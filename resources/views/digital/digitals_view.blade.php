@extends('layouts.app')

@section('content')

    <div class="jumbotron" style="background-color:#EEF1F8;padding-top:0px !important; margin-bottom:0px !important;padding-bottom:0px">
        <div class="row">
            <div class="col-sm-12">
                <h3 style="padding:15px;">Digitalne novosti: <strong style="color:#3660D9">{{ucwords(str_replace('-', ' ', session('digitals_view')[0]->media_slug))}} / {{session('digitals_view')[0]->created_at->format('Y-m-d')}}</strong></h3>


                <form action="{{route('digitals_back')}}" method="POST">
                    @csrf
                    <button style="margin: 15px;" type="submit" class="btn btn-primary">Nazad</button>
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
        @if(session('digitals_view'))

            @foreach(session('digitals_view') as $printed)
                <div class="col-xs-10" style="border-top: 2px solid gray; border-right: 2px solid gray; border-radius: 5px; margin-bottom: 30px;">
                    <div class="row" style="margin-left: 0px !important; margin-right: 0px !important;">
                        <div class="col-xs-9">
                            <h1 style="color: #062945 !important;"><strong>{{$printed['naslov']}}</strong></h1>
                            <h4 style="color: #BB7DE8 !important;">{{$printed['podnaslov']}}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                           <!-- <h4 style="color:#FFAB00 !important;">Nađenje klučne reči: <strong></strong></h4> -->


                            <div class="comment more">
                                <?php
                                //$text = explode('</div>',$printed['text']);
                                //echo $text[1];
                                echo $printed['new_text'];
                                ?>
                            </div>
                            <div class="buttons_action">
                                <button style="margin-right:15px" type="submit" class="btn btn-secondary pull-right" form="izdvoji_pdf_digitalni">Štampaj PDF</button>
                                <input style="width:200px" type="text" placeholder="Unesi imejl adresu" class="pull-left form-control" />
                                <button type="button" style="margin-left:20px" class="btn pull-left">Pošalji mejl</button>
                            </div>
                            <form class="form-group" id="izdvoji_pdf_digitalni" action="/izdvojiPDF" method="POST">
                                @csrf
                                <input type="hidden"  name="media_id" value="{{ $printed['id'] }}" />
                                <input type="hidden" name="pressType" value="elektronski" />
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
            var moretext = "<br/><button type=\"button\" class=\"btn btn-primary pull-right\">Prikaži više</button>";
            var lesstext = "<br/><button type=\"button\" class=\"btn btn-primary pull-right\">Prikaži manje</button>";
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
