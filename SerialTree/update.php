<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    $id = $_POST['id'];
    $title = $_POST['title'];
    $season = $_POST['season'];
    $episode = $_POST['episode'];
    $link = $_POST['link'];

    // მონაცემთა ბაზასთან დაკავშირება
    $dbHost = 'localhost';
    $dbName = 'serialtree';
    $dbUser = 'tree';
    $dbPass = 'treepass';

    try {
        $dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $dbh->prepare("UPDATE series SET title = ?, season = ?, episode = ?, link = ? WHERE id = ?");
        $stmt->execute([$title, $season, $episode, $link, $id]);


        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>

