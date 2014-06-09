<?php
class PermalinkGeneratorBehavior extends CActiveRecordBehavior
{
    public $controller;
    public $action;
    public $params = array();
    public $ContentTitle;
    public $url=null;

    public function getPermalink()
    {

        $this->mergeParams();
        if(!empty($this->url)){
            return Yii::app()->createUrl($this->url);
        }
        return Yii::app()->createUrl($this->controller . '/' . $this->action . '/' . $this->ContentTitle, $this->params);
    }

    private function mergeParams()
    {

        if (!empty($this->params)) {
            $this->params = array_merge($this->params, array('id' => $this->owner->getPrimaryKey()));
        } else {
            $this->params = array('id' => $this->owner->getPrimaryKey());
        }
    }

}