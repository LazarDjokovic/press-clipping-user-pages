@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <?php
            use Carbon\Carbon;
            $carbon = new Carbon();
            $carbonFormat = $carbon->format('Y-m-d');
            ?>
            @if(session('search_data_digital'))
                <form action="/digitals/search" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <div class='col-sm-6'>
                            <div class="form-group">

                                <label>Izlistaj medije od : </label> <input class="form-control fromDate"  type="date" name="from" value={{ session('search_data_digital')['from'] }}><br>

                                <label>Izlistaj medije do : </label> <input class="form-control toDate" type="date" name="to" value="{{ session('search_data_digital')['to'] }}">
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="sel2">Izaberi medij</label>
                                    <select name="publisher" class="form-control publisher" id="sel2">
                                        <option selected value="svi">Svi</option>
                                        @foreach($media as $oneMedia)
                                            @if($oneMedia->slug == session('search_data_digital')['publisher'])
                                                <option value="{{$oneMedia->slug}}" selected>{{$oneMedia->name}}</option>
                                            @endif
                                            <option value="{{$oneMedia->slug}}">{{$oneMedia->name}}</option>
                                        @endforeach
                                    </select><br/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input id="submit_search" class="submit_search btn btn-info" type="submit" value="Izlistaj" name="submit_search" />
                </form>
            @else
                <form action="/digitals/search" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <div class='col-sm-6'>
                            <div class="form-group">
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
            @endif
        </div>
        @if(session('digitals'))
            <ul>
                @foreach(session('digitals')[0] as $digital)
                    <li>Objave {{$digital->objave}}</li>
                    <li>{{$digital->media_slug}}</li>
                    <li>{{$digital->created_at}}</li>
                    <li>
                        <?php
                        $neprocitani =  $digital->objave - $digital->procitani;
                        ?>
                        @if($neprocitani > 0)
                            Neprocitane objave: {{$neprocitani}}
                        @endif
                    </li>
                    <li>{{$digital->media_slug}}</li>
                    <li>
                        <form action="/digitals/view" method="POST">
                            @csrf
                            <input type="hidden" name="media_slug" value="{{$digital->media_slug}}"/>
                            <input type="hidden" name="date" value="{{$digital->created_at}}"/>
                            @if($neprocitani > 0)
                                <input type="hidden" name="neprocitani" value="1"/>
                            @endif
                            <button type="submit" class="btn btn-primary">Primary</button>
                        </form>
                    </li>
                    <hr/>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
