function showToast(type, message) {
    if (type === 'success') {
        toastr.success(message, 'Success');
    } else {
        toastr.error(message, 'Error');
    }
}

$('#addUserForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'users/save',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#AddNewModal').modal('hide');
                $('#addUserForm')[0].reset();

                // Show toast
                showToast('success', 'User added successfully!');

                // Wait for a moment before reload so toast can show
                setTimeout(() => {
                    location.reload();
                }, 1000); // 1.5 seconds
            } else {
                showToast('error', response.message || 'Failed to add user.');
            }
        },
        error: function () {
            showToast('error', 'An error occurred.');
        }
    });
});

// Handle the click event for the Edit button
$(document).on('click', '.edit-btn', function () {
     const userId = $(this).data('id'); // Get user ID from data-id attribute

        // Fetch user details via AJAX
             $.ajax({
                    url: baseUrl + 'users/edit/' + userId, // URL for fetching user details
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.data) {
                            // Populate the modal with the user data
                            $('#editUserModal #name').val(response.data.name);
                            $('#editUserModal #userId').val(response.data.id);
                            $('#editUserModal #email').val(response.data.email);
                            $('#editUserModal #password').val(''); // Clear password field
                            $('#editUserModal #role').val(response.data.role);
                            $('#editUserModal #status').val(response.data.status);
                            $('#editUserModal #phone').val(response.data.phone);
                            // Show the modal
                            $('#editUserModal').modal('show');
                        } else {
                            alert('Error fetching user data');
                        }
                    },
                    error: function () {
                        alert('Error fetching user data');
                    }
                });
            });

            // Handle the form submission for updating the user
            $('#editUserForm').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                const formData = {
                    id: $('#editUserModal #userId').val(),
                    email: $('#editUserModal #email').val(),
                    name: $('#editUserModal #name').val(),
                    password: $('#editUserModal #password').val(), // Get the password (empty if not updated)
                    role: $('#editUserModal #role').val(),
                    status: $('#editUserModal #status').val(),
                    phone: $('#editUserModal #phone').val()
                };

                // Send the update request via AJAX
                $.ajax({
                    url: baseUrl + 'users/update', // URL for updating the user
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                if (response.success) {
                            // Close the modal
                $('#editUserModal').modal('hide');

                // Show toast
                 showToast('success', 'User Updated successfully!');
               
                setTimeout(() => {
                 location.reload();
                }, 1000); // 1.5 seconds
             } else {
             alert('Error updating user');
             }
            },
            error: function () {
        alert('Error updating user');
        }
     });
});


$(document).on('click', '.deleteUserBtn', function () {
    const userId = $(this).data('id');

    if (confirm('Are you sure you want to delete this user?')) {
        $.ajax({
            url: baseUrl + 'users/delete/' + userId,
            method: 'DELETE',
            success: function (response) {
                if (response.success) {
                 
                     showToast('success', 'User deleted successfully.');
                   setTimeout(() => {
                    location.reload();
                }, 1000); // 1.5 seconds
                } else {
                    alert(response.message || 'Failed to delete user.');
                }
            },
            error: function () {
                alert('Something went wrong while deleting.');
            }
        });
    }
});

$(document).ready(function () {
    const $table = $('#example1');

    $table.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: baseUrl + 'users/fetchUsers',
            type: 'POST',
        },
        columns: [
            { data: 'row_number' },
            { data: 'id', visible: false },
            { data: 'name' },
            { data: 'email' },
            { data: 'role' },
            { data: 'status' },
            { data: 'phone' },
            { data: 'created_at' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-warning edit-btn" data-id="${row.id}">
                            <i class="far fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteUserBtn" data-id="${row.id}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `;
                }
            }
        ],
        responsive: true,
        autoWidth: false
    });
});
