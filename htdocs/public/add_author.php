<?php
if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";
    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_author = array(
            "firstname" => $_POST['firstname'],
            "lastname"  => $_POST['lastname'],
        );
        $sql = "INSERT INTO authors (firstname, lastname) values (:firstname, :lastname)";
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_author);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php include "templates/header.php"; ?>
<?php if (isset($_POST['submit']) && $statement) { ?>
  <?php echo escape($_POST['firstname']); ?> successfully added.
<?php } ?>
<h2>Add an Author</h2>

    <form method="post">
    	<label for="firstname">First Name</label>
    	<input type="text" name="firstname" id="firstname">
    	<label for="lastname">Last Name</label>
    	<input type="text" name="lastname" id="lastname">
    	<input type="submit" name="submit" value="Submit">
    </form>

    <a href="index.php">Back to home</a>
    <a href="admin.php">Back to admin page</a>
    <?php include "templates/footer.php"; ?>