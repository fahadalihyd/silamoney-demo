@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="{{ route('sila-user.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>First</label>
                    <input type="text" name="first" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label>Last</label>
                    <input type="text" name="last" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label>Handel</label>
                    <input type="text" name="handel" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="stAdd">Street Address</label>
                    <input type="text" id='stAdd' name="street_address" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" id='state' name="state" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="postalCode">Postal Code</label>
                    <input type="text" id="postalCode" name="postal_code" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">email</label>
                    <input type="text" id="email" name="email" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">Identity</label>
                    <input type="text" id="identity" name="identity_number" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label >Date of birth</label>
                    <input type="date" name="name" id="" class="form-control">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Add</button>
                </div>
            </form>
        </div>    
    </div>
@endsection