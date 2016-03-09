<?php
/**
 * Created by PhpStorm.
 * User: hemery
 * Date: 30/12/2015
 * Time: 11:27
 */

namespace Modules\Authentifier\Helpers;

use Core\View;
use Helpers\Session;

class Feedback {
    private $good;
    private $bad;

    /**
     * Feedback constructor.
     */
    public function __construct($session = false) {
        $feedback = Session::get('feedback');
            if (isset($feedback) !== false) {
                $this->good = $feedback->good;
                $this->false = $feedback->false;
                return;
            }
            $this->good = [];
            $this->bad = [];
            $this->update();
    }


    public function add($msg, $good = false) {
        if ($good) {
            $this->good[] = $msg;
        } else {
            $this->bad[] = $msg;
        }
        $this->update();
    }


    public function merge(array $msg, $good = false) {
        if ($good) {
            array_merge($this->good[], $msg);
        } else {
            array_merge($this->bad[], $msg);
        }
        $this->update();
    }

    public function count($good = false) {
        if ($good) {
            return count($this->good);
        } else {
            return count($this->bad);
        }
    }

    public function get($good = false) {
        if ($good) {
            return $this->good;
        } else {
            return $this->bad;
        }
    }

    public function render() {
        View::renderModule('Authentifier/Views/Feedback/feedback');
        $this->good = [];
        $this->bad = [];
        $this->update();
    }

    public function update(){
        Session::set('feedback',$this);
    }
}