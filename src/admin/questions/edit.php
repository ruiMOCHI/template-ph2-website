<?php
// mb_internal_encoding('UTF-8');

// require_once('../../vendor/autoload.php');
// require('../../dbconnect.php');
// require('../../vendor/verot/class.upload.php/src/class.upload.php');

// session_start();

// if (!isset($_SESSION['id'])) {
//     header('Location: /admin/auth/signin.php');
//     exit;
// } else {

//     $sql = "SELECT * FROM questions WHERE id = :id";
//     $stmt = $dbh->prepare($sql);
//     $stmt->bindValue(":id", $_REQUEST["id"]);
//     $stmt->execute();
//     $question = $stmt->fetch();

//     $sql = "SELECT * FROM choices WHERE question_id = :question_id";
//     $stmt = $dbh->prepare($sql);
//     $stmt->bindValue(":question_id", $_REQUEST["id"]);
//     $stmt->execute();
//     $choices = $stmt->fetchAll();

//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         try {
//             $dbh->beginTransaction();

//             // 問題レコードの更新（画像）
//             if ($_FILES["image"]["tmp_name"] !== "") {

//                 if ($_FILES['image']['error'] != UPLOAD_ERR_OK) {
//                     throw new Exception("ファイルがアップロードされていない、またはアップロードでエラーが発生しました。");
//                 }

//                 if ($_FILES['image']['size'] > 5000000) {
//                     throw new Exception("ファイルサイズが大きすぎます。");
//                 }

//                 $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
//                 $file_parts = explode('.', $_FILES['image']['name']);
//                 $file_ext = strtolower(end($file_parts));
//                 if (!in_array($file_ext, $allowed_ext)) {
//                     throw new Exception("許可されていないファイル形式です。");
//                 }

//                 $allowed_mime = array('image/jpeg', 'image/png', 'image/gif');
//                 $file_mime = mime_content_type($_FILES['image']['tmp_name']);
//                 if (!in_array($file_mime, $allowed_mime)) {
//                     throw new Exception("許可されていないMIMEタイプです。");
//                 }

//                 $image_name = uniqid(mt_rand(), true) . '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
//                 $image_path = dirname(__FILE__) . '/../../assets/img/quiz/' . $image_name;
//                 // ファイルが正常に移動されたら、データベースを更新する
//                 if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
//                     $sql = "UPDATE questions SET image = :image WHERE id = :id";
//                     $stmt = $dbh->prepare($sql);
//                     $stmt->bindValue(":image", $image_name);
//                     $stmt->bindValue(":id", $_POST["question_id"]);
//                     $stmt->execute();
//                 } else {
//                     throw new Exception("Failed to upload the image.");
//                 }
//             }

            

//             // 問題レコードの更新（画像以外）
//             $sql = "UPDATE questions SET content = :content, supplement = :supplement WHERE id = :id";
//             $stmt = $dbh->prepare($sql);
//             $stmt->bindValue(":content", $_POST["content"]);
//             $stmt->bindValue(":supplement", $_POST["supplement"]);
//             $stmt->bindValue(":id", $_POST["question_id"]);
//             $stmt->execute();

//             // 選択肢レコードの更新
//             $sql = "UPDATE choices SET name = :name, valid = :valid WHERE id = :id AND question_id = :question_id";
//             // 各選択肢についてループ
//             for ($i = 0; $i < count($_POST["choices"]); $i++) {
//                 $stmt = $dbh->prepare($sql);
//                 $stmt->bindValue(":name", $_POST["choices"][$i]);
//                 $stmt->bindValue(":valid", (int)($_POST['correctChoice'] == $_POST["choice_ids"][$i]) ? 1 : 0);
//                 $stmt->bindValue(":id", $_POST["choice_ids"][$i]);
//                 $stmt->bindValue(":question_id", $_POST["question_id"]);
//                 $stmt->execute();
//             }
//             $dbh->commit();
//             $_SESSION['message'] = "問題編集に成功しました。";
//             header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $_POST["question_id"]);
//             exit;
//         } catch (PDOException $e) {
//             $dbh->rollBack();
//             $_SESSION['message'] = "問題編集に失敗しました。";
//             error_log($e->getMessage());
//             exit;
//         }
//     }
// }

mb_internal_encoding('UTF-8');

require_once('../../vendor/autoload.php');
require('../../dbconnect.php');
require('../../vendor/verot/class.upload.php/src/class.upload.php');

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: /admin/auth/signin.php');
    exit;
} else {

    $sql = "SELECT * FROM questions WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":id", $_REQUEST["id"]);
    $stmt->execute();
    $question = $stmt->fetch();

    $sql = "SELECT * FROM choices WHERE question_id = :question_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":question_id", $_REQUEST["id"]);
    $stmt->execute();
    $choices = $stmt->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $dbh->beginTransaction();

            // 問題レコードの更新（画像）
            if ($_FILES["image"]["tmp_name"] !== "") {

                if ($_FILES['image']['error'] != UPLOAD_ERR_OK) {
                    throw new Exception("ファイルがアップロードされていない、またはアップロードでエラーが発生しました。");
                }

                if ($_FILES['image']['size'] > 5000000) {
                    throw new Exception("ファイルサイズが大きすぎます。");
                }

                $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
                $file_parts = explode('.', $_FILES['image']['name']);
                $file_ext = strtolower(end($file_parts));
                if (!in_array($file_ext, $allowed_ext)) {
                    throw new Exception("許可されていないファイル形式です。");
                }

                $allowed_mime = array('image/jpeg', 'image/png', 'image/gif');
                $file_mime = mime_content_type($_FILES['image']['tmp_name']);
                if (!in_array($file_mime, $allowed_mime)) {
                    throw new Exception("許可されていないMIMEタイプです。");
                }

                $image_name = uniqid(mt_rand(), true) . '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
                $image_path = dirname(__FILE__) . '/../../assets/img/quiz/' . $image_name;
                // ファイルが正常に移動されたら、データベースを更新する
                if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                    $sql = "UPDATE questions SET image = :image WHERE id = :id";
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindValue(":image", $image_name);
                    $stmt->bindValue(":id", $_POST["question_id"]);
                    $stmt->execute();
                } else {
                    throw new Exception("Failed to upload the image.");
                }
            }
            // アップロードされたファイルの情報を取得
            $fileInfo = $_FILES['image'];

            // // ファイルサイズのバリデーション (5MB)
            $maxFileSize = 5 * 1024 * 1024;

            // if ($fileInfo['error'] != UPLOAD_ERR_OK) {   [[[[[class.upload.phpと被っているバリデーションなので、コメントアウト]]]]]
            //     throw new Exception("ファイルがアップロードされていない、またはアップロードでエラーが発生しました。");
            // }

            // if ($fileInfo['size'] > $maxFileSize) {
            //     throw new Exception('ファイルサイズが大きすぎます。5MBまでしかアップロードできません。');
            // }

            // $allowedExtensions = array('jpeg', 'png', 'gif');
            // $allowedMimeTypes = array('image/jpeg', 'image/png', 'image/gif');

            // $extension = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
            // $mime = mime_content_type($fileInfo['tmp_name']);

            // if (!in_array($extension, $allowedExtensions) || !in_array($mime, $allowedMimeTypes)) {
            //     throw new Exception('許可されていないファイル形式です。jpeg、png、gifのいずれかをアップロードしてください。');
            // }

            // アップロードされたファイルを渡す
            $file = $_FILES['image'];
            $lang = 'ja_JP';

            // 画像のアップロードと変換
            $handle = new \Verot\Upload\Upload($fileInfo);

            // ファイル名を変更
            $handle->file_new_name_body = 'uploaded_image';

            // 拡張子の統一
            $handle->file_safe_name = true;
            $handle->file_overwrite = true;
            $handle->allowed = array('image/*');
            $handle->file_max_size = $maxFileSize;

            // 画像のリサイズ
            $handle->image_resize = true;
            $handle->image_x = 718;
            $handle->image_ratio_y = true;

            // // アップロードを実行
            // if ($handle->process()) {
            //     // アップロード成功
            //     $image_name = $handle->file_dst_name;
            //     $sql = "UPDATE questions SET image = :image WHERE id = :id";
            //     $stmt = $dbh->prepare($sql);
            //     $stmt->bindValue(":image", $image_name);
            //     $stmt->bindValue(":id", $_POST["question_id"]);
            //     $stmt->execute();
            // } else {
            //     // アップロード処理失敗
            //     throw new Exception('エラーが発生しました: ' . $handle->error);
            // }

            // 問題レコードの更新（画像以外）
            $sql = "UPDATE questions SET content = :content, supplement = :supplement WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(":content", $_POST["content"]);
            $stmt->bindValue(":supplement", $_POST["supplement"]);
            $stmt->bindValue(":id", $_POST["question_id"]);
            $stmt->execute();

            // 選択肢レコードの更新
            $sql = "UPDATE choices SET name = :name, valid = :valid WHERE id = :id AND question_id = :question_id";
            // 各選択肢についてループ
            for ($i = 0; $i < count($_POST["choices"]); $i++) {
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(":name", $_POST["choices"][$i]);
                $stmt->bindValue(":valid", (int)($_POST['correctChoice'] == $_POST["choice_ids"][$i]) ? 1 : 0);
                $stmt->bindValue(":id", $_POST["choice_ids"][$i]);
                $stmt->bindValue(":question_id", $_POST["question_id"]);
                $stmt->execute();
            }

            $dbh->commit();
            $_SESSION['message'] = "問題編集に成功しました。";
            header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $_POST["question_id"]);
            exit;
        } catch (PDOException $e) {
            $dbh->rollBack();
            $_SESSION['message'] = "問題編集に失敗しました。";
            error_log($e->getMessage());
            exit;
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
    <title>POSSE 管理画面ダッシュボード</title>
    <!-- スタイルシート読み込み -->
    <link rel="stylesheet" href="./assets/styles/common.css">
    <link rel="stylesheet" href="../admin.css">
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
                    <input type="submit" value="ログアウト" class="submit" />
                </form>
            </div>
        <?php } ?>
    </header>
    <div class="wrapper">
        <aside>
            <nav>
                <ul>
                    <li>
                        <a href="">ユーザー招待</a>
                    </li>
                    <li>
                        <a href="http://localhost:8080/admin/index.php">問題一覧</a>
                    </li>
                    <li>
                        <a href="http://localhost:8080/admin/questions/create.php">問題作成</a>
                    </li>
                </ul>
            </nav>
        </aside>
        <main>
            <div class="container">
                <h1 class="mb-4">問題編集</h1>
                <form class="question-form" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="question" class="form-label">問題文:</label>
                        <input type="text" name="content" id="question" class="form-control required" value="<?= $question["content"] ?>" placeholder="問題文を入力してください" />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">選択肢:</label>
                        <div class="form-choices-container">
                            <?php foreach ($choices as $key => $choice) { ?>
                                <input type="text" name="choices[]" class="required form-control mb-2" placeholder="選択肢を入力してください" value=<?= $choice["name"] ?>>
                                <input type="hidden" name="choice_ids[]" value="<?= $choice["id"] ?>">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">正解の選択肢</label>
                        <div class="form-check-container">
                            <?php foreach ($choices as $key => $choice) { ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="correctChoice" id="correctChoice<?= $key ?>" value="<?= $choice["id"] ?>" <?= $choice["valid"] === 1 ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="correctChoice1">
                                        選択肢<?= $key + 1 ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="question" class="form-label">問題の画像</label>
                        <input type="file" name="image" id="image" class="form-control" />
                    </div>
                    <div class="mb-4">
                        <label for="question" class="form-label">補足:</label>
                        <input type="text" name="supplement" id="supplement" class="form-control required" placeholder="補足を入力してください" value="<?= $question["supplement"] ?>" />
                    </div>
                    <input type="hidden" name="question_id" value="<?= $question["id"] ?>">
                    <button type="submit" disabled class="btn submit">更新</button>
                    <!-- <button type="submit" class="btn submit"><a href="http://localhost:8080/admin/index.php">更新</a></button> これで更新をおしたら、問題一覧に飛べる -->
                </form>
            </div>

        </main>
    </div>
    <script>
        // const submitButton = document.querySelector('.btn.submit')
        // const inputDoms = Array.from(document.querySelectorAll('.required')) //requiredは必要項目(だから、必須項目でない補足には付いてない)
        // inputDoms.forEach(inputDom => {
        //     inputDom.addEventListener('input', event => { 此処と、201行目。いや疲れたー
        //         const isFilled = inputDoms.filter(d => d.value).length === inputDoms.length
        //         submitButton.disabled = !isFilled
        //     })
        // })
        const submitButton = document.querySelector('.btn.submit')
        const inputDoms = Array.from(document.querySelectorAll('.required'))
        inputDoms.forEach(inputDom => {
            inputDom.addEventListener('input', event => { 
                const isFilled = inputDoms.filter(d => d.value).length === inputDoms.length
                submitButton.disabled = !isFilled
            });
        });
    </script>
</body>

</html>