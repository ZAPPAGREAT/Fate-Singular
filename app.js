const express = require('express');
const mysql = require('mysql2');
const path = require('path');
const app = express();

// 静的ファイルの提供（ディレクトリリスティングを無効化）
const staticOptions = {
  index: false,
  dotfiles: 'deny'
};


app.use(express.static(path.join(__dirname, 'public'), staticOptions));



// EJSをテンプレートエンジンとして設定
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// テンプレート名のスペースを許可
app.set('view options', {
  filename: function(name) {
    return name.replace(/%20/g, ' ');
  }
});

// データベース接続設定
const db = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '283zappa',
  database: 'Fate_singular',
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
});

// ルーティング設定
// トップページ
app.get('/', (req, res) => {
    res.render(top.php);
});

// 接続テスト
app.get('/test', (req, res) => {
    console.log("/test にアクセスされました");
    res.send('あっ、見つかっちゃった！ 秘密のコマンドの部屋へようこそ！ ま、何もないケドね 笑');
});

// 目次ページ
app.get('/contents', (req, res) => {
    res.render(contents.php);
});
  

// お話ページ
app.get('/stories/:id', (req, res) => {
  const novelId = req.params.id;

  db.query('SELECT content FROM novels WHERE id = ?', [novelId], (err, results) => {
    if (err) {
    console.error('クエリエラー:', err);
    res.status(500).send('サーバーエラー');
    return;
  }

  if (results.length === 0) {
    res.status(404).send('お話が見つかりませんでした');
    return;
  }

  const contentHtml = results[0].content;
    res.render(stories.php, { contentHtml });
  });
});

// 登場人物ページ
app.get('/characters', (req, res) => {
    res.render(characters.php);
});

// この作品についてご注意ページ
app.get('/about', (req, res) => {
    res.render(about.php);
});



// でDBからnovelsの1件目を取得して表示

  


// サーバーの起動
const PORT = process.env.PORT || 3004;

console.log("1: ファイル読み込み直後");

db.getConnection((err, connection) => {
  if (err) {
    console.error('接続失敗:', err);
  } else {
    console.log('接続成功！');
    connection.release(); // 必ず返す！
  }
  console.log('データベースに接続しました。');

  // 💡データベース接続が成功したら、ここでサーバーを起動する！
  app.listen(PORT, () => {
    console.log(`http://localhost:${PORT} でサーバーが起動しました`);
  });
});


  