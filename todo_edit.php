<?php
include("functions.php");

// id受け取り ーーーーー情報が受け取れているか var_dumpで確認
// var_dump($_GET);  
// exit();

$id = $_GET['id'];

// DB接続
$pdo = connect_to_db();

// SQL実行
$sql = 'SELECT * FROM todo_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// 今回は全体ではなく一部分だけを取得したいので fetch を使う！　fetchAll を使うと、全体が取れる！
$record = $stmt->fetch(PDO::FETCH_ASSOC);

// echo "<pre>";
// var_dump($record);
// echo "</pre>";
// exit();


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB連携型todoリスト（編集画面）</title>
</head>

<body>
  <form action="todo_update.php" method="POST">
    <fieldset>
      <legend>DB連携型todoリスト（編集画面）</legend>
      <a href="todo_read.php">一覧画面</a>
      <div>
        <!-- 👇 ーーーーーーここ編集するとこーーーーーーーーー -->
        todo: <input type="text" name="todo" value="<?= $record['todo'] ?>">
      </div>
      <div>
        deadline: <input type="date" name="deadline" value="<?= $record['deadline'] ?>">
      </div>
      <div>
      <input type="hidden" name="id" value="<?= $record['id'] ?>">
    </div>
    <!-- 👆 ーーーーーーーーーーここまでーーーーーーーーーーーーー -->
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>

</body>

</html>