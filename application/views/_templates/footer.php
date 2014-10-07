<?php
    $this_uri = SERVER.$_SERVER['REQUEST_URI'];
    if (!empty($_SERVER['REDIRECT_URL'])){
       $this_uri = SERVER.$_SERVER['REDIRECT_URL'];
    }
?>
<footer>
    <!-- Footer content -->
    <?if($this_uri == URL.'table'){?>
    <a href="" alt="Embed code of this table to your website"><img class="icon" src="<?=URL?>public/img/embed_icon.png" title="Add the embed code of this table to your website" /></a>
    <?}?>
    <nav>
    <ul>
                <!-- same like "home" or "home/index" -->
            <li<?php if($this_uri === URL){echo ' class="active"';}?>><a href="." title="Home">Home</a></li>
            <li<?php if($this_uri === URL.'home/importtable'){echo ' class="active"';}?>><a href="<?php echo URL; ?>home/importtable" title="Import Table">Import Table</a></li>
            <li<?php if($this_uri === URL.'table'){echo ' class="active"';}?>><a href="<?php echo URL; ?>table" title="Table">Table</a></li>
            <li<?php if($this_uri === URL.'home/cookiepolicy'){echo ' class="active"';}?>><a href="<?php echo URL; ?>home/cookiepolicy" title="Cookie Policy">Cookie Policy</a></li>
    </ul>
    </nav>  
    <?if($this_uri == URL.'table'){?>
    <form class="displaynone"><textarea><script language="JavaScript" src="<?=URL?>table/as_javascript?table=<?=$table?>" type="text/javascript"></script></textarea></form>
    <?}?>
</footer>


    <!-- pull in the javascript at the bottom of the page as per latest html5 thing.. -->
    
    <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.simplemodal.min.js"></script>
    <!-- our JavaScript -->
    <script src="<?php echo URL; ?>public/js/application.js"></script>
 
</body>
</html>