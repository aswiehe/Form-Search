<!-- Avery Wiehe -->

<?php

function searchBooks($term, $database) {
  $searchResults = array();
  if(empty($term)) {
    $sql = file_get_contents('sql/getBooks.sql');
    $statement = $database->prepare($sql);
    $statement->execute();
    $searchResults = $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  else {
    $term = $term.'%';
    $sql = file_get_contents('sql/searchBooks.sql');
    $params = array(
			'title' => $term
		);
    $statement = $database->prepare($sql);
		$statement->execute($params);
    $searchResults = $statement->fetchAll(PDO::FETCH_ASSOC);
  }
	// Return a list of books based upon the search term from the database
  return $searchResults;
}
