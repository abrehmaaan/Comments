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
$names = array();
$emails = array();
$comments = array();
$ids = array();
require_once('config.inc.php');
$conn_str = DB_SYS.':host='.DB_HOST.';dbname='.DB_NAME;
try {
    $pdo = new PDO($conn_str,DB_USER,DB_PASS);
    $sql = "SELECT * FROM postingcomments ORDER BY Name DESC";
    $stat = $pdo->prepare($sql);
    $stat->execute();
    while($result = $stat->fetch()){
        $ids[] = $result['Id'];
        $names[] = $result['Name'];
        $emails[] = $result['Email'];
        $comments[] = $result['Comment'];
    }
}
catch (PDOException $e) {
    die('Server error');
}
?>
<h1>Comments</h1>
<table>
    <tr>
        <th></th>
        <th>Name</th>
        <th>Comments</th>
    </tr>
    <?php
        $length = count($names);
        for ($i = 0; $i < $length; $i++) {
            $j = $i+1;
            echo "<tr><td>{$j}</td><td><a href='mailto:{$emails[$i]}'>{$names[$i]}</a></td><td>{$comments[$i]}</td></tr>";
        }
    ?>
</table>
<form action="delete.php" method="post">
    <table>
        <tr>
            <td><label for="num">Delete Comment Number</label></td>
            <td><input type="number" name="num" id="num"></td>
            <?php
                foreach ($ids as $array)
                {
                ?>
                    <input type="hidden" name="ids[]" value="<?php echo $array; ?>"/>
                <?php    
                }
            ?>
            <td><button type="submit">Delete</button></td>
        </tr>
    </table>
</form>
<p><a href="index.html">Add new comment</a></p>
<p><a href="showCommentsASC.php">Sort comments by ascending order</a></p>
<p><a href="showCommentsDSC.php">Sort comments by descending order</a></p>
</body>
</html>