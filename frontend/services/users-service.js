let UsersService = {
    init: function () {
        $("#register-form").validate({
             rules: {
                username: 'required',
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                }
            },
            messages: {
                name: 'Please enter your name',
                email: {
                    required: 'Please enter your email',
                    email: 'Please enter a valid email address'
                },
                password: {
                    required: 'Please enter a password',
                    minlength: 'Password must be at least 8 characters long',
                    maxlength: 'Password cannot be longer than 20 characters',
                }
            },
            submitHandler: function (form) {
              let user = Object.fromEntries(new FormData(form).entries());
              UsersService.addUser(user);
              form.reset();
            },
          });
       
        $("#editUserForm").validate({
            submitHandler: function (form) {
              let user = Object.fromEntries(new FormData(form).entries());
              UsersService.editUser(user);
           
            },
        });

        UsersService.getAllUsers();
    },

    openAddModal : function() {
        $('#addUserModal').show();
    }, 

    addUser: function (user) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.post('user', user, function(response){
            toastr.success("User added successfully")
            $.unblockUI();
            UsersService.getAllUsers();
            UsersService.closeModal();
        }, function(response){
            UsersService.closeModal()
            toastr.error(response.message);
        })
    },

    getAllUsers : function(){
        RestClient.get("users", function(data){
            Utils.datatable('users-table', [
                { data: 'name', title: 'Name' },
                { data: 'email', title: 'Email' },
                { data: 'password', title: 'Password' },
                {
                title: 'Actions',
                    render: function (data, type, row, meta) {
                        const rowStr = encodeURIComponent(JSON.stringify(row)); 

                        return `<div class="d-flex justify-content-center gap-2 mt-3">
                            <button class="btn btn-primary" onclick="UsersService.openEditModal('${row.id}')">Edit User</button>
                            <button class="btn btn-danger" onclick="UsersService.openConfirmationDialog(decodeURIComponent('${rowStr}'))">Delete User</button>
                            <button class="btn btn-secondary" onclick="UsersService.openViewMore('${row.id}')">View More</button>
                        </div>
                        `;
                    }
                }
            ], data, 10);
        }, function (xhr, status, error) {
            console.error('Error fetching data from file:', error);
        });
    },

    getUserById : function(id) {
        RestClient.get('user_by_id?id='+id, function (data) {
            localStorage.setItem('selected_user', JSON.stringify(data))
            $('input[name="username"]').val(data.username)
            $('input[name="email"]').val(data.email)
            $('input[name="password"]').val(data.password)
            $.unblockUI();
        }, function (xhr, status, error) {
            console.error('Error fetching data');
            $.unblockUI();
        });
    }, 

    openViewMore : function(id) {
        window.location.replace("#view_more");
        UsersService.getUserById(id) 
    },

    populateViewMore : function(){
        let selected_user = JSON.parse(localStorage.getItem('selected_user'))
        $("#user-name").text(selected_user.username)
        $("#user-email").text(selected_user.email)
        $("#user-password").text(selected_user.password)
    },

    openEditModal : function(id) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        $('#editUserModal').show();
        UsersService.getUserById(id)  
    }, 

    closeModal : function() {
        $('#editUserModal').hide();
        $("#deleteUserModal").modal("hide");
        $('#addUserModal').hide();
    },

    editUser : function(user){
        console.log(user)
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.patch('user/' + user.id, user, function (data) {
            $.unblockUI();
            toastr.success("User edited successfully")
            UsersService.closeModal()
            UsersService.getAllUsers();
        }, function (xhr, status, error) {
            console.error('Error');
            $.unblockUI();
        });
    },

    openConfirmationDialog: function (user) {
        user = JSON.parse(user)
        $("#deleteUserModal").modal("show");
        $("#delete-user-body").html(
        "Do you want to delete user: " + user.name
        );
        $("#delete_user_id").val(user.id);
    },

    deleteUser: function () {
        RestClient.delete('users/' + $("#delete_user_id").val(), null, function(response){
            UsersService.closeModal()
            toastr.success(response.message);
            UsersService.getAllUsers();
        }, function(response){
            UsersService.closeModal()
            toastr.error(response.message);
        })
    }
}