@extends('main')
@section('title', 'Login')

@section('body')
    <form method="POST" action="/login">
        @csrf
        <label for="emailField">User Email:</label>
        <input type="text" id="emailField" name="email"/>

        <label for="passwordField">User Password:</label>
        <input type="password" id="passwordField" name="password"/>
        <input type="submit" id="loginBtn" value="login"/>
    </form>
@endsection