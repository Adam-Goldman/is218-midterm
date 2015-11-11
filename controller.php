<?php

	//ini_set('display_errors',1);
	//error_reporting(E_ALL);
	

	include 'user.php';
	include 'page.php';

	function readCSV($csvFile){
          	$file_handle = fopen($csvFile, 'r');
          	while (!feof($file_handle) ) {
                  	$line_of_text[] = fgetcsv($file_handle, 1024);
          	}
          	fclose($file_handle);
          	return $line_of_text;
 	}

   	$obj = new main();

   	class main {
    		public function __construct() {
      		$page_request = 'homepage';
      		if(isset($_REQUEST['page'])) {
        		$page_request = $_REQUEST['page'];
      		}
      		$page = new $page_request;
      		if($_SERVER['REQUEST_METHOD'] == 'GET') {
        		$page->get();
      		} else {
        		$page->post();
      		}	
     		}
	}
?>
