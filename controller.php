<?php

	//ini_set('display_errors',1);
	//error_reporting(E_ALL);

	function readCSV($csvFile){
          	$file_handle = fopen($csvFile, 'r');
          	while (!feof($file_handle) ) {
                  	$line_of_text[] = fgetcsv($file_handle, 1024);
          	}
          	fclose($file_handle);
          	return $line_of_text;
 	}

	class user{
		public $firstname;
		public $lastname;
		public $email;

		public function __construct($first, $last, $eml){
			$this->firstname=$first;
			$this->lastname=$last;
			$this->email=$eml;
		}
	}

	class users{
		public $users = [];

		public function __construct(){
			$this->users = readCSV('users.csv');
		}

		public function addUser($first, $last, $eml){
			$obj = new user($first, $last, $eml);
			$tempArray[0] = $obj->firstname;
			$tempArray[1] = $obj->lastname;
			$tempArray[2] = $obj->email;
			$file = fopen('users.csv',"a");
             		fputcsv($file,$tempArray);
                      	fclose($file);

		}

		public function userTable(){
			foreach($this->users as $value){
				if($value[0] != '' && $value[1] != '' && $value[2] != ''){
					echo '<tr>
                                	        <td>'.$value[0].'</td>
                                        	<td>'.$value[1].'</td>
                                        	<td>'.$value[2].'</td>
						<td><form method=GET>
                                        	<input type="hidden" name="email" value="'.$value[2].'">
						<input type="hidden" name="first" value="'.$value[0].'">
						<input type="hidden" name="last" value="'.$value[1].'">
                                  	<button type="submit" name="page" value="edit">Edit User</button>
                                  	</form></td>
                                        	</tr>
				  ';
				}
			}
		}

		public function updateUser($eml, $first, $last){
			$tempArray = [];
			foreach($this->users as $value){
				array_push($tempArray, $value);
			}
			$file = fopen('users.csv',"w");
			foreach($tempArray as $line){
				if($eml === $line[2]){
					$line[0] = $first;
					$line[1] = $last;
				}
				fputcsv($file,$line);
			}
			fclose($file);
		}

		public function deleteUser($eml){
			$tempArray = [];
			foreach($this->users as $value){
				if($eml != $value[2]){
					array_push($tempArray, $value);
				}
			}
			$file = fopen('users.csv',"w");
			foreach ($tempArray as $line){
				fputcsv($file,$line);
			}
			fclose($file);
		}

		//public function __destruct(){
		//	$file = fopen('users.csv',"a");
		//	foreach ($this->users as $line){
  		//		fputcsv($file,explode(',',$line));
  		//	}
		//	fclose($file);
		//}
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

   	class page {
		public $pageBody;
     		public function get() {}
     		public function post() {}
		public function put() {}
		public function delete() {}
		public function __destruct(){
			echo $this->pageBody;
		}
   	}

   	class homepage extends page {
     		public function get() {
      			echo '<form method="get">
 			     	 First name:<br>
  				 <input required type="text" name="firstname">
  				 <br>
  				 Last name:<br>
  				 <input required type="text" name="lastname">
  				 <br>
  				 Email address:<br>
  				 <input required type="test" name="email">
  				 <br><br>
				 <input hidden type"add" value="true">
  				 <button type="submit" name="page" value="table">Add User</button>

				 </form>
 			';
     			}
	}

   	class table extends page {
     		public function get() {
			$newUser = new users();
			$saveUser = new users();
			$deleteUser = new users();
			$userTables = new users();
			if(isset($_GET["firstname"]) &&	$_GET["firstname"] != '' && isset($_GET["lastname"]) && $_GET["lastname"] != '' && isset($_GET["email"]) && $_GET["email"] != '') {
				$newUser->addUser($_GET["firstname"], $_GET["lastname"], $_GET["email"]);
			}
			if($_GET["save"] === "true"){
				$saveUser->updateUser($_GET["email"], $_GET["firstname"], $_GET["lastname"]);
			}
			elseif($_GET["delete"] === "true"){
				$deleteUser->deleteUser($_GET["email"]);
			}
			echo' <head>
			      <style>
				table, th, td {
    					border: 1px solid black;
    					border-collapse: collapse;
				}
				th, td {
    					padding: 15px;
				}
			      </style>
			      </head>
		              <body>
				<table style="width:100%">
  				<tr>
    					<td>Firstname</td>
    					<td>Lastname</td>
    					<td>Email</td>
  					</tr>';
				$userTables->userTable();
			echo'	</table>
				</body>
			';
     		}
   	}

		class edit extends page {
                public function get() {
                        echo '<form method="get">
                                 First name:<br>
                                 <input type="text" name="firstname" value='.$_GET["first"].'>
                                 <br>
                                 Last name:<br>
                                 <input type="text" name="lastname" value='.$_GET["last"].'>
                                 <br><br>
				 <input hidden name="save" value="true">
				 <input hidden name="email" value='.$_GET["email"].'>
                                 <button type="submit" name="page" value="table">Save</button>
				 </form>
				 <form method="get">
				 <input hidden name="delete" value="true">
				 <input hidden name="email" value='.$_GET["email"].'>
				 <button type="submit" name="page" value="table">Delete</button>
				 </form>
                        ';
                }
        }


?>
