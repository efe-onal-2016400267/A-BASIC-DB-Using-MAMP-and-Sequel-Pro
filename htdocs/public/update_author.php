<?php

/**
  * List all users with a link to edit
  */

try {
  require "../config.php";
  require "../common.php";

  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM authors";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();

} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php include "templates/header.php"; ?>
 <h2>Update an Author</h2>
 <table>
  <thead>
    <tr>
      <th>#</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Edit</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["id"]); ?></td>
      <td><?php echo escape($row["firstname"]); ?></td>
      <td><?php echo escape($row["lastname"]); ?></td>
      <td><a href="update-single-author.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>
    

    <a href="index.php">Back to home</a>
    <a href="admin.php">Back to admin page</a>
<?php include "templates/footer.php"; ?>