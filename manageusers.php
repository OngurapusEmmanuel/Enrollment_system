

<?php
    require_once("includes/db.php");

    // Check if the connection is established
    if ($con) {
        $x = 1;

        // Prepare the statement to select data from the 'exhibits' table
        $stmt = $con->prepare("
            SELECT Id,Firstname,Lastname,Email,`Phone Number`,Role,Status 
            FROM users
        ");

        // Execute the statement
        $stmt->execute();

        // Bind the results to variables
        $stmt->bind_result($Id,$firstname, $lastname, $email, $phone, $role, $status);

        // Fetch the data and display it in the table
        while ($stmt->fetch()) {
            echo "
            <tr>
                <td>{$Id}</td>
                <td>{$firstname}</td>
                <td>{$lastname}</td>
                <td>{$email}</td>
                <td>{$phone}</td>
                <td>{$role}</td>
                <td>{$status}</td>
                <td>
                     <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal">Edit</button>
                      <button class="btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
            ";
            $x++;
        }
    }
        ?>
        <?php

if ($_SERVER["REQUEST_METHOD"]==="POST") {
    $firstname=($_POST["firstname"]);
    $lastname=($_POST["lastname"]);
    $phone=($_POST["phoneNumber"]);
    $role=($_POST["userRole"]);
    $status=($_POST["userStatus"]);
	$email = ($_POST["userEmail"]);
	$password = ($_POST["password"]);
	require_once "includes/config.php";
	$con;
	
    // Insert data into database
$stmt = $con->prepare("UPDATE users SET `Firstname`= ?, `Lastname`= ? , `Email`= ? , `Phone Number` = ? `Role`=? `Status`=? WHERE `Firstname`= ? AND `Lastname`=? ");VALUES (' '$firstname', '$lastname', '$email','$phone','$role','$status')";

$stmt->bind_param('ssssss',$email, $phone, $role, $status,$firstname,$lastname);

if ($conn->query($sql) === TRUE) {
    echo "<script>
    alert('Infor updated successfully!');
    window.location.href = 'admin-dashboard.php'; 
</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$con->close();
}
?>
 <?php if(isset($_GET['id'])) ?>
           <?php
                require_once("includes/config.php");
                $con;
                if ($con) {
                    $stmt = $con->prepare("
                    SELECT Firstname,Lastname,Email,`Phone Number`,Role,Status
                    FROM exhibits WHERE Id=?");
                    $stmt->bind_param('i', $_GET['id']);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($firstname,$lastname, $email,$phone,$role,$status);
                    while ($stmt->fetch()) {
                        $firstname=$firstname;
                        $lastname = $lastname;
                        $email = $email;
                        $phone =$phone;
                    }
                }
            }
            ?>