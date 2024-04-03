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
</div>
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
				<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Add Client</h4>
										<button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
											<i class="fa fa-plus"></i>
											Add Client
										</button>
									</div>
								</div>
								<div class="card-body">
									<!-- Modal -->
									<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-body">
													<p class="small">Create a new Client</p>
													<form>
														<div class="row">
															<div class="col-sm-12">
																<div class="form-group form-group-default">
																	<label>Name</label>
																	<input id="addName" type="text" class="form-control" placeholder="Enter name" >
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group form-group-default">
																	<label>Status</label>
																	<select id="addStatus" class="form-control">
																		<option value="Active">Active</option>
																		<option value="InActive">InActive</option>
																	</select>
																</div>
															</div>
															<div class="col-sm-12">
																<div class="form-group form-group-default" id = "addRole">
																	<label>Role</label>
																	<div class="row">
																		<div class="col-sm-3">
																			<input type="checkbox" id="roleCreate" value="create">
																			<label for="roleCreate">Create</label>
																		</div>
																		<div class="col-sm-3">
																			<input type="checkbox" id="roleEdit" value="edit">
																			<label for="roleEdit">Update</label>
																		</div>
																		<div class="col-sm-3">
																			<input type="checkbox" id="roleView" value="view">
																			<label for="roleView">View</label>
																		</div>
																		<div class="col-sm-3">
																			<input type="checkbox" id="roleDelete" value="delete">
																			<label for="roleDelete">Delete</label>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</form>
												</div>
												<div class="modal-footer no-bd">
													<button type="button" id="addAdminButton" class="btn btn-primary" onclick= "addClient()">Add</button>
													<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
								<!-- Modal -->
								<div class="modal fade" id="updateTable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-body">
												<p class="small">Edit Client Details</p>
												<form>
													<div class="row">
														<div class="col-sm-12">
															<div class="form-group form-group-default">
																<label>Name</label>
																<input id="updateName" type="text" class="form-control" placeholder="Enter name" readonly>
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
																		<input type="checkbox" data-role="create" value="create">
																		<label for="roleCreate">Create</label>
																	</div>
																	<div class="col-sm-3">
																		<input type="checkbox" data-role="edit" value="edit">
																		<label for="roleEdit">Edit</label>
																	</div>
																	<div class="col-sm-3">
																		<input type="checkbox" data-role="view" value="view">
																		<label for="roleView">View</label>
																	</div>
																	<div class="col-sm-3">
																		<input type="checkbox" data-role="delete" value="delete">
																		<label for="roleDelete">Delete</label>
																	</div>

																</div>
															</div>
														</div>
													</div>
												</form>
											</div>
											<div class="modal-footer no-bd">
												<button type="button" id="updateButton" class="btn btn-primary" onclick= "updateClientDetails()">Update</button>
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
													<th>Role</th>
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
	$(document).ready(function () {
		// Initialize tooltips
		// console.log("Document is ready.");

		initTooltips();

		// DataTable initialization
		var table = $('#add-row').DataTable({
			"pageLength": 10,
		});

		// Function to initialize tooltips
		function initTooltips() {
			$('[data-toggle="tooltip"]').tooltip();
		}

		$(document).on('click', '.edit-btn', function () {
			var $row = $(this).closest('tr');
			var name = $row.find('td:eq(0)').text(); 
			var status = $row.find('td:eq(1)').text();
			var rolesData = $row.data('roles');
			var clientId = $row.data('client-id'); 
			console.log("Client ID:", clientId); 
			var roles = rolesData ? rolesData.split(', ') : []; 
			$('#updateName').val(name); 
			$('#updateStatus').val(status);
			updateClientId = clientId;
			// Uncheck all checkboxes first
			$('input[type="checkbox"]').prop('checked', false);

			// Check checkboxes based on roles
			roles.forEach(function(role) {
				$('input[type="checkbox"][data-role="' + role + '"]').prop('checked', true);
			});

			$('#updateTable').modal('show');
		});

		// AJAX request to get client data
		$.ajax({
			type: 'GET',
			url: '/mbscan/superAdmin/getClient',
			success: function (response) {
				table.clear().draw();
				response.forEach(function (client) {
				// Populate visible row
				var roles = '';
				if (client.role_details) {
					var roleDetails = JSON.parse(client.role_details);
					if (roleDetails.can_create) roles += 'create, ';
					if (roleDetails.can_update) roles += 'edit, ';
					if (roleDetails.can_delete) roles += 'delete, ';
					if (roleDetails.can_view) roles += 'view, ';
				}
				roles = roles.replace(/,\s*$/, '');
				var rowData = [
				client.client_name || '-',
				client.status || '-',
				roles || '-',
				'<td><div class="form-button-action"><button type="button" data-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary btn-lg edit-btn"><i class="fa fa-edit"></i></button></div></td>'
			];

			var row = table.row.add(rowData).draw(false).node();
			$(row).data('roles', roles);
			$(row).data('client-id', client.id); 

			// Create invisible row containing client_id only
			var invisibleRow = '<tr class="invisible-row" data-client-id="' + client.id + '"></tr>';
			$(row).after(invisibleRow);

			});

			},
			error: function (xhr, status, error) {
				console.error("AJAX request failed with error:", error);
			}
		});

		// Event listener for add admin button
		$('#addAdminButton').click(function () {
			var addName = $('#addName');
			var addStatus = $('#addStatus');
			var roles = $('#roleCreate, #roleEdit, #roleView, #roleDelete');
			if (addName.val().trim() === '' || addStatus.val().trim() === '' || !roles.is(':checked')) {
				addName.addClass('is-invalid');
				addStatus.addClass('is-invalid');
				roles.addClass('is-invalid');
				return;
			}
			$('#addRowModal').modal('hide');
		});

		// Event listener to reset form fields and remove invalid class when the modal is opened
		$('#addRowModal').on('show.bs.modal', function (e) {
			$('#addName').val('').removeClass('is-invalid');
			$('#addStatus').val('Active').removeClass('is-invalid');
			$('#createCheckbox, #updateCheckbox, #deleteCheckbox, #viewCheckbox').prop('checked', false).removeClass('is-invalid');
		});

	});

	// Function to add client
	function addClient() {
		var name = $('#addName').val();
		var status = $('#addStatus').val();
		var createCheckbox = $('#roleCreate').prop('checked');
		var updateCheckbox = $('#roleEdit').prop('checked');
		var viewCheckbox = $('#roleView').prop('checked');
		var deleteCheckbox = $('#roleDelete').prop('checked');

		if (!name || !status) {
			alert("Please fill out all required fields.");
			return;
		}

		$.ajax({
			type: 'POST',
			url: '/mbscan/superAdmin/addclient',
			data: {
				name: name,
				status: status,
				can_create: createCheckbox,
				can_edit: updateCheckbox,
				can_view: viewCheckbox,
				can_delete: deleteCheckbox,
				role_name: ''
			},
			success: function (response) {
			if (response === "duplicate") {
				alert("Client name already exists. Please choose a different name.");
				return;
            }
			var responseParts = response.split('|');
			var clientId = responseParts[0];
			var clientName = responseParts[1];
			$.ajax({
				type: 'POST',
				url: '/mbscan/superAdmin/createSchemaAndTables',
				data: {
					clientId: clientId
				},
				success: function (secondResponse) {
					// console.log(secondResponse);
				},
				error: function (xhr, status, error) {
					console.error(xhr.responseText);
				}
			});
		},
		error: function (xhr, status, error) {
			console.error(xhr.responseText);
		}
		});
	}
		var updateClientId;
		
	function updateClientDetails() {
		// Get the updated status and role details
		var status = $('#updateStatus').val();
		
		// Get boolean values for role details
		var roles = {
			can_create: $('#updateRole input[data-role="create"]').prop('checked'),
			can_update: $('#updateRole input[data-role="edit"]').prop('checked'),
			can_delete: $('#updateRole input[data-role="delete"]').prop('checked'),
			can_view: $('#updateRole input[data-role="view"]').prop('checked')
		};

		// Convert boolean values to strings
		for (var key in roles) {
			if (roles.hasOwnProperty(key)) {
				roles[key] = roles[key] ? 'true' : 'false';
			}
		}
		var data = {
			clientId: updateClientId,
			status: status,
			roleDetails: roles 
		};

		$.ajax({
			type: 'POST',
			url: '/mbscan/superAdmin/updateClient',
			data: data,
			success: function (response) {
				$('#updateTable').modal('hide');
			},
			error: function (xhr, status, error) {
				console.error('Error updating client details:', error);
			}
		});
	}

	function logout(){
	$.ajax({
	type: "GET",
	url: "/mbscan/superAdmin/logout",
	success: function(response) {
		window.location.href = '/mbscan/superAdmin/login';
	},
	error: function(xhr, status, error) {
		console.error(xhr.responseText);
	}
	});

	}
</script>
</body>
</html>
