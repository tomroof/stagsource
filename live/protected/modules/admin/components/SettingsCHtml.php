<?php
/**
 * Html is a static class that provides a collection of helper methods for creating HTML views.
 *
 * @author Vlad <vladbbk@gmail.com>
 * @version $Id$
 * @since 1.0
 */

class SettingsCHtml extends CHtml
{
    /**
     * Generates a Setting text field input.
     * @param $attribute
     * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
     * attributes are also recognized (see {
     * @internal param string $name the input name
     * @internal param string $value the input value
     * @link clientChange} and {@link tag} for more details.)
     * @return string the generated input field
     * @see clientChange
     * @see inputField
     */

    public static function settingsTextField($name, $htmlOptions = array(), $s_label = '', $s_description = '')
    {
        $model = Settings::model()->findByPk($name);
        $value = $model->value;
        $name = "Settings[$name]";

        if ($model->validation_type == 'email' && $model->required == 1)
            $add_class = " validate[required,custom[email]] medium";
        elseif ($model->validation_type == 'email')
            $add_class = " validate[custom[email]] medium";


        if ($model->validation_type == 'url' && $model->required == 1)
            $add_class = " validate[required,custom[url]] medium";
        elseif ($model->validation_type == 'url')
            $add_class = " validate[custom[url]] medium";

        if (empty($model->validation_type) && $model->required == 1)
            $add_class = " validate[required] medium";

        if (isset($htmlOptions['class']) && !empty($add_class))
            $htmlOptions['class'] = $htmlOptions['class'] . $add_class;
        elseif((!isset($htmlOptions['class']) || empty($htmlOptions['class']))  && !empty($add_class))
            $htmlOptions['class'] = $add_class;

        self::clientChange('change', $htmlOptions);
        $html = '<div class="section">
                    <label>' . $s_label . '<small>' . $s_description . '</small></label>
                <div>' . self::inputField('text', $name, $value, $htmlOptions) . '</div>
                </div>';
        return $html;
    }

    public static function settingsCheckBox($name, $htmlOptions = array(), $s_label = '', $s_description = '')
    {
        $checked = Settings::getSettingValue($name);
        $name = "Settings[$name]";

        if ($checked)
            $htmlOptions['checked'] = 'checked';
        else
            unset($htmlOptions['checked']);
        $value = isset($htmlOptions['value']) ? $htmlOptions['value'] : 1;
        self::clientChange('click', $htmlOptions);

        if (array_key_exists('uncheckValue', $htmlOptions)) {
            $uncheck = $htmlOptions['uncheckValue'];
            unset($htmlOptions['uncheckValue']);
        } else
            $uncheck = null;

        if ($uncheck !== null) {
            // add a hidden field so that if the radio button is not selected, it still submits a value
            if (isset($htmlOptions['id']) && $htmlOptions['id'] !== false)
                $uncheckOptions = array('id' => self::ID_PREFIX . $htmlOptions['id']);
            else
                $uncheckOptions = array('id' => false);
            $hidden = self::hiddenField($name, $uncheck, $uncheckOptions);
        } else
            $hidden = '<input type="hidden" name="' . $name . '" value=0>';
        // add a hidden field so that if the checkbox  is not selected, it still submits a value

        $html = '<div class="section">
                    <label>' . $s_label . '<small>' . $s_description . '</small></label>
                <div>' . $hidden . self::inputField('checkbox', $name, $value, $htmlOptions) . '</div>
                </div>';
        return $html;
    }

    public static function settingstextArea($name, $htmlOptions = array(), $s_label = '', $s_description = '')
    {
        $model = Settings::model()->findByPk($name);
        $value = $model->value;
        $name = "Settings[$name]";


        $htmlOptions['name'] = $name;
        if (!isset($htmlOptions['id']))
            $htmlOptions['id'] = self::getIdByName($name);
        else if ($htmlOptions['id'] === false)
            unset($htmlOptions['id']);

        if ($model->validation_type == 'url' && $model->required == 1)
            $add_class = " validate[required,custom[url]] medium";
        elseif ($model->validation_type == 'url')
            $add_class = " validate[custom[url]] medium";

        if (empty($model->validation_type) && $model->required == 1)
            $add_class = " validate[required] medium";

        if (isset($htmlOptions['class']) && !empty($add_class))
            $htmlOptions['class'] = $htmlOptions['class'] . $add_class;
        elseif((!isset($htmlOptions['class']) || empty($htmlOptions['class']))  && !empty($add_class))
            $htmlOptions['class'] = $add_class;

        self::clientChange('change', $htmlOptions);
        $html = '<div class="section">
                    <label>' . $s_label . '<small>' . $s_description . '</small></label>
                <div>' . self::tag('textarea', $htmlOptions, isset($htmlOptions['encode']) && !$htmlOptions['encode'] ? $value : self::encode($value)) . '</div>
                </div>';
        return $html;
    }

}