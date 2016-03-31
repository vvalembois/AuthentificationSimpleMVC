<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;
use Helpers\Data;
use Helpers\RainCaptcha;
use Helpers\Request;
use Helpers\Database;
use Modules\Authentifier\Helpers\InputValidation;

class RegisterModel extends UserModel
{
    public function setUserActiveValidate($user_activation_hash){
        if($this->checkUserActivationHash($user_activation_hash)) {
            $this->setUserActive(1);
            return $this->save();
        }
        return false;
    }
}