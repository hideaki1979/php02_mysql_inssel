<?php
    // 書籍情報一括登録用PHP
    require_once("db.php");

    //エラー表示
    ini_set("display_errors", 1);
    // アップロード対象ファイルが正常にアップロードされたかをチェック。
    // リクエストメソッドがPOSTか。csvファイルか。アップロードエラーがないか。
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["bookdata"]) && 
    $_FILES["bookdata"]["error"] == UPLOAD_ERR_OK) {
        // フォームで指定されたアップロードデータを取得（tmp_fileはアップロード時の一時保管先）
        $file = $_FILES["bookdata"]["tmp_name"];
        // 正規にHTTP POSTでアップロードされたかをチェック
        if(!is_uploaded_file($file)){
            locRedirect("こちらのファイルはHTTP POSTを通じてアップロードされてません！");
        }

        $bookData = fopen($file, "r");
        $header = fgetcsv($bookData); // 先頭行はタイトル行のため登録しない
        // ヘッダー行から発売日の要素数を検索して合致した要素数を設定
        $dateIndex = array_search("releasedate", $header);
        
        $pdo = getPdoConnection();  // DB接続
        
        // SQL文作成
        $sql = "INSERT INTO gs_book (title, publisher, auther, price, imageurl, caption, releasedate, indate) 
        VALUES(:title, :publisher, :auther, :price, :imageurl, :caption, :releasedate, sysdate());";
        $stmt = $pdo->prepare($sql);

        // csvを読み込み、データ行ごとにinsert文を発行する。
        while($line = fgetcsv($bookData)){
            foreach($line as $key => $value) {  // keyは要素数、valueはCSVの値
                // 発売日の場合、DBがDate型のため、型変換する
                if($key == $dateIndex) {
                    $date = DateTime::createFromFormat("Y年m月d日", $value);
                    $line[$key] = $date->format("Y-m-d");
                }
            }
            
            // 条件値をバインド変数に格納
            $stmt->bindValue(":title", $line[0], PDO::PARAM_STR);
            $stmt->bindValue(":publisher", $line[1], PDO::PARAM_STR);
            $stmt->bindValue(":auther", $line[2], PDO::PARAM_STR);
            $stmt->bindValue(":price", $line[3], PDO::PARAM_INT);
            $stmt->bindValue(":imageurl", $line[4], PDO::PARAM_STR);
            $stmt->bindValue(":caption", $line[5], PDO::PARAM_STR);
            $stmt->bindValue(":releasedate", $line[6], PDO::PARAM_STR);
            $status = $stmt->execute();

            //４．データ登録処理後
            if($status==false){
                //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
                $error = $stmt->errorInfo();
                exit("SQLError:".$error[2]);
            }
        }
        fclose($bookData);
        //５．upload.phpへリダイレクト
        locRedirect("一括登録処理が正常終了しました！");
        
    } else {
        //５．upload.phpへリダイレクト
        locRedirect("不正なアップロードファイルがリクエストされています！");
    }

    function locRedirect($message) {
        // クエリパラメータにメッセージを設定し、upload.phpへリダイレクト
        header("Location: upload.php?message=".urlencode($message));
        exit();
    }
?>