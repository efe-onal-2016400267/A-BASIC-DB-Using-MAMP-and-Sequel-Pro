<?php

/**
  * List all users with a link to edit
  */

try {
  require "../config.php";
  require "../common.php";

  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM topics";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();

} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php include "templates/header.php"; ?>
 <h2>Update a Topic</h2>
 <table>
  <thead>
    <tr>
      <th>#</th>
      <th>Topic Name</th>
      <th>SOTA Result</th>
      <th>Edit</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["id"]); ?></td>
      <td><?php echo escape($row["topic_name"]); ?></td>
      <td><?php echo escape($row["SOTAresult"]); ?></td>
      <td><a href="update-single-topic.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>
    

    <a href="index.php">Back to home</a>
    <a href="admin.php">Back to admin page</a>

<?php include "templates/footer.php"; ?>