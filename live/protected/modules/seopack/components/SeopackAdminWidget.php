<?php

class SeopackAdminWidget extends CWidget
{
    public  $model;
    public function init()
    {
        Yii::import('application.modules.seopack.models.SeoPack');
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }

    public function run()
    {
        $modelSeoPack = SeoPack::model()->getSeoModel(get_class($this->model),$this->model->getPrimaryKey());

        if(!$modelSeoPack)
        {
            $modelSeoPack = new SeoPack();
        }
        $this->render('admin',compact('modelSeoPack'));
    }



}

?>