<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;

class AdminModel extends Model
{
    public static function selectAllUsers(){
        return (Database::get()->select('SELECT user_name, user_email FROM '.PREFIX.'users', array(), \PDO::FETCH_ASSOC));
    }
    
    public static function deleteUser($user_id){
        //TODO
    }

    public static function updateAccountType($user_id, $new_account_type){
        //TODO
    }
}