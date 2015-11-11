<?php

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
                        $userExist = false;
                        $tempArray[0] = $obj->firstname;
                        $tempArray[1] = $obj->lastname;
                        $tempArray[2] = $obj->email;
                        foreach($this->users as $value){
                                if($value[2] === $tempArray[2]){
                                        $userExist = true;
                                }
                        }
                        if($userExist === false){
                                $file = fopen('users.csv',"a");
                                fputcsv($file,$tempArray);
                                fclose($file);
                        }
                        else{
                                echo 'User exist already...';
                        }

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
                //      $file = fopen('users.csv',"a");
                //      foreach ($this->users as $line){
                //              fputcsv($file,explode(',',$line));
                //      }
                //      fclose($file);
                //}
        }
                           

?>
