<?php 
    // initialize errors variable
	$errors = "";

	// connect to database
	$db = mysqli_connect("localhost", "mamp", "root", "todo");

	if (mysqli_connect_errno()) {
		echo "Not connected, error: " . mysqli_connect_error();

	}

	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {

		if (empty($_POST['task'])) {
			$errors = "You must fill in the task";
		} else{
			$task = $_POST['task'];
			$sql = "INSERT INTO `tasks`(`task`) VALUES ('$task')";
			echo 'sql: ' . $sql;

			$result = mysqli_query($db, $sql);
			
		//	var_dump($result);
			//  echo 'result: ' . $result;
			//echo(mysqli_error($db));
		//	 die;

			header('location: index.php');
		}
    }

    
    if (isset($_GET['del_task'])) {
        $id = $_GET['del_task'];
    
        mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);
        header('location: index.php');
    }
    ?>

<!DOCTYPE html>
<html>
<head>
    <title>To do list</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="heading">
		<h2>Toe-de-loe list</h2>
	</div>
    <form method="post" action="index.php" class="input_form">
    <?php if (isset($errors)) { ?>
        <p><?php echo $errors; ?></p>
    <?php } ?>
		<input type="text" name="task" class="task_input">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
    </form>
        <table>
	        <thead>
		        <tr>
			    <th></th>
			    <th>Tasks</th>
			    <th id="action">Action</th>
		    </tr>
	    </thead>

	    <tbody>
		    <?php 
		    // select all tasks if page is visited or refreshed
		    $tasks = mysqli_query($db, "SELECT * FROM tasks");

		    $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
			    <tr>
				    <td> <?php echo $i; ?> </td>
				        <td class="task"> <?php echo $row['task']; ?> </td>
				        <td class="delete"> 
					    <a href="index.php?del_task=<?php echo $row['id'] ?>">x</a> 
				    </td>
			    </tr>
		    <?php $i++; } ?>	
	    </tbody>
    </table>
    </body>
</html>
