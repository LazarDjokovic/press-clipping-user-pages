@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form action="/digitals/back" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Back</button>
            </form>
        </div>
        <ul>
            @foreach($digitals_view as $digital)
                <li>{{$digital['naslov']}}</li>
                <li>{{$digital['new_text']}}</li>
                <li><hr/></li>
            @endforeach
        </ul>
        <form action="/$digital/search" method="POST">
            <button type="submit" class="btn btn-primary">Primary</button>
        </form>
    </div>
@endsection
