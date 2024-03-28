<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script  src="https://www.gstatic.com/firebasejs/9.0.1/firebase-app-compat.js"></script>
    <script  src="https://www.gstatic.com/firebasejs/9.0.1/firebase-auth-compat.js"></script>
    <script  src="https://www.gstatic.com/firebasejs/ui/6.0.0/firebase-ui-auth.js"></script>
	<link rel="icon" href="../assets/img/testright.svg" type="image/x-icon"/>

    <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-database-compat.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <title>Login</title>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-medium" style="color: #1E1E1E;">Super Admin Login</h1>
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
        </div>
    </div>

    <script>
//     function login() {
//     var username = document.getElementById('username').value;
//     var password = document.getElementById('password').value;

//     // Send an AJAX request to the server to handle login
//     fetch('/mbscan/superAdmin/loginAuth', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//         },
//         body: JSON.stringify({
//             username: username,
//             password: password
//         })
//     })
//     .then(response => {
//         if (response.ok) {
//             // Log that the login was successful
//             console.log('Login successful');

//             window.location.href = '/mbscan/superAdmin/dashboard';
//         } else {
//             console.log('Login failed');

//             document.getElementById('loginStatusLabel').textContent = 'Login failed. Please try again.';
//         }
//     })
//     .catch(error => {
//         console.error('Error:', error);
//     });
// }

function login() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    var formData = {
        username: username,
        password: password
    };

    // AJAX request
    $.ajax({
        type: "POST",
        url: "/mbscan/superAdmin/loginAuth",
        data: JSON.stringify(formData),
        contentType: "application/json",
        dataType: "json",
        success: function(response) {
            if (response.status === 'success') {
                // Redirect or do something upon successful login
                window.location.href = '/mbscan/superAdmin/dashboard';
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

