@extends('layouts.wrapper')
@section('content')
        This @if(!empty($notFoundType)) {{$notFoundType}} @endif is not for you
@endsection
