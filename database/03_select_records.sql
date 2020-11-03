/**
 * あるレストランに対するレビュを抽出するSQL
 * 外部キー制約があるので、from句にふたつのテーブル、where条件にこれらテーブルのフィールドの条件を記述するだけで取得できる。
 * この場合は、restaurantsテーブルとreviewsテーブルに同一のレストランIDが存在しているレストランの名前とそのレストランについてのレビュを抽出する。
 * さらに、〈具体的なレストランIDを指定する〉ことで、そのレストランIDについてのレビュだけを抽出することができる。
 */
select
	reviews.id,
	restaurants.id,
	restaurants.name,
	reviews.reviewer,
	reviews.comment,
	reviews.point,
	reviews.posted_at
from
	restaurants, reviews
where
	restaurants.id = reviews.restaurant_id and restaurants.id = 7;