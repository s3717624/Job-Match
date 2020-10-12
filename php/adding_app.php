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
$name = mysqli_real_escape_string($conn, $_REQUEST['name']);
$skills = mysqli_real_escape_string($conn, $_REQUEST['appskills']);
$edu = mysqli_real_escape_string($conn, $_REQUEST['appedu']);
$phone = mysqli_real_escape_string($conn, $_REQUEST['phone']);
$email = mysqli_real_escape_string($conn, $_REQUEST['email']);

$sql = "INSERT INTO applicants (account_id, job_id, cover_letter, app_name, app_skills, app_education, app_phone, app_email) VALUES ('$userid', '$jobid', '$cover', '$name', '$skills', '$edu', '$phone', '$email')";
if(mysqli_query($conn, $sql)){
    echo "Records added successfully.";
    $_SESSION['job_created'];
    mysqli_close($conn);
    header("Location: ../");
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
?>