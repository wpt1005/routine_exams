/**
 * 【レストランレビュサイト用データベース作成スクリプト】
 * 
 * 〈実行方法〉
 * 　　1. root権限でmysqlコマンドラインツールを起動する。
 * 　　2. sourceコマンドを使ってこのファイルを実行する。
 * 　　3. show databasesコマンドで「restaurantdb」が作成されていることを確認する。
 * 　　4. mysqlコマンドラインツールを終了する。
 * 
 * 《データベース接続情報》
 * 　・データソースネーム：mysql:host=localhost;dbname=restaurantdb;charset=utf8
 * 　・接続ユーザ名：restaurantdb_admin
 * 　・接続パスワード：admin123
 */

/* データベースと接続ユーザを初期化（削除） */
drop database if exists restaurantdb;
drop user if exists restaurantdb_admin;
/* データベースと接続ユーザを作成 */
create database restaurantdb;
grant all privileges on restaurantdb.* to 'restaurantdb_admin'@'localhost' identified by 'admin123';
