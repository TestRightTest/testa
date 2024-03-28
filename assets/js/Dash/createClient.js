$(document).ready(function () {
    // Initialize tooltips
    console.log("Document is ready.");

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
        console.log("Making fields editable.");
        var editableColumns = [0, 1, 2, 3];
        row.find('td').each(function (index) {
            if (editableColumns.includes(index)) {
                var currentValue = $(this).text().trim();
                if (index === 1) { // Check if the column is the status column
                    console.log("Status column found.");
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
                    console.log("Role column found.");
                    var roles = ['Create', 'Update', 'Delete', 'Edit'];
                    var checkboxes = '';
                    roles.forEach(role => {
                        var checked = currentValue.includes(role) ? 'checked' : '';
                        checkboxes += '<label><input type="checkbox" value="' + role + '" ' + checked + '> ' + role + '</label><br>';
                    });
                    $(this).data('original-text', currentValue); // Store original text
                    $(this).html(checkboxes);
                } else {
                    console.log("Other column found.");
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
        console.log("Making fields non-editable.");
        row.find('td').each(function () {
            var originalText = $(this).data('original-text');
            $(this).html(originalText);
        });
        var actionCell = row.find('td:last');
        actionCell.html('<div class="form-button-action"><button type="button" data-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary btn-lg edit-btn"><i class="fa fa-edit"></i></button></div>');
    }

    // Event listener for edit button
    $(document).on('click', '.edit-btn', function () {
        console.log("Edit button clicked.");
        var $row = $(this).closest('tr');
        makeFieldsEditable($row);
    });

    // Event listener for cancel button
    $(document).on('click', '.cancel-btn', function () {
        console.log("Cancel button clicked.");
        var $row = $(this).closest('tr');
        makeFieldsNonEditable($row);
    });

    // AJAX request to get client data
    // $.ajax({
    //     type: 'GET',
    //     url: '/world/superAdmin/getClient',
    //     success: function (response) {
    //         table.clear().draw();
    //         response.forEach(function (client) {
    //             var rowData = [
    //                 client.client_name || '-',
    //                 client.status || '-',
    //                 client.role || '-',
    //                 '<td><div class="form-button-action"><button type="button" data-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary btn-lg edit-btn"><i class="fa fa-edit"></i></button></div></td>'
    //             ];
    //             table.row.add(rowData).draw(false);
    //         });
    //     },
    //     error: function (xhr, status, error) {
    //         console.error(xhr.responseText);
    //     }
    // });

    // AJAX request to get client data
    console.log("Sending AJAX request to fetch client data.");
    $.ajax({
        type: 'GET',
        url: '/world/superAdmin/getClient',
        success: function (response) {
            console.log("AJAX request successful. Received client data:", response);
            table.clear().draw();
            response.forEach(function (client) {
                console.log("Processing client:", client);
                var rowData = [
                    client.client_name || '-',
                    client.status || '-',
                    client.role || '-',
                    '<td><div class="form-button-action"><button type="button" data-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary btn-lg edit-btn"><i class="fa fa-edit"></i></button></div></td>'
                ];
                table.row.add(rowData).draw(false);
            });
        },
        error: function (xhr, status, error) {
            console.error("AJAX request failed with error:", error);
        }
    });




    // Event listener for add admin button
    $('#addAdminButton').click(function () {
        console.log("Add admin button clicked.");
        var addName = $('#addName');
        var addStatus = $('#addStatus');
        var roles = $('#roleCreate, #roleEdit, #roleView, #roleDelete');
        if (addName.val().trim() === '' || addStatus.val().trim() === '' || !roles.is(':checked')) {
            console.log("Validation failed. Required fields are empty or checkboxes are not checked.");
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
    url: '/world/superAdmin/addclient',
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
            url: '/world/superAdmin/createSchemaAndTables',
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