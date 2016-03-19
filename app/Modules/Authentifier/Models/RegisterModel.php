<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;
use Helpers\RainCaptcha;
use Helpers\Request;
use Helpers\Database;
use Modules\Authentifier\Helpers\InputValidation;

class RegisterModel extends Model
{
    public static function insertUser($user_data){
        Database::get()->insert(PREFIX.'users', $user_data);
        return Database::get()->lastInsertId('user_id');
    }
}