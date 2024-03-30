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
															<div class="col-md-6 pr-0">
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
																			<label for="roleEdit">Edit</label>
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

		// Function to make fields editable
		function makeFieldsEditable(row) {
			// console.log("Making fields editable.");
			var editableColumns = [0, 1, 2, 3];
			row.find('td').each(function (index) {
				if (editableColumns.includes(index)) {
					var currentValue = $(this).text().trim();
					if (index === 1) { // Check if the column is the status column
						// console.log("Status column found.");
						var selectOptions = ['Active', 'Inactive'];
						var dropdown = '<select class="form-control">';
						selectOptions.forEach(option => {
							dropdown += '<option value="' + option + '"';
							if (option === currentValue) {
								dropdown += ' selected';
							}
							dropdown += '>' + option + '</option>';
						});
						dropdown += '</select>';
						$(this).data('original-text', currentValue); // Store original text
						$(this).html(dropdown);
					} else if (index === 2) { // Check if the column is the role column
						// console.log("Role column found.");
						var roles = ['Create', 'Update', 'Delete', 'View'];
						var checkboxes = '';
						roles.forEach(role => {
							var checked = currentValue.includes(role) ? 'checked' : '';
							checkboxes += '<label><input type="checkbox" value="' + role + '" ' + checked + '> ' + role + '</label><br>';
						});
						$(this).data('original-text', currentValue); // Store original text
						$(this).html(checkboxes);
					} else {
						// console.log("Other column found.");
						$(this).data('original-text', currentValue); // Store original text
						$(this).html('<input type="text" class="form-control" value="' + currentValue + '">');
					}
				}
			});
			var actionCell = row.find('td:last');
			actionCell.html('<div class="btn-group" role="group"><button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-link btn-danger cancel-btn"><i class="fa fa-times"></i></button> <button type="button" data-toggle="tooltip" title="Submit" class="btn btn-link btn-success btn-lg submit-btn" id="submitProgress"><i class="fa fa-check"></i></button></div>');
		}

		// Function to make fields non-editable
		function makeFieldsNonEditable(row) {
			// console.log("Making fields non-editable.");
			row.find('td').each(function () {
				var originalText = $(this).data('original-text');
				$(this).html(originalText);
			});
			var actionCell = row.find('td:last');
			actionCell.html('<div class="form-button-action"><button type="button" data-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary btn-lg edit-btn"><i class="fa fa-edit"></i></button></div>');
		}

		// Event listener for edit button
		$(document).on('click', '.edit-btn', function () {
			// console.log("Edit button clicked.");
			var $row = $(this).closest('tr');
			makeFieldsEditable($row);
		});

		// Event listener for cancel button
		$(document).on('click', '.cancel-btn', function () {
			// console.log("Cancel button clicked.");
			var $row = $(this).closest('tr');
			makeFieldsNonEditable($row);
		});
		// Event listener for edit button
		$(document).on('click', '.submit-btn', function () {
			var $row = $(this).closest('tr');
			var client_id = $row.find('.client-id').text();
			var role_name = $row.find('.role-name').text();
			var can_view = $row.find('.can-view').text();
			var can_create = $row.find('.can-create').text();
			var can_delete = $row.find('.can-delete').text();
			var can_edit = $row.find('.can-edit').text();
			var status = $row.find('.status').text();

			$.ajax({
				url: '/mbscan/superAdmin/updateClient',
				method: 'POST',
				dataType: 'json',
				data: {
					client_id: client_id,
					role_name: role_name,
					can_view: can_view,
					can_create: can_create,
					can_delete: can_delete,
					can_edit: can_edit,
					status: status
				},
				success: function (response) {
					console.log(response);
					// Handle success response
				},
				error: function (xhr, status, error) {
					console.error(xhr.responseText);
					// Handle error response
				}
			});
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
                if (roleDetails.can_create) roles += 'Create, ';
                if (roleDetails.can_update) roles += 'Update, ';
                if (roleDetails.can_delete) roles += 'Delete, ';
                if (roleDetails.can_view) roles += 'View, ';
            }
            roles = roles.replace(/,\s*$/, '');

            var rowData = [
                client.client_name || '-',
                client.status || '-',
                roles || '-',
                '<td><div class="form-button-action"><button type="button" data-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary btn-lg edit-btn"><i class="fa fa-edit"></i></button></div></td>'
            ];
            var row = table.row.add(rowData).draw(false).node();
            
            // Create invisible row containing client_id only
            var invisibleRow = '<tr class="invisible-row" data-client-id="' + client.id + '"></tr>';
            $(row).after(invisibleRow);

            // Log client ID
            console.log("Client ID:", client.id);
        });
    },
    error: function (xhr, status, error) {
        console.error("AJAX request failed with error:", error);
    }
});



		// Event listener for add admin button
		$('#addAdminButton').click(function () {
			// console.log("Add admin button clicked.");
			var addName = $('#addName');
			var addStatus = $('#addStatus');
			var roles = $('#roleCreate, #roleEdit, #roleView, #roleDelete');
			if (addName.val().trim() === '' || addStatus.val().trim() === '' || !roles.is(':checked')) {
				// console.log("Validation failed. Required fields are empty or checkboxes are not checked.");
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
			// console.log("Client added with name: " + response);
			var responseParts = response.split('|');
			var clientId = responseParts[0];
			var clientName = responseParts[1];
			// console.log("Client ID: " + clientId);
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

	function logout(){
	$.ajax({
	type: "GET",
	url: "/mbscan/superAdmin/logout",
	success: function(response) {
		// Redirect to login page after successful logout
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
