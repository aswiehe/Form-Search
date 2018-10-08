<?php
include('config.php');

// Get type of form either add or edit
$action = $_GET['action'];

// Get an associative array of categories
$sql = file_get_contents('sql/getCategories.sql');
$statement = $database->prepare($sql);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

// If form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$isbn = $_POST['isbn'];
	$title = $_POST['book-title'];
	$book_categories = $_POST['book-category'];
	$author = $_POST['book-author'];
	$price = $_POST['book-price'];

	if($action == 'add') {
		// Insert book
		$sql = file_get_contents('sql/insertBook.sql');
		$params = array(
			'isbn' => $isbn,
			'title' => $title,
			'author' => $author,
			'price' => $price
		);

		$statement = $database->prepare($sql);
		$statement->execute($params);

		// Set categories for book
		$sql = file_get_contents('sql/insertBookCategory.sql');
		$statement = $database->prepare($sql);

		foreach($book_categories as $category) {
			$params = array(
				'isbn' => $isbn,
				'categoryid' => $category
			);
			$statement->execute($params);
		}
	}

	elseif ($action == 'edit') {

	}

	// Redirect to book listing page
	header('location: index.php');
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">

  	<title>Add New Book</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1>Add New Book</h1>
		<form action="" method="POST">
			<div class="form-element">
				<label>ISBN:</label>
				<input type="text" name="isbn" class="textbox" />
			</div>
			<div class="form-element">
				<label>Title:</label>
				<input type="text" name="book-title" class="textbox" />
			</div>
			<div class="form-element">
				<label>Category:</label>
				<?php foreach($categories as $category) : ?>
					<input class="radio" type="checkbox" name="book-category[]" value="<?php echo $category['categoryid'] ?>" /><span class="radio-label"><?php echo $category['name'] ?></span><br />
				<?php endforeach; ?>
			</div>
			<div class="form-element">
				<label>Author</label>
				<input type="text" name="book-author" class="textbox" />
			</div>
			<div class="form-element">
				<label>Price:</label>
				<input type="number" step="any" name="book-price" class="textbox" />
			</div>
			<div class="form-element">
				<input type="submit" class="button" />&nbsp;
				<input type="reset" class="button" />
			</div>
		</form>
	</div>
</body>
</html>
