<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
	<link rel="icon" href="../assets/img/testright.svg" type="image/x-icon"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Login</title>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <div class="mb-6 text-center">

        <img src="<?php echo base_url(); ?>assets/img/login.svg" alt="Company Logo" class="mx-auto mb-4" style="width: 200px;">            <h1 class="text-2xl font-medium" style="color: #1E1E1E;">Login</h1>
        </div>
        <form id="loginForm">
            <div class="mb-4">
                <label for="username" class="block text-gray-600 text-sm font-medium mb-2">Username</label>
                <input type="text" id="username" name="username" class="w-full border rounded-md py-2 px-3" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-600 text-sm font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full border rounded-md py-2 px-3" required>
            </div>
            <button type="button" onclick="login()" class="w-full bg-blue-500 text-white py-2 rounded-md mb-4">Login</button>
        </form>
        <div id="loginStatusLabel" class="mt-2 text-center text-red-500"></div>
        <div class="mb-6 text-center">
            <img src="<?php echo base_url(); ?>assets/img/byTestRight.svg" alt="Company Logo" class="mx-auto mb-4" style="width: 120px;"> 
        </div>
    </div>

    <script>
        function login(){
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            var formData = {
                username: username,
                password: password
            };
            // AJAX request
            $.ajax({
                type: "POST",
                url: "/mbscan/client/loginAuth",
                data: JSON.stringify(formData),
                contentType: "application/json",
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        // Redirect or do something upon successful login
                        window.location.href = '/mbscan/client/dashboard';
                        console.log(response.message);
                    } else {
                        document.getElementById("loginStatusLabel").innerHTML = response.message;
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>

