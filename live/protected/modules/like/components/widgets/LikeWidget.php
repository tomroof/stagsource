<?php

/**
 * LikeWidget Widget file.
 * @author Polshikov Roman <polshikovrm@gmail.com>
 * @copyright Copyright &copy; 2013 Tomasnet Media
 */
class LikeWidget extends CWidget
    {

    /**
     *  @var model Object of the model for like/favorite/etc. action.
     *  Requaried
     */
    public $model;

    /**
     *  @var html template  for widjet
     *  Optional
     */
    public $template = '<a href="#" onclick="js:;">Like</a>';

    /**
     * @var  Action type add to  like/favorite/etc.
     * Requaried
     */
    public $type;

    /**
     *  Optional @var containerTag widget container
     *  Optional
     */
    public $containerTag = 'span';

    /**
     * @var array the HTML options for the view container tag.
     * Optional
     */
    public $htmlOptions = array();

    /**
     * @var Count likes/favorites/etc. for this model name
     * Optional
     */
    public $countLikes;

    /**
     * @var ECMA script files for ajax/jquery widget methods
     * all widget scripts in folber module_path/components/assets/js/
     * Optional
     */
    public $scripts = array(
            'likewidget_1_0.js'
    );

    /**
     * @var widget data for ajax/jquery methods
     * Optional
     */
    public $widgetData;

    /**
     * @var widget  css class for active state
     * Optional
     */
    public $activeCssClass = 'active';


    /**
     * Initializes the view.
     */
    public function init(){

        Yii::import('application.modules.like.models.*');
        $this->countLikes = Like::getCountLikes(get_class($this->model), $this->model->getPrimaryKey(), $this->type);
        $this->setStateWidget();
        $cs = Yii::app()->clientScript;
        foreach($this->scripts as $script){
            $cs->registerScriptFile(
                      Yii::app()->assetManager->publish(
                                dirname(__FILE__) . '/assets/js/' . $script
                      )
            );
        }
    }

    /**
     * Renders the view.
     */
    public function run(){


        echo CHtml::openTag($this->containerTag, $this->htmlOptions, $this->template);
        $this->renderContent();
        echo CHtml::closeTag($this->containerTag);
    }

     /**
     * Set State Widget Before Initialization
     * toggle active/deactive css class
     */
    public function setStateWidget(){

       $status = Like::getLikeStatus(get_class($this->model), $this->model->getPrimaryKey(), $this->type,Yii::app()->user->id);

       if($status) {
           $this->activeCssClass = null;
       }
       $this->mergeHtmlOptions();
    }

    /**
     * Renders the main content of the view.
     * The content is divided into sections, such as summary, items, pager.
     * Each section is rendered by a method named as "renderXyz", where "Xyz" is the section name.
     * The rendering results will replace the corresponding placeholders in {@link template}.
     */
    public function renderContent(){

        ob_start();
        echo preg_replace_callback("/{(\w+)}/", array($this, 'renderSection'), $this->template);
        ob_end_flush();
    }

    /**
     * Renders a section.
     * This method is invoked by {@link renderContent} for every placeholder found in {@link template}.
     * It should return the rendering result that would replace the placeholder.
     * @param array $matches the matches, where $matches[0] represents the whole placeholder,
     * while $matches[1] contains the name of the matched placeholder.
     * @return string the rendering result of the section
     */
    protected function renderSection($matches){
        $method = 'render' . $matches[1];
        if(method_exists($this, $method))
        {
            $this->$method();
            $html = ob_get_contents();
            ob_clean();
            return $html;
        }
        else
            return $matches[0];
    }

    /**
     * Render the coun likes.
     */
    public function renderCountLikes(){
        echo Chtml::tag('span', array('class' => 'like-count'), $this->countLikes);
    }

    /**
     *  Merge widget html css class with custom class
     */
    public function mergeHtmlOptions(){

        $widgetData = array(
                'model_name' => get_class($this->model),
                'model_id' => $this->model->getPrimaryKey(),
                'user_id' => Yii::app()->user->id,
                'like_type' => $this->type
        );
        $this->widgetData = json_encode($widgetData);
        if(isset($this->htmlOptions['class']))
        {
            $cssCustomClass = $this->htmlOptions['class'];
            $this->activeCssClass = $this->activeCssClass . ' ' . $cssCustomClass;
        }

        $this->htmlOptions = array_merge(
                $this->htmlOptions, array(
                'class' => $this->activeCssClass,
                'likewidget-data' => $this->widgetData,
                'onclick' => 'likeWidgetAction(this)'
        ));
    }

    }