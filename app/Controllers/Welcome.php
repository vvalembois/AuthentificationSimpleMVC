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
        $this->test();
        View::render('index', $data);
        View::renderTemplate('footer', $data);
    }

    public function test(){
        $this->account_type_required = 1;
        $test = $this->checkAccountRequired();
        if ($test)
            echo "taLeDroit";
        else
            echo "taPasDroit";
    }
}
