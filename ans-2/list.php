<?php
/** リクエストパラメータを取得 */
isset($_POST["area"]) ? $area = $_POST["area"] : $area = "";
//var_dump($area);	// 作業-4
/** データベース接続情報を設定 */
$dsn = "mysql:host=localhost;dbname=restaurantdb;charset=utf8";
$user = "restaurantdb_admin";
$password = "admin123";

// データベース接続オブジェクトを取得
$pdo = new PDO($dsn, $user, $password);
// 実行するSQLを設定
$sql = "select * from restaurants where area = ?";
// SQL実行オブジェクトを取得
$pstmt = $pdo->prepare($sql);
// プレースホルダにリクエストパラメータを設定
$pstmt->bindValue(1, $area);
// SQLを実行
$pstmt->execute();
// SQL実行結果を配列に取得
$records = $pstmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($records); // 作業-5
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8" />
	<title>レストランレビュサイト - 小テスト</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="stylesheet" href="../assets/css/list.css" />
</head>
<body id="list">
	<header>
		<h1>レストラン レビュ サイト</h1>
	</header>
	<main>
		<article>
			<div class="clearfix">
			<h2>レストラン一覧</h2>
			<section class="entry">
				<form action="list.php" method="post">
					<select name="area">
						<option value="">-- 地域を選んでください --</option>
						<option value="福岡">福岡</option>
						<option value="神戸">神戸</option>
						<option value="伊豆">伊豆</option>
					</select>
					<input type="submit" value="検索" />
				</form>
			</section>
			</div>
			<?php if (count($records) > 0): ?>
			<section class="result">
				<p><?= count($records) ?>件のレストランが見つかりました。</p>
				<table class="list">
					<?php foreach ($records as $record): ?>
					<tr>
						<td class="photo"><img name="image" alt="「<?= $record["name"] ?>」の写真" src="../pages/img/<?= $record["image"] ?>" /></td>
						<td class="info">
							<dl>
								<dt name="name"><?= $record["name"] ?></dt>
								<dd name="description"><?= $record["description"] ?></dd>
							</dl>
						</td>
						<td class="link"><a href="detail.php?id=<?= $record["id"] ?>">詳細</a></td>
					</tr>
					<?php endforeach; ?>
				</table>
			</section>
			<?php endif; ?>
		</article>
	</main>
	<footer>
		<div class="copyright">&copy; 2020 the applied course of web system development</div>
	</footer>
</body>
</html>