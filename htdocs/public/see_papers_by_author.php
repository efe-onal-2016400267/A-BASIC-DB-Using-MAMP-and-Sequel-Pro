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

    $sql = "SELECT p1.title 
    FROM paper_author AS p1
    WHERE author_firstname = :firstname AND author_lastname = :lastname" ;

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $statement->bindParam(':lastname', $lastname, PDO::PARAM_STR);
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
    > No results found for <?php echo escape($_POST['firstname']); ?>.
  <?php }
} ?>

<h2>Find papers of an author.</h2>

<form method="post">
  <label for="firstname">First Name</label>
  <input type="text" id="firstname" name="firstname">
  <label for="lastname">Last Name</label>
  <input type="text" id="lastname" name="lastname">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>
<a href="user.php">Back to user page</a>

<?php require "templates/footer.php"; ?>