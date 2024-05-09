<?php
if(isset($_POST['employee_id'], $_POST['attendance_date'], $_POST['attendance_status'])) 
{
    $employee_id = $_POST['employee_id'];
    $attendance_date = $_POST['attendance_date'];
    $attendance_status = $_POST['attendance_status'];

    $connect = new mysqli('localhost', 'root', '', 'employeedatabase');
    if ($connect->connect_error) 
    {
        die("Connection Failed: " . $connect->connect_error);
    } 
    else 
    {
        // Check if the employee ID exists in the database
        $check_employee = $connect->query("SELECT * FROM attendance WHERE employee_id='$employee_id'");
        if ($check_employee->num_rows == 0) 
        {
            echo "\n";
        } 
        
            // Insert attendance record
            $insert = $connect->query("INSERT INTO attendance (employee_id, attendance_date, attendance_status) VALUES ('$employee_id', '$attendance_date', '$attendance_status')");

            if ($insert)
            {
                echo "Record inserted successfully.\n";
                
            } 
            else {
                echo "Error: " . $connect->error;
            }
    }

    $connect->close();
}

else{
    echo "Something is missing in submission form.";
}
?>
