<?php

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
