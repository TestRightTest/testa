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
                            <li class="nav-item">
                                <a href="<?= base_url('superAdmin/dashboard') ?>" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-plus"></i>
                                    <p>Create/Edit Client</p>
                                </a>
                            </li>
                            <li class="nav-item active">
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
				<!-- <div id="loadingScreen">
					<i id="loadingIcon" class="fas fa-spinner"></i>
				</div> -->
				<div class="page-inner">

					<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Add User</h4>
										<button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
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
															<div class="col-sm-12">
																<div class="form-group form-group-default">
																	<label>Device ID</label>
																	<input id="addDeviceID" type="text" class="form-control" placeholder="Enter Device ID">
																</div>
															</div>
															<div class="col-md-6 pr-0">
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
															<div class="col-sm-12">
																<div class="form-group form-group-default">
																	<label>Role</label>
																	<div class="row">
																		<div class="col-sm-3">
																			<input type="checkbox" id="createCheckbox" value="create">
																			<label for="roleCreate">Create</label>
																		</div>
																		<div class="col-sm-3">
																			<input type="checkbox" id="updateCheckbox" value="edit">
																			<label for="roleEdit">Edit</label>
																		</div>
																		<div class="col-sm-3">
																			<input type="checkbox" id="viewCheckbox" value="view">
																			<label for="roleView">View</label>
																		</div>
																		<div class="col-sm-3">
																			<input type="checkbox" id="deleteCheckbox" value="delete">
																			<label for="roleDelete">Delete</label>
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
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Device ID</th>
													<th>Name</th>
													<th>Username</th>
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
	
	<script>
		$(document).ready(function () {
    const table = $('#add-row').DataTable({
        pageLength: 10
    });

    const $addUserButton = $('#addUserButton');
    const $addRowModal = $('#addRowModal');
    const $password = $('#password');
    const $confirmPassword = $('#confirm_password');
    const $passwordError = $('#password_error');
    const $addDeviceID = $('#addDeviceID');
    const $addName = $('#addName');
    const $addUsername = $('#addUsername');

    function initTooltips() {
        $('[data-toggle="tooltip"]').tooltip();
    }

	function makeFieldsEditable(row) {
    const editableColumns = [0, 1, 2, 3];
    row.find('td').each((index, td) => {
        if (editableColumns.includes(index)) {
            let htmlContent = '';
            const currentValue = $(td).text().trim();
            if (index === 3) { // If it's the role column
                const checkboxOptions = ['Create', 'Edit', 'Delete', 'View'];
                checkboxOptions.forEach(option => {
                    const isChecked = currentValue.includes(option);
                    htmlContent += `<label class="checkbox-inline"><input type="checkbox" value="${option}" ${isChecked ? 'checked' : ''}> ${option}</label>`;
                });
            } else {
                htmlContent = `<input type="text" class="form-control" value="${currentValue}">`;
            }
            $(td).data('original-text', currentValue).html(htmlContent);
        }
    });

    const actionCell = row.find('td:last');
    actionCell.html(`<div class="btn-group" role="group">
        <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-link btn-danger cancel-btn">
            <i class="fa fa-times"></i>
        </button>
        <button type="button" data-toggle="tooltip" title="Submit" class="btn btn-link btn-success btn-lg submit-btn" id="submitProgress">
            <i class="fa fa-check"></i>
        </button>
    </div>`);
	}


    function makeFieldsNonEditable(row) {
        row.find('td').each(function () {
            const originalText = $(this).data('original-text');
            $(this).html(originalText);
        });
		
        const actionCell = row.find('td:last');
        actionCell.html(`<div class="form-button-action">
            <button type="button" data-toggle="tooltip" " class="btn btn-link btn-primary btn-lg edit-btn">
                <i class="fa fa-edit"></i>
            </button>
        </div>`);
    }

    $(document).on('click', '.edit-btn', function () {
        const $row = $(this).closest('tr');
        makeFieldsEditable($row);
    });

    $(document).on('click', '.cancel-btn', function () {
        const $row = $(this).closest('tr');
        makeFieldsNonEditable($row);
    });

    $addUserButton.click(function () {
        const fields = [$addDeviceID, $addName, $addUsername, $password, $confirmPassword];
        let isValid = true;
        fields.forEach(field => {
            if (field.val().trim() === '') {
                field.addClass('is-invalid');
                isValid = false;
            } else {
                field.removeClass('is-invalid');
            }
        });

        if (!isValid) return;

        $addRowModal.modal('hide');
    });

    $addRowModal.on('show.bs.modal', function (e) {
        [ $addDeviceID, $addName, $addUsername, $password, $confirmPassword ].forEach(field => {
            field.val('').removeClass('is-invalid');
        });
        $passwordError.text('');
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

    // Load users and populate DataTable
    $.ajax({
        type: 'GET',
        url: '/mbscan/superAdmin/getUsers',
        success: function (response) {
            table.clear().draw();
            response.forEach(user => {
                const rowData = [
                    user.device_id || '-',
                    user.name || '-',
                    user.user_name || '-',
                    user.role || '-',
                    `<div class="form-button-action">
                        <button type="button" data-toggle="tooltip" " class="btn btn-link btn-primary btn-lg edit-btn">
                            <i class="fa fa-edit"></i>
                        </button>
                    </div>`
                ];
                initTooltips();
                table.row.add(rowData).draw(false);
            });
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});



	function addUser() {
    var deviceID = $('#addDeviceID').val();
    var name = $('#addName').val();
    var username = $('#addUsername').val();
    var password = $('#password').val();
    var confirmPassword = $('#confirm_password').val();
    var createCheckbox = $('#roleCreate').prop('checked');
    var updateCheckbox = $('#roleEdit').prop('checked');
    var viewCheckbox = $('#roleView').prop('checked');
    var deleteCheckbox = $('#roleDelete').prop('checked');
    // Perform client-side validation
    if (!deviceID || !name || !username || !password || !confirmPassword) {
        alert("Please fill out all required fields.");
        return;
    }
    if (password !== confirmPassword) {
        $('#password_error').text('Passwords do not match');
        return;
    }

    // AJAX request to send data to the controller
    $.ajax({
        type: 'POST',
        url: '/mbscan/superAdmin/adduser',
        data: {
            device_id: deviceID,
            name: name,
            username: username,
            password: password,
            create: createCheckbox,
            update: updateCheckbox,
            view: viewCheckbox,
            delete: deleteCheckbox,
            role_name: '',
            status:'',
        },
        success: function(response) {
            console.log(response);
        },
        error: function(xhr, status, error) {
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
