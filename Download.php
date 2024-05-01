<?php
$postcount=0;
$comcount=0;

$jsonStringPosts = file_get_contents('http://jsonplaceholder.typicode.com/posts');
$arryPostsObj = json_decode($jsonStringPosts, true);

$jsonStringComments= file_get_contents('http://jsonplaceholder.typicode.com/comments');
$arryCommentsObj = json_decode($jsonStringComments, true);

$db_server = "localhost";
$db_user="root";
$db_password = "";
$db_name = "DB";
$con = mysqli_connect($db_server, $db_user, $db_password, $db_name);

if (mysqli_connect_errno()){
    die("Ошибка: ". $con->connect_error);
}

foreach ($arryPostsObj as $item)
{
    $sql = "INSERT INTO Posts (userId, id, title, body) VALUES (?,?,?,?)";
    $stmt = $con -> prepare($sql); 
    $stmt -> bind_param('iiss', $item['userId'], $item['id'], $item['title'], $item['body']);
    $stmt -> execute();
    $postcount +=1;
}

foreach ($arryCommentsObj as $item)
{
    $sql = "INSERT INTO Comments (postId, id, name, email, body) VALUES (?,?,?,?,?)";
    $stmt = $con -> prepare($sql); 
    $stmt -> bind_param('iisss', $item['postId'], $item['id'], $item['name'], $item['email'], $item['body']);
    $stmt -> execute();
    $comcount +=1;
}    
    echo "Загружено $postcount записей и $comcount комментариев";
    $con -> close();
    ?>
