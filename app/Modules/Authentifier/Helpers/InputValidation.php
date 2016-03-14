<?php
/**
 * User: deloffre
 * Date: 08/03/16
 * Time: 22:40
 */

namespace Modules\Authentifier\Helpers;


use Helpers\Gump;
use Modules\Feedback\Helpers\Feedback;

class InputValidation
{

    /**
     * Generals inputs validations
     */

    /** Vérifie la conformité d'un nom d'utilisateur
     * @param $user_name Le nom d'utilisateur
     * @return bool true si le nom a une taille comprise entre 5 et 63 caractères et ne contient pas le symbole '@'
     */
    public static function UsernameValidation($user_name){
        return (strlen($user_name) > 4 && strlen($user_name) < 64 && !strchr($user_name,'@'));
    }


    /** Vérifie la conformité d'une adresse mail
     * @param $user_email L'adresse mail
     * @return bool
     */
    public static function emailValidation($user_email){
        return !empty($user_email) && filter_var($user_email,FILTER_VALIDATE_EMAIL);
    }

    /**
     * Register inputs validations
     */

    /** Teste si la saisie de l'adresse mail (et sa confirmation) sont valides et identiques
     * @param $user_email Adresse mail saisie par l'utilisateur
     * @param $user_email_repeat Adresse mail confirmée par l'utilisateur
     * @return bool
     */
    public static function registerEmailValidation($user_email, $user_email_repeat){
        return  self::emailValidation($user_email) && self::emailValidation($user_email_repeat) && $user_email==$user_email_repeat;
    }

    /** Teste si la saisie du mot de passe (et sa confirmation) sont valides et identiques
     * @param $user_password Mot de passe saisi par l'utilisateur
     * @param $user_password_repeat Mot de passe confirmé par l'utilisateur
     * @return bool
     */
    public static function registerPasswordValidation($user_password, $user_password_repeat){
        return  (!empty($user_password)) &&
        ($user_password == $user_password_repeat) &&
        (strlen($user_password) >= 8);
    }

    /**
     * Teste si toute les saisies du formulaire d'inscription sont correct, vérifie aussi le captcha
     * @param $user_captcha
     * @param $user_name
     * @param $user_email
     * @param $user_email_repeat
     * @param $user_password
     * @param $user_password_repeat
     * @return bool
     */
    /*public static function registerInputValidation($user_captcha, $user_name, $user_email, $user_email_repeat, $user_password, $user_password_repeat){
        $captcha = new RainCaptcha();
        return  ($captcha->checkAnswer($user_captcha)) &&
        (InputValidation::UsernameValidation($user_name)) &&
        (InputValidation::registerEmailValidation($user_email, $user_email_repeat)) &&
        (InputValidation::registerPasswordValidation($user_password, $user_password_repeat));
    }*/

    public static function inputsValidationRegister($data){
        $gump = new GUMP();

        $data = $gump->sanitize($data); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'user_name'    => 'required|alpha_numeric|max_len,100|min_len,4',
            'user_password'    => 'required|max_len,100|min_len,6',
            'user_password_repeat'    => 'required|max_len,100|min_len,6',
            'user_mail'       => 'required|valid_email',
            'user_mail_repeat'       => 'required|valid_email',
        ));

        $gump->filter_rules(array(
            'user_name' => 'trim|sanitize_string',
            'user_password' => 'trim',
            'user_password_repeat' => 'trim',
            'user_mail'    => 'trim|sanitize_email',
            'user_mail_repeat'    => 'trim|sanitize_email',
            'user_captcha'    => 'sanitize_string'
        ));

        $validated_data = $gump->run($data);

        $feedback = new Feedback();

        if(!$passwordEquality = $data['user_password']==$data['user_password_repeat']) {
            $feedback->add("Passwords are not the same !",FEEDBACK_TYPE_WARNING);
        }

        if(!$mailEquality = $data['user_mail']==$data['user_mail_repeat']) {
            $feedback->add("Email adresses are not the same !", FEEDBACK_TYPE_WARNING);
        }

        if ($validated_data == false) {
                foreach($gump->get_readable_errors() as $error)
                    $feedback->add($error,FEEDBACK_TYPE_WARNING);
        }

        if(!$passwordEquality || !$mailEquality || !$validated_data) return false;
        return $validated_data;
    }

    public static function inputsValidationProfileUpdate($data)
    {
        $gump = new GUMP();

        $data = $gump->sanitize($data); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'user_name'    => 'alpha_numeric|max_len,100|min_len,4',
            'user_new_password'    => 'max_len,100|min_len,6',
            'user_new_password_repeat'    => 'max_len,100|min_len,6',
            'user_password' => 'required|max_len,100|min_len,6',
            'user_email'       => 'valid_email'
        ));

        $gump->filter_rules(array(
            'user_name' => 'trim|sanitize_string',
            'user_password' => 'trim',
            'user_new_password' => 'trim',
            'user_new_password_repeat' => 'trim',
            'user_email'    => 'trim|sanitize_email'
        ));

        $validated_data = $gump->run($data);

        $feedback = new Feedback();

        if(!$passwordEquality = $validated_data['user_new_password']==$validated_data['user_new_password_repeat']) {
            $feedback->add("Passwords are not the same !",FEEDBACK_TYPE_WARNING);
        }

        if ($validated_data == false) {
            foreach($gump->get_readable_errors() as $error)
                $feedback->add($error,FEEDBACK_TYPE_WARNING);
        }

        if(!$validated_data || !$passwordEquality)
            return false;

        return $validated_data;
    }

    public static function inputsValidationLogin($data){
        $gump = new GUMP();

        $data = $gump->sanitize($data); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'user_name'    => 'required|alpha_numeric|max_len,100|min_len,4',
            'user_password'    => 'required|max_len,100|min_len,6'
        ));

        $gump->filter_rules(array(
            'user_name' => 'trim|sanitize_string',
            'user_password' => 'trim'
        ));

        $validated_data = $gump->run($data);

        $feedback = new Feedback();

        if ($validated_data == false) {
            foreach($gump->get_readable_errors() as $error)
                $feedback->add($error,FEEDBACK_TYPE_WARNING);
        }

        if(!$validated_data) return false;
        return $validated_data;
    }
}