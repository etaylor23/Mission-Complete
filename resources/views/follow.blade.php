@extends('layouts.wrapper')
@section('content')

<div class="main-content">
    <h1>Find followers</h1>

    <form class="" action="/follow/search" method="get">
        <input type="text" name="find-user" id="find-user" placeholder="Find a new follower!">
    </form>

</div>


@endsection
