<?php

/**
 * Use an HTML form to create a new entry in the
 * students table.
 *
 */

require "config.php";
require "common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $new_student = array(
      "firstname" => $_POST['firstname'],
      "lastname"  => $_POST['lastname'],
      "coursename" => $_POST['coursename'],
      "regno"       => $_POST['regno'],
      "units"  => $_POST['units'],
      "gpa"  => $_POST['gpa']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "students",
      implode(", ", array_keys($new_student)),
      ":" . implode(", :", array_keys($new_student))
    );

    $statement = $connection->prepare($sql);
    $statement->execute($new_student);
  } catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
<blockquote><?php echo escape($_POST['firstname']); ?> successfully added.</blockquote>
<?php endif; ?>

<h2>Add a student</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">

    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname">

    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname">

    <label for="regno">Registration Number</label>
    <input type="text" name="regno" id="regno">

    <label for="coursename">Course name</label>
    <input type="text" name="coursename" id="coursename">

    <label for="units"> Number of units </label>
    <input type="text" name="units" id="units">

    <label for="gpa"> GPA Score </label>
    <input type="text" name="gpa" id="gpa">
    <br>
    <br>

    <input type="submit" name="submit" value="Submit">
</form>

<br>
<a href="index.php"> Back to home </a>

<?php require "templates/footer.php"; ?>