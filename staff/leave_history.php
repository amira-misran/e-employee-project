<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php
if (isset($_GET['delete'])) {
    $delete = intval($_GET['delete']); // Ensuring that $delete is an integer to prevent SQL injection

    // Fetch the leave details to get the requested days
    $fetch_leave_query = "SELECT * FROM tblleave WHERE id = ?";
    $stmt_fetch_leave = $conn->prepare($fetch_leave_query);
    $stmt_fetch_leave->bind_param("i", $delete);
    $stmt_fetch_leave->execute();
    $leave_result = $stmt_fetch_leave->get_result();

    if ($leave_result->num_rows > 0) {
        $leave_data = $leave_result->fetch_assoc();
        $requested_days = $leave_data['RequestedDays'];
        $emp_id = $leave_data['empid'];

        // Fetch employee's current available leave days
        $fetch_employee_query = "SELECT * FROM tblemployees WHERE emp_id = ?";
        $stmt_fetch_employee = $conn->prepare($fetch_employee_query);
        $stmt_fetch_employee->bind_param("i", $emp_id);
        $stmt_fetch_employee->execute();
        $employee_result = $stmt_fetch_employee->get_result();

        if ($employee_result->num_rows > 0) {
            $employee_data = $employee_result->fetch_assoc();
            $current_av_leave = $employee_data['Av_leave'];

            // Calculate new available leave days after deleting the leave application
            $new_av_leave = $current_av_leave + $requested_days;

            // Update the employee's available leave days in the tblemployees table
            $update_employee_query = "UPDATE tblemployees SET Av_leave = ? WHERE emp_id = ?";
            $stmt_update_employee = $conn->prepare($update_employee_query);
            $stmt_update_employee->bind_param("ii", $new_av_leave, $emp_id);
            $stmt_update_employee->execute();

            // Delete the leave application from tblleave
            $delete_query = "DELETE FROM tblleave WHERE id = ?";
            $stmt_delete_leave = $conn->prepare($delete_query);
            $stmt_delete_leave->bind_param("i", $delete);
            $delete_result = $stmt_delete_leave->execute();

            if ($delete_result) {
                echo "<script>alert('Your leave application deleted Successfully');</script>";
                echo "<script type='text/javascript'> document.location = 'leave_history.php'; </script>";
            } else {
                echo "<script>alert('Error deleting record.');</script>";
            }
        } else {
            echo "<script>alert('Error fetching employee details.');</script>";
        }
    } else {
        echo "<script>alert('Leave application not found.');</script>";
    }

    // Close prepared statements
    $stmt_fetch_leave->close();
    $stmt_fetch_employee->close();
    $stmt_update_employee->close();
    $stmt_delete_leave->close();
}
?>

<body>
    <?php include('includes/navbar.php')?>

    <?php include('includes/right_sidebar.php')?>

    <?php include('includes/left_sidebar.php')?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20">
            

            <div class="card-box mb-30">
                <div class="pd-20">
                        <h2 class="text-blue h4">ALL MY LEAVE</h2>
                    </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus">LEAVE TYPE</th>
                                <th>DATE FROM</th>
                                <th>DATE TO</th>
                                <th>NO. OF DAYS</th>
                                <th>HR STATUS</th>
                                <th>OM STATUS</th>
                                <th class="datatable-nosort">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sql = "SELECT * from tblleave where empid = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $session_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $cnt = 1;
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlentities($row['LeaveType']);?></td>
                                    <td><?php echo htmlentities($row['FromDate']);?></td>
                                    <td><?php echo htmlentities($row['ToDate']);?></td>
                                    <td><?php echo htmlentities($row['num_days']);?></td>
                                    <td><?php 
                                        $hr_status = $row['HRRemarks'];
                                        if($hr_status == 1) {
                                            echo '<span style="color: green">Approved</span>';
                                        } elseif($hr_status == 2) {
                                            echo '<span style="color: red">Not Approved</span>';
                                        } else {
                                            echo '<span style="color: blue">Pending</span>';
                                        }
                                    ?></td>
                                    <td><?php 
                                        $om_status = $row['OMRemarks'];
                                        if($om_status == 1) {
                                            echo '<span style="color: green">Approved</span>';
                                        } elseif($om_status == 2) {
                                            echo '<span style="color: red">Not Approved</span>';
                                        } else {
                                            echo '<span style="color: blue">Pending</span>';
                                        }
                                    ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                <i class="dw dw-more"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                <a class="dropdown-item" href="view_leaves.php?edit=<?php echo htmlentities($row['id']);?>" ><i class="icon-copy dw dw-eye"></i>View Details</a>
                                                <a class="dropdown-item" href="leave_history.php?delete=<?php echo htmlentities($row['id']);?>"><i class="dw dw-delete-3"></i>Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $cnt++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
               </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->

    <?php include('includes/scripts.php')?>
</body>
</html>
