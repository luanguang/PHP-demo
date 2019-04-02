<?php

function get_txt_files($dir = './keywords')
{
    if (!is_dir($dir)) {
        return;
    }

    $handler = opendir($dir);
    while (($filename = readdir($handler)) !== false) {
        if ($filename != '.' && $filename != '..') {
            if (is_txt($filename)) {
                $files[] = $dir . '/' . $filename;
            }
        }
    }
    closedir($handler);

    return $files;
}

function is_txt($file)
{
    return pathinfo($file, PATHINFO_EXTENSION) == 'txt';
}

function get_file_name($file)
{
    return basename($file, '.txt');
}

function generate_sql($files)
{
    $now_number = get_keyword_number('127.0.0.1', 'root', 'root', 'xhs');
    $sql = '';
    foreach ($files as $file) {
        $filename = get_file_name($file);
        $table_name = 'keyword_' . $now_number;
        $table_sql = "
        CREATE TABLE IF NOT EXISTS `$table_name` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `keyword` varchar(50) DEFAULT '0',
            `is_crawl` tinyint(4) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        $postfix[] = ['keyword' => $filename];
        $insert_sql = "INSERT INTO $table_name (`keyword`) VALUES ";
        $insert_data = explode("\n", str_replace("\r", '', file_get_contents($file)));
        foreach ($insert_data as $insert) {
            if ($insert != '') {
                $insert_sql .= sprintf("('%s'),", $insert);
            }
        }

        $insert_sql = rtrim($insert_sql, ',') . ';';
        $sql .= $table_sql . $insert_sql . PHP_EOL;
        $now_number++;
    }

    $postfix_sql = 'INSERT INTO `postfix` (`keyword`) VALUES ';
    foreach ($postfix as $file) {
        $postfix_sql .= sprintf("('%s'),", $file['keyword']);
    }

    $postfix_sql = rtrim($postfix_sql, ',') . ';';
    $sql = $postfix_sql . $sql;
    return $sql;
}

function get_keyword_number($host, $username, $password, $dbname)
{
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die('连接失败：' . $conn->connect_error);
    }
    $sql = 'select max(id) as number from postfix';
    $result = $conn->query($sql);
    return $result->fetch_assoc()['number'] + 1;
}

function generate_sql_file($sql)
{
    file_put_contents('./postfix.sql', $sql);
}

if (!empty($argv[1])) {
    $dir = $argv[1];
} else {
    $dir = './keywords';
}

$files = get_txt_files($dir);
$sql = generate_sql($files);
generate_sql_file($sql);
