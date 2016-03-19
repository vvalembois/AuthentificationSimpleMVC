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
        return (Database::get()->select('SELECT user_name, user_email FROM '.PREFIX.'users'));
    }
}