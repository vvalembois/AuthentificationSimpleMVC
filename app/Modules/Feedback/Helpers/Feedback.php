<?php
/**
 * Created by PhpStorm.
 * User: hemery
 * Date: 30/12/2015
 * Time: 11:27
 */

namespace Modules\Feedback\Helpers;

use Core\View;
use Helpers\Session;

define('FEEDBACK_SESSION','session_feedbacks');
define('FEEDBACK_TYPE_SUCCESS','SUCCESS');
define('FEEDBACK_TYPE_INFO','INFO');
define('FEEDBACK_TYPE_WARNING','WARNING');
define('FEEDBACK_TYPE_FAIL','FAIL');


class Feedback {

    static protected $_FEEDBACK_TYPE = [
        'SUCCESS'   => ['css'=>'alert-success', 'label-css' => 'label-success', 'label-content' => 'Success'],
        'INFO'      => ['css'=>'alert-info', 'label-css' => 'label-info', 'label-content' => 'Information'],
        'WARNING'   => ['css'=>'alert-warning', 'label-css' => 'label-warning', 'label-content' => 'Warning'],
        'FAIL'      => ['css'=>'alert-danger', 'label-css' => 'label-danger', 'label-content' => 'Fail']
    ];

    private $feedbacks;

    /**
     * Feedback constructor.
     */
    public function __construct() {
        $this->feedbacks = [];
        $feedback_session = Session::get(FEEDBACK_SESSION);
        $this->merge($feedback_session);

        $this->sessionSave();

    }

    /** Add a feedback content, you can change the feedback type
     * @param $content The feedback content
     * @param string $type Optionnal : FEEDBACK_TYPE_INFO(Default)| FEEDBACK_TYPE_SUCCESS| FEEDBACK_TYPE_WARNING| FEEDBACK_TYPE_FAIL
     */
    public function add($content, $type = FEEDBACK_TYPE_INFO) {
        $this->sessionLoad();
        $this->feedbacks [] = array('content' => $content, 'type' => $type);
        $this->sessionSave();
    }

    /** Check if feedbacks exists or not
     * @return bool
     */
    public function isEmpty(){
        $this->sessionLoad();
        return empty($this->feedbacks);
    }

    /** Count the current number of feedbacks
     * @return int Current count of feedbacks
     */
    public function count() {
        $this->sessionLoad();
        return count($this->feedbacks);
    }

    /** Get all feedbacks
     * @return array all feedbacks
     */
    public function get() {
        $this->sessionLoad();
        return $this->feedbacks;
    }

    /**
     * The default render method for feedbacks
     */
    public function render() {
        $data = [];
        if(!$this->isEmpty())
            foreach ($this->get() as $data['feedback']) {
                $data['feedback-property'] = Feedback::$_FEEDBACK_TYPE[$data['feedback']['type']];
                View::renderModule('Feedback/Views/feedback_message', $data);
            }

        $this->sessionClear();
    }

    /** Merge this instance feedbacks tabs with an other.
     * @param array $feedbacks An other feedbacks tab
     */
    private function merge(array $feedbacks) {
        if($feedbacks!= null && !empty($feedbacks))
            $this->feedbacks = array_unique(array_merge($this->feedbacks,$feedbacks),SORT_REGULAR);
    }

    /**
     * Load the session feedbacks array and merge with this instance feedbacks array
     */
    private function sessionLoad(){
        $feedback_session = Session::get(FEEDBACK_SESSION);
        if(empty($feedback_session))
           Session::set(FEEDBACK_SESSION,$this->feedbacks);
        $this->merge($feedback_session);
    }

    /**
     * Merge and save this instance feedbacks array with the session feedbacks array
     */
    private function sessionSave(){
        $this->sessionLoad();
        Session::set(FEEDBACK_SESSION,$this->feedbacks);
    }

    /**
     * Clear the session feedbacks array
     */
    private function sessionClear(){
        Session::destroy(FEEDBACK_SESSION);
    }
}