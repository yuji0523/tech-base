<!DOCTYPE html>

<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_5-01</title>
    </head>
    <body> 
        <?php
        $name=$_POST["name"];
        $com=$_POST["comment"];
        $editno=$_POST["editno"];
        $time=date("Y年m月d日 H時i分s秒");
        $editx=$_POST["editx"];
        $pass=$_POST["pass"];
        $delete=$_POST["delete"];
        $edpass=$_POST["edpass"];
        $delpass=$_POST["delpass"];
        
        
//データベース
        $dsn='データベース名';
	    $user = 'ユーザー名';
	    $password = 'パスワード';
	    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	    
	    $sql = "CREATE TABLE IF NOT EXISTS tbtest"
	    ." ("
	    . "id INT AUTO_INCREMENT PRIMARY KEY,"
	    . "name char(32),"
	    . "comment TEXT"
	    .");";
	    $stmt = $pdo->query($sql);  
	    
	    $sql ='SHOW TABLES';
	    $result = $pdo -> query($sql);
	    foreach ($result as $row)
	    {
		echo $row[0];
		echo '<br>';
	    }
	    echo "<hr>";
//データ入力	    
	    $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
	    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	    $name = $_POST["name"];
	    $comment = $_POST["comment"]; //好きな名前、好きな言葉は自分で決めること
	    $sql -> execute();
	    
//データ表示
        $sql = 'SELECT * FROM tbtest';
	    $stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
	    foreach ($results as $row)
	    {
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'<br>';
	    
	    }
	    
//削除機能
    if(!empty($_POST["delete"]))
    {
     $id = 2;
	$sql = 'delete from tbtest where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
    }
        
        ?>
        <form action=""method="post">
            <input type="text" name="name" 
                value="<?php echo $edname; ?>" 
                placeholder="名前">
            <input type="text" name="comment" 
                value="<?php echo $edcom; ?>" placeholder="コメント">
            <input type="text" name="pass" placeholder="パス設定">
            <input type="text" name="editx" 
                value="<?php echo $ednum;?>">
            <input type="submit" name="submit"><br>
            
            <input type="text" name="delete" placeholder="消去対象番号">
            <input type="text" name="delpass" placeholder="削除用パスワード">
            <input type="submit" name="del" value="削除">
            
            <input type="text" name="editno" placeholder="編集対象番号">
            <input type="text" name="edpass" placeholder="編集用パスワード">
            <input type="submit" name="edit" value="編集">
        </form>        
    </body>
</html>