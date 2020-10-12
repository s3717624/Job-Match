<?php
session_start();
require './db_inc.php';
require './account_class.php';

$conn = mysqli_connect("localhost", "outsideadmin", "bLb$?Se%@6@U*5CK", "login_system");
 
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$jobname = mysqli_real_escape_string($conn, $_REQUEST['jobname']);
$jobshortdesc = mysqli_real_escape_string($conn, $_REQUEST['jobshortdesc']);
$jobdesc = mysqli_real_escape_string($conn, $_REQUEST['jobdesc']);
$jobskills = mysqli_real_escape_string($conn, $_REQUEST['jobskills']);
$jobeducation = mysqli_real_escape_string($conn, $_REQUEST['jobeducation']);
$jobapply = mysqli_real_escape_string($conn, $_REQUEST['jobapply']);
$joblocation = mysqli_real_escape_string($conn, $_REQUEST['joblocation']);
$jobnature = mysqli_real_escape_string($conn, $_REQUEST['jobnature']);
$jobsalary = mysqli_real_escape_string($conn, $_REQUEST['jobsalary']);
$ID = mysqli_real_escape_string($conn, $_REQUEST['sessionid']);

$jobapply = date("Y-m-d", strtotime($jobapply));

$sql = "INSERT INTO jobs (job_name, job_short_desc, job_desc, job_skills, job_education, job_apply_date, job_location, job_nature, job_salary, employer_id) VALUES ('$jobname', '$jobshortdesc', '$jobdesc', '$jobskills', '$jobeducation', '$jobapply', '$joblocation', '$jobnature', '$jobsalary', '$ID')";
if(mysqli_query($conn, $sql)){
    echo "Records added successfully.";
    $_SESSION['job_created'];
    $servername = "localhost";
        $username = "outsideadmin";
        $password = "bLb$?Se%@6@U*5CK";
        $dbname = "login_system";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn)
        {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql1 = "SELECT * FROM login_system.jobs";
        $res1 = mysqli_query($conn, $sql1);

        if(!$res1)
        {
            echo "error ".mysqli_error($conn);
        }

//        global $pdo;
//
//        $sql1 = "SELECT * FROM login_system.jobs";
//        try {
//            $res = $pdo->prepare($sql1);
//            $res->execute();
//        }
//        catch (PDOException $e)
//        {
//            throw new Exception('Database query error');
//        }
//
//        while($row = $res->fetch(PDO::FETCH_ASSOC))
        while($row = mysqli_fetch_assoc($res1))
        {
            $sound = " ";
            if ($row['job_name']!=null)
            {
                $words = explode(" ", $row['job_name']);
                foreach($words as $word)
                {
                    $sound.=metaphone($word)." ";
                }
            }

            if ($row['job_short_desc']!=null)
            {
                $words = explode(" ", $row['job_short_desc']);
                foreach($words as $word)
                {
                    $sound.=metaphone($word)." ";
                }
            }

            if ($row['job_desc']!=null)
            {
                $words = explode(" ", $row['job_desc']);
                foreach($words as $word)
                {
                    $sound.=metaphone($word)." ";
                }
            }

            // Free to add others

            $id = $row['job_id'];
            $sql2 = "UPDATE login_system.jobs SET indexing = '$sound' WHERE job_id = '$id'";

//            $values = array(':sound' => $sound, ':id' => $id);

//            try
//            {
//                $res = $pdo->prepare($sql2);
//                $res->execute($values);
//            }
//            catch (PDOException $e)
//            {
//                throw new Exception('Database update error');
//            }

            $res2 = mysqli_query($conn, $sql2);

            if(!$res2)
            {
                echo "error ".mysqli_error($conn);
            }


        }
    mysqli_close($conn);
    header("Location: ../");
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
?>