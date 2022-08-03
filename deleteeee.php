<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Contacts</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body>
<?php

if(isset($_POST)){
    $num = $_POST['num'];
    if($num == ""){
        echo "<p>You must enter value in each field. Click your browser's back button to go back to form.</p>";
    }
    else{
        require_once('config.inc.php');
        $conn_str = DB_SYS.':host='.DB_HOST.';dbname='.DB_NAME;
        try {
            $pdo = new PDO($conn_str,DB_USER,DB_PASS);
            $sql = "DELETE FROM postingcomments WHERE Id=:id";
            $stat = $pdo->prepare($sql);
            $stat->bindValue(":id",$num);
            $stat->execute();
            echo "<p>Comment Deleted.</p><p><a href='index.html'>Someone else wants to comment?</a></p>";
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
?>
</body>
</html>