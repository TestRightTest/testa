<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>MBScan Dashboard</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="<?php echo base_url(); ?>assets/img/testright.svg" type="image/x-icon"/>
	<!-- Fonts and icons -->
	<script src="<?php echo base_url(); ?>assets/js/plugin/webfont/webfont.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['<?php echo base_url(); ?>assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/atlantis.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/demo.css">
</head>
<body>

	<div class="wrapper">
		<!-- Modal -->
		<!-- <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="modal-title" id="exampleModalLongTitle">Enter Settings Password</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<input type="password" id="password-input" class="form-control input-sm" placeholder="Enter Password" aria-label="" aria-describedby="basic-addon1" style="border-width: 3px;">
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn" data-dismiss="modal">Close</button>
						<button type="button" class="btn" id="submit-button" style="background-color: #2dbd85; color: white;">Submit</button>
					</div>
				</div>
			</div>
		</div> -->
		<div class="main-header">			
			<!-- Logo Header -->
			<div class="logo-header" style="background-color: #133B62;">
				<a href="<?= base_url('client/dashboard') ?>" class="logo">
					<img src="<?php echo base_url(); ?>assets/img/MbScanLogo.png" alt="navbar brand" class="navbar-brand">
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"style="color: #fff" >
						<i class="icon-menu"></i>
					</span>
				</button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<nav class="navbar navbar-header navbar-expand-lg" style="background-color: #133B62;">				
			</nav>
        </div>
		<div>
            <div class="sidebar sidebar-style-2" background-color="white">			
                <div class="sidebar-wrapper scrollbar scrollbar-inner">
                    <div class="sidebar-content">
						<div class="user">
							<div class="info">
								<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
									<span>
										<span id="companyName" style="font-weight: bold; font-size: larger;">Company Name</span>
									</span>
								</a>
								<div class="clearfix"></div>
							</div>
						</div>
						
						<ul class="nav nav-primary">
							<!-- Home link -->
							<li class="nav-item">
								<a href="<?= base_url('client/dashboard') ?>" class="collapsed" aria-expanded="false">
									<i class="fas fa-home"></i>
									<p>Home</p>
								</a>
							</li>
							<?php

							use Config\Constants; // Import the Constants class

							?>
							<?php if (isset($roleDetails[Constants::CAN_ADJUST]) && $roleDetails[Constants::CAN_ADJUST]): ?>
								<!-- If user has "can_adjust" permission, show the Device Settings option -->
								<li class="nav-item active">
                                <a href="<?= base_url('client/dashboard/settings') ?>" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                    <p>Device Settings</p>
                                </a>
                            </li>
							<?php endif; ?>

							<?php if (
								isset($roleDetails[Constants::CAN_CREATE]) &&
								$roleDetails[Constants::CAN_CREATE] ||
								isset($roleDetails[Constants::CAN_EDIT]) &&
								$roleDetails[Constants::CAN_EDIT] ||
								isset($roleDetails[Constants::CAN_DELETE]) &&
								$roleDetails[Constants::CAN_DELETE]
							): ?>
								<!-- If user has "can_create", "can_edit", and "can_delete" permissions, show the Create/Edit User option -->
							<li class="nav-item">
                                <a href="<?= base_url('client/dashboard/settings/createuser') ?>" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-users"></i>
                                    <p>Create/ Edit User</p>
                                </a>
                            </li>
							<?php endif; ?>
							<!-- Logout link -->
							<li class="nav-item">
								<a href="#signout function" class="collapsed" aria-expanded="false" onclick="logout()">
									<i class="fas fa-sign-out-alt"></i>
									<p>Logout</p>
								</a>
							</li>
						</ul>
                    </div>
					<div style="position: absolute; bottom: 10px; width: 100%; text-align: center;">
						<a href="https://www.testright.in/" class="collapsed" aria-expanded="false">
							<p><img src="<?php echo base_url(); ?>assets/img/byTestRight.svg" alt="navbar brand" class="navbar-brand"></p>
						</a>
					</div>
                </div>
            </div>
		</div>
		<div class="main-panel">
			<div class="content">
				<!-- <div id="loadingScreen">
					<i id="loadingIcon" class="fas fa-spinner"></i>
				</div> -->
				<div class="page-inner">

					<div class="page-header">					
						<div class="btn-group" id="companyIdDropdownContainer" style="display: none;">
							<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Company Id
							</button>
							<div class="dropdown-menu" id="companyIdDropdown">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header d-flex justify-content-between">
									<div class="container-fluid">
										<div class="row">
											<div class="col-md-6" id="rotationBlock">
												<div class="form-group" >
													<div class="input-group">
														<input type="checkbox" id="rotationCheckbox" onclick="rotationCheckBox()">
														<div class="input-group-prepend" id="rotationtoast">
															<span class="input-group-text" style="background-color: #ffffff;">Rotation Interval:</span>
														</div>
														<input type="text" id="rotationInterval" class="form-control form-control-sm col-2" maxlength="3" placeholder="" aria-label="" aria-describedby="basic-addon1" disabled style="background-color: #ffffff;">
														<div class="input-group-append">
															<span class="input-group-text" style="background-color: #ffffff;">Minutes</span>
														</div>
														<div class="form-button-action">
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg edit-btn" data-original-title="Edit Data">
																<i class="fa fa-edit"></i>
															</button>
											
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger cancel-btn" data-original-title="Cancel">
																<i class="fa fa-times"></i>
															</button>
									  
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-lg submit-btn" id="submitRotation" data-original-title="Submit">
																<i class="fa fa-check"></i>
															</button>
														</div>
													</div>
												</div>
											</div>
									  
											<div class="col-md-6">
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-prepend" id="progresstoast" >
															  <span class="input-group-text" style="background-color: #ffffff;">Decolor Threshold:</span>
														</div>
														<input type="text" id="progressThreshold" class="form-control form-control-sm col-2" maxlength="3" placeholder="" aria-label="" aria-describedby="basic-addon1" disabled style="background-color: #ffffff;"> 
														<div class="input-group-append">
															<span class="input-group-text" style="background-color: #ffffff;">%</span>
														</div>
														<div class="form-button-action">
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg edit-btn" data-original-title="Edit Data">
															<i class="fa fa-edit"></i>
															</button>
											
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger cancel-btn" data-original-title="Cancel">
															<i class="fa fa-times"></i>
															</button>
											
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-lg submit-btn" id="submitProgress" data-original-title="Submit">
															<i class="fa fa-check"></i>
															</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>	
								</div>
								
								<div class="card-body">
									<div class="table-responsive">															
										<table id="add-row" class="display table table-striped table-hover" >											
											<thead>
												<tr>
													<th>Device Id</th>
													<!-- <th>Password</th> -->
													<th>NickName</th>
													<th>Adjust Temp</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											 <tbody id="settingstableBody"></tbody>
										</table>
									</div>
								</div>							
							</div>
						</div>					
					</div>
				</div>
			</div>
		</div>
		<!-- added an closing div tag on 29-01-2024 -->
	</div>
	<!--   Core JS Files   -->
	<script src="<?php echo base_url(); ?>assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/core/popper.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/core/bootstrap.min.js"></script>
	<!-- jQuery UI -->
	<script src="<?php echo base_url(); ?>assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="<?php echo base_url(); ?>assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
	<!-- Datatables -->
	<script src="<?php echo base_url(); ?>assets/js/plugin/datatables/datatables.min.js"></script>
	<!-- Atlantis JS -->
	<script src="<?php echo base_url(); ?>assets/js/atlantis.min.js"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="<?php echo base_url(); ?>assets/js/setting-demo2.js"></script>
	<script >
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
			});


			// Add Row
			$('#add-row').DataTable({
				"pageLength": 5,
			});

			var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

			$('#addRowButton').click(function() {
				$('#add-row').dataTable().fnAddData([
					$("#addName").val(),
					$("#addPosition").val(),
					$("#addOffice").val(),
					action
					]);
				$('#addRowModal').modal('hide');

			});
			$.ajax({
				url: '/mbscan/client/getUser',
				type: 'GET',
				success: function(data) {
					response = data;
					if (response.length > 0) {
						$('#companyName').text(response[0].client_name);
						console.log("data :",response);
					}
				},
				error: function(xhr, status, error) {
					console.error(xhr.responseText);
				}
			});
			
		});
	</script>
    <!-- <script src="../documentation/assets/Dashboard.js"></script> -->
	<script src="<?php echo base_url(); ?>assets/js/Dash/settings.js"></script>
</body>
</html>