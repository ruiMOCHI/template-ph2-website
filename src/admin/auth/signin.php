<?php
mb_internal_encoding('UTF-8');
require(dirname(__FILE__) . '../../../dbconnect.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // バリデーション
  if (empty($_POST['email'])) {
    $message = 'メールアドレスは必須項目です。';
  } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $message = '正しいEメールアドレスを指定してください。';
  } elseif (empty($_POST['password'])) {
    $message = 'パスワードは必須項目です。';
  } else {
    $email = $_POST['email'];
    $password = $_POST['password'];

    /*データベースへの接続。メールが一致するユーザーをデータベースから探す*/
    $stmt = $dbh->prepare('select * from users where email = :email');
    $stmt->bindValue(':email', $email/*, PDO::PARAM_STR*/);
    $stmt->execute();
    $user = $stmt->fetch();

    /*ユーザーが存在し、パスワードが正しいか確認。一致していることが確認できれば、ホーム画面に遷移するようにしています。*/
    if ($user && password_verify($password, $user["password"])) {
      session_start();
      $_SESSION['id'] = $user['id'];
    header('Location: ../index.php' ); /*'Location: ../questions/create.php' で問題作成ページに飛べる*/
      exit();
    } else {
      // 認証失敗: エラーメッセージをセット
      $message = 'メールアドレスまたはパスワードが間違っています。';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSSE ログイン</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="./../assets/styles/common.css">
  <link rel="stylesheet" href="./../admin.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
<header>
  <div class="p-header__logo"><img src="../../assets/img/logo.svg" alt="POSSE"></div>
  <?php if (isset($_SESSION['id'])) { ?>
  <div>
    <form method="POST" action="/admin/auth/signin.php">
      <input type="submit" value="ログアウト" class="submit"/>
    </form>
  </div>
  <?php } ?>
</header>
  <div class="wrapper">
    <main>
      <div class="container">
        <h1 class="mb-4">ログイン</h1>
        <?php if ($message !== '') { ?>
          <p style="color: red;"><?= $message ?></p>
        <?php }; ?>
        <form method="POST">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="email form-control required" id="email">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" name="password" id="password" class="form-control required">
          </div>
          <!-- <div class="mb-3">
            <label for="password" class="form-label">パスワード確認</label>
            <input type="password" name="password" id="password" class="form-control required">
          </div> -->
          <button type="submit" disabled class="btn submit">ログイン</button>
        </form>
      </div>
    </main>
  </div>
  <script>
    const submitButton = document.querySelector('.btn.submit')
    const inputDoms = Array.from(document.querySelectorAll('.required')) //requiredは必要項目(だから、必須項目でない補足には付いてない)
    inputDoms.forEach(inputDom => {
      inputDom.addEventListener('input', event => {
        const isFilled = inputDoms.filter(d => d.value).length === inputDoms.length
        submitButton.disabled = !isFilled
      })
    })
  </script>
</body>

</html>