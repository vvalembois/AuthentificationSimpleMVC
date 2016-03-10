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
        $this->good = [];
        $this->bad = [];
        $feedback = Session::get('feedback');
        if (isset($feedback)) {
            $this->good = $feedback->good;
            $this->bad = $feedback->bad;
        }
        $this->updateSession();
    }


    public function add($msg, $good = false) {
        if ($good) {
            $this->good[] = $msg;
        } else {
            $this->bad[] = $msg;
        }
        $this->updateSession();
    }


    public function merge(array $msg, $good = false) {
        if ($good) {
            array_merge($this->good, $msg);
        } else {
            array_merge($this->bad, $msg);
        }
        $this->updateSession();
    }

    public function count($good = false) {
        if ($good) {
            return count($this->good);
        } else {
            return count($this->bad);
        }
    }

    public function countAll(){
        return count($this->bad) + count($this->good);
    }

    public function get($good = false) {
        if ($good) {
            return $this->good;
        } else {
            return $this->bad;
        }
    }

    public function render() {
        if($this->countAll() > 0) {
            View::renderModule('Authentifier/Views/Feedback/feedback_header');
            if ($this->count() > 0) {
                $data['type'] = "danger";
                foreach ($this->get() as $data['message']) {
                    View::renderModule('Authentifier/Views/Feedback/feedback_message', $data);
                }
            } else if ($this->count(true) > 0) {
                $data['type'] = "success";
                foreach ($this->get(true) as $data['message']) {
                    View::renderModule('Authentifier/Views/Feedback/feedback_message', $data);
                }
            }

            View::renderModule('Authentifier/Views/Feedback/feedback_footer');

            $this->good = [];
            $this->bad = [];
            $this->updateSession();
        }
    }

    public function updateFeedback(){
        $feedback = Session::get('feedback');
        if (isset($feedback)) {
            $this->good = $feedback->good;
            $this->bad = $feedback->bad;
        }
    }

    public function updateSession(){
        Session::set('feedback',$this);
    }
}