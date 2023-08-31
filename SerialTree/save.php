<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    $title = $_POST['title'];
    $season = $_POST['season'] !== '' ? $_POST['season'] : null;
    $episode = $_POST['episode'] !== '' ? $_POST['episode'] : null;
    $link = $_POST['link'] !== '' ? $_POST['link'] : null;

    // მონაცემთა ბაზასთან დაკავშირება
    $dbHost = 'localhost';
    $dbName = 'serialtree';
    $dbUser = 'tree';
    $dbPass = 'treepass';

    try {
        $dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $dbh->prepare("INSERT INTO series (title, season, episode, link) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $season, $episode, $link]);


        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>

