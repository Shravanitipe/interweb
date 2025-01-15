<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "interweb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Create
if (isset($_POST['create'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $sql = "INSERT INTO tasks (title, description) VALUES ('$title', '$description')";
    $conn->query($sql);
}

// Handle Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $sql = "UPDATE tasks SET title='$title', description='$description' WHERE id=$id";
    $conn->query($sql);
}

// Handle Delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM tasks WHERE id=$id";
    $conn->query($sql);
}

// Fetch all tasks
$tasks = $conn->query("SELECT * FROM tasks");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 5px;
            margin-right: 10px;
        }
        button {
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <h1>CRUD Application</h1>

    <!-- Create Form -->
    <form method="POST">
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="description" placeholder="Description">
        <button type="submit" name="create">Create</button>
    </form>

    <!-- Task Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $tasks->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td>
                        <form method="POST" style="display: inline-block;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="text" name="title" value="<?= $row['title'] ?>" required>
                            <input type="text" name="description" value="<?= $row['description'] ?>">
                            <button type="submit" name="update">Update</button>
                        </form>
                        <form method="POST" style="display: inline-block;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
