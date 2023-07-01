@extends('main')
@section('title', 'Employee Form')
@section('message', $message ?? null)

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

        @if( !$edit )
            <label for="passwordField">Logon Password</label>
            <input type="password" id="passwordField" name="password"/>
        @endif
        
        <label for="dobField">Date of Birth</label>
        <input type="date" value="{{ $employee->dob ?? '' }}" id="dobField" name="dob"/>

        <label for="contactEmailField">Contact Email</label>
        <input type="text" value="{{ $employee->contact_email ?? '' }}" id="contactEmailField" name="contact_email"/>

        <label for="contactPhoneField">Contact Phone</label>
        <input type="text" value="{{ $employee->contact_phone ?? '' }}" id="contactPhoneField" name="contact_phone"/>

        <label for="contactAddressField">Contact Address</label>
        <input type="text" value="{{ $employee->contact_address ?? '' }}" id="contactAddressField" name="contact_address"/>

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