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

	<!-- CSS Files -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/atlantis.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/demo.css">
</head>
<body>

	<div class="wrapper">
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
									</span>
								</a>
								<div class="clearfix"></div>
							</div>
						</div>
						
						<ul class="nav nav-primary">
							<!-- Home link -->
							<li class="nav-item active">
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
								<li class="nav-item">
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
						<!-- <div><h1><span id="deviceId">Device ID: </span></h1></div> -->
					
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
									<div class="dropdown" id="AllDevices">
										<button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #3f8cda; color: white; width: 130px;">
											<!-- All Devices -->
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="deviceDropdown">
											<!-- Device IDs will be dynamically added here -->
										</div>
									</div>

									<div class="ml-auto">
										<!-- admin download button -->
										<div class="btn-group" id="Download">
											<button onclick="DownloadData()" type="button" class="btn" style="background-color: #2dbd85; color: #ffffff;">Download</button>
											<!-- <button id="downloadAllDropdownItem" type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #2dbd85; color: #ffffff;">
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu">
												<a class="dropdown-item" onclick="downloadAllData()" >Download All</a>
											</div> -->
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
                                                    <!-- <th ><input type="checkbox" onclick="toggleAll(this)"></th> -->
													<th scope="col">Device ID</th>
													<th scope="col">Sample Name</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Decolorized Time</th>
                                                    <th scope="col">Start Time</th>
                                                    <th scope="col">End Time</th>
													<th scope="col">Channel ID</th>
													<!-- <th scope="col">End Progress</th> -->
													<th scope="col">Test Count</th>

													<!-- <th scope="col">Device Readings</th> -->
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
			var response; 

			function formatDate(date) {
				var year = date.getFullYear();
				var month = ('0' + (date.getMonth() + 1)).slice(-2);
				var day = ('0' + date.getDate()).slice(-2);

				return year + '-' + month + '-' + day;
			}

			function calculateDecolorizedTime(startTime, endTime) {
				var startDate = new Date(startTime);
				var endDate = new Date(endTime);
				var timeDiff = endDate - startDate;
				var decolorizedTime = Math.round(timeDiff / (1000 * 60));

				return decolorizedTime + ' minutes';
			}

			function populateDataTable(data) {

				var table = $('#basic-datatables').DataTable();
				if (table) {
					// If DataTable instance exists, destroy it
					table.destroy();
				}
				$('#basic-datatables').DataTable({
					data: data,
					columns: [
						// {
						// 	// Adding a checkbox in the first column
						// 	data: null,
						// 	render: function(data, type, row, meta) {
						// 		return '<input type="checkbox" class="checkbox">';
						// 	}
						// },
						{ data: 'device_id' },
						{ data: 'sample_name' },
						{
							data: 'start_time',
							render: function(data, type, row, meta) {
								var startDate = new Date(data);
								return formatDate(startDate);
							}
						},
						{
							data: 'end_time',
							render: function(data, type, row, meta) {
								var endDate = new Date(data);
								var startDate = new Date(row.start_time);
								return calculateDecolorizedTime(startDate, endDate);
							}
						},
						{ data: 'start_time' },
						{ data: 'end_time' },
						{ data: 'channel_id' },
						{ data: 'test_count_id' }
					],
					order: [[2, 'desc'], [4, 'desc']] // Sort by start_time (3rd column) first and end_time (5th column) second, both in descending order

				});
			}


			$.ajax({
				url: '/mbscan/client/getUser',
				type: 'GET',
				success: function(data) {
					response = data;
					console.log(response);
					if (response.length > 0) {
						console.log("client_name: ", response[0].client_name);
						$('#companyName').text(response[0].client_name);
						// console.log("role details: ",response[0].role_details );
						console.log("role details: ");
						var roleDetails = JSON.parse(response[0].role_details);
						console.log(roleDetails);
						
						// Check if the user has permission to view only
						// if (roleDetails.can_view && !roleDetails.can_edit && !roleDetails.can_create && !roleDetails.can_delete) {
						// 	// Hide the entire settings option
						// 	$('#settingsOption').hide();
						// } else {
						// 	// Show the settings option
						// 	$('#settingsOption').show();
						// }

						// Clear existing dropdown items
						$('#deviceDropdown').empty();

						// Add "All Devices" option
						$('#deviceDropdown').append('<a class="dropdown-item" href="#" data-id="all">All Devices</a>');

						// Add device IDs and names from the response
						response.forEach(function(data) {
							var deviceIds = data.device_ids.substring(1, data.device_ids.length - 1).split(',');
							var deviceNames = data.device_names.substring(1, data.device_names.length - 1).split(',');

							// Assuming device_ids and device_names have the same length
							for (var i = 0; i < deviceIds.length; i++) {
								var deviceId = deviceIds[i].trim();
								var deviceName = deviceNames[i].trim();
								$('#deviceDropdown').append('<a class="dropdown-item" href="#" data-id="' + deviceId + '">' + deviceName + '</a>');
							}
						});

						$('#dropdownMenuButton').text('All Devices');
						$('#deviceDropdown').find('[data-id="all"]').click();
					}
				},
				error: function(xhr, status, error) {
					console.error(xhr.responseText);
				}
			});

			// Update button text when an option is clicked
			$('#deviceDropdown').on('click', '.dropdown-item', function(e) {
				e.preventDefault();
				var selectedDeviceId = $(this).attr('data-id');
				var selectedDeviceName = $(this).text();
				$('#dropdownMenuButton').text(selectedDeviceId === 'all' ? 'All Devices' : selectedDeviceName);

				var userId = response[0].user_id;

				if (selectedDeviceId !== 'all') {
					// Make AJAX call to get data for selected device and client
					var clientId = response[0].client_id;
					$.ajax({
						url: '/mbscan/client/getSelectedUserData',
						type: 'GET',
						data: {
							device_id: selectedDeviceId,
							client_id: clientId,
							user_id: userId // Pass the userId to the AJAX call
						},
						success: function(data) {
							// Process the data as needed
							populateDataTable(data);
							console.log('Data for selected device:', data);
						},
						error: function(xhr, status, error) {
							console.error(xhr.responseText);
						}
					});
				} else {
					// If "All Devices" is selected, make AJAX call to get all device data
					var clientId = response[0].client_id;
					$.ajax({
						url: '/mbscan/client/getAllDeviceData',
						type: 'GET',
						data: { client_id: clientId, user_id: userId }, // Pass the userId to the AJAX call
						success: function(data) {
							// Process the data as needed
							populateDataTable(data);
							console.log('All device data:', data);
						},
						error: function(xhr, status, error) {
							console.error(xhr.responseText);
						}
					});
				}
			});
		});
		function DownloadData() {
			// Get the DataTable instance
			var table = $('#basic-datatables').DataTable();

			// Get the data from the DataTable
			var data = [];
			table.rows().nodes().each(function (node, index) {
				var rowData = [];
				$(node).find('td').each(function () {
					rowData.push($(this).text());
				});
				data.push(rowData);
			});

			// Prepare workbook and worksheet
			var workbook = XLSX.utils.book_new();
			var worksheet = XLSX.utils.aoa_to_sheet([]);

			// Add column headers
			var headers = table.columns().header().toArray().map(header => header.innerText);
			XLSX.utils.sheet_add_aoa(worksheet, [headers], {origin: 'A1'});

			// Add data rows
			XLSX.utils.sheet_add_aoa(worksheet, data, {origin: 'A2'});

			// Add worksheet to workbook
			XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');

			// Convert workbook to binary Excel file
			var excelFile = XLSX.write(workbook, { bookType: 'xlsx', type: 'binary' });

			// Convert binary Excel file to blob
			var blob = new Blob([s2ab(excelFile)], { type: 'application/octet-stream' });

			// Create a download link
			var link = document.createElement("a");
			link.href = window.URL.createObjectURL(blob);
			link.download = "datatable_data.xlsx";

			// Append the link to the body and trigger the download
			document.body.appendChild(link);
			link.click();

			// Cleanup
			document.body.removeChild(link);
		}

		// Utility function to convert string to ArrayBuffer
		function s2ab(s) {
			var buf = new ArrayBuffer(s.length);
			var view = new Uint8Array(buf);
			for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
			return buf;
		}



		function logout(){
			$.ajax({
			type: "GET",
			url: "/mbscan/client/logout",
			success: function(response) {
				window.location.href = '/mbscan/client/login';
			},
			error: function(xhr, status, error) {ss
				console.error(xhr.responseText);
			}
			});

		}
	</script>
</body>
</html>
