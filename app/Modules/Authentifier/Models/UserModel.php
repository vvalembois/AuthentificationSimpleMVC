<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;
use Modules\Authentifier\Helpers\InputValidation;

class UserModel extends Model
{
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

    public static function newUser($user_captcha, $user_name, $user_email, $user_email_repeat, $user_password, $user_password_repeat){
        return InputValidation::registerInputValidation($user_captcha, $user_name, $user_email, $user_email_repeat, $user_password, $user_password_repeat);
    }
}