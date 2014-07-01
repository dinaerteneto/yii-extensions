<?php

class UploadAction extends CAction {
    
    public $path = null;
    public $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
    public $size = array();
    public $preview = false;    
    
    public function __construct() {
        if (empty($this->path)) {
            $this->path = YiiBase::getPathOfAlias('webroot') . '/upload/temp/';
        }
        if (!is_dir($this->path)) {
            mkdir($this->path, 0777, true);
            chmod($this->path, 0777);
            //throw new CHttpException(500, "{$this->path} does not exists.");
        } else if (!is_writable($this->path)) {
            chmod($this->path, 0777);
            //throw new CHttpException(500, "{$this->path} is not writable.");
        }        
    }
    
    public function run() {
        $this->upload();
    }
   
    public function upload() {
        if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
            $this->_exit_status(array('status' => 'Error! Wrong HTTP method!'));
        }

        
        if (array_key_exists('pic', $_FILES) && $_FILES['pic']['error'] == 0) {
            $pic = $_FILES['pic'];
            if (!in_array($this->_get_extension($pic['name']), $this->allowed_ext)) {
                $this->_exit_status(array('status' => 'Only ' . implode(',', $this->allowed_ext) . ' files are allowed!'));
            }
            // Move the uploaded file from the temporary
            // directory to the uploads folder:
            //Novo nome
            $pic['name'] = $this->_aleatorio() . '_' . $this->_aleatorio() . '.' . $this->_get_extension($pic['name']);
            if (move_uploaded_file($pic['tmp_name'], $this->path . $pic['name'])) {
                $this->_exit_status(array('status' => 'File was uploaded successfuly!', 'name' => $pic['name']));
            }
        }
        $this->_exit_status(array('status' => 'Something went wrong with your upload!'));        
    }    
    
    // Helper functions
    private function _exit_status($json) {
        echo CJSON::encode($json);
        exit;
    }

    private function _get_extension($file_name) {
        $ext = explode('.', $file_name);
        $ext = array_pop($ext);
        return strtolower($ext);
    }

    private function _aleatorio() {
        $novo_valor = "";
        $valor = "abcdefghijklmnopqrstuvwxyz0123456789";
        srand((double) microtime() * 1000000);
        for ($i = 0; $i < 10; $i++) {
            $novo_valor.= $valor[rand() % strlen($valor)];
        }
        return $novo_valor;
    }    
    
}

