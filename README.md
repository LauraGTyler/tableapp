This is an all purpose table application to allow you to import data from a number of sources and produce a pretty table.

You can currently see the tableapp working at: http://tableapp.lauratyler.co.uk/php-mvc/

The first table is the songs table, thanks to php-mvc http://www.php-mvc.net/. The application itself is open source for you to download and play with. I've added a logger thanks to bit bucket

I will accept suggestions for change to the application (laura@jofa.co.uk). Also through github, when I have worked out how.

The table will allow you to:

* Import your table in the following formats:
** MySQL Table Dump
** CSV File
** JSON array
** Excel file 

* Select which columns you can view, thanks - Eric Martin http://www.ericmmartin.com/projects/simplemodal/ for the modal
* Give you pagination, thanks - Techumber http://www.techumber.com/2012/08/simple-pagination-with-php-mysql.html
* Thanks PHP Excel https://github.com/PHPOffice/PHPExcel for the excel file reader.
* Allow you to search your table by view
* Allow you to embed your table on other peoples websites.

Instructions for install - simply download the application and put it in your web root. To get the Excel file upload to work, you will need to download PHP Excel and put the 'Classes' into the 'libs' folder.
