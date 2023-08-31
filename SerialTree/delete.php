<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // მონაცემთა ბაზასთან დაკავშირება
    $dbHost = 'localhost';
    $dbName = 'serialtree';
    $dbUser = 'tree';
    $dbPass = 'treepass';

    try {
        $dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $sql = "DELETE FROM series WHERE id = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$id]);


        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>

