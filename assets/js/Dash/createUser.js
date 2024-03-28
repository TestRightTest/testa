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
        url: '/world/superAdmin/getUsers',
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
        url: '/world/superAdmin/adduser',
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
        url: "/world/superAdmin/logout",
        success: function(response) {
            // Redirect to login page after successful logout
			window.location.href = '/world/superAdmin/login';
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

	}