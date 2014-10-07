<?php
/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        // debug message to show where you are, just for the demo
        // echo 'Message from Controller: You are in the controller home, using the method index()';
        // load views. within the views we can echo out $songs and $amount_of_songs easily
        session_start();
        if (!empty($_REQUEST['ticked_cookie'])){
            $_SESSION['ticked_cookie'] =1;
            unset($_REQUEST['ticked_cookie']);
        }
        require 'application/views/_templates/header.php';
        require 'application/views/home/index.php';
        require 'application/views/_templates/footer.php';
    }

    /**
     * PAGE: importtable
     * This method handles what happens when you move to http://yourproject/home/importtable
     * The camelCase writing is just for better readability. The method name is case insensitive.
     */
    public function importtable()
    {
        // debug message to show where you are, just for the demo
        // echo 'Message from Controller: You are in the controller home, using the method importtable()';
        session_start();
        if (!empty($_REQUEST['ticked_cookie'])){
            $_SESSION['ticked_cookie'] =1;
            unset($_REQUEST['ticked_cookie']);
        }
        $table_model = $this->loadModel('TableModel');
        $tables = $table_model->getAllTables();
        
        // load views. within the views we can echo out $songs and $amount_of_songs easily
        require 'application/views/_templates/header.php';
        require 'application/views/home/importtable.php';
        require 'application/views/_templates/footer.php';
    }
    
    public function addtablemysql()
    {
        $filetmpdir = FILETMPDIR;
        if (!file_exists($filetmpdir)) {
            mkdir($filetmpdir);
        }
        require 'application/libs/PHPLogger.php';
        $log = new PHPLogger(FILETMPDIR.'/log');

        $uploadfile = $filetmpdir .'/'. basename($_FILES['mysqltable']['name']);
        
        if (move_uploaded_file($_FILES['mysqltable']['tmp_name'], $uploadfile)) {          
            $log->i('File upload', 'File is valid:'.basename($_FILES['mysqltable']['name']).' and was successfully uploaded' );
        } else {
            $log->w('File upload', "File was not uploaded correctly.\n");
            header('Location: '.URL.'home/importtable');
        } 
        $table_model = $this->loadModel('TableModel');
        $return = $table_model->importMysqlFile($uploadfile);
        unlink($uploadfile);
        //redirect
        header('Location: '.URL.'home/importtable');
    }

     public function addtablecsv()
    {
        $filetmpdir = FILETMPDIR;
        if (!file_exists($filetmpdir)) {
            mkdir($filetmpdir);
        }
        require 'application/libs/PHPLogger.php';
        $log = new PHPLogger(FILETMPDIR.'/log');

        $uploadfile = $filetmpdir .'/'. basename($_FILES['csvtable']['name']);
        
        if (move_uploaded_file($_FILES['csvtable']['tmp_name'], $uploadfile)) {          
            $log->i('File upload', 'File is valid:'.basename($_FILES['csvtable']['name']).' and was successfully uploaded' );
        } else {
            $log->w('File upload', "File was not uploaded correctly.\n");
            header('Location: '.URL.'home/importtable');
        } 
        $table_model = $this->loadModel('TableModel');
        
        $data = $table_model->importCSVFile($uploadfile);

        unlink($uploadfile);
        //redirect
        header('Location: '.URL.'home/importtable');
    }
    
     public function addtablejson()
    {
        $filetmpdir = FILETMPDIR;
        if (!file_exists($filetmpdir)) {
            mkdir($filetmpdir);
        }
        require 'application/libs/PHPLogger.php';
        $log = new PHPLogger(FILETMPDIR.'/log');

        $uploadfile = $filetmpdir .'/'. basename($_FILES['jsontable']['name']);
        
        if (move_uploaded_file($_FILES['jsontable']['tmp_name'], $uploadfile)) {          
            $log->i('File upload', 'File is valid:'.basename($_FILES['jsontable']['name']).' and was successfully uploaded' );
        } else {
            $log->w('File upload', "File was not uploaded correctly.\n");
            header('Location: '.URL.'home/importtable');
        } 
        $table_model = $this->loadModel('TableModel');
        
        $data = $table_model->importJSONFile($uploadfile);
        unlink($uploadfile);
        //redirect
        header('Location: '.URL.'home/importtable');
    }
    
       public function addexcel()
    {
        $filetmpdir = FILETMPDIR;
        if (!file_exists($filetmpdir)) {
            mkdir($filetmpdir);
        }
        require 'application/libs/PHPLogger.php';
        $log = new PHPLogger(FILETMPDIR.'/log');

        $uploadfile = $filetmpdir .'/'. basename($_FILES['exceltables']['name']);
        
        if (move_uploaded_file($_FILES['exceltables']['tmp_name'], $uploadfile)) {          
            $log->i('File upload', 'File is valid:'.basename($_FILES['exceltables']['name']).' and was successfully uploaded' );
        } else {
            $log->w('File upload', "File was not uploaded correctly.\n");
            header('Location: '.URL.'home/importtable');
        } 
        $table_model = $this->loadModel('TableModel');

        $data = $table_model->importExcelFile($uploadfile);
        unlink($uploadfile);
        //redirect
        header('Location: '.URL.'home/importtable');
    }
    
    
 
    public function cookiepolicy(){
        session_start();
        $_SESSION['ticked_cookie'] =1;
        require 'application/views/_templates/header.php';
        require 'application/views/home/cookiepolicy.php';
        require 'application/views/_templates/footer.php';
        
    }
    
    
}