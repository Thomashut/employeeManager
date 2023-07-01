@extends('main')
@section('title', 'Employee Form')

@section('body')
    <h5>Employee Form</h5>
    @if( $edit )
        <form method="POST" action="/employee/update/{{$employee->id}}">
        @method('PUT')
    @else
        <form method="POST" action="/employee/save">
    @endif
        @csrf
        <label for="firstField">Firstname</label>
        <input type="text" value="{{ $employee->firstname ?? '' }}" id="firstField" name="firstname"/>
        
        <label for="surnameField">Surname</label>
        <input type="text" value="{{ $employee->surname ?? '' }}" id="surnameField" name="surname"/>

        <label for="emailField">Logon Email</label>
        <input type="text" value="{{ $employee->email ?? '' }}" id="emailField" name="email"/>
        
        <label for="dobField">Date of Birth</label>
        <input type="date" value="{{ $employee->dob ?? '' }}" id="dobField" name="dob"/>

        <label for="contactEmailField">Contact Email</label>
        <input type="text" value="{{ $employee->contactEmail ?? '' }}" id="contactEmailField" name="contactEmail"/>

        <label for="contactPhoneField">Contact Phone</label>
        <input type="text" value="{{ $employee->contactPhone ?? '' }}" id="contactPhoneField" name="contactPhone"/>

        <label for="contactAddressField">Contact Address</label>
        <input type="text" value="{{ $employee->contactAddress ?? '' }}" id="contactAddressField" name="contactAddress"/>

        <label for="departmentField">Department</label>
        <select name="department_id" id="departmentField">
            @foreach( $departments as $department )
                <option value={{$department->id}} selected={{ $employee?->department_id == $department->id }}>
                    {{$department->name}}
                </option>
            @endforeach
        </select>

        <input type="submit" value="Submit"/>
    </form>
@endsection