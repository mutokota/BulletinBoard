<?php
define("FILENAME", "./board.txt");
date_default_timezone_set('Asia/Tokyo');


//変数の初期化
$current_date = null;
$data = null;
$file_handle = null;
$split_data = null;
$message = array();
$message_array = array();
$error_message = array();
$clean = array();

if (!empty($_POST["submit"])) {
  if (empty($_POST["title"])) {
    $error_message[] = "タイトルを記入してください";
  }
  if (empty($_POST["article"])) {
    $error_message[] = "記事を記入してください";
  }
  if (empty($error_message)) {
    if ($file_handle = fopen(FILENAME, "a")) {
      $current_date = date("Y-m-d H:i:s");
      $data
        = "'" . $_POST['title'] . "','" . $_POST['article'] . "','" . $current_date  . "'\n";

      fwrite($file_handle, $data);
      fclose($file_handle);
    }
  }
}

if ($file_handle = fopen(FILENAME, "r")) {
  while ($data = fgets($file_handle)) {
    $split_data = preg_split('/\'/', $data);
  }
  $message = array(
    "title" => $split_data[1],
    "article" => $split_data[3]
  );
  array_unshift($message_array, $message);
  fclose($file_handle);
}
?>
<!DOCTYPE html>

<html>

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="../css/style.css" />
  <script>
    ask = () => {
      return confirm('投稿してよろしいですか？');
    }
  </script>
</head>

<body>
  <header class="header">
    <h1>
      <a href="index.php">Lalabel News</a>
    </h1>
  </header>
  <section class="form">
    <h2>さぁ、最新のニュースをシェアしましょう</h2>
    <?php if (!empty($error_message)) : ?>
      <ul>
        <?php foreach ($error_message as $value) : ?>
          <li style="color:red"><?php echo $value; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <form action="" method="POST" onsubmit="return ask()">
      <div class="title">
        <label for="title">タイトル</label>
        <input type="text" name="title" id="title" />
      </div>
      <div class="article">
        <label for="article" style="vertical-align: top">記事</label>
        <textarea name="article" id="article" cols="30" rows="10"></textarea>
      </div>
      <input type="submit" name="submit" value="投稿" class="submit" />
    </form>
  </section>
  <section>
    <div>
      <?php if (!empty($message_array)) : ?>
        <?php foreach ($message_array as $value) : ?>
          <h4><?php echo "タイトル:" . $value["title"]; ?></h4>
          <p><?php echo  "記事:" . $value["article"]; ?></p>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

</body>

</html>