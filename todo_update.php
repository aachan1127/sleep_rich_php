<?php
// ーーーーーーーデータ送信できてるか確認ーーーーーーー
// var_dump($_POST);
// exit();
// ーーーーーーーーーーーーーーーーーーーーーーーーーー

// 入力項目のチェック

if (
    !isset($_POST['todo']) || $_POST['todo'] === '' ||
    !isset($_POST['deadline']) || $_POST['deadline'] === '' ||
    !isset($_POST['id']) || $_POST['id'] === ''
    ) {
    exit('paramError');
    }

    $todo = $_POST['todo'];
    $deadline = $_POST['deadline'];
    $id = $_POST['id'];


// DB接続ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
include('functions.php');
$pdo = connect_to_db();


// SQL実行ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
// 後ろの方　####################   必ず WHERE で id を指定すること！！！   ##########👇ここ！！！！！
$sql = 'UPDATE todo_table SET todo=:todo, deadline=:deadline, updated_at=now() WHERE id=:id';
// ############################   WHERE をつけないと、全部のデータが更新されてしまう！！！！！！！！！！

// ーーーーーーーーーーー　メモ　ーーーーーーーーーーーーー
// -- UPDATE文の基本構造
// UPDATE テーブル名 SET 変更データ WHERE 選択データ;

// -- 例
// UPDATE todo_table SET todo='PHP課題' WHERE id = 1;
// -- 【重要】必ずWHEREを使用！！（忘れると全てのデータが更新されます．．！）
// ーーーーーーーーーーー　メモ　ーーーーーーーーーーーーー



$stmt = $pdo->prepare($sql);
$stmt->bindValue(':todo', $todo, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header('Location:todo_read.php');
exit();
