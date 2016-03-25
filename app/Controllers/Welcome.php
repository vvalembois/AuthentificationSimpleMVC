<?php
/**
 * Welcome controller
 *
 * @author David Carr - dave@daveismyname.com
 * @version 2.2
 * @date June 27, 2014
 * @date updated Sept 19, 2015
 */

namespace Controllers;

use Core\View;
use Helpers\Session;
use Modules\Authentifier\Controllers\Authentifier;
use Modules\Authentifier\Controllers\Login;
use Modules\Authentifier\Controllers\Profile;
use Modules\Authentifier\Helpers\AuthMail\AuthMail;
use Modules\Authentifier\Models\AdminModel;
use Modules\Authentifier\Models\LoginModel;
use Modules\Authentifier\Models\UserModelTest;

/**
 * Sample controller showing a construct and 2 methods and their typical usage.
 */
class Welcome extends Authentifier
{

    /**
     * Call the parent construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->language->load('Welcome');
    }

    /**
     * Define Index page title and load template files
     */
    public function index()
    {
        $data['title'] = "Page de test";

        $data['user_status'] = $this->getUserStatus();


        View::renderTemplate('header', $data);
        $this->feedback->render();
        View::render('index', $data);
        $this->test();
        View::renderTemplate('footer', $data);
    }

    public function test(){
        $data['user_name'] = "Jean";
        $data['user_email'] = "Jean@hotmail.fr";
        $data['last_connection'] = "29/02/2016";
        $data['time_register'] = "12";
        $data['user_account_type'] = "0";
        //test vu administration
        View::renderModule('/Authentifier/Views/Profile/user_profile', $data);

    }
}
