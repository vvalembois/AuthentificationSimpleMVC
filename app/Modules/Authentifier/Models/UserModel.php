<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;
use Helpers\Database;
use Modules\Authentifier\Helpers\InputValidation;

class UserModel extends Model
{
    private $user_id;
    private $user_name;
    private $session_id;
    private $user_password_hash;
    private $user_email;
    private $user_active;
    private $user_deleted;
    private $user_account_type;
    private $user_has_avatar;
    private $user_remember_me_token;
    private $user_creation_timestamp;
    private $user_suspension_timestamp;
    private $user_last_login_timestamp;
    private $user_failed_logins;
    private $user_last_failed_logins;
    private $user_activation_hash;
    private $user_password_reset_hash;
    private $user_reset_timestamp;
    private $user_provider_type;

    public static function selectAll($user_id){
        return (Database::get()->select('SELECT * FROM '.PREFIX.'users
        WHERE user_id = :user_id'
        ,array(":user_id"=>$user_id),
            \PDO::FETCH_ASSOC)[0]
        );
    }



    public static function selectID($user_name_or_email){
        $user_id = (Database::get()->select(
            'SELECT user_id FROM '.PREFIX.'users
            WHERE user_name = :user_name_or_email
            OR user_email = :user_name_or_email'
            ,array(":user_name_or_email"=>$user_name_or_email),
            \PDO::FETCH_ASSOC)
        );
        if(!empty($user_id))
            return $user_id[0]['user_id'];
        return false;
    }

    public static function exist($user_name_or_email){
        return (self::selectID($user_name_or_email))!= false;
    }

    public static function getUserPasswordHash($user_id){
        $user_password_hash = (Database::get()->select(
            'SELECT user_password_hash FROM '.PREFIX.'users
            WHERE user_id = :user_id'
            ,array(":user_id"=>$user_id),
            \PDO::FETCH_ASSOC)
        );
        if(!empty($user_password_hash))
            return $user_password_hash[0]['user_password_hash'];
        return false;
    }



    public static function selectSession($user_id){
        return (Database::get()->select('SELECT session_id FROM '.PREFIX.'users
        WHERE user_id = :user_id'
            ,array(":user_id"=>$user_id),
            \PDO::FETCH_ASSOC)[0]
        );
    }

    public static function sessionCheck($user_id, $user_session){

    }


}