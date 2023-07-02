@extends('main')
@section('title', 'Employee List')
@section('message', $message ?? null)

@section('body')
    <h5>Employee List</h5>
    <table>
        <thead>
            <tr>
                <th>Name</th><th>Department</th><th>Manager?</th><th>Edit</th><th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ "$employee->firstname $employee->surname" }}</td>
                    <td>{{ $employee->department?->name ?? "No Department" }}</td>
                    <td>{{ $employee->user?->manager ? "Yes" : "No" }}</td>
                    <td><a href="/employee/edit/{{$employee->id}}">Edit</a></td>
                    <td>
                        @if(isset($restore) && $restore)
                            <form method="POST" action="/employee/restore/{{$employee->id}}">
                                @method("GET")
                                @csrf
                                <input type="submit" value="Restore" />
                            </form>
                        @else
                            <form method="POST" action="/employee/delete/{{$employee->id}}">
                                @method("DELETE")
                                @csrf
                                <input type="submit" value="Delete" />
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $employees->links('vendor.pagination.simple-default') }}
    <p><a href="/employee/create">Add New Employee</p>
    @if(isset($restore) && $restore)
        <p><a href="/employee/list">View Active Employees</a></p>
    @else
        <p><a href="/employee/restoreList">View Deleted Employees</a></p>
    @endif
@endsection