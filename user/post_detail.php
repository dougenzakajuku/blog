<?php
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/Session.php');
require_once(__DIR__ . '/../dao/BlogDao.php');

$session = Session::getInstance();
if (!isset($_SESSION["formInputs"]['userId'])) redirect('./user/signin.php');

$blogId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$blogDao = new BlogDao();
$userId = $blogDao->findUserIdByBlogId($blogId);

/*
 * sessionのidと記事の作成者のidが同じでない場合にリダイレクトする
 */
if ($userId != $_SESSION["formInputs"]['userId']) redirect('./');
$errors = $session->popAllErrors();

$myblogsInfo = $blogDao->findBlogById($blogId);
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>マイ記事詳細ページ</title>
</head>

<body>
  <section>
    <div class="bg-green-300 text-white py-20">
      <div class="container mx-auto my-6 md:my-24">
        <div class="w-full justify-center">
          <div class="container w-full px-4">
            <div class="flex flex-wrap justify-center">
              <div class="w-full lg:w-6/12 px-4">
                <?php foreach ($errors as $error) : ?>
                  <p><?php echo $error; ?></p>
                <?php endforeach; ?>
                <div class="">
                  <h2 class="mb-12 text-6xl text-center font-bold text-green-800"><?php print(nl2br($myblogsInfo['title'])); ?></h2>
                </div>
                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-white">
                  <div class="flex-auto p-5 lg:p-10">
                    <div class="relative w-full mb-3">
                      <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="content">投稿日時: <?php echo nl2br($myblogsInfo['created_at']); ?></label>
                      <div class="border-0 px-3 py-3 bg-gray-300 text-gray-800 rounded text-sm shadow focus:outline-none w-full">
                        <?php echo nl2br($myblogsInfo['content']); ?>
                      </div>
                    </div>
                    <div class="text-right mt-6">
                      <a href="/blog/post/edit.php?id=<?php echo $_GET["id"] ?>">
                        <button class="bg-yellow-300 text-black mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="submit" style="transition: all 0.15s ease 0s;">編集
                        </button>
                      </a>
                      <a href="/blog/post/delete.php?id=<?php echo $_GET["id"] ?>">
                        <button class="bg-yellow-300 text-black mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="submit" style="transition: all 0.15s ease 0s;">削除
                        </button>
                      </a>
                      <a href="../mypage.php">
                        <button class="bg-yellow-300 text-black mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="submit" style="transition: all 0.15s ease 0s;">マイページへ
                        </button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>