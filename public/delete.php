<?php

/**
 * Delete a user
 */

require "config.php";
require "common.php";

$success = null;

if (isset($_POST["submit"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $id = $_POST["submit"];

    $sql = "DELETE FROM students WHERE id = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $success = "Student successfully deleted";
  } catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM students";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch (PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Delete students</h2>

<?php if ($success) echo $success; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
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
        <th>Delete</th>
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
          <td><button type="submit" name="submit" value="<?php echo escape($row["id"]); ?>">Delete</button></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</form>

<br>
<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>