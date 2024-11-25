<?php
    require_once("db.php"); //DB接続用PHP読み込み

    //エラー表示
    ini_set("display_errors", 1);

    function getPublisherAll($pdo) {
        $sql = "SELECT * FROM gs_publisher;";   // 全件取得なのでバインド変数無しで実行
        $stmt = $pdo->prepare($sql);
        $status = $stmt->execute();
        $values = "";
        if($status==false){
            //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
            $error = $stmt->errorInfo();
            exit("SQLError:".$error[2]);
        }
        // 全データ取得
        $values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
        return $values;
    }

    function getBookSearchCond($pdo, $conditions) {
        // 検索画面の条件項目を取得する
        $title = $conditions["title"];
        $publisher = $conditions["publisher"];
        $priceFrom = $conditions["priceFrom"];
        $priceTo = $conditions["priceTo"];
        // ベースのSQL文作成
        $sql = "SELECT BOOK.*, PUB.publish_name FROM gs_book AS BOOK INNER JOIN gs_publisher AS PUB 
            ON BOOK.publisher = PUB.publish_cd";
        
        // 検索条件を動的に追加するため、条件文とバインド変数に値を配列に格納する。
        $condArray = [];
        $bindArray = [];
        // 書籍名が入力されていた場合
        if (!empty($title)) {
            $condArray[] = "BOOK.title LIKE :title";
            $bindArray[":title"] = '%'.$title.'%';
        }

        // 出版社が選択されていた場合
        if(!empty($publisher)) {
            $condArray[] = "BOOK.publisher = :publisher";
            $bindArray[":publisher"] = $publisher;
        }

        // 値段（From）が選択されていた場合
        if(!empty($priceFrom)) {
            $condArray[] = "BOOK.price >= :priceFrom";
            $bindArray[":priceFrom"] = $priceFrom;
        }

        // 値段（To）が選択されていた場合
        if(!empty($priceTo)) {
            $condArray[] = "BOOK.price <= :priceTo";
            $bindArray[":priceTo"] = $priceTo;
        }

        // WHERE句のSQL文生成(implodeで配列から文字列に変換)
        if(!empty($condArray)) {
            $sql .= " WHERE ".implode(" AND ", $condArray);
        }

        // 発売日のチェックがONの場合
        if(isset($_POST["orderbyDate"])) {
            $sql .= " ORDER BY BOOK.releasedate DESC";
        }

        // select文発行
        $stmt = $pdo->prepare($sql);
        $status = $stmt->execute($bindArray);
        //４．データ登録処理後
        if($status==false){
            //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
            $error = $stmt->errorInfo();
            exit("SQLError:".$error[2]);
        }
        // 検索結果取得し、画面側に返す
        $books =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
        return $books;
    }

    function bookInsert($pdo, $post) {
        // 登録画面の項目取得
        $title = $post["title"];
        $publisher = $post["publisher"];
        $auther = $post["auther"];
        $price = $post["price"];
        $imageurl = $post["imageurl"];
        $caption = $post["caption"];
        $releasedate = $post["releasedate"];

        // SQL文作成
        $sql = "INSERT INTO gs_book (title, publisher, auther, price, imageurl, caption, releasedate, indate) 
        VALUES(:title, :publisher, :auther, :price, :imageurl, :caption, :releasedate, sysdate());";
        $stmt = $pdo->prepare($sql);
        // 条件値をバインド変数に格納
        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":publisher", $publisher, PDO::PARAM_STR);
        $stmt->bindValue(":auther", $auther, PDO::PARAM_STR);
        $stmt->bindValue(":price", $price, PDO::PARAM_INT);
        $stmt->bindValue(":imageurl", $imageurl, PDO::PARAM_STR);
        $stmt->bindValue(":caption", $caption, PDO::PARAM_STR);
        $stmt->bindValue(":releasedate", $releasedate, PDO::PARAM_STR);
        $status = $stmt->execute(); // insert文実行

        //４．データ登録処理後
        if($status==false){
            //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
            $error = $stmt->errorInfo();
            exit("SQLError:".$error[2]);
        }
        // クエリパラメータにメッセージを設定し、upload.phpへリダイレクト
        header("Location: regist.php?message=".urlencode("登録処理が正常終了しました！"));
        exit();
    }

?>