@extends('layouts.app')

@section('content')
    @include('users.favorites', ['users' => $users])
@endsection