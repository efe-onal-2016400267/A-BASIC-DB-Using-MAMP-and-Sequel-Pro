<?php
if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";
    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_author = array(
            ":topic_name" => $_POST['topic_name'],
            ":SOTAresult"  => $_POST['SOTAresult'],
        );
        $sql = "INSERT INTO topics (topic_name, SOTAresult) values (:topic_name, :SOTAresult)";
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_author);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php include "templates/header.php"; ?>
<?php if (isset($_POST['submit']) && $statement) { ?>
  <?php echo escape($_POST['topic_name']); ?> successfully added.
<?php } ?>
<h2>Add a Topic</h2>

    <form method="post">
    	<label for="topic_name">Topic Name</label>
    	<input type="text" name="topic_name" id="topic_name">
    	<label for="SOTAresult">SOTA Result</label>
    	<input type="text" name="SOTAresult" id="SOTAresult">
    	<input type="submit" name="submit" value="Submit">
    </form>

    <a href="index.php">Back to home</a>
    <a href="admin.php">Back to admin page</a>
    <?php include "templates/footer.php"; ?>