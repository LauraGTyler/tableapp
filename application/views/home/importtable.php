<section class="container">
    <p>Current / available tables are as follows. If you would like to see the pretty table that already exists for that table, just click on the link.</p>
    <ul>
    <? $tables_att = 'Tables_in_'.DB_NAME;
       foreach ($tables as $table){?>
       <li><a href="<?php echo URL; ?>table?table=<?=$table->$tables_att?>" title="Go to the table <?=$table->$tables_att?>"><?=$table->$tables_att?></a>&nbsp;&nbsp;<a href="<?php echo URL; ?>table/removetable?table=<?=$table->$tables_att?>" title="Remove the table <?=$table->$tables_att?>">&#x2717;</a>
        <?}?>
    </ul>
    <p>To add a new table, simply upload from one of the entries below:</p>
    <form class="uploadform" action="<?php echo URL; ?>home/addtablemysql" method="POST" enctype="multipart/form-data">
        <fieldset>
          <legend><img src="<?=URL?>/public/img/logo_mysql.ico" alt="MySQL Table Dump" />&nbsp;&nbsp;MySQL Table Dump</legend>
          <input type="file" name="mysqltable" accept=".sql" />
    <input type="submit" title="Upload" value="Upload" /> <input title="Reset" type="reset" />
        </fieldset>
    </form>
    <br /><br />
    <form class="uploadform" action="<?php echo URL; ?>home/addtablecsv" method="POST"  enctype="multipart/form-data">
        <fieldset>
          <legend><img src="<?=URL?>/public/img/csv.png" alt="CSV File" />&nbsp;&nbsp;CSV File</legend>
          <input type="file" name="csvtable" accept=".csv, text/csv" />
    <input type="submit" title="Upload" value="Upload" /> <input title="Reset" type="reset" />
        </fieldset>
    </form>
    <br /><br />
    <form class="uploadform" action="<?php echo URL; ?>home/addtablejson" method="POST"  enctype="multipart/form-data">
        <fieldset>
        <legend><img src="<?=URL?>/public/img/json.ico" alt="JSON array of objects" />&nbsp;&nbsp;JSON array of objects <a class="jsonexample">Click here for example</a></legend>
          <input type="file" name="jsontable" accept=".json, application/json" />
    <input type="submit" title="Upload" value="Upload" /> <input title="Reset" type="reset" />
        </fieldset>
    </form>
    <?if(file_exists('application/libs/PHPExcel') && file_exists('application/libs/PHPExcel.php')){?>
    <form class="uploadform" action="<?php echo URL; ?>home/addexcel" method="POST"  enctype="multipart/form-data">
        <fieldset>
        <legend><img src="<?=URL?>/public/img/excel.ico" alt="excel spreadsheet" />&nbsp;&nbsp;Excel spreadsheet</legend>
          <input type="file" name="exceltables" accept=".xls, .xlsx" />
    <input type="submit" title="Upload" value="Upload" /> <input title="Reset" type="reset" />
        </fieldset>
    </form>
    <?}?>
    <br /><br />
    <div id="basic-modal-content" class="displaynone">
    [{"id":"2","artist":"Jessy Lanza","track":"Kathy Lee","link":"http:\/\/vimeo.com\/73455369"},{"id":"3","artist":"The Orwells","track":"In my Bed (live)","link":"http:\/\/www.youtube.com\/watch?v=8tA_2qCGnmE"},{"id":"4","artist":"L'Orange & Stik Figa","track":"Smoke Rings","link":"https:\/\/www.youtube.com\/watch?v=Q5teohMyGEY"},{"id":"5","artist":"Labyrinth Ear","track":"Navy Light","link":"http:\/\/www.youtube.com\/watch?v=a9qKkG7NDu0"},{"id":"6","artist":"Bon Hiver","track":"Wolves (Kill them with Colour Remix)","link":"http:\/\/www.youtube.com\/watch?v=5GXAL5mzmyw"},{"id":"7","artist":"Detachments","track":"Circles (Martyn Remix)","link":"http:\/\/www.youtube.com\/watch?v=UzS7Gvn7jJ0"},{"id":"8","artist":"Dillon & Dirk von Loetzow","track":"Tip Tapping (Live at ZDF Aufnahmezustand)","link":"https:\/\/www.youtube.com\/watch?v=hbrOLsgu000"},{"id":"9","artist":"Dillon","track":"Contact Us (Live at ZDF Aufnahmezustand)","link":"https:\/\/www.youtube.com\/watch?v=E6WqTL2Up3Y"},{"id":"10","artist":"Tricky","track":"Hey Love (Promo Edit)","link":"http:\/\/www.youtube.com\/watch?v=OIsCGdW49OQ"},{"id":"11","artist":"Compuphonic","track":"Sunset feat. Marques Toliver (DJ T. Remix)","link":"http:\/\/www.youtube.com\/watch?v=Ue5ZWSK9r00"},{"id":"12","artist":"Ludovico Einaudi","track":"Divenire (live @ Royal Albert Hall London)","link":"http:\/\/www.youtube.com\/watch?v=X1DRDcGlSsE"},{"id":"13","artist":"Maxxi Soundsystem","track":"Regrets we have no use for (Radio1 Rip)","link":"https:\/\/soundcloud.com\/maxxisoundsystem\/maxxi-soundsystem-ft-name-one"},{"id":"14","artist":"Beirut","track":"Nantes (Fredo & Thang Remix)","link":"https:\/\/www.youtube.com\/watch?v=ojV3oMAgGgU"},{"id":"15","artist":"Buku","track":"All Deez","link":"http:\/\/www.youtube.com\/watch?v=R0bN9JRIqig"},{"id":"16","artist":"Pilocka Krach","track":"Wild Pete","link":"http:\/\/www.youtube.com\/watch?v=4wChP_BEJ4s"},{"id":"17","artist":"Mount Kimbie","track":"Here to stray (live at Pitchfork Music Festival Paris)","link":"http:\/\/www.youtube.com\/watch?v=jecgI-zEgIg"},{"id":"18","artist":"Kool Savas","track":"King of Rap (2012) \/ Ein Wunder","link":"http:\/\/www.youtube.com\/watch?v=mTqc6UTG1eY&hd=1"},{"id":"19","artist":"Chaim feat. Meital De Razon","track":"Love Rehab (Original Mix)","link":"http:\/\/www.youtube.com\/watch?v=MJT1BbNFiGs"},{"id":"20","artist":"Emika","track":"Searching","link":"http:\/\/www.youtube.com\/watch?v=oscuSiHfbwo"},{"id":"21","artist":"Emika","track":"Sing to me","link":"http:\/\/www.youtube.com\/watch?v=k9sDBZm8pgk"},{"id":"22","artist":"George Fitzgerald","track":"Thinking of You","link":"http:\/\/www.youtube.com\/watch?v=-14B8l49iKA"},{"id":"23","artist":"Disclosure","track":"You & Me (Flume Edit)","link":"http:\/\/www.youtube.com\/watch?v=OUkkaqSNduU"},{"id":"24","artist":"Crystal Castles","track":"Doe Deer","link":"http:\/\/www.youtube.com\/watch?v=zop0sWrKJnQ"},{"id":"25","artist":"Tok Tok vs. Soffy O.","track":"Missy Queens Gonna Die","link":"http:\/\/www.youtube.com\/watch?v=EN0Tnw5zy6w"},{"id":"26","artist":"Fink","track":"Maker (Synapson Remix)","link":"http:\/\/www.youtube.com\/watch?v=Dyd-cUkj4Nk"},{"id":"27","artist":"Flight Facilities (ft. Christine Hoberg)","track":"Clair De Lune","link":"http:\/\/www.youtube.com\/watch?v=Jcu1AHaTchM"},{"id":"28","artist":"Karmon","track":"Turning Point (Original Mix)","link":"https:\/\/www.youtube.com\/watch?v=-tB-zyLSPEo"},{"id":"29","artist":"Shuttle Life","track":"The Birds","link":"http:\/\/www.youtube.com\/watch?v=-I3m3cWDEtM"},{"id":"30","artist":"Sant\u00e9","track":"Homegirl (Rampa Mix)","link":"http:\/\/www.youtube.com\/watch?v=fnhMNOWxLYw"}]
    </div>
</section>
