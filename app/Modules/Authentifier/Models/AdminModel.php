<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;
use Helpers\Database;

class AdminModel extends Model
{
    public static function selectAllUsers(){
        $users = Database::get()->select('SELECT user_name, user_email FROM '.PREFIX.'users',array(),\PDO::FETCH_ASSOC);
        if(!empty($users))
            return $users;
        return false;
    }
    
    public static function deleteUser($user_id){
        //TODO
    }

    public static function updateAccountType($user_id, $new_account_type){
        //TODO
    }
}