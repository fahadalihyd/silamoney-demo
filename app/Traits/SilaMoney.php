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
    public $privateKey = "6176e178939276377db2fd485e1f8045e279dd3075fa2f10e3243c22e3993310";

    public function getClient()
    {
      return  SilaApi::fromDefault($this->handel, $this->privateKey);
    }
}


?>