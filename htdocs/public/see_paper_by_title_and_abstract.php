<?php

/**
  * Function to query information based on
  * a parameter: in this case, location.
  *
  */

if (isset($_POST['submit'])) {
  try {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);
      $searchword = $_POST['searchword'];
    $sql = "SELECT p1.title 
    FROM papers AS p1
    WHERE p1.title LIKE '%$searchword%' OR p1.abstract LIKE '%$searchword%'" ;

  


    $statement = $connection->prepare($sql);
    $statement->bindParam('%:searchword%', $searchword, PDO::PARAM_STR);

    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table>
      <thead>
<tr>
  <th>Title</th>
</tr>
      </thead>
      <tbody>
  <?php foreach ($result as $row) { ?>
      <tr>
<td><?php echo escape($row["title"]); ?></td>

      </tr>
    <?php } ?>
      </tbody>
  </table>
  <?php } else { ?>
    > No results found for <?php echo escape($_POST['searchword']); ?>.
  <?php }
} ?>

<h2>Find papers by keyword.</h2>

<form method="post">
  <label for="searchword">Search</label>
  <input type="text" id="searchword" name="searchword">

  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>
<a href="user.php">Back to user page</a>

<?php require "templates/footer.php"; ?>