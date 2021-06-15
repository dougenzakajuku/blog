<h1>新規会員登録</h1>
<form action="/blog_php/register.php" method="post">
    <div>
        <label>名前：<label>
                <input type="text" name="user_name" placeholder="" required>
    </div>
    <div>
        <label>メールアドレス：<label>
                <input type="text" name="email" placeholder="" required>
    </div>
    <div>
        <label>パスワード：<label>
                <input type="password" name="password" placeholder="" required>
    </div>
    <input type="submit" value="新規登録">
</form>
<p>すでに登録済みの方は<a href="/blog_php/login_form.php">こちら</a></p>