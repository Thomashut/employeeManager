@extends('main')
@section('title', 'Login')

@section('body')
    <form method="POST" action="/login">
        @csrf
        <input type="text" name="email"/>
        <input type="password" name="password"/>
        <input type="submit" value="login"/>
    </form>
@endsection