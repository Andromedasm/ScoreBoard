<?php
// inc/db.php
function getDatabaseConnection() {
    // 从配置文件获取数据库连接信息
    $config = include 'config.php';

    // 创建一个新的PDO对象并连接到数据库
    $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['name']};user={$config['user']};password={$config['password']}";
    return new PDO($dsn);
}
