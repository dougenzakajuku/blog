<?php
session_start();
if ($_SESSION['loginStatus'] == false) {
  header("Location: ./signin.php");
  exit;
}
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

require_once('./pdo.php');

$sql = "SELECT * FROM blogs ORDER BY created_at DESC";
$statement = $pdo->prepare($sql);
$statement->execute();

$blogsInfoList = $statement->fetchAll(PDO::FETCH_ASSOC);
$myBlogsInfoList = [];
foreach ($blogsInfoList as $blogsInfo) {
  if ($_SESSION['id'] == $blogsInfo['user_id']) $myBlogsInfoList[] = $blogsInfo;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>マイページ</title>
</head>

<header>
  <div class="w-full">
    <nav class="bg-white shadow-lg">
      <div class="md:flex items-center justify-between py-2 px-8 md:px-12">
        <div class="flex justify-between items-center">
          <div class="text-2xl font-bold text-gray-800 md:text-3xl">
            <h1><?php echo $_SESSION['user_name']; ?></h1>
          </div>
          <div class="md:hidden">
          </div>
        </div>
        <div class="flex flex-col md:flex-row hidden md:block -mx-2">
          <a href="./index.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">一覧ページ</a>
          <a href="./logout.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">ログアウト</a>
        </div>
      </div>
    </nav>
  </div>
</header>

<body>
  <div class="blogs__wraper bg-green-300  py-20 px-20">
    <?php foreach ($errors as $error) : ?>
      <p><?php echo $error; ?></p>
    <?php endforeach; ?>
    <div class="ml-8 mb-12">
      <h2 class="mb-2 px-2 text-6xl font-bold text-green-800">マイページ</h2>
    </div>
    <div class="mx-8 my-0">
      <a href="./create.php">
        <button class="bg-transparent hover:bg-green-800 text-gray-600 font-semibold hover:text-white py-2 px-4 border border-green-800 hover:border-transparent rounded">
          新規作成
        </button>
      </a>
    </div>
    <div class="flex flex-wrap">
      <?php foreach ($myBlogsInfoList as $myBlogsInfo) : ?>
        <div class="blogs bg-white w-1/5 m-8">
          <div class="">
            <img src="https://images.unsplash.com/photo-1489396160836-2c99c977e970?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60" class="">
          </div>
          <div class="p-5">
            <h1 class="text-2xl font-bold text-green-800 py-2"><?= htmlspecialchars($myBlogsInfo['title']) ?></h1>
            <p class="bg-white text-sm text-black"><?php echo $myBlogsInfo['created_at'] ?></p>
            <p class="bg-white text-sm text-black"><?php echo mb_strimwidth(strip_tags($myBlogsInfo['content']), 0, 15, '…', 'UTF-8') ?></p>
            <a href="./myarticledetail.php?id=<?php echo $myBlogsInfo['id'] ?>" class="py-2 px-3 mt-4 px-6 text-white bg-green-500 inline-block rounded">記事詳細へ</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>

</html>