<?php
session_start();
if(!$_SESSION['auth']){
    header('location:login.php');
}
require_once 'database.php';

function stringSanitizer($stringSanitizado)
{
	//remove space bfore and after
	$stringSanitizado = trim($stringSanitizado);
	//remove slashes
	$stringSanitizado = stripslashes($stringSanitizado);
	$stringSanitizado = (filter_var($stringSanitizado, FILTER_SANITIZE_STRING));
	return $stringSanitizado;
}

// keep track validation errors
$idError = null;
$contentError = null;
$idQ = null;
$idUserLogged = $_SESSION['idUser'];
echo $idUserLogged;

if (!empty($_GET['idQ'])) {
	$idQ = $_REQUEST['idQ'];
}

if (null == $idQ) {
	header("Location: index.php");
}

if (!empty($_POST)) {
	// keep track post values
	$aContent = $_POST['aContent'];

	$idQSano = (filter_var($idQ, FILTER_SANITIZE_NUMBER_INT));
	$contentSanitizado = stringSanitizer($aContent);

	/// validate input
	$valid = true;

	if (empty($aContent)) {
		$contentError = 'Please input a description';
		$valid = false;
	}

	// update data
	if ($valid) {
		var_dump($_POST);
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO answer (idQ,idUser,aContent) values(?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($idQSano, $idUserLogged,  $contentSanitizado));
		Database::disconnect();
		header("Location: answer.php");
	}
} else {
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM question where idQ = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($idQ));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	$title = $data['qtitle'];
	$content = $data['qcontent'];

	Database::disconnect();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>
	<script src="css/customStyles.css"></script>
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
	<div class="container">
		<div class="span10 offset1">
			<div class="row">
				<h3>Answer the question</h3>
			</div>

			<form class="form-horizontal" action="answer.php?idQ=<?php echo $idQ ?>" method="post">
				
			<div class="control-group <?php echo !empty($titleError) ? 'error' : ''; ?>">
					<h3> <?php echo !empty($title) ? $title : ''; ?></h3>
					<div class="controls">
						<?php if (!empty($titleError)) : ?>
							<span class="help-inline"><?php echo $titleError; ?></span>
						<?php endif; ?>
					</div>
				</div>

				<div class="control-group <?php echo !empty($contentError) ? 'error' : ''; ?>">
					<p> <?php echo !empty($content) ? $content : ''; ?></p>
					<div class="controls">
						<?php if (!empty($contentError)) : ?>
							<span class="help-inline"><?php echo $contentError; ?></span>
						<?php endif; ?>
					</div>
				</div>

				<h3>Answers</h3>
				<?php
				$pdo = Database::connect();
                        $sql2 = "select * from answer where idQ=" . $idQ . ";";

                        foreach ($pdo->query($sql2) as $row) {
                            echo '<tr>';
                            echo '<td>' . $row['aContent'] . '</td>';
                            echo '<div class ="row">';
                            echo '</td>';
                            echo '</div>';
                            echo '</tr>';
                        }
                        Database::disconnect();
                        ?>

				<div class="control-group <?php echo !empty($contentError) ? 'error' : ''; ?>">

					<h3>Your answer</h3>
					<div class="form-floating">
						<textarea name="aContent" class="form-control" placeholder="Leave your answer here" id="answerTextarea" style="height: 100px; width: 55em"></textarea>
					</div>
					<?php if (!empty($contentError)) : ?>
						<span class="help-inline"><?php echo $contentError; ?></span>
					<?php endif; ?>
				</div>

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Answer</button>
					<a class="btn" href="index.php">Go to main page</a>
				</div>
			</form>
		</div>

	</div> <!-- /container -->
</body>

</html>