<?php

namespace App\Http\Controllers;

use App\Traits\SilaMoney;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    use SilaMoney;
    
    public function index()
    {
        var_dump(getenv('OPENSSL_CONF'));
        $client = $this->getClient();
        $client->generateWallet($this->privateKey);
    }
}
