<?php
session_start();
require './db_inc.php';
require './account_class.php';

$conn = mysqli_connect("localhost", "outsideadmin", "bLb$?Se%@6@U*5CK", "login_system");
 
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$cover = mysqli_real_escape_string($conn, $_REQUEST['cover']);
$jobid = mysqli_real_escape_string($conn, $_REQUEST['jobid']);
$userid = mysqli_real_escape_string($conn, $_REQUEST['sessionid']);

$sql = "INSERT INTO applicants (account_id, job_id, cover_letter) VALUES ('$userid', '$jobid', '$cover')";
if(mysqli_query($conn, $sql)){
    echo "Records added successfully.";
    $_SESSION['job_created'];
    mysqli_close($conn);
    header("Location: ../");
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
?>