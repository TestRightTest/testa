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
		document.addEventListener('DOMContentLoaded', function() {
		var passwordInput = document.getElementById('password-input');
		var submitButton = document.getElementById('submit-button');

		submitButton.addEventListener('click', function() {
			var enteredPassword = passwordInput.value;

			// Get the currently signed-in user
			if (user) {
					//logic for user sign in
			} else {
				// User is not signed in, handle accordingly
				console.log('User is not logged in');
				// You may want to redirect to the login page or show a message
			}
		});
	});
	
	</script>
	<style>
		.logo-header .navbar-brand {
            max-height: 30px; /* Adjust the max height as needed */
        }

        .logo-header .navbar-brand img {
            max-width: 100%;
            height: auto;
        }

        /* Optional: Adjust the size of the toggle button icons */
        .navbar-toggler-icon,
        .btn-toggle i {
            font-size: 20px; /* Adjust the font size as needed */
        }

		.start-time-column {
			display: none;
		}

		/* Show the Start Time column when the 'admin' class is present */
		.admin .start-time-column {
			display: table-cell;
		}

		#loadingScreen {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(128, 128, 128, 0.8);
		display: flex;
		align-items: center;
		justify-content: center;
		z-index: 9999;
		color: white; /* Text color */
	}


    #loadingIcon {
        font-size: 3em; /* Adjust the size of the spinner */
        animation: spin 1s linear infinite; /* Rotation animation */
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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
		<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
						<div id="error-message" style="color: red; font-size: 12px;"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn" data-dismiss="modal">Close</button>
						<button type="button" class="btn" id="submit-button" style="background-color: #2dbd85; color: white;">Submit</button>
					</div>
				</div>
			</div>
		</div>
		
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
				<!-- <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button> -->
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
										<span id="AccType" style=" font-size: small">Account Type</span>
										<span id="companyId" style=" font-size: small">Company ID</span>
									</span>
								</a>
								<div class="clearfix"></div>
							</div>
						</div>
						
                        <ul class="nav nav-primary">
                            <li class="nav-item active">
                                <a href="<?= base_url('client/dashboard') ?>" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-home"></i>
                                    <p>Home</p>
                                </a>
                            </li>
							<li class="nav-item"   id="settingsItem" style="display: none;" data-toggle="modal" data-target="#exampleModalCenter">
								<a data-toggle="collapse" href="<?= base_url('client/dashboard/settings') ?>" class="collapsed" aria-expanded="false">
									<i class="fas fa-cog"></i>
									<p>Settings</p>
									<!-- <span class="caret"></span> -->
								</a>
							</li>		
							<hr class="light-line">

							<li class="nav-item">
                                <a href="#signout function" class="collapsed" aria-expanded="false" onclick="signOut()">
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
						<div><h1><span id="deviceId">Device ID: </span></h1></div>
					
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
									<div class="dropdown" id="AllDevices" style="display: none;">
										<button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #3f8cda; color: white;">
											<!-- All Devices -->
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="deviceDropdown">
											<!-- Device IDs will be dynamically added here -->
										</div>
									</div>
									<!-- Add this HTML structure to your page where you want to display the toast -->

									<!-- Place this div with ml-auto to push the buttons to the right -->
									<div class="ml-auto">
										<!-- user download button -->
										<div class="btn-group" id="userDownload" style="display: none;">
											<button onclick="exportSelected()" type="button" class="btn" style="background-color: #2dbd85; color: #ffffff;">Download</button>
											<button id="downloadAllDropdownItem" type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #2dbd85; color: #ffffff;">
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu">
												<a class="dropdown-item" onclick="downloadAll()" style="color: #2dbd85;">Download All</a>
											</div>
										</div>
						
										<!-- admin download button -->
										<div class="btn-group" id="adminDownload" style="display: none; ">
											<button onclick="downloadAdminSelectedData()" type="button" class="btn" style="background-color: #2dbd85; color: #ffffff;">Download</button>
											<button id="downloadAllDropdownItem" type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #2dbd85; color: #ffffff;">
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu">
												<a class="dropdown-item" onclick="downloadAdminAllData()" >Download All</a>
											</div>
										</div>

										<!-- <div id="toastContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 11">
										</div> -->
									</div>
									<!-- End of ml-auto div -->
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
                                                    <th ><input type="checkbox" onclick="toggleAll(this)"></th>
													<th scope="col">Company ID</th>
													<th scope="col">Device ID</th>
													<th scope="col">Sample Name</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Decolorized Time</th>
                                                    <th scope="col">Start Time</th>
                                                    <th scope="col">End Time</th>
													<th scope="col">Channel ID</th>
													<th scope="col">End Progress</th>
													<th scope="col">Device Readings</th>
													
												</tr>
											</thead>                                  
                                            <tbody id="tableBody"></tbody>
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
	<script >
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
			});

			$('#multi-filter-select').DataTable( {
				"pageLength": 5,
				initComplete: function () {
					this.api().columns().every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value=""></option></select>')
						.appendTo( $(column.footer()).empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
								);

							column
							.search( val ? '^'+val+'$' : '', true, false )
							.draw();
						} );

						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
				}
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
		});
	</script>
	<!-- <script>
		function fetchDataServer() {
			if ( document.getElementById('deviceIdInput').value != '' ) {
				$.ajax({
					url: 'result.php?id='+document.getElementById('deviceIdInput').value ,
					type: 'GET',
					dataType: 'json',
					success: function(response) {
						var table = $('#basic-datatables').DataTable();
						table.rows().remove().draw();
						if (response.code === '200') {
							populateDatatable(response.data);
						} else {
							console.error('Error: Unable to fetch data.');
						}
					},
					error: function(xhr, status, error) {
						console.error('Error: ' + error);
					}
				});
			}
		}

		// Function to populate datatable
		function populateDatatable(data) {
			var table = $('#basic-datatables').DataTable();
			table.rows().remove().draw();
			data.forEach(function(row) {
				table.row.add([
					row.company_id,
					row.device_id,
					row.sample_name,
					row.date,
					row.decolorized_time,
					row.start_time,
					row.end_time,
					row.channel_id,
					row.end_progress,
					row.test_count_id
				]).draw(false);
			});
		}

		$(document).ready(function() {
			var intervalId = setInterval(fetchDataServer, 10000);
		});
	</script> -->
</body>
</html>
