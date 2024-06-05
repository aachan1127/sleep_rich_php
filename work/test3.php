<?php
include("work_functions.php");

// 日付の取得
$date = $_POST['date'];
$before_date = $_POST['before_date'];

// DB接続
$pdo = connect_to_db();

// SQL実行
$sql = 'SELECT * FROM sleep_table WHERE date BETWEEN :before_date AND :date';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':before_date', $before_date, PDO::PARAM_STR);
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($records, JSON_UNESCAPED_UNICODE);
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>日付と曜日出力</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <label for="datePicker">日付を選択:</label>
    <input type="date" id="datePicker">
    
    <form id="searchForm" method="POST">
        <button id="dateButton">日付選択</button>
    </form>

    <div id="result"></div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#dateButton').on('click', function(event) {
                event.preventDefault();
                const selectedDate = new Date($('#datePicker').val());
                const beforeDate = new Date(selectedDate.getTime() - (7 * 24 * 60 * 60 * 1000));
                searchWeek(selectedDate, beforeDate);
            });

            function searchWeek(date, before_date) {
                // 曜日を配列に格納
                const resultDiv = $('#result');
                resultDiv.empty();

                // 選択された日付の表示
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');

                // 1週間前の日付の表示
                const before_year = before_date.getFullYear();
                const before_month = String(before_date.getMonth() + 1).padStart(2, '0');
                const before_day = String(before_date.getDate()).padStart(2, '0');

                // データを送信して取得
                $.ajax({
                    type: 'POST',
                    url: 'work_search.php',
                    data: {
                        date: `${year}-${month}-${day}`,
                        before_date: `${before_year}-${before_month}-${before_day}`
                    },
                    dataType: 'json',
                    success: function(response) {
                        displayResults(response);
                    },
                    error: function() {
                        alert('データの取得に失敗しました。');
                    }
                });
            }

            function displayResults(data) {
                const resultDiv = $('#result');
                resultDiv.empty();
                data.forEach(record => {
                    resultDiv.append(`
                        <div>
                            <p>開始時間: ${record.sleep_start_time}</p>
                            <p>終了時間: ${record.sleep_end_time}</p>
                            <p>気分: ${record.feel}</p>
                            <p>コメント: ${record.comment}</p>
                        </div>
                    `);
                });
            }
        });
    </script>
</body>
</html>