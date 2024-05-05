<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "academic_records";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to calculate the number of days until the due date
function daysUntilDueDate($dueDate) {
    $today = new DateTime();
    $dueDateTime = new DateTime($dueDate);
    $interval = $today->diff($dueDateTime);
    return $interval->days;
}

// Fetch tasks from the database
$sql = "SELECT * FROM todolist";
$task_result = $conn->query($sql);

// Handle task deletion
if (isset($_POST['delete_task'])) {
    $task_id = $_POST['task_id'];
    $sql = "DELETE FROM todolist WHERE id = '$task_id'";
    $conn->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle new task submission
if (isset($_POST['add_task'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];
    $username = ''; // Add the logic to get the username from the session or other sources

    $sql = "INSERT INTO todolist (title, description, priority, due_date, username) VALUES ('$title', '$description', '$priority', '$due_date', '$username')";
    $conn->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle search
if (isset($_POST['search'])) {
    $search_term = $_POST['search'];
    $sql = "SELECT * FROM todolist WHERE title LIKE '%$search_term%' OR description LIKE '%$search_term%'";
    $task_result = $conn->query($sql);
}

// Handle updating task priority
if (isset($_POST['update_task_priority'])) {
    $task_id = $_POST['task_id'];
    $priority = $_POST['priority'];

    $sql = "UPDATE todolist SET priority = '$priority' WHERE id = '$task_id'";
    $conn->query($sql);
    exit(); // No need to redirect
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <!-- Include Sortable library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=argue_demo&display=swap">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        header {
            background-color: #AE0000;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-family: 'argue_demo';
            font-size: 32px; 
            color:white;
        }

        #search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        #search-container input[type="text"] {
            padding: 5px;
            border-radius: 3px;
            border: 1px solid #ccc;
            width: 300px;
        }

        #search-container button[type="submit"] {
            background-color: #000000;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
            margin-left: 10px;
        }

        main {
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }

        .priority-column {
            flex: 1;
            padding: 10px;
        }

        .priority-column h2 {
            text-align: center;
        }

        .task-list {
            list-style-type: none;
            padding: 0;
        }

        .task-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        button {
            background-color: #AE0000;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        button:hover {
            background-color: #555;
        }

        form {
            margin-bottom: 20px;
        }

        form input[type="text"],
        form input[type="date"],
        form select,
        form textarea {
            margin-bottom: 10px;
            padding: 5px;
            border-radius: 3px;
            border: 1px solid #ccc;
            display: block;
            width: 100%;
        }

        form button[type="submit"] {
            background-color: #AE0000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 3px;
        }

        form button[type="submit"]:hover {
            background-color: #555;
        }

        #add-task-container {
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        /* Styles for task priority based on due date */
        .priority-green {
            border: 2px solid green;
            background-color: #bee5b0;
        }

        .priority-yellow {
            border: 2px solid yellow;
            background-color: #Fdfd96;
        }

        .priority-red {
            border: 2px solid red;
            background-color: #Ff6961;
        }
    </style>
</head>
<body>
    <header>
        <h1 style="font-family: 'argue_demo'; font-size: 32px; color:white;">To-Do List</h1>
        <div id="search-container">
            <form method="post">
                <input type="text" name="search" placeholder="Search tasks...">
                <button type="submit">Search</button>
            </form>
        </div>
    </header>

    <div id="add-task-container">
        <h2>Add New Task</h2>
        <form method="post">
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <select name="priority" required>
                <option value="">Select Priority</option>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select>
            <input type="date" name="due_date" required>
            <button type="submit" name="add_task">Add Task</button>
        </form>
    </div>

    <main>
        <div class="priority-column" id="high-priority-column">
            <h2>High Priority</h2>
            <ul class="task-list high-priority" id="high-priority-tasks">
                <?php while ($row = $task_result->fetch_assoc()): ?>
                    <?php
                    $daysUntil = daysUntilDueDate($row['due_date']);
                    $priorityClass = '';
                    if ($daysUntil > 5) {
                        $priorityClass = 'priority-green';
                    } elseif ($daysUntil <= 5 && $daysUntil >= 1) {
                        $priorityClass = 'priority-yellow';
                    } else {
                        $priorityClass = 'priority-red';
                    }
                    ?>
                    <?php if ($row['priority'] === 'high'): ?>
                        <li class="task-card <?php echo $priorityClass; ?>" id="task-<?php echo $row['id']; ?>" data-priority="<?php echo $row['priority']; ?>">
                            <h3><?php echo $row['title']; ?></h3>
                            <p><?php echo $row['description']; ?></p>
                            <p>Due: <?php echo date('d/m/Y', strtotime($row['due_date'])); ?></p>
                            <form method="post">
                                <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_task">Delete</button>
                            </form>
                        </li>
                    <?php endif; ?>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="priority-column" id="medium-priority-column">
            <h2>Medium Priority</h2>
            <ul class="task-list medium-priority" id="medium-priority-tasks">
                <?php $task_result->data_seek(0); // Reset result pointer ?>
                <?php while ($row = $task_result->fetch_assoc()): ?>
                    <?php
                    $daysUntil = daysUntilDueDate($row['due_date']);
                    $priorityClass = '';
                    if ($daysUntil > 5) {
                        $priorityClass = 'priority-green';
                    } elseif ($daysUntil <= 5 && $daysUntil >= 1) {
                        $priorityClass = 'priority-yellow';
                    } else {
                        $priorityClass = 'priority-red';
                    }
                    ?>
                    <?php if ($row['priority'] === 'medium'): ?>
                        <li class="task-card <?php echo $priorityClass; ?>" id="task-<?php echo $row['id']; ?>" data-priority="<?php echo $row['priority']; ?>">
                            <h3><?php echo $row['title']; ?></h3>
                            <p><?php echo $row['description']; ?></p>
                            <p>Due: <?php echo date('d/m/Y', strtotime($row['due_date'])); ?></p>
                            <form method="post">
                                <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_task">Delete</button>
                            </form>
                        </li>
                    <?php endif; ?>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="priority-column" id="low-priority-column">
            <h2>Low Priority</h2>
            <ul class="task-list low-priority" id="low-priority-tasks">
                <?php $task_result->data_seek(0); // Reset result pointer ?>
                <?php while ($row = $task_result->fetch_assoc()): ?>
                    <?php
                    $daysUntil = daysUntilDueDate($row['due_date']);
                    $priorityClass = '';
                    if ($daysUntil > 5) {
                        $priorityClass = 'priority-green';
                    } elseif ($daysUntil <= 5 && $daysUntil >= 1) {
                        $priorityClass = 'priority-yellow';
                    } else {
                        $priorityClass = 'priority-red';
                    }
                    ?>
                    <?php if ($row['priority'] === 'low'): ?>
                        <li class="task-card <?php echo $priorityClass; ?>" id="task-<?php echo $row['id']; ?>" data-priority="<?php echo $row['priority']; ?>">
                            <h3><?php echo $row['title']; ?></h3>
                            <p><?php echo $row['description']; ?></p>
                            <p>Due: <?php echo date('d/m/Y', strtotime($row['due_date'])); ?></p>
                            <form method="post">
                                <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_task">Delete</button>
                            </form>
                        </li>
                    <?php endif; ?>
                <?php endwhile; ?>
            </ul>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lowPrioritySortable = new Sortable(document.getElementById('low-priority-tasks'), {
                group: 'tasks',
                animation: 150,
                onEnd: updateTaskPriority
            });

            const mediumPrioritySortable = new Sortable(document.getElementById('medium-priority-tasks'), {
                group: 'tasks',
                animation: 150,
                onEnd: updateTaskPriority
            });

            const highPrioritySortable = new Sortable(document.getElementById('high-priority-tasks'), {
                group: 'tasks',
                animation: 150,
                onEnd: updateTaskPriority
            });

            function updateTaskPriority(event) {
                const taskId = event.item.id.split('-')[1];
                let newPriority;

                if (event.to.id === 'low-priority-tasks') {
                    newPriority = 'low';
                } else if (event.to.id === 'medium-priority-tasks') {
                    newPriority = 'medium';
                } else if (event.to.id === 'high-priority-tasks') {
                    newPriority = 'high';
                }

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '<?php echo $_SERVER['PHP_SELF']; ?>', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        console.log('Task priority updated successfully.');
                    } else {
                        console.error('Error updating task priority.');
                    }
                };
                xhr.send(`update_task_priority=true&task_id=${taskId}&priority=${newPriority}`);
            }
        });
    </script>
</body>
</html>
