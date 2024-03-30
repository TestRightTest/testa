<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>MB Scan Dashboard</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="<?php echo base_url(); ?>assets/img/testright.svg" type="image/x-icon"/>
	<!-- firebase -->
    <!-- <script src="../assets/js/plugin/webfont/webfont.min.js"></script> -->
	<script src="<?php echo base_url(); ?>assets/js/plugin/webfont/webfont.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/Dash/downloadData.js"></script>


	<!-- Add these links to include Bootstrap Toast related files -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" integrity="sha384-twXV5tVO9tbFntpIBKbF+JLeI73KbSe5O8XUaVsFqtk3F" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-pzjw8Y+uoVBfXgDgS2KOg02eR5WSs5f/v0p1wrKHAFOw0s6Rl/d8yUJ6UeG4uP1M" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYjGvIccE6D6P7e3PeN9O5trF" crossorigin="anonymous"></script>

	<!-- Fonts and icons -->
	<!-- <script src="../assetss/js/plugin/webfont/webfont.min.js"></script> -->
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha256-F6p5o3Gw0w9Il6G8uo2bD8aLG6fBNE0t1AsjwmP5dEw=" crossorigin="anonymous" /> -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>
	
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

	tr.highlight {
		background-color:#D3D3D3; 
	}
	.light-line {
		width: 90%; 
    	border-top: 1px solid #f0f0f0; 
    	margin: 10px auto; 
	}

	.btn-toggle{
		color: #fff;
	}

	</style>

	<script src="<?php echo base_url(); ?>assets/js/plugin/webfont/webfont.min.js"></script>
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
			var user = firebase.auth().currentUser;

			if (user) {
				// User is signed in, reauthenticate with the entered password
				var credential = firebase.auth.EmailAuthProvider.credential(
					user.email,
					enteredPassword
				);

				user.reauthenticateWithCredential(credential)
					.then(function() {
						// Reauthentication successful, redirect to settings.html
						window.location.href = 'settings.html';
					})
					.catch(function(error) {
						console.error('Reauthentication error:', error);
						alert('Incorrect password. Please try again.');
					});
			} else {
				// User is not signed in, handle accordingly
				// console.log('User is not logged in');
				// You may want to redirect to the login page or show a message
			}
		});
	});
	
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/atlantis.min.css">
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/demo.css">
	<!-- <script src="../assets/js/Dash/Dashboard.js"></script> -->

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
                            <li class="nav-item">
                                <a href="<?= base_url('client/dashboard') ?>" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-home"></i>
                                    <p>Home</p>
                                </a>
                            </li>
							<li class="nav-item active"   id="settingsItem" style="display: block;" data-toggle="modal" data-target="#exampleModalCenter">
								<a data-toggle="collapse" href="<?= base_url('client/dashboard/settings') ?>" class="collapsed" aria-expanded="false">
									<i class="fas fa-cog"></i>
									<p>Settings</p>
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
													<th>Password</th>
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
    <!-- <script src="../documentation/assets/Dashboard.js"></script> -->
	<script src="<?php echo base_url(); ?>assets/js/Dash/settings.js"></script>
</body>
</html>