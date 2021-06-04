<?php

namespace App\Http\Controllers;

use App\Models\SilaUser;
use App\Models\Wallet;
use App\Traits\SilaMoney;
use Illuminate\Http\Request;
use Silamoney\Client\Domain\User;
use Silamoney\Client\Domain\UserBuilder;
use DateTime;
use Silamoney\Client\Domain\SearchFilters;

class SilaUserController extends Controller
{
    use SilaMoney;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $silaUsers = SilaUser::orderBy('id')->get();
        return view('sila-user.index'  , compact('silaUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sila-user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->checkHandel($request->handel)) {
        
            $client = $this->getClient();
            $wallet =  $client->generateWallet();
             $privateKey = $wallet->getPrivateKey();
            $address = $wallet->getAddress();
    
            $handel = $request->handel;
            $userHandle = $handel;
            $firstName = $request->first;
            $lastName = $request->last;
            $cryptoAddress = $address; // Hex-encoded blockchain address (prefixed with "0x")
            // $birthDate =  DateTime::createFromFormat('m/d/Y' , '3/19/1996');  // Only date part will be taken when sent to api
            $birthDate =  DateTime::createFromFormat('m/d/Y' , date('m/d/Y' , strtotime($request->dob)));  // Only date part will be taken when sent to api
           
            $streetAddress1 = $request->street_address;
            $streetAddress2 = '';
            $city = $request->city;
            $state = $request->state; // 2 characters code only
            $postalCode = $request->postal_code; // can be 5 or 9 digits format
            $phone = $request->phone;
            $email = $request->email;
            $identityNumber = $request->identity_number;
            
            $user = new User($userHandle, $firstName, $lastName, $streetAddress1, $streetAddress2, $city, $state, $postalCode, $phone, $email, $identityNumber, $cryptoAddress, $birthDate);

            // Optional parameters can be set to null
            // $user = new User($userHandle, $firstName, $lastName, null, null, null, null, null, null, null, null, $cryptoAddress, $birthDate);
    
            // You can use the UserBuilder to avoid using null on optional parameters
            // $builder = new UserBuilder();
            // $user = $builder->handle($userHandle)->firstName($firstName)->lastName($lastName)->cryptoAddress($cryptoAddress)->birthDate($birthDate)->build();
    
            // Call the api
            $response = $client->register($user);
            // dd($response->getData()->success);
            if ($response->getStatusCode() == 200) {
                SilaUser::create([
                    'name' => $request->first .' '. $request->last,
                    'handel' => $request->handel,
                    'crypto_address' => $cryptoAddress,
                    'dob' => $birthDate,
                    'private_key' => $privateKey,
                    'address' => $address,
                ]);
                return redirect()->back()->with('message' ,  response()->json($response->getData()));
            }


            // Success 200
            echo $response->getStatusCode(); // 200
            echo "<br>";
            echo $cryptoAddress;
            dd($response->getData());
            // echo $response->getData()->getReference(); // Random reference number
            // echo $response->getData()->getStatus(); // SUCCESS
            // echo $response->getData()->getMessage(); // User was successfully register


        }else{
            return redirect()->back()->with('message' , "This $request->handel is not available.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SilaUser  $silaUser
     * @return \Illuminate\Http\Response
     */
    public function show(SilaUser $silaUser)
    {
        $client = $this->getClient();
        $wallets = Wallet::where('user_id' , $silaUser->id)->get();
        $userHandle = $silaUser->handel;
        $userPrivateKey = $silaUser->private_key; // Hex format
        $response = $client->getAccounts($userHandle, $userPrivateKey);
        $accounts = $response->getStatusCode() == 200 ? $response->getData() : [];
        $handles = SilaUser::where('kyc_status' , 1)->where('handel' , '!=' , $silaUser->handel)->get('handel');
        return view('sila-user.show' , compact('wallets' , 'silaUser'  , 'accounts' , 'handles' ));
    }

    
    public function transactions(SilaUser $user)
    {
        $client = $this->getClient();
        $userHandle = $user->handel;
        $filters = new SearchFilters();
        // $filters->setPerPage(1000);
        $userPrivateKey = $user->private_key; // Hex format
        $response = $client->getTransactions($userHandle, $filters, $userPrivateKey);
        $transactions = $response->getStatusCode() == 200 ? $response->getData() : [];
        return view('sila-user.transaction' , compact('transactions' , 'user'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SilaUser  $silaUser
     * @return \Illuminate\Http\Response
     */
    public function edit(SilaUser $silaUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SilaUser  $silaUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SilaUser $silaUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SilaUser  $silaUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(SilaUser $silaUser)
    {
        //
    }
}
