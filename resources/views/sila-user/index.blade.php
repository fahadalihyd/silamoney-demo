@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <a href="{{ route('sila-user.create') }}" class="btn btn-sm btn-info">Create User </a>
        </div>
        <div class="col-md-10">
            <div class="table-responsive">
                <table class="table table-light">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>handel</th>
                            <th>Crypto Address</th>
                            <th>DOB</th>
                            <th>Private Key</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($silaUsers as $user)
                            <tr>
                                <td> <a href="{{ route('sila-user.show' , $user->id) }}">{{ $user->id }}</a>  - {{ ($user->kyc_status == 1 ? 'approved' : '') }} </td>
                                <td> <a href="{{ route('sila-user.show' , $user->id) }}">{{ $user->name }}</a> <a class="btn btn-sm btn-success" href="{{ route('sila-user.transactions' , $user->id) }}" >Transactions</a> </td>
                                <td>{{ $user->handel }}</td>
                                <td>{{ $user->crypto_address }}</td>
                                <td>{{ $user->dob }}</td>
                                <td>{{ $user->private_key }}</td>
                                <td>{{ $user->address }}</td>
                                <td>
                                    <a class="" href="{{ route('request.kyc' , $user->id) }}">Request Kyc</a>
                                    <a class="" href="{{ route('check.kyc' , $user->id) }}">Check Kyc</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection