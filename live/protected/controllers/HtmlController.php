<?php

class HtmlController extends Controller
{

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        
       
    }

 

    public function actionCategory()
    {
        
       $this->render('category');
    }


    public function actionCommunity()
    {
        
       $this->render('community');
    }

    public function actionCurriculumEngagement()
    {
        
       $this->render('curriculum-engagement');
    }

    public function actionCurriculumExploration()
    {
        
       $this->render('curriculum-exploration');
    }

    public function actionResources()
    {
        
       $this->render('resources');
    }


}