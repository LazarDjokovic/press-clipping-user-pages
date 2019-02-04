<footer class="footer navbar-fixed-bottom text-center" style="background-color: #2F3649;min-height:0px !important;padding:5px;">


    <div class="row">

        @if(session('printeds_view'))





                    {{session('printeds_view')->links()}}

                <!-- <ul class="pagination list-inline" style="padding:0px !important;margin:0px !important;">
                    <li class="page-item"><a class="page-link" href="#">10</a></li>

                    <li class="page-item active">
				  <span class="page-link">
					20
					<span class="sr-only">(current)</span>
				  </span>
                    </li>

                        <li class="page-item"><a class="page-link" href="#">30</a></li>

                </ul> -->


        @endif
    </div>



</footer>