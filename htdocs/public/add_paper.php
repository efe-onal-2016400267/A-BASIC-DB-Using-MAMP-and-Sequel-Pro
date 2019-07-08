<?php
if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";
    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        $string_arr1 = explode(", ", $_POST['auth_names']);
        for($i = 0; $i < count($string_arr1); $i++){
                $fullname = explode(" ", $string_arr1[$i]);
                $my_first_name = $fullname[0];
                $my_last_name = $fullname[1];
                $new_paper_author = array(
            ":author_firstname" => $my_first_name,
            ":author_lastname" => $my_last_name,
            ":title" => $_POST['title']
        );
                $sql = "INSERT INTO paper_author (author_firstname, author_lastname, title) values (:author_firstname, :author_lastname, :title)";
                $statement = $connection->prepare($sql);
                $statement->execute($new_paper_author);
        }

        $string_arr2 = explode(", ", $_POST['topics']);
        for($i = 0; $i < count($string_arr2); $i++){
            $new_paper_topic = array(
            ":topic_name" => $string_arr2[$i],
            ":title" => $_POST['title']
          );  
            $sql2 = "INSERT INTO topic_paper(
                topic_name, title) values (:topic_name, :title)";
            $statement1 = $connection->prepare($sql2);
            $statement1->execute($new_paper_topic);
        }  

        $new_paper = array(
            ":title" => $_POST['title'],
            ":abstract" => $_POST['abstract'],
            ":SOTAresult" => $_POST['SOTAresult']
        );
        $sql3 = "INSERT INTO papers(title, abstract, SOTAresult) values (:title, :abstract, :SOTAresult)"; 
        $statement2 = $connection->prepare($sql3);
        $statement2->execute($new_paper);  
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php include "templates/header.php"; ?>
<?php if (isset($_POST['submit']) && $statement) { ?>
  <?php echo escape($_POST['title']); ?> successfully added.
<?php } ?>
<h2>Add a Paper</h2>

    <form method="post">
    	<label for="auth_names">Author Names</label>
    	<input type="text" name="auth_names" id="auth_names">
    	<label for="title">Title</label>
    	<input type="text" name="title" id="title">
        <label for="abstract">Abstract</label>
        <input type="text" name="abstract" id="abstract">
        <label for="topics">Topics</label>
        <input type="text" name="topics" id="toipcs">
        <label for="SOTAresult">SOTA Result</label>
        <input type="text" name="SOTAresult" id="SOTAresult">
    	<input type="submit" name="submit" value="Submit">
    </form>

    <a href="index.php">Back to home</a>
    <a href="admin.php">Back to admin page</a>

    <?php include "templates/footer.php"; ?>