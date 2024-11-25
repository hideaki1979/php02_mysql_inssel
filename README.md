# ①課題名
- MIRRORMAN BOOKSTORE-RETURNS
<br>
## ②課題内容（どんな作品か）
- 書籍情報を一覧検索・一括登録・登録を行えます。  
　（登録元はRAKUTEN BOOKS APIの情報から）
<br>
## ③アプリのデプロイURL  
https://kagami-hide.sakura.ne.jp/php02_mysql_inssel/
<br>
## ④アプリのログイン用IDまたはPassword（ある場合）
- ID: 
- PW: 
<br>
## ⑤工夫した点・こだわった点
- CSVから一括登録を行えるようにしました。  
　検索画面はプルダウン表示の項目をDBから取得して表示するようにし、  
　書籍情報TBLをベースに出版社を別テーブルで管理をして、  
　SQLではINNER JOINを使って名称を取るようにしました。
　DB接続を共通関数化にして画面側からは関数を呼ぶだけにしてます。
<br>
## ⑥難しかった点・次回トライしたいこと（又は機能）
【難しかった点】  
- 一括登録、検索（条件を動的に生成する）ともに調査、デバッグに時間がかかりました。
<br>
【次回トライしたいこと】  
- 登録画面にRAKUTEN BOOKS APIからISBN番号をキーに  
　書籍情報を取得して画面上に表示させたい。
- セッション情報で検索情報を保持（今は検索すると入力が消えてしまう）  
- ラジオボタン、複数チェックボックスでの動的条件（IN句）などを使っての
- 複雑なSQLの理解を深める。
- 一部バグを見つけたので取り除きたい。
<br>
## ⑦フリー項目（感想、シェアしたいこと等なんでも）
- まずは手を動かすために以前の課題（GoogleBooksAPI）のをベースに  
　PHPからMySQLへの登録・検索を行えるようにしました。  
　検索画面もINNER JOINや検索条件を動的にすることなど  
　ある程度やりたかったことは出来たと思います。
　今後はAPIを絡めたり、JSとの連携なども含めて課題を作成出来ればと思います。  
- 
- [参考記事]
  - 1. []()
  - 2. []()