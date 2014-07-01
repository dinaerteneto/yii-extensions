<?php

class UploadWidget extends CWidget {

    private $_assetUrl = null;
    
    
    protected function registerClientScript() {
        $this->_assetUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.upload.assets')); // path to Slider extension and cache it in assets.
        Yii::app()->clientScript->registerScriptFile($this->_assetUrl . '/js/jquery.js', 2);
        Yii::app()->clientScript->registerScriptFile($this->_assetUrl . '/js/jquery.filedrop.js', 2); 
        Yii::app()->clientScript->registerScriptFile($this->_assetUrl . '/js/script.js', 2); 
        Yii::app()->clientScript->registerCssFile($this->_assetUrl . '/css/styles.css');
    }

    public function init() {
        $this->registerClientScript();
    }

    public function run() {
        $this->render('upload', array('assets' => $this->_assetUrl));
    }
    

}
