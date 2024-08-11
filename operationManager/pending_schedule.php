<!-- hr pending leave -->

<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    date_default_timezone_set('Asia/Kolkata');
    $admremarkdate = date('Y-m-d G:i:s', strtotime("now"));

    if ($status === '2') {
        $sql = "UPDATE tblschedule SET OMRemarks = '$status', OMDate = '$admremarkdate' WHERE id = '$id'"; // Removed extra comma after '$status'

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Schedule rejected successfully');</script>";
            echo "<script>window.location.href='pending_schedule.php'</script>";
        } else {
            die(mysqli_error($conn)); // Use $conn to fetch the error
        }
    } else if ($status === '1') {
        $sql = "UPDATE tblschedule SET OMRemarks = '$status', OMDate = '$admremarkdate' WHERE id = '$id'";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Schedule approved successfully');</script>";
            echo "<script>window.location.href='pending_schedule.php'</script>";
        } else {
            die(mysqli_error($conn)); // Use $conn to fetch the error
        }
    } else {
        echo "<script>alert('Error occurred');</script>";
    }
}
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
								<h4>Pending Schedule</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Pending Schedule</li>
								</ol>
							</nav>
					</div>
				</div>
			</div>

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">PENDING SCHEDULE</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">DEPT.</th>
								<th>HOD NAME</th>
								<th>FILE NAME</th>
								<th>APPLIED DATE</th>
								<th>OM STATUS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>
                                <?php
                                $status=0; 
                                $sql = "SELECT id, DepartmentShortName, HODName, folderName, PostingDate, OMRemarks FROM tblschedule WHERE OMRemarks= '$status' ORDER BY id DESC";
                                $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                while ($row = mysqli_fetch_array($query)) {
                                ?>  

								<td class="table-plus">
                                <div class="name-avatar d-flex align-items-center">
                                    <div class="txt">
                                        <div class="weight-600"><?php echo $row['DepartmentShortName'];?></div>
                                    </div>
                                </div>
								</td>
								<td><?php echo $row['HODName']; ?></td>
                                <td><?php echo $row['folderName']; ?></td>
                                <td><?php echo $row['PostingDate']; ?></td>
			
	                            <td><?php $stats=$row['OMRemarks'];
	                             if($stats==1){
	                              ?>
	                                  <span style="color: green">Approved</span>
	                                  <?php } if($stats==2)  { ?>
	                                 <span style="color: red">Rejected</span>
	                                  <?php } if($stats==0)  { ?>
	                             <span style="color: blue">Pending</span>
	                             <?php } ?>
	                            </td>
								<td>
									<div class="table-actions">
									<a title="View Details" href="../admin/folder/<?php echo urlencode($row['folderName']);?>" target="_blank">
							            <i class="dw dw-eye" data-color="#265ed7"></i>
							        </a><td>
									<button class="btn btn-primary" id="action_take_<?php echo $row['id']; ?>" data-toggle="modal" data-target="#success-modal-<?php echo $row['id']; ?>">Take&nbsp;Action</button>

							        <form name="adminaction" method="post" action="pending_schedule.php">
										<div class="modal fade" id="success-modal-<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-body text-center font-18">
														<h4 class="mb-20">Leave take action</h4>
														<select name="status" required class="custom-select form-control">
															<option value="">Choose your option</option>
						                                          <option value="1">Approved</option>
						                                          <option value="2">Rejected</option>
														</select>
														<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
													</div>
													<div class="modal-footer justify-content-center">
														<input type="submit" class="btn btn-primary" name="update" value="Submit">
													</div>
												</div>
											</div>
										</div>
		  							</form>
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
	
	<script src="../vendors/scripts/datatable-setting.js"></script></body>

</body>
</html>














