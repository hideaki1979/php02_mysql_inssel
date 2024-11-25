<?php
    // 書籍情報登録画面用PHP

    require_once("db.php");
    require_once("booksql.php");

    $pdo = getPdoConnection();  // DB接続
    $publishers = getPublisherAll($pdo);    // 出版社テーブル全件取得
    $message = "";
    if(isset($_GET["message"])){
        $message = nl2br(htmlspecialchars($_GET["message"], ENT_QUOTES, "UTF-8"));
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include("inc/head.html") ?>
</head>
<body>
    <?php include("inc/header.html") ?>
    <div class="main">
        <div class="container">
            <form class="registform" action="bookinsert.php" method="post">
                <p><?php echo $message; ?></p>
                <h2 class="screenname">書籍情報登録</h2>
                <div class="row regrow">
                    <label class="reglabel">書籍名：</label>
                    <input type="text" name="title" class="title" required>
                </div>
                <div class="row regrow">
                    <label class="reglabel">出版社：</label>
                    <select name="publisher" class="publisher">
                        <option value=""></option>
                        <?php foreach($publishers as $publisher): ?>
                            <option value=<?=$publisher["publish_cd"] ?>>
                                <?=$publisher["publish_name"] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="row regrow">
                    <label class="reglabel">著者名：</label>
                    <input type="text" name="auther" class="auther">
                </div>
                <div class="row regrow">
                    <label class="reglabel">値段：</label>
                    <input type="text" name="price" class="price">
                </div>
                <div class="row regrow">
                    <label class="reglabel">表紙URL：</label>
                    <input type="text" name="imageurl" class="imageurl">
                </div>
                <div class="row regrow">
                    <label class="reglabel">説明：</label>
                    <textarea name="caption" cols="60" rows="5" class="caption"></textarea>
                </div>
                <div class="row regrow">
                    <label class="reglabel">発売日：</label>
                    <input type="date" name="releasedate" class="releasedate">
                </div>
                <input type="submit" class="formbutton registbtn" value="登録">
            </form>
        </div>
    </div>
</body>
</html>