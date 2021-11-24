<?php
require 'database.php';
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
$titleError = null; 
$contentError = null; 

if (!empty($_POST)) {

	// keep track post values
	// $idQ = $_POST['idQ'];
    $idUser = 1;
	$title = $_POST['title'];
	$content = $_POST['content'];

	$idSano = stringSanitizer($idUser);
	$titleSanitized = stringSanitizer($title);
	$contentSanitized = stringSanitizer($content);

	// validate input
	$valid = true;

	if (empty($title)) {
		$idError = 'Input a title for your question';
		$valid = false;
	}
	if (empty($content)) {
		$nombreError = 'Enter a description for your question';
		$valid = false;
	}

	// insert data
	if ($valid) {
		var_dump($_POST);
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO question (idUser,qtitle ,qcontent) values(?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($idSano, $titleSanitized, $contentSanitized));
		Database::disconnect();
		header("Location: index.php");
	}
}
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
	<div class="container">
		<div class="span10 offset1">
			<div class="row">
				<h3>Submit a question</h3>
			</div>

			<form class="form-horizontal" action="submitQuestion.php" method="post">

				<div class="control-group <?php echo !empty($titleError) ? 'error' : ''; ?>">
					<label class="control-label">Question title</label>
					<div class="controls">
						<input name="title" type="text" placeholder="Question" value="<?php echo !empty($title) ? $title : ''; ?>">
						<?php if (($titleError != null)) ?>
						<span class="help-inline"><?php echo $titleError; ?></span>
					</div>
				</div>

				<div class="control-group <?php echo !empty($contentError) ? 'error' : ''; ?>">
					<label class="control-label">Description</label>
					<div class="controls">
						<input name="content" type="text" placeholder="Description of your question" value="<?php echo !empty($content) ? $content : ''; ?>">
						<?php if (($contentError != null)) ?>
						<span class="help-inline"><?php echo $contentError; ?></span>
					</div>
				</div>

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Submit</button>
					<a class="btn" href="index.php">Go back</a>
				</div>

			</form>
		</div>
	</div> <!-- /container -->
</body>

</html>