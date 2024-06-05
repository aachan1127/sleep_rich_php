<?php

// データ受け取り　ーーーーーーーーーーーーーーーーーー
// var_dump($_GET);
// exit();
$id = $_GET['id'];
//⇒read.phpでa hrefのとこで、?id={$record["id"]}のように
//idを設定している＆
//GETはURLに表示されるので（POSTはURLが隠れる）
//ここでGETするとidを取れる

// DB接続　ーーーーーーーーーーーーーーーーーーーーー
include('functions.php');
$pdo = connect_to_db();

// ーーーーーーーーー　SQL実行　ーーーーーーーーーー

// -- WHEREで指定しないとテーブルのデータが全滅する！！（デリートした後は永久欠番！）
// -- DELETEすると復旧できないので注意！！👇ここ！
$sql = 'DELETE FROM todo_table WHERE id=:id';

// ーーーーーーーー　補足　ーーーーーーーーーー
// アカウント管理などをする時は、論理削除した方がいい！
// デリートの項目を MyAdmin　で NULL にして、削除ボタンを押すとそこに削除した日時が入るようにする
// SQLを実行するところに　IS NULL を追加する。
// ーーーーーーーーーーーーーーーーーーーーーー
// --- メモ ---
// -- DELETE文の基本構造
// DELETE FROM テーブル名;

// -- 例

// -- 全消去
// DELETE FROM todo_table;
// -- 指定データのみ
// DELETE FROM todo_table WHERE id = 2;
// ーーーーーーーーーーーーーーーーーーーーーーーーー

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:todo_read.php");
exit();

