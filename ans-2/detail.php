<?php
/**
 * 評価ポイントを星印文字列に変換する（作業-5）。
 * @param int 評価ポイント
 * @return string 星印文字列
 */
function convertPointsToStars($point):string {
	$stars = "";
	for ($i = 0; $i < 5; $i++) {
		if ($i < $point) {
			$stars .= "★";
		} else {
			$stars .= "☆";
		}
	}
	return $stars;
}
?>
<?php
/** リクエストパラメータを取得 */
isset($_GET["id"]) ? $id = $_GET["id"] : $id = 0;
// var_dump($id);	// 【作業-1】

/** データベース接続情報を設定 */
$dsn = "mysql:host=localhost;dbname=restaurantdb;charset=utf8";
$user = "restaurantdb_admin";
$password = "admin123";

// データベース接続オブジェクトを取得
$pdo = new PDO($dsn, $user, $password);

/** レストランを取得 */
// レストランを取得するQLを設定
$sql = "select * from restaurants where id = ?";
// SQL実行オブジェクトを取得
$pstmt = $pdo->prepare($sql);
// プレースホルダにリクエストパラメータを設定
$pstmt->bindValue(1, $id);
// SQLを実行
$pstmt->execute();
// SQL実行結果を配列に取得
$records = $pstmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($records);	// 【作業-2】

// レストランを取得
$resutaurant = null;
if (count($records) > 0) {
	$restaurant = $records[0];
}

/** レストランに対するレビュを取得 */
// レビュを取得するQLを設定
$sql = "select * from reviews where restaurant_id = ?";
// SQL実行オブジェクトを取得
$pstmt = $pdo->prepare($sql);
// プレースホルダにリクエストパラメータを設定
$pstmt->bindValue(1, $id);
// SQLを実行
$pstmt->execute();
// SQL実行結果を配列に取得
$records = $pstmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($records);	// 【作業-3】

// レビュを取得
$reviews = [];
foreach ($records as $record) {
	$review = [];
	$review["id"] = $record["id"];
	$review["restaurant_id"] = $id;
	$review["reviewer"] = $record["reviewer"];
	$review["comment"] = $record["comment"];
	$review["point"] = $record["point"];
	$review["posted_at"] = $record["posted_at"];
	$reviews[] = $review;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8" />
	<title>レストランレビュサイト - 小テスト</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="stylesheet" href="../assets/css/detail.css" />
</head>
<body id="detail">
	<div class="p-wrapper">
	<header>
		<h1><a href="list.php">レストラン レビュ サイト</a></h1>
	</header>
	<main>
		<article class="detail">
			<h2>レストラン詳細</h2>
			<?php if (!is_null($restaurant)): ?>
			<section>
				<table class="list">
					<tr>
						<td class="photo"><img name="image" src="../pages/img/<?= $restaurant["image"] ?>" /></td>
						<td class="info">
							<dl>
								<dt name="name"><?= $restaurant["name"] ?></dt>
								<dd name="description"><?= $restaurant["description"] ?></dd>
							</dl>
						</td>
					</tr>
				</table>
			</section>
			<?php endif; ?>
		</article>
		<article class="reviews">
			<h2>レビュ一覧</h2>
			<?php if (count($records) > 0): ?>
			<section>
				<?php foreach ($reviews as $review): ?>
				<dl class="review">
					<!--【作業-4】画面ショットが取れたらコメントアウト
					<dt name="point"><?= $review["point"] ?></dt>
					-->
					<dt name="point"><?= convertPointsToStars($review["point"]) ?></dt>	<!-- 【作業-5】 -->
					<dd name="description"><?= $review["comment"] ?>
							<div name="posted">
								（<span name="posted_at"><?= $review["posted_at"] ?></span><span name="reviewer"><?= $review["reviewer"] ?></span>さん）
							</div>
					</dd>
				</dl>
				<?php endforeach; ?>
			</section>
			<?php endif; ?>
		</article>
		<article class="entry">
			<h2>レビュを書き込む</h2>
			<section>
				<form action="detail.php" method="post">
					<table class="entry">
						<tr>
							<th>お名前</th>
							<td>
								<input type="text" name="name" />
							</td>
						</tr>
						<tr>
							<th>ポイント</th>
							<td>
								<input type="radio" name="point" value="1">1
								<input type="radio" name="point" value="2">2
								<input type="radio" name="point" value="3" checked>3
								<input type="radio" name="point" value="4">4
								<input type="radio" name="point" value="5">5
							</td>
						</tr>
						<tr>
							<th>レビュ</th>
							<td>
								<textarea name="comment"></textarea>
							</td>
						</tr>
					</table>
					<div class="buttons">
						<input type="submit" value="投稿" />
						<input type="reset" value="クリア" />
						<input type="hidden" name="id" value="<?= $restaurant["id"] ?>" />
					</div>
				</form>
			</section>
		</article>
	</main>
	<footer>
		<div class="copyright">&copy; 2020 the applied course of web system development</div>
	</footer>
	</div>
</body>
</html>