<?php

define("server", "localhost");  
define("user", "outsideadmin"); 
define("password", "bLb$?Se%@6@U*5CK");
define("database", "login_system"); 
define("TBL_USERS","accounts"); 
define("TBL_MESSAGES", "inbox"); 


class Message{
    
    private function _validate_message($message){
		$return = trim($message); 
		$return = filter_var($message, FILTER_SANITIZE_STRING); 
		$return = filter_var($message, FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
		return $return;
	} 
	
	public function send_message($to, $subject, $message){
        
        $conn = mysqli_connect(server, user, password, database);
		$from = $_SESSION['user_id'];

		$message = $this->_validate_message($message); 


		$query = "INSERT INTO " . TBL_MESSAGES . " (user_to, user_from, subject, message) VALUES(" . $to . ", " . $from . ", '" . $subject . "', '" . $message . "')";

		if($this->_validate_message($message)){
			mysqli_query($conn, $query);
			return TRUE;
		}else{
			return FALSE;
		}
	} 
	

	

	public function get_message($message_id){
        $conn = mysqli_connect(server, user, password, database);
		$role = "sender_delete";
		$id = $_SESSION['user_id'];
		$query = mysqli_query($conn, "SELECT user_to FROM " . TBL_MESSAGES . " WHERE id = '" . $message_id . "'");
		while($data = mysqli_fetch_object($query)){
			if($data->user_to != $id){
				$role = "receiver_delete";
			}			
		}
		$query = mysqli_query($conn, "SELECT * FROM " . TBL_MESSAGES . " WHERE id = '" . $message_id . "' AND (user_to = '" . $id . "' OR user_from = '" . $id . "') OR respond = '" . $message_id . "' AND " . $role . " != 'n'");
		return $query;
	} 

	public function delete_message($message_id){
        $conn = mysqli_connect(server, user, password, database);
		$role = "sender_delete";
		$id = $_SESSION['user_id'];
		$query = mysqli_query($conn, "SELECT user_to FROM " . TBL_MESSAGES . " WHERE id = '" . $message_id . "'");
		while($data = mysqli_fetch_object($query)){
			if($data->user_to != $id){
				$role = "receiver_delete";
			}			
		}

		$query1 = mysqli_query($conn, "UPDATE " . TBL_MESSAGES . " SET " . $role . " = 'y' WHERE id = '" . $message_id . "'");
	} 


	
	

} 

?>