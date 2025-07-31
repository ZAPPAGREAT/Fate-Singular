<?php
// データベース接続
$mysqli = new mysqli('localhost', 'xs138301_root', '283zappa', 'xs138301_fate');
if ($mysqli->connect_error) {
    die("接続失敗: " . $mysqli->connect_error);
}

// URLからidを取得（例：stories.php?id=1）
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// クエリを実行してデータ取得
$sql = "SELECT content FROM novels WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($contentHtml);
$stmt->fetch();
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>【非公式二次創作】Fate/Singular - お話</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">    <link rel="stylesheet" href="https://unpkg.com/ress@4.0.0/dist/ress.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="css/responsive.css">
    <script>
      window.addEventListener('load', function() {
        const logo = document.querySelector('.top-logo');
        setTimeout(() => {
          logo.classList.add('fade-in');
        }, 100);
      });
    </script>
  </head>
  <body>
    <header>
      <div class="container">
        <div class="header-left">
            <img src="/images/Fate-Singular-logo-white.png">
        </div>
        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="menu-icon"><span class="fa fa-bars"></span></label>
        <nav class="header-right">
          <a href=index.html>トップ</a>
          <a href=contents.php>目次</a>
          <a href=characters.php>登場人物</a>
          <a href=about.pgp>この作品についてご注意</a>
        </nav>
      </div>
    </header>
    <div class="story-box">
      <div class="container">
        <?= $contentHtml ?> <!-- HTMLとして描画 -->
      </div>
    </div>
    <footer>
      <div class="footer-visual">
        <h2>【非公式二次創作】Fate/Singular</h2>
        <p>© 2025 ZAPPA All Rights Reserved.</p>
        <p>本作品は「Fateシリーズ」（© TYPE-MOON）の二次創作です。公式とは関係ありません</p>
      </div>
    </footer>
  </body>
</html>