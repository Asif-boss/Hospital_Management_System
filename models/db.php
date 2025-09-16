<?php
    $host = "127.0.0.1";
    $dbuser = "root";
    $dbpass = "";
    // $dbname = "demo_hospital";
    $dbname = "hospital";

    function getConnection(){
        global $host, $dbname, $dbpass, $dbuser;
        $con = mysqli_connect($host, $dbuser, $dbpass, $dbname);
        return $con;
    }
?>