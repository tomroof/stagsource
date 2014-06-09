<?php

/**
 * Maintenance mode for Yii framework.
 * @author Karagodin Evgeniy (ekaragodin@gmail.com)
 * v 1.0
 */
class MaintenanceMode extends CComponent
{

    public $enabledMode = true;
    public $capUrl = 'maintenance/index';
    public $message = "Извините, на сайте ведутся технические работы.";
    public $users = array('admin',);
    public $roles = array('true',);
    public $ips = array();//allowed IP
    public $urls = array();

    public function init()
    {



        $this->enabledMode = Settings::getSettingValue('maintenance_mode');
// Извинте за такое логическое решение, но чекбокс достал.
        if (!$this->enabledMode) {
            Yii::app()->user->setStateKeyPrefix('_admin');
            $disable = in_array(Yii::app()->user->isAdmin(), $this->users);

            if (Yii::app()->user->isAdmin()) {
                Yii::app()->user->setStateKeyPrefix('_user');
                $disable = $disable || Yii::app()->user->checkAccess('admin');
            }
            if (strstr(Yii::app()->request->getPathInfo(), $this->urls[0]))
                $path = TRUE;
            else
                $path = FALSE;

            $disable = $disable || $path;

            $disable = $disable || in_array($this->getIp(), $this->ips);//check "allowed IP"


            if (!$disable) {
                if ($this->capUrl === 'maintenance/index') {
                    Yii::app()->controllerMap['maintenance'] = 'application.extensions.MaintenanceMode.MaintenanceController';
                }

                Yii::app()->catchAllRequest = array($this->capUrl);
            }
        }
    }

    //get user IP
    protected function getIp()
    {
        $strRemoteIP = $_SERVER['REMOTE_ADDR'];
        if (!$strRemoteIP) {
            $strRemoteIP = urldecode(getenv('HTTP_CLIENTIP'));
        }
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $strIP = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $strIP = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $strIP = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $strIP = getenv('HTTP_FORWARDED');
        } else {
            $strIP = $_SERVER['REMOTE_ADDR'];
        }

        if ($strRemoteIP != $strIP) {
            $strIP = $strRemoteIP . ", " . $strIP;
        }
        return $strIP;
    }

}
