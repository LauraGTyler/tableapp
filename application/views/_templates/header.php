<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PHP MVC skeleton</title>
    <meta name="description" content="This is an example table application using the php mvc framework">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css -->
    <link href="<?php echo URL; ?>public/css/style.css" rel="stylesheet">
    <link href="<?php echo URL; ?>public/css/basic.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo URL; ?>public/img/petl.ico">
</head>
<body>
  <header>
    <img class="icon" src="<?php echo URL; ?>public/img/petl.png" title="My Logo: Paul et Laura" />
    <h1>Laura's table application</h1>
    <p>This is an example table application using the <a href="http://www.php-mvc.net" target="blank" title="php-mvc">php mvc</a> framework.</p>
    <?php
    $this_uri = SERVER.$_SERVER['REQUEST_URI'];
    if (!empty($_SERVER['REDIRECT_URL'])){
       $this_uri = SERVER.$_SERVER['REDIRECT_URL'];
    }
    ?>
    <nav>
    <ul>
                <!-- same like "home" or "home/index" -->
            <li<?php if($this_uri === URL){echo ' class="active"';}?>><a href="<?php echo URL; ?>" title="Home">Home</a></li>
            <li<?php if($this_uri === URL.'home/importtable'){echo ' class="active"';}?>><a href="<?php echo URL; ?>home/importtable" title="Import Table">Import Table</a></li>
            <li<?php if($this_uri === URL.'table'){echo ' class="active"';}?>><a href="<?php echo URL; ?>table" title="Table">Table</a></li>
            <li<?php if($this_uri === URL.'home/cookiepolicy'){echo ' class="active"';}?>><a href="<?php echo URL; ?>home/cookiepolicy" title="Cookie Policy">Cookie Policy</a></li>
    </ul>
    </nav>
    <?php if(empty($_SESSION['ticked_cookie'])){ ?>
    <div id="cookie-modal" class="displaynone">
        <p>This site uses cookies, please see the <a href="<?=URL?>home/cookiepolicy" title="Cookie policy">Cookie policy</a> for more information.</p>
    </div>
   <?php  }?>
    <!-- Header content -->
  </header>
<!-- header -->

