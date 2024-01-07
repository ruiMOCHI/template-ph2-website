<?php
mb_internal_encoding('UTF-8');

session_start();
$_SESSION = array(); /*セッション変数を空の配列に設定して、すべてのセッションデータをクリア*/
session_destroy();  //sessionを破壊、放棄

header('Location: ../index.php');

/* session_destroy() 関数は、セッションデータをサーバー上から破棄します。
しかし、この関数は PHPの $_SESSION 配列自体は破棄しません。そのため、$_SESSION に格納されているデータに引き続きアクセスすることができます。
☆これらを破棄するために、セッション変数を空の配列に設定しています。*/