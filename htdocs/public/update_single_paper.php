<?php
/**
  * Use an HTML form to edit an entry in the
  * users table.
  *
  */
require "../config.php";
require "../common.php";
if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $topic =[
      ":id"        => $_POST['id'],
      ":title" => $_POST['title'],
      ":abstract" => $_POST['abstract'],
      ":SOTAresult"  => $_POST['SOTAresult'],
    ];

    $id = $_POST['id'];

    $title1 = $_POST['title'];
    $authorme=[
      ":id" => $_POST['id'],
      ":title" => $_POST['title']];

    $sql1 = "UPDATE paper_author
              SET paper_author.title = :title
              WHERE paper_author.title IN(
              SELECT p.title FROM papers AS p WHERE p.id = :id)";
    $statement1 = $connection->prepare($sql1);
  $statement1->execute($authorme);
   $sql2 = "UPDATE topic_paper
              SET topic_paper.title = :title
              WHERE topic_paper.title IN(
              SELECT p.title FROM papers AS p WHERE p.id = :id)";
    $statement2 = $connection->prepare($sql2);
  $statement2->execute($authorme);
  
    $sql = "UPDATE papers
            SET id = :id,
              title = :title,
              abstract = :abstract,
              SOTAresult = :SOTAresult
            WHERE id = :id";
  $statement = $connection->prepare($sql);
  $statement->execute($topic);


  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];
    $sql = "SELECT * FROM papers WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}




?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
  <?php echo escape($_POST['title']); ?> successfully updated.
<?php endif; ?>

<h2>Edit a Paper</h2>

<form method="post">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
      <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>
<a href="admin.php">Back to admin page</a>
<?php require "templates/footer.php"; ?>