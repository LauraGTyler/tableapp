<section id="content" role="main">
   <h2>Welcome to the home page.</h2> 
   <p>This is an all purpose table application to allow you to import data from a number of sources and produce a pretty table.</p>
   <p>The first table is the songs table, thanks to php-mvc. The application itself is open source for you to download and play with. I've added a logger thanks to <a href="https://bitbucket.org/huntlyc/simple-php-logger/downloads" alt="logger" >bit bucket</a></p>
   <p></p>
   <p>I will accept suggestions for change to the application (<a href="mailto:laura@jofa.co.uk">laura@jofa.co.uk</a>). Also through github, when I have worked out how.</p>
   <p>The table will allow you to:</p>
   <ul>
       <li><a href="<?=URL?>home/importtable" title="Import your table">Import your table</a> in the following formats:
           <ul>
               <li><a href="<?=URL?>home/importtable" title="Import your table"><img src="<?=URL?>/public/img/logo_mysql.ico" title="MySQL Table Dump" alt="MySQL Table Dump" /></a>&nbsp;&nbsp;MySQL Table Dump</li>
               <li><a href="<?=URL?>home/importtable" title="Import your table"><img src="<?=URL?>/public/img/csv.png" title="CSV File" alt="MySQL Table Dump" /></a>&nbsp;&nbsp;CSV File</li>
               <li><a href="<?=URL?>home/importtable" title="Import your table"><img src="<?=URL?>/public/img/json.ico" title="JSON array" alt="MySQL Table Dump" /></a>&nbsp;&nbsp;JSON array</li>
<?if(file_exists('application/libs/PHPExcel') && file_exists('application/libs/PHPExcel.php')){?>
               <li><a href="<?=URL?>home/importtable" title="Import your table"><img src="<?=URL?>/public/img/excel.ico" title="excel file" alt="Excel file" /></a>&nbsp;&nbsp;Excel file</li>
<?}?>
           </ul>
       </li>
       <li>Select which columns you can view, thanks - <a href="http://www.ericmmartin.com/projects/simplemodal/" title="simple modal" target="blank">Eric Martin</a> for the modal</li>
       <li>Give you pagination, thanks - <a href="http://www.techumber.com/2012/08/simple-pagination-with-php-mysql.html" title="pagination" target="blank">Techumber</a></li>
       <li>Thanks <a href="https://github.com/PHPOffice/PHPExcel" alt="PHPExcel">PHP Excel</a> for the excel file reader.</li>
       <li>Allow you to search your table by view</li>
       <li>Allow you to embed your table on other peoples websites.</li>
   </ul>
   <p>Instructions for install - simply download the application and put it in your web root. To get the Excel file upload to work, you will need to download <a href="https://github.com/PHPOffice/PHPExcel" alt="PHP Excel">PHP Excel</a> and put the 'Classes' into the 'libs' folder.</p>
</section>
