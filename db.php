<?php 

$conn = mysqli_connect("127.0.0.1", "root", "", "teamorderdb");

if (!$conn) {
    die("connection failed" . mysqli_connect_error());
}
?>