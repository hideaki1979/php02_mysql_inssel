<?php
    // 書籍情報登録用PHP
    require_once("db.php");
    require_once("booksql.php");

    $pdo = getPdoConnection();  // DB接続
    $message = bookInsert($pdo, $_POST);    //書籍情報登録
    // クエリパラメータにメッセージを設定し、upload.phpへリダイレクト
    header("Location: regist.php?message=".urlencode($message));
    exit();
?>