<?php

/* $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"], 1); */

/* Host name of the MySQL server */
$host = "durvbryvdw2sjcm5.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";

/* MySQL account username */
$user = "pc12yq30edvxp1o9";

/* MySQL account password */
$passwd = "k34nig1nou1zifrp";

/* The schema you want to use */
$schema = "s9e7fl2cr9xmtxws";

/* The PDO object */
$pdo = NULL;

$conn = mysqli_connect($host, $user, $passwd, $schema);

/* Connection string, or "data source name" */
$dsn = 'mysql:host=' . $host . ';dbname=' . $schema;

/* Connection inside a try/catch block */
try
{
    /* PDO object creation */
    $pdo = new PDO($dsn, $user,  $passwd);

    /* Enable exceptions on errors */
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    /* If there is an error an exception is thrown */
    echo 'Database connection failed.';
    die();
}

?>