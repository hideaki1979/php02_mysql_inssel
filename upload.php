<?php
    if(isset($_GET["message"])){
        $message = nl2br(htmlspecialchars($_GET["message"], ENT_QUOTES, "UTF-8"));
    } else {
        $message = "";
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
            <p><?php echo $message; ?></p>
            <form class="uploadform" action="bookbulkinsert.php" method="post" enctype="multipart/form-data">
                <h2 class="uploadguide">※アップロードしたいファイルを指定</h2>
                <input type="file" name="bookdata" accept="csv" required>
                <input type="submit" class="formbutton uploadbtn" value="アップロード">
            </form>
        </div>
    </div>
    
</body>
</html>