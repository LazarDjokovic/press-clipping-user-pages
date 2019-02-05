<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/jquery-ui-1.10.4.min.js')}}"></script>
<script src="{{asset('js/jquery-1.8.3.min.js')}}"></script>
<script src="{{asset('js/jquery-ui-1.9.2.custom.min.js')}}"></script>
<div class="container">
    @csrf
    <div id="two_latest_news">

    </div>
</div>
<script>
    $(document).ready(function () {

        two_latest_news();

        function two_latest_news(){

            var token =  $('input[name="_token"]').attr('value');

            $.ajax({
                type:'POST',
                url:'/test/two_latest_news',
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
                complete: function() {
                    // Schedule the next request when the current one's complete
                    //setInterval(two_latest_news, 20000);
                    setInterval(function(){
                        $("#two_latest_news").animate({'margin-top':'50px'},1000)
                        $("#two_latest_news").animate({'margin-top':'0px'},1000)
                    },5000);
                }
            })
        }
    })
</script>