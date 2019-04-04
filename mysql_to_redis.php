<?php
//将mysql中的路由导入redis当中
$host = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'xhs';
$all_db = 3;

$conn = new mysqli($host, $username, $password, $dbname);

$redis_host = '192.168.2.82';
$redis_port = 6379;

$redis = new Redis();
$redis->connect($redis_host, $redis_port);

if ($conn->connect_error) {
    die('连接失败: ' . $conn->connect_error);
} else {
    echo '连接成功<br>';
}
$base_url = 'https://www.xiaohongshu.com/search/keyword?';
for ($i = 1; $i <= $all_db; $i++) {
    $sql = 'select * from keyword_' . $i . ' where is_crawl=0';
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $url = $base_url . http_build_query(['q' => $row['keyword']]) . '#' . $i;
            $redis->lpush('xiaohongshu:start_urls', $url);
            mysqli_query($conn, 'update keyword_' . $i . ' set is_crawl=1 where id=' . $row['id']);
        }
    }
}

$conn->close();
$redis->close();
