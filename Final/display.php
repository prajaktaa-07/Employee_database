<?php
$connect = new mysqli('localhost', 'root', '', 'employeedatabase');
if ($connect->connect_error) {
    die("Connection Failed: " . $connect->connect_error);
}

/*$query = "DELETE FROM attendance";
$result = $connect->query($query);
if ($result === true) {
    echo "All records deleted successfully.";
} else {
    echo "Error deleting records: " . $connect->error;
}
*/

$query = "SELECT * FROM attendance";
$result = $connect->query($query);

if ($result === false) {
    echo "Error executing query: " . $connect->error;
} else {
    if ($result->num_rows > 0) {
        echo "<table border='1'>
        <tr>
            <th>Employee_id</th>
            <th>Attendance_date</th>
            <th>Attendance_status</th>
        </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row['employee_id'] . "</td>
                <td>" . $row['attendance_date'] . "</td>
                <td>" . $row['attendance_status'] . "</td>
                <td>
                    <a href='update.php?attendance_date=" . $row['attendance_date'] . "'>Update</a>
                <td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "No records found";
    }
}
$connect->close();
?>
