<?php
$con = mysqli_connect('mysql', 'root', 'root', 'Maoyan');
mysqli_set_charset($con, 'utf8');
if (!$con) {
    die('Could not connect: ' . mysql_error());
}

function getCSVdata($filename)
{
    $row = 1;
    if (($handle = fopen($filename, 'r')) !== false) {
        while (($data = fgetcsv($handle)) != false) {
            $content = mb_convert_encoding($data[0], 'UTF-8', 'GBK');
            $datas[] = $content;
        }

        fclose($handle);
        return $datas;
    }
}
$result = getCSVdata('./内衣长尾词_1550133544.csv');
$datas = array_chunk($result, 1000);
$sql = 'insert into keywords (keyword) values ';
foreach ($datas as $data) {
    $name = '(\'' . implode("','", $data) . '),';
    $name = rtrim($name, ',');
    $name = str_replace(',', '),(', $name) . ';';
    $name = substr_replace($name, '\');', -2);
    if (mysqli_query($con, ($sql . $name))) {
        echo '插入成功';
    }
}

mysqli_close($con);