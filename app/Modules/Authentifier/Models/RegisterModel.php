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

class RegisterModel extends Model
{

    public static function newUser($user_captcha, $user_name, $user_email, $user_email_repeat, $user_password, $user_password_repeat){
        return self::registerInputValidation($user_captcha, $user_name, $user_email, $user_email_repeat, $user_password, $user_password_repeat);
    }

    public static function registerInputValidation($user_captcha, $user_name, $user_email, $user_email_repeat, $user_password, $user_password_repeat){
        /* TODO vérifier tous les paramètres saisies par l'utilisateur */
        $captcha = new RainCaptcha();
        return  ($captcha->checkAnswer($user_captcha)) &&
                (self::registerUsernameValidation($user_name)) &&
                (self::registerEmailValidation($user_email, $user_email_repeat)) &&
                (self::registerPasswordValidation($user_password, $user_password_repeat));
    }

    public static function registerUsernameValidation($user_name){
        return (strlen($user_name) > 4 && strlen($user_name) < 64);
    }

    public static function registerEmailValidation($user_email, $user_email_repeat){
        return  (!empty($user_email)) &&
                (!empty($user_email_repeat)) &&
                ($user_email==$user_email_repeat) &&
                (filter_var($user_email, FILTER_VALIDATE_EMAIL));
    }

    public static function registerPasswordValidation($user_password, $user_password_repeat){
        return  (!empty($user_password)) &&
                ($user_password == $user_password_repeat) &&
                (strlen($user_password) >= 8);
    }

}