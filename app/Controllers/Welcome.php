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
use Core\Controller;
use Helpers\RainCaptcha;
use Helpers\Request;
use Modules\Authentifier\Models\CaptchaModel;

/**
 * Sample controller showing a construct and 2 methods and their typical usage.
 */
class Welcome extends Controller
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
        $data['title'] = $this->language->get('welcome_text');

        View::renderTemplate('header', $data);
        View::render('index', $data);
        View::renderTemplate('footer', $data);
    }

    public function test(){
        echo "projet S4 - Authendkzodjstifier";
        $this->testCaptcha();

    }

    private function testCaptcha(){
        $captcha = new RainCaptcha();
        echo "<img src=".$captcha->getImage()."/>";

        echo "<form action='#' method='POST'>
              <input type='text' name='usercaptcha'/>
              <input type='submit'/>
               </form>";

        $captcha2 = new RainCaptcha();
        if($captcha2->checkAnswer(Request::post('usercaptcha')))
            echo "ok";
        else
            echo "faux";
    }
}
