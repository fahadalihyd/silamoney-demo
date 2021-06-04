@extends('layouts.app')

@section('content')   
<div class="row justify-content-cnter p-5">
    
                <div class="col-md-6">
                    <form  action="{{ route('register.wallet' , $silaUser->id) }}" method="POST">
                        @method("POST")
                        @csrf
                        <div class="form-group">
                            <label for="nickName">nickname of wallet</label>
                            <input id="nickName" class="form-control" type="text" name="nickname">
                        </div>
                        <div class="form-group">
                          <button class="btn btn-scondary" type="submit">Save</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <h3>Wallets</h3>
                    <table class="table table-light">
                        <tbody>
                            <tr>
                                <td>Nickname</td>
                                <td>Address</td>
                                <td>PrivateKey</td>
                            </tr>
                            @forelse ($wallets as $wallet)
                                <tr>
                                    <td>{{ $wallet->nickname }}</td>
                                    <td>{{ $wallet->address }}</td>
                                    <td>{{ $wallet->private_key }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No Data Found</td>
                                </tr>
                            @endforelse    
                        </tbody>
                    </table>
                </div>    

    <div class="col-md-6">
        <form  action="{{ route('create.account' , $silaUser->id) }}" method="POST">
            @method("POST")
            @csrf
            <div class="form-group m-5">
                <h3>Create Bank Account</h3>
            </div>
            <div class="form-group">
                <label for="account_name">Account name</label>
                <input id="account_name" class="form-control" type="text" required name="account_name">
            </div>
            <div class="form-group">
                <label for="routingNumber">Routing Number</label>
                <input id="routingNumber" class="form-control" type="number" required name="routing_number">
            </div>
            <div class="form-group">
                <label for="accountNumber">Account Number</label>
                <input id="accountNumber" class="form-control" type="number" required name="account_number">
            </div>
            <div class="form-group">
              <button class="btn btn-scondary" type="submit">Save</button>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <h3>Accounts</h3>
        <table class="table table-light">
            <tbody>
                <tr>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Status</th>
                </tr>
                @forelse ($accounts as $account)
                    <tr>
                        <td>{{ $account->accountName }}</td>
                        <td>{{ $account->accountNumber }}</td>
                        <td>{{ $account->accountStatus }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No Data Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="col-md-6">
        <form  action="{{ route('issue.sila' , $silaUser->id) }}" method="POST">
            @method("POST")
            @csrf
            <div class="form-group m-5">
                <h3>Issue Sila</h3>
            </div>
            <div class="form-group">
                <label for="nickName">Account name</label>
                <select class="form-control" required name="account_name">
                    @forelse ($accounts as $account)
                    <option value="{{ $account->accountName }}">{{ $account->accountName }}</option>
                @empty
                    <option value="" disabled selected>No Account Found</option>
                @endforelse
                </select>
            </div>
            <div class="form-group">
                <label for="Amount">Amount</label>
                <input id="Amount" class="form-control" type="number" required name="amount">
            </div>
            <div class="form-group">
              <button class="btn btn-scondary" type="submit">Save</button>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <form  action="{{ route('transfer.sila' , $silaUser->id) }}" method="POST">
            @method("POST")
            @csrf
            <div class="form-group m-5">
                <h3>Transfer Sila</h3>
            </div>
            <div class="form-group">
                <label for="nickName">Destination</label>
                <select class="form-control" required name="destination_handel">
                    @forelse ($handles as $handel)
                    <option value="{{ $handel->handel }}">{{ $handel->handel }}</option>
                @empty
                    <option value="" disabled selected>No Handel Found</option>
                @endforelse
                </select>
            </div>
            <div class="form-group">
                <label for="Amount">Amount</label>
                <input id="Amount" class="form-control" type="number" required name="amount">
            </div>
            <div class="form-group">
              <button class="btn btn-scondary" type="submit">Save</button>
            </div>
        </form>
    </div>

    <div class="col-md-6">
        <form  action="{{ route('redeem.sila' , $silaUser->id) }}" method="POST">
            @method("POST")
            @csrf
            <div class="form-group m-5">
                <h3>Withdraw/Redeem Sila</h3>
            </div>
            <div class="form-group">
                <label for="nickName">Account name</label>
                <select class="form-control" required name="account_name">
                    @forelse ($accounts as $account)
                    <option value="{{ $account->accountName }}">{{ $account->accountName }}</option>
                @empty
                    <option value="" disabled selected>No Account Found</option>
                @endforelse
                </select>
            </div>
            <div class="form-group">
                <label for="Amount">Amount</label>
                <input id="Amount" class="form-control" type="number" required name="amount">
            </div>
            <div class="form-group">
              <button class="btn btn-scondary" type="submit">Save</button>
            </div>
        </form>
    </div>

</div>
@endsection