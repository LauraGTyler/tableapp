<?php

/**
 * Class Songs
 * This is a demo class.
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Table extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/table/index
     */
    public function index()
    {   
        if (!empty($_REQUEST['ticked_cookie'])){
            $_SESSION['ticked_cookie'] =1;
            unset($_REQUEST['ticked_cookie']);
        }
        
        if (empty($_REQUEST['table'])){
            //redirect
            header('Location: '.URL.'home/importtable');
        }
        session_start();
        
        $table = $_REQUEST['table'];
        if (empty($_REQUEST['page'])){
            $page = 1;
        }else{
            $page = $_REQUEST['page'];
        }
        $orderby = '';
        if (!empty($_REQUEST['orderby'])){
            $orderby = $_REQUEST['orderby'];
        }
        // Lauras model
        $model = $this->loadModel('TableModel');
        $model->table = $table;

        // Get the data
        $data = $model->getData($orderby);
        $page_data = $model->PageData($page,$data);
        $pages = $model->getPages($data);
        $colnames = array_keys((array) ($data[0]));
        

       if (!empty($_REQUEST['q']) && !empty($_REQUEST['column'])){
            $class = 'active';
            $value = $_REQUEST['q'];
            $selected = $_REQUEST['column'];
            $data = $model->queryData($value, $selected, $orderby);
            $page_data = $model->PageData($page,$data);
            $pages = $model->getPages($data);
        }

       if (!empty($_REQUEST['tableColumns'])){
           unset($_SESSION[$table]['cols']);
           $_SESSION[$table]['cols'] = $_REQUEST['tableColumns'];
       }

       if (empty($_SESSION[$table]['cols'])){
          $_SESSION[$table]['cols'] = $colnames;
       }
       $cols = $_SESSION[$table]['cols'];

        // load views. within the views we can echo out $songs and $amount_of_songs easily
        require 'application/views/_templates/header.php';
        require 'application/views/table/index.php';
        require 'application/views/_templates/footer.php';
    }

    public function removetable()
    {
        if (empty($_REQUEST['table'])){
            //redirect
            header('Location: '.URL.'home/importtable');
        }
        $table = $_REQUEST['table'];
        // Lauras model
        $model = $this->loadModel('TableModel');
        $model->table = $table;//preg_replace('/[^a-zA-Z0-9 ]/','',$table);

        $model->removeTable();
        
        header('Location: '.URL.'home/importtable');
        
    }
    
    public function just_the_table(){
        session_start();
        $table = $_REQUEST['table'];
        if (empty($_REQUEST['page'])){
            $page = 1;
        }else{
            $page = $_REQUEST['page'];
        }
        $orderby = '';
        if (!empty($_REQUEST['orderby'])){
            $orderby = $_REQUEST['orderby'];
        }
        // Lauras model
        $model = $this->loadModel('TableModel');
        $model->table = $table;

        // Get the data
        $data = $model->getData($orderby);
        $page_data = $model->PageData($page,$data);
        $pages = $model->getPages($data);
        $colnames = array_keys((array) ($data[0]));
        

       if (!empty($_REQUEST['q']) && !empty($_REQUEST['column'])){
            $class = 'active';
            $value = $_REQUEST['q'];
            $selected = $_REQUEST['column'];
            $data = $model->queryData($value, $selected, $orderby);
            $page_data = $model->PageData($page,$data);
            $pages = $model->getPages($data);
        }

       if (!empty($_REQUEST['tableColumns'])){
           unset($_SESSION[$table]['cols']);
           $_SESSION[$table]['cols'] = $_REQUEST['tableColumns'];
       }

       if (empty($_SESSION[$table]['cols'])){
          $_SESSION[$table]['cols'] = array_slice($colnames, 0, 5);
       }
       $cols = $_SESSION[$table]['cols'];
       
       ob_start();
        // load views. within the views we can echo out $songs and $amount_of_songs easily
        require 'application/views/table/index.php';
        $doc = ob_get_contents();
       ob_end_clean();
       echo $_GET['callback'].'('.json_encode($doc).')';
    }
    
     public function as_javascript()
    {    
         /* This is for the embed code */ 
         
         /* Embed works if you use:
          * <script language="JavaScript" src="http://127.0.0.1:8888/php-mvc/table/as_javascript?table=song" 
          *         type="text/javascript"></script>
          * But the links don't. I would have to rewrite links in javascipt to get working..
          */
         
        if (empty($_REQUEST['table'])){
            echo 'not all the parameters where sent to the request';
            exit;
        }
        session_start();
        
        $table = $_REQUEST['table'];
        if (empty($_REQUEST['page'])){
            $page = 1;
        }else{
            $page = $_REQUEST['page'];
        }
        $orderby = '';
        if (!empty($_REQUEST['orderby'])){
            $orderby = $_REQUEST['orderby'];
        }
        // Lauras model
        $model = $this->loadModel('TableModel');
        $model->table = $table;

        // Get the data
        $data = $model->getData($orderby);
        $page_data = $model->PageData($page,$data);
        $pages = $model->getPages($data);
        $colnames = array_keys((array) ($data[0]));
        

    if (!empty($_REQUEST['q']) && !empty($_REQUEST['column'])){
        $class = 'active';
        $value = $_REQUEST['q'];
        $selected = $_REQUEST['column'];
        $data = $model->queryData($value, $selected, $orderby);
        $page_data = $model->PageData($page,$data);
        $pages = $model->getPages($data);
    }

   if (!empty($_REQUEST['tableColumns'])){
       unset($_SESSION[$table]['cols']);
       $_SESSION[$table]['cols'] = $_REQUEST['tableColumns'];
   }
   
   if (empty($_SESSION[$table]['cols'])){
      $_SESSION[$table]['cols'] = array_slice($colnames, 0, 5);
   }
   $cols = $_SESSION[$table]['cols'];

    $js='';
   //get the javascript
   foreach(array('jquery.min.js','application.js','as_javascript.js','jquery.simplemodal.min.js') as $jsfile){
       $js .= file_get_contents(URL.'/public/js/'.$jsfile);
       
   }
   
   ob_start();
   echo '<link href="'.URL.'/public/css/style.css" rel="stylesheet">';
   echo '<link href="'.URL.'/public/css/basic.css" rel="stylesheet">';
   require 'application/views/table/index.php';
   $doc = ob_get_contents();
   ob_end_clean();
   ob_start();
   echo 'document.write('.json_encode($doc).');';
   $doc = ob_get_contents();
   ob_end_clean();
   header('Content-type: application/javascript');
   echo $js;
   echo $doc;
    }
  
}
