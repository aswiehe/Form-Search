<!-- Avery Wiehe -->

<?php

//Include the
include('config.php');

// Include the file containing functions (functions.php)
include('functions.php');
// Get search term if provided otherwise use an empty string to return all results
$term = '';
// If form submitted set term
if($_SERVER['REQUEST_METHOD'] == 'GET') {
	if(isset($_GET['search-term'])) {
		$term = $_GET['search-term'];
	/*
		put searchBooks($term, $database); here instead of outside next closing brackets if you only want the list of
		all books after search button is pressed without a search term being put in. I left the call for searchBooks
		where it is, because a user might not immediately no putting in an empty String would return all results. Also
		wasn't exactly sure about which way instructions asked for, but wanted to show I know how to make either way work.
	*/
	}
}
// Call the searchBooks function passing the search term to the function and set the results to a variable called $books
	$searchResults = searchBooks($term, $database);
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<title>Search Books</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="page">
		<h1>Books</h1>
		<form method="GET">
			<input type="text" name="search-term" placeholder="Search..." />
			<input type="submit" />
		</form>
		<br><br><hr><br><br>

		<?php // - Loop over the results of $books and print the title and price. ?>
		<?php foreach($searchResults as $searchResult) : ?>
			<p>
				<?php echo $searchResult['title'] ?>
				&nbsp; - &nbsp;
				<?php echo $searchResult['price'] ?>
			</p>
			<br>
		<?php endforeach ?>

	</div>
</body>
</html>
