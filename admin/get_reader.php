<?php
global $dbh;
session_start();

include('includes/config.php');
if(isset($_POST)) {
    if (isset($_POST['id'])) {
        $variable = $_POST['id'];
        $sql = "SELECT FullName FROM tblreaders WHERE ReaderId = :var";
    } elseif (isset($_POST['isbn'])) {
        $variable = $_POST['isbn'];
        $sql = "SELECT BookName FROM tblbooks WHERE ISBNNumber = :var";
    }

    $query = $dbh->prepare($sql);
    $query->bindParam(':var', $variable);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_OBJ);

    if (!empty($result->FullName)) {
        echo $result->FullName;
    } elseif (!empty($result->BookName)) {
        echo $result->BookName;
    } else {
        echo 0;
    }
}
?>
