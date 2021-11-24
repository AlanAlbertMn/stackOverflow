<?php
session_start();
if(!$_SESSION['auth']){
    header('location:login.php');
}
require_once 'database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>

    <header>
        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <img src="img/stackImg.jpg" alt="" width="220" height="10">
                </a>
                <a href="login.php">Login</a>
            </div>
        </nav>
    </header>
    <form>
        <div class="container" style="width: 66%">
            <div class="row">
                <h2>stackOverflow</h2>
            </div>
            <div class="row">
                <p>
                <div>
                    <a href="submitQuestion.php" class="btn btn-primary">Submit a question</a>
                </div>
                </p>
                <!-- <select class="a-spacing-top-mini" name="sort" id="sort" onchange="this.form.submit();">
					
				</select> -->
                <!-- <input type="text" placeholder="ID de articulo a buscar" name="find" id="find" onchange="this.form.submit();"> -->
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Questions</th>
                            <th>Details</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $pdo = Database::connect();
                        $sql = "select * from question ORDER BY idQ;";

                        foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>' . $row['qtitle'] . '</td>';
                            echo '<div class ="row">';
                            echo '<td width=300>';
                            echo '<a class="btn btn-info" style="width=150px;" href="answer.php?idQ=' . $row['idQ'] . '">Details</a>';
                            echo '&nbsp;';
                            echo '<a class="btn btn-success" href="answer.php?idQ=' . $row['idQ'] . '">Answer</a>';
                            echo '</td>';
                            echo '</div>';
                            echo '</tr>';
                        }
                        Database::disconnect();
                        ?>
                    </tbody>
                </table>
            </div>
            <h4>
                Alan Rodrigo Albert Morán
            </h4>
        </div>
    </form>
</body>

</html>