@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <form action="/digitals/search" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class='col-sm-6'>
                        <div class="form-group">
                            <?php
                            use Carbon\Carbon;
                            $carbon = new Carbon();
                            $carbonFormat = $carbon->format('Y-m-d');
                            ?>
                            <label>Izlistaj medije od : </label> <input class="form-control fromDate"  type="date" name="from" value={{ $carbonFormat }}><br>

                            <label>Izlistaj medije do : </label> <input class="form-control toDate" type="date" name="to" value="{{ $carbonFormat }}">
                        </div>
                    </div>
                    <div class='col-sm-6'>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="sel2">Izaberi medij</label>
                                <select name="publisher" class="form-control publisher" id="sel2">
                                    <option selected value="svi">Svi</option>
                                    @foreach($media as $oneMedia)
                                        <option value="{{$oneMedia->slug}}">{{$oneMedia->name}}</option>
                                    @endforeach
                                </select><br/>
                            </div>
                        </div>
                    </div>
                </div>
                <input id="submit_search" class="submit_search btn btn-info" type="submit" value="Izlistaj" name="submit_search" />
            </form>
        </div>
    </div>
@endsection
