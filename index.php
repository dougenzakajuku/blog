<!-- 一覧表示 -->
<?php
session_start();
$user_name = $_SESSION['user_name'];
if (isset($_SESSION['id'])) { //ログインしているとき
  $msg = 'こんにちは' . htmlspecialchars($user_name, \ENT_QUOTES, 'UTF-8') . 'さん';
  $link = '<a href="logout.php">ログアウト</a>';
} else { //ログインしていない時
  $msg = 'ログインしていません';
  $link = '<a href="login_form.php">ログイン</a>';
}
?>
<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>blog一覧</title>
</head>

<body>
  <?php
  $dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
  $db_account_name = "blog";
  $db_account_password = "blog";
  try {
    $pdo = new PDO($dsn, $db_account_name, $db_account_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  } catch (PDOException $Exception) {
    die('接続エラー：' . $Exception->getMessage());
  }
  try {
    $sql = "SELECT * FROM blog.blogs ORDER BY created_at DESC";
    $stmh = $pdo->prepare($sql);
    $stmh->execute();
  } catch (PDOException $Exception) {
    die('接続エラー：' . $Exception->getMessage());
  }
  ?>
  <h1>blog一覧</h1>

  <div class="blogs__wraper bg-green-300  py-20 px-20">
    <div class="flex flex-wrap">

      <?php
      while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
        if ($_SESSION['id'] == $row['user_id']) {
      ?>

          <div class="blogs bg-white w-1/5 m-8">
            <div class="">
              <img src="https://images.unsplash.com/photo-1489396160836-2c99c977e970?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60" class="">
            </div>
            <div class="p-5">
              <h1 class="text-2xl font-bold text-green-800 py-2"><?= htmlspecialchars($row['title']) ?></h1>
              <p class="bg-white text-sm text-black"><?= htmlspecialchars($row['content']) ?></p>
              <a href="/detail.php/?a=<?= htmlspecialchars($row['id']) ?>" class="py-2 px-3 mt-4 px-6 text-white bg-green-500 inline-block rounded">記事詳細へ</a>
            </div>
          </div>

      <?php
        }
      }
      $pdo = null;
      ?>

    </div>
  </div>

  <div><a href="/create.php">新規作成</a></div>
</body>

</html>