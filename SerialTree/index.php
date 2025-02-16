<!DOCTYPE html>
<html>
<head>
    <title>SerialTree</title>
    <link rel="icon" type="image/x-icon" href="icons/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <br><br>

    <div class="container">
        <center>
            <h1>სერიალების სია</h1>
	    <br>
	    <br>
	    
		<h1>
		    რაოდენობა: <span id="row_count">0</span>
		</h1>
	    <br>
            <br>
        </center>

        <!-- ფილტრაციის ფორმა -->
        <form action="" method="GET" class="mb-xozo">
          
                
                    <label for="filter_title"></label>
                    <br>
                    <input class="mb-input-xozo" placeholder="დასახელება" type="text" class="form-control" name="filter_title" id="filter_title" value="<?php echo isset($_GET['filter_title']) ? $_GET['filter_title'] : ''; ?>">
                
                
                    <label for="filter_season"></label>
                    <br>
                    <input class="mb-input-xozo" placeholder="სეზონი" type="text" class="form-control" name="filter_season" id="filter_season" value="<?php echo isset($_GET['filter_season']) ? $_GET['filter_season'] : ''; ?>">
                
                
              

                    <button type="submit" class="btn-xozo">ძიება</button>


        </form>
<br>
        <center>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">ახალი ჩანაწერი</button>
        </center>

        <br>

        <table class="table">
            <thead>
                <tr>
                    <th>დასახელება</th>
                    <th>სეზონი</th>
                    <th>ეპიზოდი</th>
                    <th>ბმული</th>
                    <th>ქმედება</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // მონაცემთა ბაზასთან დაკავშირება
                $dbHost = 'localhost';
                $dbName = 'serialtree';
                $dbUser = 'tree';
                $dbPass = 'treepass';

                try {
                    $dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
                    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    
                    $filterTitle = isset($_GET['filter_title']) ? $_GET['filter_title'] : '';
                    $filterSeason = isset($_GET['filter_season']) ? $_GET['filter_season'] : '';

                    
                    $sql = "SELECT * FROM series WHERE 1=1";
                    $params = array();

                    if (!empty($filterTitle)) {
                        $sql .= " AND title LIKE ?";
                        $params[] = "%$filterTitle%";
                    }

                    if ($filterSeason) {
                        $sql .= " AND season = ?";
                        $params[] = $filterSeason;
                    }

                    $stmt = $dbh->prepare($sql);
                    $stmt->execute($params);

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo"<tr>";
                        echo "<td>{$row['title']}</td>";
                        echo "<td>{$row['season']}</td>";
                        echo "<td>{$row['episode']}</td>";
                        echo "<td><a href=\"{$row['link']}\" target=\"_blank\">ბმული</a></td>";
                        echo "<td>";
                        echo "<a href=\"#\" class=\"btn btn-primary btn-sm\" data-bs-toggle=\"modal\" data-bs-target=\"#editModal{$row['id']}\">ჩასწორება</a> ";
                        echo "<a href=\"delete.php?id={$row['id']}\" class=\"btn btn-danger btn-sm\">წაშლა</a>";
                        echo "</td>";
                        echo "</tr>";

                        
                        echo "<div class=\"modal fade\" id=\"editModal{$row['id']}\" tabindex=\"-1\" aria-labelledby=\"editModalLabel{$row['id']}\" aria-hidden=\"true\">";
                        echo "<div class=\"modal-dialog\">";
                        echo "<div class=\"modal-content\">";
                        echo "<div class=\"modal-header\">";
                        echo "<h5 class=\"modal-title\" id=\"editModalLabel{$row['id']}\">სერიალის ჩანაცვლება</h5>";
                        echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>";
                        echo "</div>";
                        echo "<div class=\"modal-body\">";
                        echo "<form action=\"update.php\" method=\"POST\">";
                        echo "<input type=\"hidden\" name=\"id\" value=\"{$row['id']}\">";
                        echo "<div class=\"mb-3\">";
                        echo "<label for=\"title\" class=\"form-label\">დასახელება</label>";
                        echo "<input type=\"text\" class=\"form-control\" id=\"title\" name=\"title\" value=\"{$row['title']}\">";
                        echo "</div>";
                        echo "<div class=\"mb-3\">";
                        echo "<label for=\"season\" class=\"form-label\">სეზონი</label>";
                        echo "<input type=\"number\" class=\"form-control\" id=\"season\" name=\"season\" value=\"{$row['season']}\">";
                        echo "</div>";
                        echo "<div class=\"mb-3\">";
                        echo "<label for=\"episode\" class=\"form-label\">სერია</label>";
                        echo "<input type=\"number\" class=\"form-control\" id=\"episode\" name=\"episode\" value=\"{$row['episode']}\">";
                        echo "</div>";
                        echo "<div class=\"mb-3\">";
                        echo "<label for=\"link\" class=\"form-label\">ბმული</label>";
                        echo "<input type=\"text\" class=\"form-control\" id=\"link\" name=\"link\" value=\"{$row['link']}\">";
                        echo "</div>";
                        echo "<button type=\"submit\" class=\"btn btn-primary\">შენახვა</button>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } catch (PDOException $e) {
                    echo "შეცდომა: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>
    </div>


    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">დამატება</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="save.php" method="POST">
                        <div class="mb-3">
                            <label for="title" class="form-label">დასახელება</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="season" class="form-label">სეზონი</label>
                            <input type="number" class="form-control" id="season" name="season">
                        </div>
                        <div class="mb-3">
                            <label for="episode" class="form-label">სერია</label>
                            <input type="number" class="form-control" id="episode" name="episode">
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">ბმული</label>
                            <input type="text" class="form-control" id="link" name="link">
                        </div>
                        <button type="submit" class="btn btn-primary">შენახვა</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        
        var addModal = new bootstrap.Modal(document.getElementById('addModal'));
        <?php
        
        $stmt->execute($params);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "var editModal{$row['id']} = new bootstrap.Modal(document.getElementById('editModal{$row['id']}'));";
        }
        ?>
    </script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        
        var rowCount = $('table tbody tr').length;
        $('#row_count').text(rowCount);
    });
</script>
</body>
</html>
