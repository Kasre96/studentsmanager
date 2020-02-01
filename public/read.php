<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */

require "config.php";
require "common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * 
            FROM students
            WHERE regno = :regno";

    $regno = $_POST['regno'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':regno', $regno, PDO::PARAM_STR);
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
    <h2> Fetched Student </h2>

    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Registration Number</th>
          <th>Course Name</th>
          <th>No. of units</th>
          <th>GPA Score</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["firstname"]); ?></td>
          <td><?php echo escape($row["lastname"]); ?></td>
          <td><?php echo escape($row["regno"]); ?></td>
          <td><?php echo escape($row["coursename"]); ?></td>
          <td><?php echo escape($row["units"]); ?></td>
          <td><?php echo escape($row["gpa"]); ?> </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['regno']); ?>.</blockquote>
    <?php } 
} ?> 

<h2> Find a student by registration number </h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">

  <label for="regno"> Registration Number </label>
  <input type="text" id="regno" name="regno">
  <br>
  <br>

  <input type="submit" name="submit" value="FIND">
</form>

<br>
<a href="index.php"> Back to home </a>

<?php require "templates/footer.php"; ?>