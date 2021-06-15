<?php
session_start();
$user_name = $_SESSION['user_name'];
if (isset($_SESSION['id'])) { //ログインしているとき
  $msg = 'こんにちは' . htmlspecialchars($user_name, \ENT_QUOTES, 'UTF-8') . 'さん';
} else { //ログインしていない時
  header("Location: ./login_form.php");
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>blog一覧</title>
</head>

<div class="w-full">
  <nav class="bg-white shadow-lg">
    <div class="md:flex items-center justify-between py-2 px-8 md:px-12">
      <div class="flex justify-between items-center">
        <div class="text-2xl font-bold text-gray-800 md:text-3xl">
          <h1><?php echo $msg; ?></h1>
        </div>
      </div>
      <div class="flex flex-col md:flex-row hidden md:block -mx-2">
        <a href="./mypage.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">マイページ</a>
        <a href="./logout.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">ログアウト</a>
      </div>
    </div>
  </nav>
</div>

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
  $order_id = @$_GET["order"];
  try {
    if (isset($order_id)) {
      $sql = "SELECT * FROM blog.blogs ORDER BY created_at " . $order_id;
    } else {
      $sql = "SELECT * FROM blog.blogs ORDER BY created_at DESC";
    }
    $stmh = $pdo->prepare($sql);
    $stmh->execute();
  } catch (PDOException $Exception) {
    die('接続エラー：' . $Exception->getMessage());
  }
  ?>

  <div class="blogs__wraper bg-green-300  py-20 px-20">
    <div class="ml-8 mb-12">
      <h2 class="mb-2 px-2 text-6xl font-bold text-green-800">blog一覧</h2>
    </div>
    <div class="ml-8">
      <a href="index.php?order=desc">
        <button class="bg-white text-black mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="submit" style="transition: all 0.15s ease 0s;">新しい順
        </button>
      </a>
      <a href="index.php?order=asc">
        <button class="bg-white text-black mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="submit" style="transition: all 0.15s ease 0s;">古い順
        </button>
      </a>
    </div>
    <div class="flex flex-wrap">
      <?php
      while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
        $limit = 15;
        $content = mb_strimwidth(strip_tags($row['content']), 0, 15, '…', 'UTF-8');
      ?>

        <div class="blogs bg-white w-1/5 m-8">
          <div class="">
            <img src="https://images.unsplash.com/photo-1489396160836-2c99c977e970?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60" class="">
          </div>
          <div class="p-5">
            <h1 class="text-2xl font-bold text-green-800 py-2"><?= htmlspecialchars($row['title']) ?></h1>
            <p class="bg-white text-sm text-black"><?= htmlspecialchars($row['created_at']) ?></p>
            <p class="bg-white text-sm text-black"><?= htmlspecialchars($content) ?></p>
            <a href="./detail.php/?id=<?= htmlspecialchars($row['id']) ?>" class="py-2 px-3 mt-4 px-6 text-white bg-green-500 inline-block rounded">記事詳細へ</a>
          </div>
        </div>

      <?php
      }
      $pdo = null;
      ?>

    </div>
  </div>
</body>

</html>