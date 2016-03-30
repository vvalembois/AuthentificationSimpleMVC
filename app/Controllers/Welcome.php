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
use Core\Model;
use Helpers\Session;
use Models\ArticleModel;
use Modules\Authentifier\Controllers\Authentifier;
use Modules\Authentifier\Helpers\AuthMail\AuthMail;
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
        $data['user_status'] = (Session::get('user_name') ? Session::get('user_name') : "Visitor");
        $this->test();
        View::renderTemplate('header', $data);
        $this->feedback->render();
        View::render('index', $data);
        View::renderTemplate('footer', $data);
    }

    public function test(){
        $article = ArticleModel::findById(4);
        var_dump($article);
        echo "<br>";
        $article->setArtTitle("gros beatard");
        $article->save();
        var_dump($article);
    }
}
