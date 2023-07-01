@extends('main')
@section('title', 'Dashboard')

@section('body')
    <h5>Dashboard</h5>
    <p>Department: {{ Auth::user()->Employee?->Department?->name ?? "No Department" }}</p>
@endsection