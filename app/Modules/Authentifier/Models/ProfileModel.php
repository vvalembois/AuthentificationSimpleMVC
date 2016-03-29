<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;
use Helpers\Database;

class ProfileModel extends UserModel
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

    public function updateUserProfile(array $user_data_update){
        return Database::get()->update('users', $user_data_update,array('user_id' => $this->user_id));
    }

    public static function selectProfile($user_id){
        return (Database::get()->select(
            'SELECT user_id, user_name, user_email FROM '.PREFIX.'users
            WHERE user_id = :user_id'
            ,array(":user_id"=>$user_id),
            \PDO::FETCH_ASSOC)[0]
        );
    }

    public function getArray(){

        return array(
            'user_name' => $this->user_name,
            'user_email' => $this->user_email,
            'user_account_type' => $this->user_account_type,
            'user_has_avatar' => $this->user_has_avatar, //TODO
            'user_last_login_timestamp' => $this->user_last_login_timestamp,
            'user_creation_timestamp' => $this->user_creation_timestamp
        );
    }

    public function getUserLastLoginTimestampArray(){
        $last_login = array();
        $last_login['user_last_login'] = time() - $this->getUserLastLoginTimestamp();
        $last_login['user_last_login_minutes'] = $last_login['user_last_login'] / 60;
        $last_login['user_last_login_hours'] = $last_login['user_last_login_minutes'] / 60;
        $last_login['user_last_login_days'] = $last_login['user_last_login_hours'] / 24;
        $last_login['user_last_login_minutes'] = $last_login['user_last_login_minutes']%60;
        $last_login['user_last_login_hours'] = $last_login['user_last_login_hours']%24;
        $last_login['user_last_login_days'] = (int)$last_login['user_last_login_days'];
        return $last_login;
    }
}