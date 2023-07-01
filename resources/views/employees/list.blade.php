@extends('main')
@section('title', 'Employee List')

@section('body')
    <h5>Employee List</h5>
    <table>
        <thead>
            <tr>
                <td>Name</td><td>Department</td><td>Manager?</td><td>Edit</td><td>Delete</td>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ "$employee->firstname $employee->surname" }}</td>
                    <td>{{ $employee->department?->name ?? "No Department" }}</td>
                    <td>{{ $employee->user?->manager ? "Yes" : "No" }}</td>
                    <td><a href="./employee/edit/{{$employee->id}}">Edit</a></td>
                    <td><a href="./employee/delete/{{$employee->id}}">Delete</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection