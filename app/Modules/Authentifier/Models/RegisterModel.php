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
    public static function insertUser($user_data){
        Database::get()->insert(PREFIX.'users', $user_data);
        return RegisterModel::findByUserID(Database::get()->lastInsertId('user_id'));
    }

    public function setUserActive($user_activation_hash){
        if($this->checkUserActivationHash($user_activation_hash)) {
            Database::get()->update('users', array('user_active' => 1), array('user_id' => $this->user_id));
            return true;
        }
        return false;
    }
}