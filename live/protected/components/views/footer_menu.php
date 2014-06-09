<?php
//$this->widget('zii.widgets.CListView', array(
//    'dataProvider' => $dataProvider,
//    'itemView' => '_footer_menu_item',
//    'pagerCssClass' => $menu_key,
//    'template' => FALSE
//));

$currentSlug = explode('/', Yii::app()->request->requestUri);
$currentSlug = urldecode(end($currentSlug));
?>
<?php if (!empty($menu_items)) { ?>
    <ul class="<?php echo $class; ?> <?php echo $menu_key; ?>">
        <?php if (isset($menu_name) && !empty($menu_name)) { ?>
            <li><?php echo "$menu_name"; ?></li>
        <?php } ?>
        <?php
        foreach ($menu_items as $item) { ?>
                <li class="<?php echo ($item->page->permalink == $currentSlug) ? ' active' : ''; ?>" >
                    <a class="<?php echo ($link_class) ? $item->page->permalink : ''; ?>"
                       href="<?php echo ($item->page->content != 'link') ? Yii::app()->createUrl('/page/' . $item->page->url) : $item->page->url; ?>" title="">
                        <?php echo ($show_title) ? $item->page->title : ''; ?>
                    </a>
                </li>
                <?php
        }
        ?>
    </ul>
<?php } ?>