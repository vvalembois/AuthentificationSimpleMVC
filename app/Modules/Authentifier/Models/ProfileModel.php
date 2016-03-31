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