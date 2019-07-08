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
    FROM topic_paper AS p1
    WHERE topic_name = :topic_name";

    $topic_name = $_POST['topic_name'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':topic_name', $topic_name, PDO::PARAM_STR);
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
    > No results found for <?php echo escape($_POST['topic_name']); ?>.
  <?php }
} ?>

<h2>Find user based on location</h2>

<form method="post">
  <label for="topic_name">Topic Name</label>
  <input type="text" id="topic_name" name="topic_name">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>
<a href="user.php">Back to user page</a>
<?php require "templates/footer.php"; ?>