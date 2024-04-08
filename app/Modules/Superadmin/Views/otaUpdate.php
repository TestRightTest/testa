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
		
    /* Custom Select2 styling to remove the border around the main dropdown */
    .select2-container--default .select2-selection--multiple {
        width:200%;
    }
    .selected-devices {
    width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
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
				<a href="<?= base_url('superadmin/dashboard') ?>" class="logo">
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
                            <li class="nav-item ">
                                <a href="<?= base_url('superadmin/dashboard') ?>" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-plus"></i>
                                    <p>Create/Edit Client</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('superadmin/createuser') ?>" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-plus"></i>
                                    <p>Create/Edit User</p>
                                </a>
                            </li>
							<li class="nav-item">
								<a href="<?= base_url('superadmin/createdevice') ?>" class="collapsed" aria-expanded="false">
									<i class="fas fa-plus"></i>
									<p>Create/Edit Device</p>
								</a>
							</li>
                            <li class="nav-item active">
                                <a href="<?= base_url('superadmin/otaupdate') ?>" class="collapsed" aria-expanded="false">
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
		</div>
		<div class="main-panel">
			<div class="content">
				<!-- <div id="loadingScreen">
					<i id="loadingIcon" class="fas fa-spinner"></i>
				</div> -->
				<div class="page-inner">

					<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Add Ota Update</h4>
										<button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
											<i class="fa fa-plus"></i>
											Add OTA Update
										</button>
									</div>
								</div>
								<div class="card-body">
									<!-- Modal -->
									<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-body">
													<p class="small">Add OTA Update</p>
													<form>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group form-group-default">
																	<label>Name</label>
																	<input id="addName" type="text" class="form-control" placeholder="Enter Name">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group form-group-default">
																	<label>Description</label>
																	<input id="addDescription" type="text" class="form-control" placeholder="Enter Description">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group form-group-default">
																	<label>Version</label>
																	<input id="addVersion" type="text" class="form-control" placeholder="Enter Version">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group form-group-default">
                                                                    <label for="addDeviceID">Select Device</label>
                                                                    <select id="addDeviceID" class="selected-devices" multiple>
                                                                    </select>
																</div>
															</div>
                                                            <div class="col-md-6">
																<div class="form-group form-group-default">
																	<label>Status</label>
																	<select id="addStatus" class="form-control">
																		<option value="rollOut">Roll Out</option>
																		<option value="rollBack">Roll Back</option>
																	</select>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group form-group-default">
																	<label for="fileUpload">Upload .bin File</label>
																	<input type="file"  name="fileUpload" id="fileUpload" class="form-control-file" accept=".bin">
																</div>
															</div>
														</div>
													</form>
												</div>
												<div class="modal-footer no-bd">
												<button type="button" id="addUserButton" class="btn btn-primary" onclick= "addUpdate()">Add</button>
													<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
                                    <!-- Modal -->
                                    <!-- <div class="modal fade" id="updateTable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <p class="small">Edit Client Details</p>
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group form-group-default">
                                                                    <label>Client ID</label>
                                                                    <input id="updateClient" type="text" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group form-group-default">
                                                                    <label>Name</label>
                                                                    <input id="updateName" type="text" class="form-control" placeholder="Enter name" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group form-group-default">
                                                                    <label>Username</label>
                                                                    <input id="updateUserName" type="text" class="form-control" placeholder="Enter Username" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group form-group-default">
                                                                    <label>Status</label>
                                                                    <select id="updateStatus" class="form-control">
                                                                        <option value="Active">Active</option>
                                                                        <option value="InActive">InActive</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group form-group-default" id = "updateRole">
                                                                    <label>Role</label>
                                                                    <div class="row">
                                                                        <div class="col-sm-3">
                                                                            <input type="checkbox" id="updateCreateCheckbox" data-role="create" value="create">
                                                                            <label for="roleCreate" id= "updateCheckboxLabel">Create</label>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <input type="checkbox" id="updateRoleCheckbox" data-role="edit" value="edit">
                                                                            <label for="roleEdit" id= "editRoleLabel">Edit</label>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <input type="checkbox" id="updateViewCheckbox" data-role="view" value="view">
                                                                            <label for="roleView" id="viewRoleLabel">View</label>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <input type="checkbox" id="updateDeleteRole" data-role="delete" value="delete">
                                                                            <label for="roleDelete" id="deleteRoleLabel">Delete</label>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <input type="checkbox" id="updateAdjustRole" data-role="adjust" value="adjust">
                                                                            <label for="roleAdjust" id="adjustRoleLabel">Adjust</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer no-bd">
                                                    <button type="button" id="updateButton" class="btn btn-primary" onclick= "updateUserDetails()">Update</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Date</th>
													<th>Name</th>
													<th>Description</th>
													<th>Super Admin Id</th>
                                                    <th>Status</th>
													<th>Version</th>
													<th>File Name</th>
													<th>File Size</th>
													<th>Devices</th>
													<th style="width: 10%">Action</th>
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
	<!-- Select2 CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

	<!-- Select2 JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

	<script >
		$(document).ready(function() {
			const table = $('#add-row').DataTable({
				pageLength: 10
			});

			$('#addDeviceID').select2();
			const $addDeviceID = $('#addDeviceID');

			$.ajax({
				url: "/mbscan/superadmin/getDeviceDetails",
				method: 'GET',
				dataType: 'json',
				success: function(response) {
					console.log("device details: ",response);
					$('#addDeviceID').empty();
                    $('#addDeviceID').append('<option value="">All Devices</option>');
                    response.forEach(function(response) {
                        var $option = $('<option value="' + response.id + '">' + response.device_name + '</option>');
                        $('#addDeviceID').append($option);
                    });

				},
				error: function(xhr, status, error) {
					console.error('Error occurred while fetching device details:', error);
				}
			});

			$.ajax({
				type: 'GET',
				url: '/mbscan/superadmin/getOtaDevices',
				success: function (response) {
					console.log("response : ", response);
					table.clear().draw();
					response.forEach(device => {
						const rowData = [
							device.created_on || '-',
							device.release_name || '-',
							device.release_description || '-',
							device.super_admin_id || '-',
							device.status || '-',
							device.release_version || '-',
							device.ota_file_name || '-',
							device.ota_file_size || '-',
							device.release_for || '-',
							`<div class="form-button-action">
								<button type="button" data-toggle="tooltip" class="btn btn-link btn-primary btn-lg edit-btn">
									<i class="fa fa-edit"></i>
								</button>
							</div>`
						];
						// Add rowData to the table
						table.row.add(rowData).draw();
					});
				},
				error: function (xhr, status, error) {
					console.error(xhr.responseText);
				}
			});

		
		});


		function logout(){
			$.ajax({
				type: "GET",
				url: "/mbscan/superadmin/logout",
				success: function(response) {
					// Redirect to login page after successful logout
					window.location.href = '/mbscan/superadmin/login';
				},
				error: function(xhr, status, error) {
					console.error(xhr.responseText);
				}
			});
		}

		function addUpdate() {
        // Get form data
        var formData = new FormData();
        formData.append('fileUpload', $('#fileUpload')[0].files[0]);
        formData.append('name', $('#addName').val());
        formData.append('description', $('#addDescription').val());
        formData.append('version', $('#addVersion').val());
        formData.append('status', $('#addStatus').val());

		// Get selected device IDs
		var selectedDevices = $('#addDeviceID').val();
		
		if (selectedDevices && selectedDevices.includes('')) {
			console.log("All device IDs:");
			// Log the IDs of all devices
			$('#addDeviceID option').each(function() {
				if ($(this).val() !== '') {
					console.log($(this).val());
					// Append each selected device ID to formData
					formData.append('selectedDevices[]', $(this).val());
				}
			});
		} else {
			console.log("Selected device ID(s): ", selectedDevices);
			// Append selected device IDs to formData
			selectedDevices.forEach(function(deviceId) {
				formData.append('selectedDevices[]', deviceId);
			});
		}
    

		console.log("formatted data: ", formData);        // Perform AJAX call
        $.ajax({
            url: "/mbscan/superadmin/addupdate",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === 'success') {
					$('#addRowModal').modal('hide');
                    // alert('File uploaded successfully');
                    // Optionally, perform any additional actions after successful upload
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
	</script>
</body>
</html>
