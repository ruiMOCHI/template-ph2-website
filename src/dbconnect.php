<?php
$dsn = 'mysql:host=db;dbname=posse;charset=utf8';
$user = 'root';
$password = 'root';

try {
    $dbh = new PDO($dsn, $user, $password);
    // echo 'Connection to DB';

    // //SELECT文を実行
    // $stmt = $dbh->query('select * from questions');
    // while ($row = $stmt->fetch()){
    //     echo 'Question: ' . $row['content'] . '<br>';
    //     echo 'Image: ' . $row['image'] . '<br>';
    //     echo 'Supplement: ' . $row['supplement'] . '<br>';

    //     //関連する選択肢を取得
    //     $choicesStmt = $dbh->prepare('select * from choices where question_id = :question_id');
    //     $choicesStmt->bindParam(':question_id', $row['id'], PDO::PARAM_INT);
    //     $choicesStmt->execute();

    //     echo 'Choices:<br>';
    //     while ($choice = $choicesStmt->fetch()){
    //         echo ' - Name: ' . $choice['name'] . '<br>';
    //         echo ' - Valid: ' . $choice['valid'] . '<br>';
    //     }
    // }  ここでもページ上部にデータの呼び出しをしているためコメントアウトしておく（ページ上部のphpのprint_rを消すだけではデータが非表示にならなかった
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}