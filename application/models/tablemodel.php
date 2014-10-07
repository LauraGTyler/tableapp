<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of tableModel
 *
 * @author lauratyler
 */
class tablemodel {
     /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
   
    
    var $table;
    var $items = TABLEITEMS;
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    
    public function getAllTables(){
   
        $sql = "SHOW TABLES";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // libs/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change libs/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }
    
    public function removeTable(){
        
        $sql = 'DROP TABLE `'.$this->table.'`';
        $query = $this->db->prepare($sql);
        $query->execute();
        
    }
    
    public function importMysqlFile($filename){
        $sql = file_get_contents($filename);
        
       try{
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
          $this->db->exec($sql);
          }catch(PDOException $e){
              return false;
          }
    }
    
    //excel file
    
    public function importExcelFile($filename){

       require 'application/libs/PHPExcel/IOFactory.php';
       ini_set("memory_limit","-1");
       ini_set('max_execution_time', 1200);
       $inputFileType = PHPExcel_IOFactory::identify($filename);
       $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
       $cacheSettings = array( ' memoryCacheSize ' => '8MB');
       PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
       $objReader = PHPExcel_IOFactory::createReader($inputFileType);
       $objReader->setReadDataOnly(true);

       $objPHPExcel = $objReader->load($filename);
       $worksheets = $objPHPExcel->getAllSheets();

       $i=0;
       foreach ($worksheets as $sheet){
            $sheetname = $sheet->getTitle();
            $tablename = preg_replace('/[^a-zA-Z0-9 ]/', '', substr(basename($filename), 0, -5)) . '-' . $sheetname;
            $sql = 'CREATE TABLE `' . $tablename . '` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,';
            $rowIt = $sheet->getRowIterator();
            $Row1 = $rowIt->current();

            $cellIt = $Row1->getCellIterator();
            $HighestRow = $sheet->getHighestRow();
            $rownumber =$Row1->getRowIndex();
            $cellIt->setIterateOnlyExistingCells(false);
            $cols = array();
            $i=0;
            $cols = '(';
            $qs = '';
            foreach ($cellIt as $cell) {
                $column = $cell->getCalculatedValue();
                $column = $this->trim_all($column);
                if (empty($column)){
                    $column = '-'.$i.'-';
                }
                $sql .= '`' . $column . '` varchar(255),';
                $cols .="`$column`,";
                $qs .= '?,';
                $i++;
            }

            $sql .= 'PRIMARY KEY (`id`))';
            try{
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                $qr = $this->db->exec($sql);
            }catch(PDOException $e){
                return false;
            }
            $log = new PHPLogger(FILETMPDIR.'/log');
            $log->i('Create table', 'Created new table:'.$tablename );
            $cols =rtrim($cols,',');
            $qs =rtrim($qs,',');
            $cols.=')';
            $Row =$Row1;
            $stripped = array();
            while ($Row->getRowIndex() < $HighestRow){
                $rowIt->next();
                $Row =  $rowIt->current();
                $cellIt = $Row->getCellIterator();
                $cellIt->setIterateOnlyExistingCells(false);
                $stripped = array();
                foreach ($cellIt as $cell) {
                    $column = $cell->getCalculatedValue();
                    $column = $this->trim_all($column);
                    $stripped[] = $column;
                }
                $sql = "INSERT INTO `$tablename` $cols VALUES ($qs)";
                $qr = $this->db->prepare($sql);
                $qr->execute($stripped);
            }
            $i++;
       }
       
    }
    
    public function importJSONFile($filename){
        $json = json_decode(file_get_contents($filename));

//code on server doesnt have this..
//        if (json_last_error()){
//            return false;
//        }

         if (empty($json[0])){
              return false;
         }

        //strip out any bad character put in by hackers..
        $table_name= preg_replace('/[^a-zA-Z0-9 ]/','',substr(basename($filename),0,-5));
        
        $columns = array_keys(get_object_vars($json[0]));
        if (empty($columns)){
                return;
            }
           $sql = 'CREATE TABLE `'.$table_name.'` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,';
           $cols = '(';
           $qs = '';
           $i=0;
           foreach($columns as $column){
               
                if ($column == 'id'){
                    $column = $table_name . '_id';
                }
                if (empty($column)){
                    $column='-'.$i.'-';
                }
                $column = $this->trim_all($column);
                $sql .='`'.$column.'` varchar(255),'; 
                $cols .="`$column`,";
                $qs .= '?,';
                $i++;
            }
            
            $cols =rtrim($cols,',');
            $qs =rtrim($qs,',');
            $cols.=')';
            $sql .='PRIMARY KEY (`id`))';
            
            try{
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                $qr = $this->db->exec($sql);
            }catch(PDOException $e){
                return false;
            }
            
            $log = new PHPLogger(FILETMPDIR.'/log');
            $log->i('Create table', 'Created new table:'.$table_name );
            $cnames = $columns;
            while ($data = array_shift($json)) {
                $data = get_object_vars($data);
                //strip the columns that are empty
                $stripped = array();
                foreach($columns as $column){
                    $coldata = array_shift($data);
                    $stripped[] = $coldata;
                }
                
                $sql = "INSERT INTO `$table_name` $cols VALUES ($qs)";
                $qr = $this->db->prepare($sql);
                $qr->execute($stripped);
            }
            $log->i('Add table data', 'Added data to:'.$table_name );
   
       
    }
    
    public function importCSVFile($filename){
        $data = file_get_contents($filename);
        $table_name= preg_replace('/[^a-zA-Z0-9 ]/','',substr(basename($filename),0,-4));
        $log = new PHPLogger(FILETMPDIR.'/log');
        if (($getfile = fopen($filename, "r")) !== FALSE) { 
            $columns = fgetcsv($getfile, 1000, ",");
            if (empty($columns)){
                return;
            }
            $sql = 'CREATE TABLE `'.$table_name.'` (
                     `id` int(11) NOT NULL AUTO_INCREMENT,';
            $cols = '(';
            $qs = '';
            $i=0;
           foreach($columns as $column){
                if ($column == 'id'){
                    $column = $table_name . '_id';
                }
                $column = $this->trim_all($column);
                if ($column==''){
                    $column='-'.$i.'-';
                }
                $sql .='`'.$column.'` varchar(255),'; 
                $cols .="`$column`,";
                $qs .= '?,';
                $i++;
            }
            $cols =rtrim($cols,',');
            $qs =rtrim($qs,',');
            $cols.=')';
            $sql .='PRIMARY KEY (`id`))';
            try{
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                $qr = $this->db->exec($sql);
            }catch(PDOException $e){
                return false;
            }
            
            $log->i('Create table', 'Created new table:'.$table_name );
            while (($data = fgetcsv($getfile, 1000, ",")) !== FALSE) {
                //strip the columns that are empty
                $stripped = array();
                foreach($data as $coldata){
                    $coldata = array_shift($data);
                    $stripped[] = $coldata;
                }
                
                $sql = "INSERT INTO `$table_name` $cols VALUES ($qs)";
                $qr = $this->db->prepare($sql);
                $qr->execute($stripped);
            }
            $log->i('Add table data', 'Added data to:'.$table_name );
   
        }
    }
   
    
    //thanks http://pageconfig.com/post/remove-undesired-characters-with-trim_all-php
    function trim_all( $str , $what = NULL , $with = ' ' ){
        if( $what === NULL ){
            //  Character      Decimal      Use
            //  "\0"            0           Null Character
            //  "\t"            9           Tab
            //  "\n"           10           New line
            //  "\x0B"         11           Vertical Tab
            //  "\r"           13           New Line in Mac
            //  " "            32           Space

            $what   = "\\x00-\\x20";    //all white-spaces and control chars
        }

        return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
    }
    
    
    public function getData($orderby=''){
        $sql = 'SELECT * FROM `'.$this->table.'`'.$orderby;
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public function queryData( $q, $column, $orderby=''){

        if ($column == 'id'){
           $sql = "SELECT * FROM `".$this->table."` WHERE $column = ".(int)$q .$orderby;
        }else{
           $sql = "SELECT * FROM `".$this->table."` WHERE INSTR(`$column`, '{$q}')".$orderby;
        }
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();

   }
  
    public function getPages($data){
        $number_items = count($data);
        $items = $this->items;
        $pages = (int) ($number_items/$items);
        if ($number_items % $items)
          $pages++;
        return $pages;
  }
  
   function pageData($pageNumber, $data){
  
        $items = $this->items;
        $start = ($pageNumber -1) * $items;
        $output = array_slice( $data, $start,$items);
        return $output;
  }  


  // This code was stolen outright from:
  // http://www.techumber.com/2012/08/simple-pagination-with-php-mysql.html
  // Fiddles with it a bit to put everything in lis
  function paginate($reload, $page, $tpages) {
    $adjacents = 2;
    $prevlabel = "&lsaquo;";
    $nextlabel = "&rsaquo;";
    $out = "";
    // previous
    if ($page == 1) {
        $out.= "<li class=\"active\"><a href=''>".$prevlabel."</a></li>\n";
    } elseif ($page == 2) {
        $out.="<li><a href=\"".$reload."\">".$prevlabel."</a>\n</li>";
    } else {
        $out.="<li><a href=\"".$reload."&amp;page=".($page - 1)."\">".$prevlabel."</a>\n</li>";
    }
    if ($page> 3) {
        $out.= "<li><a href=\"" . $reload."&amp;page=1\">1</a></li>\n";
    }

    $pmin=($page>$adjacents)?($page - $adjacents):1;
    $pmax=($page<($tpages - $adjacents))?($page + $adjacents):$tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out.= "<li class=\"active\"><a href=''>".$i."</a></li>\n";
        } elseif ($i == 1) {
            $out.= "<li><a href=\"".$reload."\">".$i."</a>\n</li>";
        } else {
            $out.= "<li><a href=\"".$reload. "&amp;page=".$i."\">".$i. "</a>\n</li>";
        }
    }
    
    if ($page<($tpages - $adjacents)) {
        $out.= "<li><a href=\"" . $reload."&amp;page=".$tpages."\">" .$tpages."</a></li>\n";
    }
    // next
    if ($page < $tpages) {
        $out.= "<li><a href=\"".$reload."&amp;page=".($page + 1)."\">".$nextlabel."</a>\n</li>";
    } else {
        $out.= "<li class=\"active\"><a href=''>".$nextlabel."</a></li>\n";
    }
    $out.= "";
    return $out;
  }

   function warning_handler($errno='0', $errstr='warning') { 
     throw new Exception($errstr);
    }  
    
}
