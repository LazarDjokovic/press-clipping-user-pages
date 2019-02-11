<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('partials.head')
<body>
    <!-- container section start -->
    <section id="container" class="">
        @include('partials.header')

        @include('partials.sidebar')

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                @yield('content')
            </section>
        </section>
    </section>

    @include('partials.footer')

    <!-- javascripts -->



    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery.scrollTo.min.js')}}"></script>
    <script src="{{asset('js/jquery.nicescroll.js')}}"></script>
    <script src="{{asset('assets/jquery-knob/js/jquery.knob.js')}}"></script>
    <script src="{{asset('js/jquery.sparkline.js')}}"></script>
    <script src="{{asset('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js')}}"></script>
    <script src="{{asset('js/owl.carousel.js')}}"></script>
    <script src="{{asset('js/fullcalendar.min.js')}}"></script>
    <script src="{{asset('js/scripts.js')}}"></script>
    <script src="{{asset('js/jquery.slimscroll.min.js')}}"></script>

    <script>
        $(document).ready(function () {

            two_latest_news();

            function two_latest_news(){

                var token =  $('input[name="_token"]').attr('value');

                $.ajax({
                    type:'POST',
                    url:'/printeds/two_latest_news',
                    data:{

                    },
                    headers:{
                        'X-CSRF-Token' : token
                    },
                    success:function (data) {
                        $('#two_latest_news').html(data);
                        //console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                    global: false,     // this makes sure ajaxStart is not triggered
                    complete: function() {
                        // Schedule the next request when the current one's complete
                        //setInterval(two_latest_news, 20000);
                        setInterval(function(){
                            $("#two_latest_news").animate({'margin-top':'50px'},1000)
                            $("#two_latest_news").animate({'margin-top':'0px'},1000)
                        },1000*50);
                    }
                })
            }

            window.setInterval(function(){
                two_latest_news();
            },1000*50);
        })
    </script>


    <!--<script src="js/bootstrap.min.js"></script>

    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>

    <script src="assets/jquery-knob/js/jquery.knob.js"></script>
    <script src="js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="js/owl.carousel.js"></script>

    <script src="js/fullcalendar.min.js"></script>



    <script src="js/scripts.js"></script>


    <script src="js/jquery.slimscroll.min.js"></script>-->
</body>
</html>
