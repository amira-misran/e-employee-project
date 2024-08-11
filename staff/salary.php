<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php
$sid = intval($_GET['salaryid']);
?>

<body>

    <?php include('includes/navbar.php')?>
    <?php include('includes/right_sidebar.php')?>
    <?php include('includes/left_sidebar.php')?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Monthly Salary</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Monthly Schedule</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h2 class="text-blue h4">MONTHLY SALARY</h2>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">DATE</th>
                                <th class="datatable-nosort">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT s.id as sid, s.entry_time 
                                        FROM tblsalary s
                                        LEFT JOIN tblemployees e ON s.employee_id = e.Staff_ID
                                        WHERE emp_id = '$session_id'
                                        ORDER BY s.id DESC";
                                $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                    <tr>
                                        <td class="table-plus">
                                            <div class="name-avatar d-flex align-items-center">
                                                <div class="txt">
                                                    <div class="weight-600"><?php echo $row['entry_time']; ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="table-actions">
                                                <a title="View Payslip" href="view_payslip.php?salaryid=<?php echo $row['sid']; ?>" target="_blank">
                                                    <i class="dw dw-eye" data-color="#265ed7"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->

    <script src="../vendors/scripts/core.js"></script>
    <script src="../vendors/scripts/script.min.js"></script>
    <script src="../vendors/scripts/process.js"></script>
    <script src="../vendors/scripts/layout-settings.js"></script>
    <script src="../src/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

    <!-- buttons for Export datatable -->
    <script src="../src/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="../src/plugins/datatables/js/vfs_fonts.js"></script>

    <script src="../vendors/scripts/datatable-setting.js"></script>
</body>
</html>
