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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['<?php echo base_url(); ?>assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	<style>
	.is-invalid {
			border: 1px solid red !important;
		}
	</style>
	<!-- CSS Files -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/atlantis.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/demo.css">
</head>
<body>
	<div class="wrapper">
		<!-- Modal -->
		<div class="main-header">			
			<!-- Logo Header -->
			<div class="logo-header" style="background-color: #133B62;">
				<a href="<?= base_url('superAdmin/dashboard') ?>" class="logo">
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
                <ul class="nav nav-primary">
                    <li class="nav-item active">
                        <a href="<?= base_url('superAdmin/dashboard') ?>" class="collapsed" aria-expanded="false">
                            <i class="fas fa-plus"></i>
                            <p>Create/Edit Client</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('superAdmin/createuser') ?>" class="collapsed" aria-expanded="false">
                            <i class="fas fa-plus"></i>
                            <p>Create/Edit User</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('superAdmin/createdevice') ?>" class="collapsed" aria-expanded="false">
                            <i class="fas fa-plus"></i>
                            <p>Create/Edit Device</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('superAdmin/otaupdate') ?>" class="collapsed" aria-expanded="false">
                            <i class="fas fa-sync-alt"></i>
                            <p>OTA Update</p>
                        </a>
                    </li>		
                    <hr class="light-line">
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
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<div class="d-flex align-items-center">
									<h4 class="card-title">Add Device</h4>
									<button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
										<i class="fa fa-plus"></i>
										Add Device
									</button>
								</div>
							</div>
							<div class="card-body">
								<!-- Modal -->
								<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-body">
												<p class="small">Create a new Device</p>
												<form>
													<div class="row">
														<div class="col-sm-12">
															<div class="form-group form-group-default">
																<label>Name</label>
																<input id="addName" type="text" class="form-control" placeholder="Enter name" >
															</div>
														</div>
														<div class="col-md-6 pr-0">
															<div class="form-group form-group-default">
																<label>Status</label>
																<select id="addStatus" class="form-control">
																	<option value="Active">Active</option>
																	<option value="InActive">InActive</option>
																</select>
															</div>
														</div>
														<div class="col-md-6 pr-0">
															<div class="form-group form-group-default">
																<label>MAC ID</label>
																<input id="addMacId" type="text" class="form-control" placeholder="Enter name" >
															</div>
														</div>
													</div>
												</form>
											</div>
											<div class="modal-footer no-bd">
												<button type="button" id="addAdminButton" class="btn btn-primary" onclick= "addDevice()">Add</button>
												<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
								<div class="table-responsive">
									<table id="add-row" class="display table table-striped table-hover" >
										<thead>
											<tr>
												<th>Name</th>
												<th>Status</th>
												<th>MAC ID</th>
												<!-- <th style="width: 10%">Action</th> -->
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- added an closing div tag on 29-01-2024 -->
	</div>
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
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>
<script>
	$(document).ready(function() {
		var table = $('#add-row').DataTable({
			"pageLength": 10,
		});

		// Function to fetch data and populate the table
		function populateTable() {
			$.ajax({
				url: '/mbscan/superAdmin/getDevices', // Adjust the URL according to your routing
				type: 'GET',
				success: function(response) {
					// Clear existing rows
					table.clear();

					// Add new rows from the response data
					response.forEach(function(device) {
						table.row.add([
							device.device_name,
							device.status,
							device.mac_id
						]).draw(false);
					});
				},
				error: function(xhr, status, error) {
					console.error(xhr.responseText);
				}
			});
		}

		// Call the populateTable function to initially populate the table
		populateTable();
	});

	function addDevice() {
    var name = $('#addName').val();
    var status = $('#addStatus').val();
    var macId = $('#addMacId').val();

    // AJAX call
    $.ajax({
        type: 'POST',
        url: '/mbscan/superAdmin/addDevice', // Adjust the URL according to your routing
        data: {
            name: name,
            status: status,
            mac_id: macId
        },
        success: function(response) {
            if (response.status === 'success') {
				$('#addRowModal').modal('hide');
                // alert(response.message);
                // Optionally, reload the page or do something else
            } else {
                alert('Failed to add device. Please try again.');
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Failed to add device. Please try again.');
        }
    });
	}

</script>
</body>
</html>
