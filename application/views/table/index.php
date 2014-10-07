<section id="content" role="main"> 
<?php
if (!empty($_REQUEST['page'])){
    $page = $_REQUEST['page'];
}
  //set up the base url for pagination
  $rcopy = $_REQUEST;
  unset($rcopy['page']);
  $end = '?'.http_build_query($rcopy);
  $session_id = session_id();

?>
  
<?php 
   $class = 'inactive';
   $value = 'Search';
   $selected = '';
   
?>
<div class="centerform">
<form action="<?=URL?>table" method ="GET">
<input type="hidden" name="table" value="<?=$table?>" />
<input type="text" name="q" id="q" class="<?php echo $class?>" value="<?php echo $value?>" />
<select name="column">
<?foreach ($colnames as $col){?>
<option value="<?=$col?>"<?php if ($selected == $col){ echo ' selected="selected"';}?>><?=$col?></option>
<?}?>
</select>
<input type="reset" name="Reset" title="Reset" />
<input type="submit" name="Search" value="Search" title="Reset" />
</form>
 <span class="tableColumnsButton" title="Click here to select table columns">Select Table Columns</span>
</div>
<form action="<?=URL?>table" method="get" id="basic-modal-content" class="displaynone">
<fieldset style="border:none">
   <legend>Table columns</legend>
    <input type="hidden" name="table" value="<?=$table?>" />
    <button type="submit" class="btn">Apply</button>
   <?foreach ($colnames as $col){?>
   <div style="text-align:left"><label class="checkbox" for="<?=$col?>">
           <input <?if (in_array($col, $cols)) echo 'checked="checked" ';?>type="checkbox" value="<?=$col?>" name="tableColumns[]" id="<?=$col?>"><?=$col?></label></div>
   <?}?>

   <button type="submit" class="btn">Apply</button> 
</fieldset>
</form>
    



<figure>
<table aria-describedby="tbl01-summary">
  <caption  class="displaynone">
  <h3>Caption</h3>
  </caption>
  <tr>
<?
//copy of request for ordering
$copy_of_request = $_REQUEST;
unset($copy_of_request['PHPSESSID']);
unset($copy_of_request['orderby']);
$copy_of_request_asc = $copy_of_request;
$copy_of_request_desc = $copy_of_request;
foreach ($cols as $col){
    $ascclass = '';
    $descclass = '';
    if(!empty($_REQUEST['orderby']) && 
        $_REQUEST['orderby']==' Order by `'.$col . '` ASC'){
            $ascclass = ' class="active"';
        }
        if(!empty($_REQUEST['orderby']) && 
        $_REQUEST['orderby']==' Order by `'.$col . '` DESC'){
            $descclass= ' class="active"';
        }
    $copy_of_request_asc['orderby'] = ' Order by `'.$col . '` ASC'; 
    $copy_of_request_desc['orderby'] = ' Order by `'.$col . '` DESC';
    
    //Refresh
    
    $asc = '<a href="'.URL .'table?'.http_build_query($copy_of_request).'" title="Order by '.$col.' ASC" >&#x21bb;</a>';
    $desc = '';
    if ($col != 'id'){
       $asc = '<a href="'.URL .'table?'.http_build_query($copy_of_request_asc).'" title="Order by '.$col.' ASC"'.$ascclass.'>&#x21d1;</a>';
       $desc = '<a href="'.URL.'table?'.http_build_query($copy_of_request_desc).'" title="Order by '.$col.' DESC"'.$descclass.'>&#x21d3;</a>';
    }
?>
<th><?=$asc?>&nbsp;&nbsp;<?=$col;?>&nbsp;&nbsp;<?=$desc?></th>
<?
}
  $i=0;
  foreach($page_data as $object){
     //odd or even class
     $i++;
     if ($i % 2){
         $class= 'odd';
     }else{
         $class = 'even';
    }

?>
  <tr class="<?=$class?>">
  <?
  
  foreach ($cols as $col){
    //little work around to get the column name right 
    //-for spreadsheets with whitespace in the name

    $cell = $object->$col;
    $cellbr = wordwrap($cell, 45, "<br />\n",true);

    if (preg_match('/^http:/', $cell) || preg_match('/^https:/', $cell)){
      $cellbr = '<a href="'.$cell.'" target="blank">'.$cellbr.'</a>';
    }
  ?>
  <td><div><?=$cellbr?></td>
  <?}?>
  </tr>
<?}?>
</table>
<figcaption id="tbl01-summary" class="displaynone">
  <p>table summary</p>
</figcaption>
</figure>

<?

?>
<div class="center">
    <ul class="pagination">
<?

$copy_of_request = $_REQUEST;
unset($copy_of_request['PHPSESSID']);
unset($copy_of_request['page']);
echo $model->paginate(URL.'table?'.http_build_query($copy_of_request), $page, $pages);
?>
    </ul>
    </div>
</section>
