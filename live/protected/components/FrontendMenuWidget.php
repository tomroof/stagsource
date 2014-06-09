<?php

class FrontendMenuWidget extends CWidget {

    public $menu_key;
    public $class;
    public $link_class;
    public $type;
    public $menu_name;
    public $show_title = true;

    public function run() {
        $menu_key = $this->menu_key;
        $class = $this->class;
        $menu_name = $this->menu_name;
        $link_class = $this->link_class;
        $show_title = $this->show_title;
        parent::run();

        switch ($this->type) {
            case 'list':
                $model = MenuManager::model()->findAllByAttributes(array('menu_key'=>$menu_key, 'language' => Yii::app()->language));
if (empty($model))
    $criteria= new CDbCriteria();
                $criteria->with='page';
                $criteria->compare('menu_key',$menu_key);
                $criteria->compare('language', 'en');
                $criteria->compare('page.status',Page::STATUS_PUBLISHED);
                $criteria->order= 't.menu_order ASC ';
                $model= MenuManager::model()->findAll($criteria);
//     $model = MenuManager::model()->findAllByAttributes(array('menu_key'=>$menu_key, 'language' => 'en'));
                $this->render('footer_menu', array(
//                    'dataProvider' => $dataProvider,
                    'menu_key' => $menu_key,
                    'class' => $class,
                    'menu_items' => $model,
                    'menu_name' => $menu_name,
                    'link_class' => $link_class,
                    'show_title' => $show_title
                ));

                break;

            case 'menu':

                $menuItems = array();
                $items = Page::model()->getMenuItems();

                $prev_lvl = 0;

                foreach ($items as $item) {
                    if ($item['lvl'] == 0) {
                        $f_position = $item['menu_order'];
                        $menuItems[$f_position] = array(
                            'label' => $item['title'],
                            'url' => ($this->getLinkMenuType($item['id']) == TRUE ? $item['url'] : Yii::app()->createUrl('page/' . $item['url'])),
                        );
                        $menuItems[$f_position]['active'] = ((isset($_GET["permalink"]) && $_GET["permalink"] == $item['url']) || (Yii::app()->getRequest()->getHostInfo() . Yii::app()->getRequest()->getUrl() == $item['url'])) ? true : false;

//                $menuItems[$f_position]['active'] = $this->checkChildrenActive($items, $item);
                    } elseif ($item['lvl'] == 1) {
                        $s_position = $item['menu_order'];
                        $menuItems[$f_position]['items'][$s_position] = array(
                            'label' => $item['title'],
                            'url' => ($this->getLinkMenuType($item['id']) == TRUE ? $item['url'] : Yii::app()->createUrl('page/' . $item['url'])),
//                    'active' => (isset($_GET["permalink"]) && $_GET["permalink"] == $item['url']) ? true : false
                        );

                        if (!$menuItems[$f_position]['active'])
                            $menuItems[$f_position]['active'] = ((isset($_GET["permalink"]) && $_GET["permalink"] == $item['url']) || (Yii::app()->getRequest()->getHostInfo() . Yii::app()->getRequest()->getUrl() == $item['url'])) ? true : false;
                    } elseif ($item['lvl'] == 2) {
                        $th_position = $item['menu_order'];
                        $menuItems[$f_position]['items'][$s_position]['items'][$th_position] = array(
                            'label' => $item['title'],
                            'url' => ($this->getLinkMenuType($item['id']) == TRUE ? $item['url'] : Yii::app()->createUrl('page/' . $item['url'])),
//                    'active' => (isset($_GET["permalink"]) && $_GET["permalink"] == $item['url']) ? true : false
                        );
                        if (!$menuItems[$f_position]['active'])
                            $menuItems[$f_position]['active'] = ((isset($_GET["permalink"]) && $_GET["permalink"] == $item['url']) || (Yii::app()->getRequest()->getHostInfo() . Yii::app()->getRequest()->getUrl() == $item['url'])) ? true : false;
                    }


                    $prev_lvl = $item['lvl'];
                }
                $this->render('frontend_menu', compact('menuItems'));

                break;

            default:
                $menuItems = array();
                $items = Page::model()->getMenuItems();

                $prev_lvl = 0;

                foreach ($items as $item) {
                    if ($item['lvl'] == 0) {
                        $f_position = $item['menu_order'];
                        $menuItems[$f_position] = array(
                            'label' => $item['title'],
                            'url' => ($this->getLinkMenuType($item['id']) == TRUE ? $item['url'] : Yii::app()->createUrl('page/' . $item['url'])),
                        );
                        $menuItems[$f_position]['active'] = ((isset($_GET["permalink"]) && $_GET["permalink"] == $item['url']) || (Yii::app()->getRequest()->getHostInfo() . Yii::app()->getRequest()->getUrl() == $item['url'])) ? true : false;

//                $menuItems[$f_position]['active'] = $this->checkChildrenActive($items, $item);
                    } elseif ($item['lvl'] == 1) {
                        $s_position = $item['menu_order'];
                        $menuItems[$f_position]['items'][$s_position] = array(
                            'label' => $item['title'],
                            'url' => ($this->getLinkMenuType($item['id']) == TRUE ? $item['url'] : Yii::app()->createUrl('page/' . $item['url'])),
//                    'active' => (isset($_GET["permalink"]) && $_GET["permalink"] == $item['url']) ? true : false
                        );

                        if (!$menuItems[$f_position]['active'])
                            $menuItems[$f_position]['active'] = ((isset($_GET["permalink"]) && $_GET["permalink"] == $item['url']) || (Yii::app()->getRequest()->getHostInfo() . Yii::app()->getRequest()->getUrl() == $item['url'])) ? true : false;
                    } elseif ($item['lvl'] == 2) {
                        $th_position = $item['menu_order'];
                        $menuItems[$f_position]['items'][$s_position]['items'][$th_position] = array(
                            'label' => $item['title'],
                            'url' => ($this->getLinkMenuType($item['id']) == TRUE ? $item['url'] : Yii::app()->createUrl('page/' . $item['url'])),
//                    'active' => (isset($_GET["permalink"]) && $_GET["permalink"] == $item['url']) ? true : false
                        );
                        if (!$menuItems[$f_position]['active'])
                            $menuItems[$f_position]['active'] = ((isset($_GET["permalink"]) && $_GET["permalink"] == $item['url']) || (Yii::app()->getRequest()->getHostInfo() . Yii::app()->getRequest()->getUrl() == $item['url'])) ? true : false;
                    }


                    $prev_lvl = $item['lvl'];
                }
                
                echo '<pre>';
var_dump($menuItems);
echo '</pre>';
                $this->render('frontend_menu', compact('menuItems'));
                break;
        }
    }

    public function getLinkMenuType($id) {
        if (Page::model()->findByPk($id)->content == 'link')
            return TRUE;
        else
            return FALSE;
    }

}
