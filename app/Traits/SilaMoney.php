<?php 

namespace App\Traits;
use Silamoney\Client\Api\SilaApi;
use Silamoney\Client\Domain\{BalanceEnvironments,Environments};

/**
 * SilaMoney
 */
trait SilaMoney
{
    private $handel = "emfg";
    public  $privateKey = "853d5aef574b55e6accd72d7debc17af488a31ba5aa5550d289e910c624ea3a0";

    public function getClient()
    {
      return SilaApi::fromDefault($this->handel, $this->privateKey);
    }

    public function checkHandel($handel)
    {
        $userHandle = $handel;
        $client = $this->getClient();
        $response = $client->checkHandle($userHandle); // Returns Silamoney\Client\Api\ApiResponse
    
        if ($response->getData()->getStatus() == 'SUCCESS') {
          return true;
        }
        ### Success 200
        // echo $response->getStatusCode(); // 200
        // echo $response->getData()->getReference(); // your unique id
        // echo $response->getData()->getStatus(); // SUCCESS
        // echo $response->getData()->getMessage(); // User is available
    }
}


?>