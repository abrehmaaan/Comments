<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Comments</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body>
<?php
if(isset($_POST)){
    $name = $_POST['name'];
    $email = $_POST['email']; 
    $comment = $_POST['comment'];
    $found = false;
    if($name == "" || $email == "" || $comment == ""){
        echo "<p>You must enter value in each field. Click your browser's back button to go back to form.</p>";
    }
    else{
        require_once('config.inc.php');
        $conn_str = DB_SYS.':host='.DB_HOST.';dbname='.DB_NAME;
        try {
            $pdo = new PDO($conn_str,DB_USER,DB_PASS);
            $sql = "SELECT * FROM postingcomments WHERE Name=:name AND Email=:email";
            $stat = $pdo->prepare($sql);
            $stat->bindValue(":name",$name);
            $stat->bindValue(":email",$email);
            $stat->execute();
            if($result = $stat->fetch()){
                echo "<h1>Comments Not Added</h1><p>Only one per person! You have already left comments for this posting.</p><p><a href='index.html'>Someone else wants to comment?</a></p>";
                die();
            }
            else{
                $sql = "INSERT INTO postingcomments(Name, Email, Comment) VALUES (:name,:email,:comment)";
                $stat = $pdo->prepare($sql);
                $stat->bindValue(":name",$name);
                $stat->bindValue(":email",$email);
                $stat->bindValue(":comment",$comment);
                $stat->execute();
                echo "<p>Comment added to database.</p><p><a href='index.html'>Someone else wants to comment?</a></p>";
            }
        }
        catch (PDOException $e) {
            die('Server error');
        }
    }
}
?>
</body>
</html>