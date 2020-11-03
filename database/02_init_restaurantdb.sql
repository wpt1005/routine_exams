/**
 * 【レストランレビュサイト用データベース作成スクリプト】
 * 
 * 〈実行方法〉
 * 　　1. restaurantdb_admin権限でmysqlコマンドラインツールを起動する。
 * 　　2. sourceコマンドを使ってこのファイルを実行する。
 * 　　3. show tablesコマンドで「restaurants」と「reviews」のふたつのテーブルが作成されていることを確認する。
 * 　　4. mysqlコマンドラインツールを終了する。
 * 
 * 《データベース接続情報》
 * 　・データソースネーム：mysql:host=localhost;dbname=restaurantdb;charset=utf8
 * 　・接続ユーザ名：restaurantdb_admin
 * 　・接続パスワード：admin123
 */

use restaurantdb

/* デーブルを初期化（削除） */
drop table if exists reviews;
drop table if exists restaurants;
/* テーブルを作成 */
-- レストランマスタ
create table restaurants (
	id int not null unique auto_increment,
	name varchar(10) not null,
	description text,
	image varchar(20),
	area varchar(5),
	created_at datetime not null default now(),
	primary key pk_restaurants (id)
) engine=InnoDB default charset=utf8;

-- レビュテーブル
create table reviews (
	id int not null unique auto_increment,
	restaurant_id int not null,
	reviewer varchar(10) not null default '名無し',
	comment text,
	point tinyint not null default 3,
	primary key pk_reviews (id),
	posted_at datetime not null default now(),
	foreign key fk_reviews (restaurant_id) references restaurants (id)
) engine=InnoDB default charset=utf8;

/* サンプルレコードの登録 */
-- restaurantsテーブル
insert into restaurants (id, name, description, image, area) values (1, 'Wine Bar ENOTECA', '常時10種類以上の赤・白ワインをご用意しています。\n記念日にご来店ください。', 'restaurant_1.jpg', '神戸');
insert into restaurants (id, name, description, image, area) values (2, 'スペイン料理 ポルファボール！', '味が自慢。スペイン現地で学んだシェフが出す味は本物です。', 'restaurant_2.jpg', '伊豆');
insert into restaurants (id, name, description, image, area) values (3, 'パス・パスタ', '本当のパスタを味わうならパス・パスタで！\n休日の優雅なランチタイムに是非どうぞ。', 'restaurant_3.jpg', '福岡');
insert into restaurants (id, name, description, image, area) values (4, 'レストラン「有閑」', '広い店内で、お昼の優雅なひと時を過ごしませんか？', 'restaurant_4.jpg', '神戸');
insert into restaurants (id, name, description, image, area) values (5, 'ビストロ「ルーヴル」', '高層ビル42階のビストロで、県内が一望できる。恋人とのひと時をここで過ごしませんか。', 'restaurant_5.jpg', '福岡');
insert into restaurants (id, name, description, image, area) values (6, '海沿いのレストラン La Mer', '海が見える、海沿いのレストランです。', 'restaurant_6.jpg', '神戸');
insert into restaurants (id, name, description, image, area) values (7, 'レストラン さくら', '四季折々の自然を楽しむ伊豆市に、ひっそりと佇む隠れ家レストラン。\n旅行でいらっしゃった方も、お近くの方も、お気軽にお立ち寄りください。', 'restaurant_7.jpg', '伊豆');
-- reviewsテーブル
insert into reviews (restaurant_id, reviewer, comment, point, posted_at) values (7, 'oie', '説明の通り、喧騒を外れた場所にひっそりとあるレストランでした。 伊豆市には初めて来ましたが、本当に桜がきれいですね。 何よりも空気がきれいで、いいリフレッシュになりました。', 5, '2018-12-23 15:43:45');
insert into reviews values (2, 7, 'totsuka', '常連の者で、いつも夫婦で伺っています。 席数が少ないので予約した方が安心ですが、その分落ち着いて食事できますよ。 コースのメインは基本的にシェフにお任せ。 来るたびに、新しい味との出会いを楽しめるお店です。', 4, '2020-06-14 05:29:01');
