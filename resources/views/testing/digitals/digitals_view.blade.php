@extends('layouts.app')

@section('content')

    <div class="jumbotron" style="background-color:#EEF1F8;padding-top:0px !important; margin-bottom:0px !important;padding-bottom:0px">
        <div class="row">
            <div class="col-sm-12">
                <h3 style="padding:15px;">Štampane novosti <strong>{{ucwords(str_replace('-', ' ', session('digitals_view')[0]->media_slug))}} / {{session('digitals_view')[0]->created_at->format('Y-m-d')}}</strong></h3>
            </div>

        </div>
        <hr style="background-color:black;">
    </div>
    <div class="row">
        <div class="col-xs-12">
            <form action="{{route('digitals_back')}}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Nazad</button>
            </form>
        </div>
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


                            <div class="comment more">
                                <?php
                                //$text = explode('</div>',$printed['text']);
                                //echo $text[1];
                                echo $printed['new_text'];
                                ?>
                            </div>


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
            var moretext = "<br/><button type=\"button\" class=\"btn btn-primary\">Prikaži više</button>";
            var lesstext = "<br/><button type=\"button\" class=\"btn btn-primary\">Prikaži manje</button>";
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
