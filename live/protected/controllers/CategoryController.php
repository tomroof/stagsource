<?php

class CategoryController extends Controller
{
    
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'community'),
                'expression' => 'Yii::app()->user->isGuest || !Yii::app()->user->isGuest',
            ),
            array('allow',
                'actions' => array('create'),
                'expression' => '!Yii::app()->user->isGuest',
            ),

            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionView($url)
    {
        $category = ContentCategories::model()->findByAttributes(array('permalink' => $url));
        if ($category) {
            $criteria = new CDbCriteria();
            $criteria->with=array('content_category_rel');
            $criteria->addCondition( 'content_category_id = ' . $category->id ,'OR');
            $criteria->addCondition( 'content_category_rel.parent = ' . $category->id,'OR');
//            $criteria->compare('t.content_type',Contents::TYPE_COMMUNITY);
            $criteria->order = 'created_at DESC';
            $dataProvider = new CActiveDataProvider('Contents', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 22,
                ),
            ));

        $this->render('view', array(
            'dataProvider' => $dataProvider,
            'category'=>$category,
        ));
        } else
            throw new CHttpException(404,'This category was not found');
    }

    public function actionCommunity($url)
    {
        $category = ContentCategories::model()->findByAttributes(array('permalink' => $url));
        if ($category) {
            $criteria = new CDbCriteria();
            $criteria->with=array('content_category_rel');
            $criteria->addCondition( 'content_category_id = ' . $category->id ,'OR');
            $criteria->addCondition( 'content_category_rel.parent = ' . $category->id,'OR');
            $criteria->compare('t.content_type',Contents::TYPE_COMMUNITY);
            $criteria->order = 'created_at DESC';
            $dataProvider = new CActiveDataProvider('Contents', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 22,
                ),
            ));

        $this->render('view', array(
            'dataProvider' => $dataProvider,
            'category'=>$category,
        ));
        } else
            throw new CHttpException(404,'This category was not found');
    }

    // Uncomment the following methods and override them if needed
}
