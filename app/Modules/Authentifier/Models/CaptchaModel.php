<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;
use Helpers\Session;

class CaptchaModel extends Model
{

    /**
     * @param $captcha
     */
    public static function check($captcha)
    {
        if ($captcha == Session::get('captcha')){
            return true;
        }
        return false;
    }
}