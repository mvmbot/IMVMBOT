<?php

include("config.php");

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully\n";

echo "HOLA SOY THE CHAMP";

$id = 1;

$sql = "SELECT * FROM admin WHERE id_admin=?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo $row['id_admin'];
    echo $row['username_admin'];
    echo $row['email_admin'];
    echo $row['password_admin'];
}

// "is" means that $id is bound as an integer and $label as a string

?>