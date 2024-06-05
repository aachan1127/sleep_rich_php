<?php

function connect_to_db(){
// 各種項目設定 mysqlのデータベース名の名前は　phpMyAdminのファイル名に変更する
$dbn ='mysql:dbname=gs_l10_02_work_php02;charset=utf8mb4;port=3306;host=localhost';
// #######    さくらサーバーなどに上げるときはここを さくらのid名に変更する！　ザンプを使用している場合はrootでOK！
$user = 'root'; 
// #######    さくらサーバーに上げる時はここを さくらのパスワードに変更する！　ザンプを使用している場合は何も記入しなくてOK！まんぷの場合はroot
$pwd = '';

try {
    // 👇関数にするとき、ここ return に変える！
    return new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    // DB接続でエラーが出ている場合は、ここのエラーメッセージが表示される。
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
  }
}
  