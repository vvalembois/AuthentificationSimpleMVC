<?php
/**
 * User: deloffre
 * Date: 08/03/16
 * Time: 22:40
 */

namespace Modules\Authentifier\Helpers;

class Cookies
{
    /**
     * Safer and better access to $_COOKIE.
     *
     * @param  string   $key
     * @static static method
     *
     * @return mixed
     */
    public static function getcookie($key)
    {
        if(empty($key)){
            return isset($_COOKIE) ? $_COOKIE : null;
        }else{
            return array_key_exists($key, $_COOKIE)? $_COOKIE[$key]: null;
        }
    }

    /**
     * Add a cookie.
     *
     * @param string $key name the data to save
     * @param string $value the data to save
     * @param int $expire count of day before expire
     */
    public static function set($key, $value = false, $expire = 1)
    {
        if (is_array($key) && $value === false) {
            foreach ($key as $name => $value) {
                self::set($name,$value,$expire);
            }
        } else {
            setcookie($key, $value, (time() + ($expire * 86400)), '/', null, null, true); // set for 7 days TODO login with cookie
        }
    }

    public static function destroy($key){
        if(self::getcookie($key) != null)
            self::set($key, NULL, 0);
    }
}