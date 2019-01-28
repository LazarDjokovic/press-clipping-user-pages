@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <?php
            use Carbon\Carbon;
            $carbon = new Carbon();
            $carbonFormat = $carbon->format('Y-m-d');
            ?>
            @if(session('search_data'))
                <form action="/printeds/search" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <div class='col-sm-6'>
                            <div class="form-group">

                                <label>Izlistaj medije od : </label> <input class="form-control fromDate"  type="date" name="from" value={{ session('search_data')['from'] }}><br>

                                <label>Izlistaj medije do : </label> <input class="form-control toDate" type="date" name="to" value="{{ session('search_data')['to'] }}">
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
            @else
                <form action="/printeds/search" method="POST">
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
        @if(session('printeds'))
            <ul>
                @foreach(session('printeds')[0] as $printed)
                        <li>{{$printed->media_slug}}</li>
                        <li>{{$printed->broj_izdanja}}</li>
                        <li>{{$printed->created_at}}</li>
                        <li>
                            <?php
                                $neprocitani =  $printed->objave - $printed->procitani;
                            ?>
                            @if($neprocitani > 0)
                                Neprocitane objave: {{$neprocitani}}
                            @endif
                        </li>
                        <li>{{$printed->media_slug}}</li>
                        <li>
                            <form action="/printeds/view" method="POST">
                                @csrf
                                <input type="hidden" name="media_slug" value="{{$printed->media_slug}}"/>
                                <input type="hidden" name="broj_izdanja" value="{{$printed->broj_izdanja}}"/>
                                <input type="hidden" name="date" value="{{$printed->created_at}}"/>
                                @if($neprocitani > 0)
                                    <input type="hidden" name="neprocitani" value="1"/>
                                @endif
                                <button type="submit" class="btn btn-primary">Primary</button>
                            </form>
                        </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
