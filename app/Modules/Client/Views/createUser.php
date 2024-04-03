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
		.is-invalid {
			border: 1px solid red !important;
		}

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
                            <li class="nav-item">
                                <a href="<?= base_url('client/dashboard') ?>" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-home"></i>
                                    <p>Home</p>
                                </a>
                            </li>
                            <!-- <li class="nav-item ">
                                <a href="<?= base_url('client/dashboard/settings') ?>" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                    <p>Settings</p>
                                </a>
                            </li> -->
							<li class="nav-item active submenu">
								<a data-toggle="collapse" href="#settings">
									<i class="fas fa-cog"></i>
									<p>Settings</p>
									<span class="caret"></span>
								</a>
								<div class="collapse show" id="settings">
									<ul class="nav nav-collapse">
										<li >
											<a href="<?= base_url('client/dashboard/settings') ?>">
												<span class="sub-item">Device Settings</span>
											</a>
										</li>
										<li class="active">
											<a href="<?= base_url('client/dashboard/settings/createuser') ?>">
												<span class="sub-item">Create/ Edit User</span>
											</a>
										</li>
									</ul>
								</div>
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
										<h4 class="card-title">Add User</h4>
										<button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal" id="addUserId" style="display: none;">
											<i class="fa fa-plus"></i>
											Add User
										</button>
									</div>
								</div>
								<div class="card-body">
									<!-- Modal -->
									<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-body">
													<p class="small">Create a new User</p>
													<form>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group form-group-default">
                                                                    <label for="addclientID">Select Client</label>
                                                                    <select id="addclientID" class="form-control" >
                                                                    </select>
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
																	<label>Name</label>
																	<input id="addName" type="text" class="form-control" placeholder="Enter Name">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group form-group-default">
																	<label>Username</label>
																	<input id="addUsername" type="text" class="form-control" placeholder="Enter Username">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group form-group-default">
																	<label>Password</label>
																	<input id="password" type="password" class="form-control" placeholder="Enter Password">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group form-group-default">
																	<label>Confirm Password</label>
																	<input id="confirm_password" type="password" class="form-control" placeholder="Confirm Password">
																	<div id="password_error" style="color: red;"></div>
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
                                                                <div class="form-group form-group-default">
                                                                    <label>Role</label>
                                                                    <div class="row">
                                                                        <div class="col-sm-3">
                                                                            <input type="checkbox" id="createCheckbox" value="create">
                                                                            <label for="createCheckbox" id="createLabel">Create</label>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <input type="checkbox" id="updateCheckbox" value="edit">
                                                                            <label for="updateCheckbox" id="updateLabel">Edit</label>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <input type="checkbox" id="viewCheckbox" value="view">
                                                                            <label for="viewCheckbox" id="viewLabel">View</label>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <input type="checkbox" id="deleteCheckbox" value="delete">
                                                                            <label for="deleteCheckbox" id="deleteLabel">Delete</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
														</div>
													</form>
												</div>
												<div class="modal-footer no-bd">
												<button type="button" id="addUserButton" class="btn btn-primary" onclick= "addUser()">Add</button>
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

                                                            <div class="col-md-6">
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
                                                                    <label>Devices</label>
                                                                    <input id="updateClient" type="text" class="form-control" readonly>
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
                                    </div>
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													
													<th>Name</th>
													<th>Username</th>
                                                    <th>Devices</th>
													<th>Role</th>
                                                    <th>Status</th>
													<th  id= "action" style="display: none;">Action</th>
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

	<script>
        $(document).ready(function () {
        const table = $('#add-row').DataTable({
            pageLength: 10
        });
        $('#addDeviceID').select2();

        const $addUserButton = $('#addUserButton');
        const $addRowModal = $('#addRowModal');
        const $password = $('#password');
        const $confirmPassword = $('#confirm_password');
        const $passwordError = $('#password_error');
        const $addclientID = $('#addclientID');
        const $addName = $('#addName');
        const $addUsername = $('#addUsername');
        const $addDeviceID = $('#addDeviceID');
        var clientRoleDetails;

        function initTooltips() {
            $('[data-toggle="tooltip"]').tooltip();
        }
        
        $(document).on('click', '.edit-btn', function () {
            const $row = $(this).closest('tr');
            var name = $row.find('td:eq(0)').text();
            var userName = $row.find('td:eq(1)').text();
            var clientId = $row.find('td:eq(2)').text();
            var roles = $row.find('td:eq(3)').text().split(', '); 
            var status = $row.find('td:eq(4)').text();
			var userId = $row.data('user-id'); 
			console.log("User ID:", userId); 
            $('#updateClient').val(clientId);
            $('#updateName').val(name);
            $('#updateUserName').val(userName);
			$('#updateStatus').val(status);
            updateUserId = userId;
            // Uncheck all checkboxes first
            $('input[type="checkbox"]').prop('checked', false);

            // Check checkboxes based on roles
            roles.forEach(function(role) {
                $('input[type="checkbox"][data-role="' + role + '"]').prop('checked', true);
            });

            $('#updateCreateCheckbox, #updateCheckboxLabel, #updateRoleCheckbox, #editRoleLabel, #updateViewCheckbox, #viewRoleLabel, #updateDeleteRole, #deleteRoleLabel').hide();

            // var clientRoleDetails = $('#addclientID option[value="' + clientId + '"]').data('role_details');
            console.log("client role details: ",clientRoleDetails);
            if (clientRoleDetails) {
                // clientRoleDetails = JSON.parse(clientRoleDetails);
                if (clientRoleDetails.can_create) {
                    $('#updateCreateCheckbox, #updateCheckboxLabel').show();
                }
                if (clientRoleDetails.can_edit) {
                    $('#updateRoleCheckbox, #editRoleLabel').show();
                }
                if (clientRoleDetails.can_view) {
                    $('#updateViewCheckbox, #viewRoleLabel').show();
                }
                if (clientRoleDetails.can_delete) {
                    $('#updateDeleteRole, #deleteRoleLabel').show();
                }
            }
            $('#updateTable').modal('show');

        });
        
        $addRowModal.on('show.bs.modal', function (e) {
            // Clear input fields and remove validation classes
            [ $addclientID, $addName, $addUsername, $password, $confirmPassword,$addDeviceID ].forEach(field => {
                field.val('').removeClass('is-invalid');
            });

            // Clear password error message
            $passwordError.text('');
            $('#createCheckbox, #createLabel, #updateCheckbox, #updateLabel, #viewCheckbox, #viewLabel, #deleteCheckbox, #deleteLabel').hide();

            // Uncheck checkboxes
            $('#createCheckbox').prop('checked', false);
            $('#updateCheckbox').prop('checked', false);
            $('#viewCheckbox').prop('checked', false);
            $('#deleteCheckbox').prop('checked', false);
                // Reset Select2 dropdown
            $('#addDeviceID').empty().select2({
                // placeholder: "Select a device",
                allowClear: true // Option to allow clearing selection
            });
        });


        $confirmPassword.on('input', function () {
            if ($password.val() !== $confirmPassword.val()) {
                $passwordError.text("Passwords do not match");
                $confirmPassword.addClass('is-invalid');
            } else {
                $passwordError.empty();
                $confirmPassword.removeClass('is-invalid');
            }
        });

        $.ajax({
            url: '/mbscan/client/getUser',
            type: 'GET',
            success: function(data) {
                response = data;
                console.log("user_details: ",response);
                console.log("role details: ", response[0].role_details);
                if (response.length > 0) {
                    console.log("client_name: ", response[0].client_name);
                    $('#companyName').text(response[0].client_name);
                    console.log("client ID: ", response[0].client_id);
                    // var clientId = response[0].client_id;
                    // Parse role details
                    var roleDetails = JSON.parse(response[0].role_details);
                    clientRoleDetails = JSON.parse(response[0].role_details);
                    console.log("Parsed role details:", roleDetails);

                    // Check if the user has the "can_create" role
                    var hasCreateRole = roleDetails && roleDetails.can_create;
                    var hasUpdateRole = roleDetails && roleDetails.can_edit;
                    // Show or hide the "Add Client" button based on the role
                    if (hasCreateRole) {
                        $('#addUserId').show();
                    } else {
                        $('#addUserId').hide();
                    }
                    // Show or hide the "Action" column based on the role
                    if (hasUpdateRole) {
                        $('#action').show(); // Show the "Action" column
                    } else {
                        $('#action').hide(); // Hide the "Action" column
                    }
                    $.each(data, function(index, value) {
                        // Append option elements to select element
                        var $option = $('<option value="' + value.id + '">' + value.client_name + '</option>');
                        $option.data('role_details', value.role_details); // Set role_details as data attribute
                        $('#addclientID').append($option);
                    });
                    
                    // Now make the second AJAX call inside this success callback
                    $.ajax({
                        type: 'GET',
                        url: '/mbscan/client/getclientusers',
                        data: {
                            client_id: response[0].client_id // Pass the client_id obtained from the first call
                        },
                        success: function(response) {
                            console.log("get users response: ", response);
                            table.clear().draw();
                            response.forEach(user => {
                                var roles = '';
                                if (user.role_details) {
                                    var roleDetails = JSON.parse(user.role_details);
                                    if (roleDetails.can_create) roles += 'create, ';
                                    if (roleDetails.can_edit) roles += 'edit, ';
                                    if (roleDetails.can_delete) roles += 'delete, ';
                                    if (roleDetails.can_view) roles += 'view, ';
                                }
                                roles = roles.replace(/,\s*$/, '');
                                const rowData = [
                                    user.name || '-',
                                    user.user_name || '-',
                                    user.device_names || '-',
                                    roles || '-', // Include role details here
                                    user.status || '-',
                                    `<div class="form-button-action">
                                        <button type="button" data-toggle="tooltip" class="btn btn-link btn-primary btn-lg edit-btn">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </div>`
                                ];

                                
                                // console.log('User ID:', user.id); // Log user_id to console
                                initTooltips();
                                var row = table.row.add(rowData).draw(false).node();
                                $(row).data('roles', roles);
                                $(row).data('user-id', user.id);

                                // Create invisible row containing client_id only
                                var invisibleRow = '<tr class="invisible-row" data-user-id="' + user.id + '"></tr>';
                                $(row).after(invisibleRow);
                                if (!hasUpdateRole) {
                                    $(row).find('.form-button-action').hide(); // Hide the "Action" button
                                }
                            });
                        },

                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });


        });
            // // // Populate the dropdown with client names
            // $.ajax({
            //     url: '/mbscan/superadmin/getClientId',
            //     type: "GET",
            //     dataType: "json",
            //     success: function(data) {
            //         // Iterate over client data
            //         $.each(data, function(index, value) {
            //             // Append option elements to select element
            //             var $option = $('<option value="' + value.id + '">' + value.client_name + '</option>');
            //             $option.data('role_details', value.role_details); // Set role_details as data attribute
            //             $('#addclientID').append($option);
            //         });
            //     }
            // });

            // Event listener for dropdown change
            $('#addclientID').on('change', function() {
                var selectedClientId = 145;

                // AJAX request to fetch device data based on selected client ID
                $.ajax({
                    url: '/mbscan/superadmin/getDevicesByClientId',
                    type: "GET",
                    dataType: "json",
                    data: {
                        clientId: selectedClientId
                    },
                    success: function(devices) {
                    $('#addDeviceID').empty();
                    $('#addDeviceID').append('<option value="">All Devices</option>');
                    devices.forEach(function(device) {
                        var $option = $('<option value="' + device.id + '">' + device.device_name + '</option>');
                        $('#addDeviceID').append($option);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
                });
            });



        // Initially hide all checkboxes and their associated labels
        $('#createCheckbox, #createLabel, #updateCheckbox, #updateLabel, #viewCheckbox, #viewLabel, #deleteCheckbox, #deleteLabel').hide();

        $('#addclientID').change(function() {
            var selectedOption = $(this).find('option:selected');
            var selectedClientRoleDetails = selectedOption.data('role_details');

            // Hide all checkboxes and their associated labels
            $('#createCheckbox, #createLabel, #updateCheckbox, #updateLabel, #viewCheckbox, #viewLabel, #deleteCheckbox, #deleteLabel').hide();

            // Check the roles in role_details and show corresponding checkboxes and labels
            if (selectedClientRoleDetails) {
                selectedClientRoleDetails = JSON.parse(selectedClientRoleDetails);
                if (selectedClientRoleDetails.can_create) {
                    $('#createCheckbox, #createLabel').show();
                }
                if (selectedClientRoleDetails.can_edit) {
                    $('#updateCheckbox, #updateLabel').show();
                }
                if (selectedClientRoleDetails.can_view) {
                    $('#viewCheckbox, #viewLabel').show();
                }
                if (selectedClientRoleDetails.can_delete) {
                    $('#deleteCheckbox, #deleteLabel').show();
                }
            }
        });

        function addUser() {
            var clientID = $('#addclientID').val();
            var name = $('#addName').val();
            var username = $('#addUsername').val();
            var password = $('#password').val();
            var confirmPassword = $('#confirm_password').val();
            var status = $('#addStatus').val();
            var createCheckbox = $('#createCheckbox').prop('checked');
            var updateCheckbox = $('#updateCheckbox').prop('checked');
            var viewCheckbox = $('#viewCheckbox').prop('checked');
            var deleteCheckbox = $('#deleteCheckbox').prop('checked');
            var device_id = $('#addDeviceID').val();
            console.log("selected device ids: ",device_id);
            // Perform client-side validation
            if (!clientID || !name || !username || !password || !confirmPassword || !status) {
                alert("Please fill out all required fields.");
                return;
            }
            if (password !== confirmPassword) {
                $('#password_error').text('Passwords do not match');
                return;
            }
            $('#addRowModal').modal('hide');
            // AJAX request to send data to the controller
            $.ajax({
                type: 'POST',
                url: '/mbscan/superadmin/adduser',
                data: {
                    client_id: clientID,
                    name: name,
                    username: username,
                    password: password,
                    create: createCheckbox,
                    update: updateCheckbox,
                    view: viewCheckbox,
                    delete: deleteCheckbox,
                    device_id: device_id,
                    role_name: '',
                    status: status,
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        var updateUserId;
        function updateUserDetails(){
            $('#updateTable').modal('hide');
            // Get the updated status and role details

            var status = $('#updateStatus').val();
            var clientId = $('#updateClient').val();
            var username = $('#updateUserName').val();
            // Get boolean values for role details
            var roles = {
                can_create: $('#updateRole input[data-role="create"]').prop('checked'),
                can_edit: $('#updateRole input[data-role="edit"]').prop('checked'),
                can_delete: $('#updateRole input[data-role="delete"]').prop('checked'),
                can_view: $('#updateRole input[data-role="view"]').prop('checked')
            };

            console.log("status", status);
            console.log("roles",roles);
            // Convert boolean values to strings
            for (var key in roles) {
                if (roles.hasOwnProperty(key)) {
                    roles[key] = roles[key] ? 'true' : 'false';
                }
            }
            var data = {
                // clientId: clientId,
                userId: updateUserId,
                status: status,
                roleDetails: roles,
                user_name: username 
            };
            console.log("data",data);

            $.ajax({
                type: 'POST',
                url: '/mbscan/superadmin/updateUser',
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
                url: "/mbscan/client/logout",
                success: function(response) {
                    // Redirect to login page after successful logout
                    window.location.href = '/mbscan/client/login';
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        }
	</script>
</body>
</html>
