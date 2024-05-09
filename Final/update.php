<?php
if(isset($_GET['attendance_date']) && !empty($_GET['attendance_date'])) {
    $attendance_date = $_GET['attendance_date'];

    // Check if attendance date is not empty
    if($attendance_date !== '') {
        if(isset($_POST['submit'])) {
            $attendance_status = $_POST['attendance_status'];

            $connect = new mysqli('localhost', 'root', '', 'employeedatabase');
            if ($connect->connect_error) {
                die("Connection Failed: " . $connect->connect_error);
            } else {
                $update = $connect->query("UPDATE attendance SET attendance_status='$attendance_status' WHERE attendance_date='$attendance_date'");

                if ($update) {
                    echo "Records updated successfully.";
                } else {
                    echo "Error updating records: " . $connect->error;
                }
            }

            $connect->close();
        } else {
            $connect = new mysqli('localhost', 'root', '', 'employeedatabase');
            if ($connect->connect_error) {
                die("Connection Failed: " . $connect->connect_error);
            } else {
                $query = $connect->query("SELECT * FROM attendance WHERE attendance_date='$attendance_date'");
                
                // Check if the query returned any results
                if ($query && $query->num_rows > 0) {
                    $row = $query->fetch_assoc();
?>
                    <form method="post">
                        <label for="attendance_status">Attendance Status:</label>
                        <select id="attendance_status" name="attendance_status" required>
                            <option value="Present" <?php if($row['attendance_status'] == 'Present') echo 'selected'; ?>>Present</option>
                            <option value="Absent" <?php if($row['attendance_status'] == 'Absent') echo 'selected'; ?>>Absent</option>
                        </select><br><br>
                        <input type="submit" name="submit" value="Update">
                    </form>
<?php
                } else {
                    echo "No record found with the provided date.";
                }
            }
            $connect->close();
        }
    } else {
        echo "Attendance date is empty.";
    }
} else {
    echo "Attendance date not provided.";
}
?>

<?php
$connect = new mysqli('localhost', 'root', '', 'employeedatabase');
if ($connect->connect_error) {
    die("Connection Failed: " . $connect->connect_error);
}

$query = "SELECT * FROM attendance";
$result = $connect->query($query);

if ($result === false) {
    echo "Error executing query: " . $connect->error;
} else {
    if ($result->num_rows > 0) {
        //echo "<Attendance_status Table>"
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
                    <a href='update.php?employee_id=" . $row['employee_id'] . "'></a>
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
