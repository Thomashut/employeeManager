@extends('main')
@section('title', 'Department Form')

@section('body')
    <h5>Department Form</h5>
    @if( $edit )
        <form method="POST" action="/department/update/{{$department->id}}">
        @method('PUT')
    @else
        <form method="POST" action="/department/save">
    @endif
        @csrf
        <label for="nameField">Name</label>
        <input type="text" value="{{ $department->name ?? '' }}" id="nameField" name="name"/>
        
        <label for="descriptionField">Description</label>
        <textarea id="descriptionField" name="description">{{ $department->description ?? '' }}</textarea>
    
        <input type="submit" value="Submit"/>
    </form>
@endsection