<!-- om pending leave -->

<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
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
								<h4>Pending Leave</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Pending Leave</li>
								</ol>
							</nav>
					</div>
				</div>
			</div>

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">PENDING LEAVE</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">STAFF NAME</th>
								<th>LEAVE TYPE</th>
								<th>APPLIED DATE</th>
								<th>HR STATUS</th>
								<th>MY STATUS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								<?php 
								$status=1;
								$om_status=0; //reg_status (before)
								$sql = "SELECT tblleave.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,tblemployees.Av_leave,tblemployees.Position_Staff,tblemployees.Staff_ID,tblleave.LeaveType,tblleave.ToDate,tblleave.FromDate,tblleave.PostingDate,tblleave.RequestedDays,tblleave.DaysOutstand,tblleave.Sign,tblleave.Reason,tblleave.HRRemarks,tblleave.OMRemarks,tblleave.HRSign,tblleave.OMSign,tblleave.HRDate,tblleave.OMDate,tblleave.num_days from tblleave join tblemployees on tblleave.empid=tblemployees.emp_id where tblleave.HRRemarks= '$status' and tblleave.OMRemarks = '$om_status' order by lid desc";
									$query = mysqli_query($conn, $sql) or die(mysqli_error());
									while ($row = mysqli_fetch_array($query)) {
								 ?>  

								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
										</div>
										<div class="txt">
											<div class="weight-600"><?php echo $row['FirstName']." ".$row['LastName'];?></div>
										</div>
									</div>
								</td>
								<td><?php echo $row['LeaveType']; ?></td>
	                            <td><?php echo $row['PostingDate']; ?></td>
								<td><?php $stats=$row['HRRemarks'];
	                             if($stats==1){
	                              ?>
	                                  <span style="color: green">Approved</span>
	                                  <?php } if($stats==2)  { ?>
	                                 <span style="color: red">Rejected</span>
	                                  <?php } if($stats==0)  { ?>
	                             <span style="color: blue">Pending</span>
	                             <?php } ?>
	                            </td>
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
										<a title="View Details" href="leave_details.php?leaveid=<?php echo $row['lid'];?>"><i class="dw dw-eye" data-color="#265ed7"></i></a>	
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