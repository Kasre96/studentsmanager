<?php

/**
 * List all students with a link to edit
 */

require "config.php";
require "common.php";

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

<h2>Update Students</h2>

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
            <th>Edit</th>
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
                <td><a href="update-single.php?id=<?php echo escape($row["id"]); ?>"> Edit </a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br>
<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>