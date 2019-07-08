
<?php
require "../config.php";
require "../common.php";
/**
  * List all users with a link to edit
  */

try {
  

  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM papers";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
  $papers_array = array();
  foreach ($result as $paper) {
    $authorStatement = "SELECT a.author_firstname, a.author_lastname FROM paper_author AS a WHERE a.title = '".$paper['title']."' ";
    $topicStatement = "SELECT t.topic_name FROM topic_paper AS t WHERE t.title = '".$paper['title']."'  ";

    $statement1 = $connection->prepare($authorStatement);
    $statement1->execute();
    $authors_of_paper = $statement1->fetchAll();

    $statement2 = $connection->prepare($topicStatement);
    $statement2->execute();
    $topics_of_paper = $statement2->fetchAll();

    $authors = "";
    foreach ($authors_of_paper as $row) {
      $authors = $authors.$row['author_firstname']." ".$row['author_lastname'].",";
    }
    $authors = rtrim($authors,',');
    $paper['authors'] = $authors;
    $paper[5] = $authors;

    $topics = "";
    foreach ($topics_of_paper as $row1) {
      $topics = $topics.$row1['topic_name'].",";
    }
    $topics = rtrim($topics,',');
    $paper['topics'] = $topics;
    $paper[6] = $topics;

    array_push($papers_array, $paper); 

  }
  
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php include "templates/header.php"; ?>
 <h2>List of all papers</h2>
 <table>
  <thead>
    <tr>
      <th>#</th>
      <th>Title</th>
      <th>Abstract</th>
      <th>SOTA Result</th>
      <th>Authors</th>
      <th>Topics</th>
      <th>Edit</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($papers_array as $row) : ?>
    <tr>
      <td><?php echo escape($row["id"]); ?></td>
      <td><?php echo escape($row["title"]); ?></td>
      <td><?php echo escape($row["abstract"]); ?></td>
      <td><?php echo escape($row["SOTAresult"]); ?></td>
      <td><?php echo escape($row["authors"]); ?></td>
      <td><?php echo escape($row["topics"]); ?></td>
      <td><a href="update_single_paper.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>
    

    <a href="index.php">Back to home</a>
    <a href="admin.php">Back to admin page</a>

<?php include "templates/footer.php"; ?>