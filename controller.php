<?php 
	ini_set('display_errors',1);
	error_reporting(E_ALL);

	function readCSV($csvFile){
          	$file_handle = fopen($csvFile, 'r');
          	while (!feof($file_handle) ) {
                  	$line_of_text[] = fgetcsv($file_handle, 1024);
          	}
          	fclose($file_handle);
          	return $line_of_text;
 	}

	$csv = 'users.csv';
	$tempUsrs = readCSV($csv);

	class user{
		private $firstname;
		private $lastname;
		private $email;
	}

	class users{
		public $users = array();

		public function __construct(){
			$this->$users = $tempUsrs;
		}

		public static  function addUser($first, $last, $eml){
			$obj = new user($first, $last, $eml);
			$this->$users = $obj;
		}

		public static function userTable(){
			foreach($this->$users as $user){
				echo '<tr>
                                        <td>'.$user[0].'</td>
                                        <td>'.$user[1].'</td>
                                        <td>'.$user[2].'</td>
                                        </tr>
					<form method=GET>
                                  <button type="submit" name="page" value="edit">Edit User</button>
                                  </form>
				  ';
			}
		}

		public static function updateUser($first, $last, $eml){
			$line = array_search($eml, $users);
			$user = $users[$line];
			$user[0] = $first;
			$user[1] = $last;
			$users[$line] = $user;
		}

		public function __destruct(){
			$file = fopen($csv,"w");
			foreach ($users as $line){
  				fputcsv($file,explode(',',$line));
  			}
			fclose($file);
		}
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
			echo $this->$pageBody;
		}
   	}

   	class homepage extends page {
     		public function get() {
      			echo '<form method=POST>
 			     	 First name:<br>
  				 <input type="text" name="firstname">
  				 <br>
  				 Last name:<br>
  				 <input type="text" name="lastname">
  				 <br>
  				 Email address:<br>
  				 <input type="test" name="email">
  				 <br>
			      </form>
			      <form method=GET>
  				 <button type="submit" name="page" value="table">Add User</button>

				 </form>
 			';
			$newUser = users::addUser($_POST("firstname"), $_POST("lastname"), $_POST("email"));
     		}
   	}

   	class table extends page {
     		public function get() {
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
				<table style="width:80%">
  				<tr>
    					<td>Firstname</td>
    					<td>Lastname</td>
    					<td>Email</td>
  					</tr>';
				$userTables = users::userTable();
			echo'	</table>
				</body>
			';
     		}
   	}

	class edit extends page {
                public function get() {
                        echo '<form method=POST>
                                 First name:<br>
                                 <input type="text" name="firstname">
                                 <br>
                                 Last name:<br>
                                 <input type="text" name="lastname">
                                 <br>
                              </form>
                              <form method=GET>
                                 <button type="submit" name="page" value="table">Add User</button>
                                 </form>
                        ';
			//$saveUser = users::
                }
        }


?>
