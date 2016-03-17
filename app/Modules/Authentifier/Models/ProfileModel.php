<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;
use Helpers\Database;

class ProfileModel extends Model
{
    public static function selectAccountType($user_id){
        $accountType = (Database::get()->select(
            'SELECT user_account_type FROM '.PREFIX.'users
            WHERE user_id = :user_id'
            ,array(":user_id"=>$user_id)
            , \PDO::FETCH_ASSOC)
        );
        if(!empty($accountType))
            return $accountType[0]['user_account_type'];
        return false;
    }

    public static function updateUserProfile(array $user_data_update, $profile){
        Database::get()->update('users', $user_data_update,$profile);
    }

    public static function selectProfile($user_id){
        return (Database::get()->select(
            'SELECT user_id, user_name, user_email FROM '.PREFIX.'users
            WHERE user_id = :user_id'
            ,array(":user_id"=>$user_id),
            \PDO::FETCH_ASSOC)[0]
        );
    }
}