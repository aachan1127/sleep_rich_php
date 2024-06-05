<?php


// $dbn = 'mysql:dbname=gs_l10_02;charset=utf8mb4;port=3306;host=localhost';
// $user = 'root';
// $pwd = '';

// try {
//   $pdo = new PDO($dbn, $user, $pwd);
// } catch (PDOException $e) {
//   echo json_encode(["db error" => "{$e->getMessage()}"]);
//   exit();
// }

// 👇これに変更するーーーーーーーーーーーーーーーーーーーーーーーー
// function connect_to_db(){

// $dbn = 'mysql:dbname=gs_l10_02;charset=utf8mb4;port=3306;host=localhost';
// $user = 'root';
// $pwd = '';

// try {
//   return new PDO($dbn, $user, $pwd);
// } catch (PDOException $e) {
//   echo json_encode(["db error" => "{$e->getMessage()}"]);
//   exit();
// }

// }

// ーーーーー　functions.php のファイルの保存した関数をここで読み込む！　ーーーーーーー
include('functions.php');
$pdo = connect_to_db();
// ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー




$sql = 'SELECT * FROM todo_table ORDER BY deadline ASC';

$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";
foreach ($result as $record) {

  //👇 href のところに =>  todo_edit.php へのリンクを追加！todo_delete.php へのリンクも一緒に！）
  // （　編集　＆　削除　ボタン　）
  $output .= "
    <tr>
      <td>{$record["deadline"]}</td>
      <td>{$record["todo"]}</td>

<td>
        <a href='todo_edit.php?id={$record["id"]}'>edit</a>
      </td>
      <td>
        <a href='todo_delete.php?id={$record["id"]}'>delete</a>
      </td>

    </tr>
  ";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB連携型todoリスト（一覧画面）</title>
</head>

<body>
  <fieldset>
    <legend>DB連携型todoリスト（一覧画面）</legend>
    <a href="todo_input.php">入力画面</a>
    <table>
      <thead>
        <tr>
          <th>deadline</th>
          <th>todo</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>