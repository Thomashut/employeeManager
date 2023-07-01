@extends('main')
@section('title', 'Department List')

@section('body')
    <h5>Department List</h5>
    <table>
        <thead>
            <tr>
                <th>Name</th><th>Description</th><th>Edit</th><th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $department)
                <tr>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->description }}</td>
                    <td><a href="/department/edit/{{$department->id}}">Edit</a></td>
                    <td>
                        <form method="POST" action="/department/delete/{{$department->id}}">
                            @method("DELETE")
                            @csrf
                            <input type="submit" value="Delete" />
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $departments->links('vendor.pagination.simple-default') }}
    <p><a href="/department/create">Add New Department</p>
@endsection