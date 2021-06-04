<?php

namespace App\Http\Controllers;

use App\Models\SilaUser;
use App\Models\Wallet as ModelsWallet;
use App\Traits\SilaMoney;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Silamoney\Client\Domain\SearchFilters;
use Silamoney\Client\Domain\User;
use Silamoney\Client\Domain\UserBuilder;
use Silamoney\Client\Domain\Wallet;
use Silamoney\Client\Security\EcdsaUtil;

class WalletController extends Controller
{
    use SilaMoney;
    
    public function index()
    {
            // var_dump(getenv('OPENSSL_CONF'));
            $client = $this->getClient();
            $wallet =  $client->generateWallet();
            echo $wallet->getPrivateKey();
            echo $wallet->getAddress();
            $response = $client->checkHandle($this->handel); // Returns Silamoney\Client\Api\ApiResponse

            ### Success 200
            echo $response->getStatusCode(); // 200
            echo $response->getData()->getReference(); // your unique id
            echo $response->getData()->getStatus(); // SUCCESS
            echo $response->getData()->getMessage(); // User is available

    }

    public function checkHandel()
    {
        $userHandle = request()->handel;
        $client = $this->getClient();
        $response = $client->checkHandle($userHandle); // Returns Silamoney\Client\Api\ApiResponse
        
        ### Success 200
        echo $response->getStatusCode(); // 200
        echo $response->getData()->getReference(); // your unique id
        echo $response->getData()->getStatus(); // SUCCESS
        echo $response->getData()->getMessage(); // User is available
    }

    

    public function register(SilaUser $user)
    {
        $client = $this->getClient();
        $wallet =  $client->generateWallet();
         $privateKey = $wallet->getPrivateKey();
        $address = $wallet->getAddress();
        $wallet = new Wallet($address , 'ETH' , request()->nickname);
        $ecdsaUtil = new EcdsaUtil();
        $walletVerificationSignature = $ecdsaUtil->sign(
            $address,
            $privateKey
        );

            // Call the api
            $response = $client->registerWallet(
            $user->handel, 
            $wallet, 
            $walletVerificationSignature, 
            $user->private_key
            );

        if ($response->getStatusCode() == 200) {
            ModelsWallet::create([
                'nickname' => request()->nickname,
                'address' => $address,
                'private_key' => $privateKey,
                'user_id' => $user->id , 
                'amount' => 0,
            ]);
            return redirect()->back()->with('message' , $response->getData()->message);
        }

        // Success 200
        echo $response->getStatusCode();
        echo $response->getData()->success;
        echo $response->getData()->status;
        echo $response->getData()->reference;
        echo $response->getData()->message;
        echo $response->getData()->wallet_nickname;

    }

    public function kyc_req(SilaUser $user)
    {
        $client = $this->getClient();
        $kycLevel = 'DOC_KYC';
        $response = $client->requestKYC($user->handel, $user->private_key, $kycLevel);
        // echo $response->getData()->message;
        return redirect()->back()->with('message' , json_encode($response->getData()) );

        // Success 200
        echo $response->getStatusCode(); // 200
        dd($response->getData());
        echo $response->getData()->reference; // Random reference number
        echo $response->getData()->status; // SUCCESS
        echo $response->getData()->message; // User submitted for KYC review.
        echo $response->getData()->success;
        echo $response->getData()->verification_uuid;
    }

    public function check_kyc(SilaUser $user)
    {
        $client = $this->getClient();
        $response = $client->checkKYC($user->handel , $user->private_key);
        if ($response->getData()->status) {
            $user->update(['kyc_status' => 1]);
        }
        return redirect()->back()->with('message' , $response->getData()->message);
    }

    public function issue(SilaUser $user)
    {
        $client = $this->getClient();

                    // Load your information
            $userHandle = $user->handel;
            $amount = request()->amount;
            $accountName = request()->account_name;
            $userPrivateKey = $user->private_key; // Hex format
            // $descriptor = 'Transaction Descriptor'; // Optional
            // $businessUuid = 'you-business-uuid-code'; // Optional
            // $processingType = AchType::SAME_DAY(); // Optional. Currently supported values are STANDARD (default if not set) and SAME_DAY

            // Call the api
            $response = $client->issueSila($userHandle, $amount, $accountName, $userPrivateKey, null, null, null);

            //Success 200
            if ($response->getStatusCode() == 200) {
                return redirect()->back()->with('message' , $response->getData()->getMessage() );
            }
            echo $response->getStatusCode(); // 200
            dd($response->getData());
            echo $response->getData()->getReference(); // Random reference number
            echo $response->getData()->getStatus(); // SUCCESS
            echo $response->getData()->getMessage(); // Transaction submitted to processing queue.
            echo $response->getData()->getDescriptor(); // Transaction Descriptor.
            echo $response->getData()->getTransactionId(); // The transaction id.
    }


    public function createAccount(SilaUser $user)
    {
        $client = $this->getClient();
        $userHandle = $user->handel;
        $accountName = request()->account_name; // Defaults to 'default' if not provided. (not required)
        $routingNumber = request()->routing_number; // The routing number. 
        $accountNumber = request()->account_number; // The bank account number
        $userPrivateKey = $user->private_key; // The private key used to register the specified user
        $accountType = 'CHECKING'; // The account type (not required). Only available value is CHECKING

        $response = $client->linkAccountDirect($userHandle, $userPrivateKey, $accountNumber, $routingNumber, $accountName, $accountType);
        if ($response->getStatusCode() == 200) {
            return redirect()->back()->with('message' , $response->getData()->getMessage());
        }
        dd($response->getData());
    }
    public function transfer(SilaUser $user)
    {
        $client = $this->getClient();
        $userHandle = $user->handel;
        $destination  = request()->destination_handel; 
        $amount = request()->amount; 
        
        $response = $client->transferSila($userHandle, $destination , $amount, $user->private_key);
        if ($response->getStatusCode() == 200) {
            return redirect()->back()->with('message' , $response->getData()->getMessage());
        }
        dd($response->getData());
    }
    public function redeem(SilaUser $user)
    {
        $client = $this->getClient();
        $userHandle = $user->handel;
        $amount = request()->amount;
        $accountName = request()->account_name;
        $userPrivateKey = $user->private_key;

        $response = $client->redeemSila($userHandle, $amount, $accountName, $userPrivateKey);
        if ($response->getStatusCode() == 200) {
            return redirect()->back()->with('message' , $response->getData()->getMessage());
        }
        dd($response->getData());
    }

    
}
