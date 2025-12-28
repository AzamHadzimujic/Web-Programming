let ProgressLogService = {
    init: function () {
        $("#progresslog-form").validate({
             rules: {
                weight: {
                    required: true,
                    minlength: 0,
                    maxlength: 500
                },
                bodyfat: {
                    required: true,
                    minlength: 0,
                    maxlength: 100
                }
            },
            messages: {
                name: 'Please enter your name',
                weight: {
                    required: 'Please enter your weight',
                    minlength: 'Weight must be at least 0',
                    maxlength: 'Weight cannot be longer than 500',
                },
                bodyfat: {
                    required: 'Please enter your body fat percentage',
                    minlength: 'Body fat must be at least 0',
                    maxlength: 'Body fat cannot be longer than 100',
                }
            },
            submitHandler: function (form) {
              let progresslog = Object.fromEntries(new FormData(form).entries());
              ProgressLogService.addProgressLog(progresslog);
              form.reset();
            },
          });
       
        $("#editProgressLogForm").validate({
            submitHandler: function (form) {
              let progresslog = Object.fromEntries(new FormData(form).entries());
              ProgressLogService.editProgressLog(progresslog);
            },
        });

        ProgressLogService.getAllProgressLogs();
    },

    openAddModal : function() {
        $('#addProgressLogModal').show();
    }, 

    addProgressLog: function (progresslog) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.post('progresslog', progresslog, function(response){
            toastr.success("Progress log added successfully")
            $.unblockUI();
            ProgressLogService.getAllProgressLogs();
            ProgressLogService.closeModal();
        }, function(response){
            ProgressLogService.closeModal()
            toastr.error(response.message);
        })
    },

    getAllProgressLogs : function(){
        RestClient.get("progresslogs", function(data){
            Utils.datatable('progresslogs-table', [
                { data: 'weight', title: 'Weight' },
                { data: 'bodyfat', title: 'Body Fat' },
                {
                title: 'Actions',
                    render: function (data, type, row, meta) {
                        const rowStr = encodeURIComponent(JSON.stringify(row)); 

                        return `<div class="d-flex justify-content-center gap-2 mt-3">
                            <button class="btn btn-primary" onclick="ProgressLogService.openEditModal('${row.id}')">Edit Progress Log</button>
                            <button class="btn btn-danger" onclick="ProgressLogService.openConfirmationDialog(decodeURIComponent('${rowStr}'))">Delete Progress Log</button>
                            <button class="btn btn-secondary" onclick="ProgressLogService.openViewMore('${row.id}')">View More</button>
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
        RestClient.get('progresslog_by_id?id='+id, function (data) {
            localStorage.setItem('selected_progresslog', JSON.stringify(data))
            $('input[name="weight"]').val(data.weight)
            $('input[name="bodyfat"]').val(data.bodyfat)
            $('input[name="id"]').val(data.id)
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
        let selected_progresslog = JSON.parse(localStorage.getItem('selected_progresslog'))
        $("#progresslog-weight").text(selected_progresslog.weight)
        $("#progresslog-bodyfat").text(selected_progresslog.bodyfat)
    },

    openEditModal : function(id) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        $('#editProgressLogModal').show();
        ProgressLogService.getProgressLogById(id)  
    }, 

    closeModal : function() {
        $('#editProgressLogModal').hide();
        $("#deleteProgressLogModal").modal("hide");
        $('#addProgressLogModal').hide();
    },

    editProgressLog : function(progresslog){
        console.log(progresslog)
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.patch('progresslog/' + progresslog.id, progresslog, function (data) {
            $.unblockUI();
            toastr.success("Progress log edited successfully")
            ProgressLogService.closeModal()
            ProgressLogService.getAllProgressLogs();
        }, function (xhr, status, error) {
            console.error('Error');
            $.unblockUI();
        });
    },

    openConfirmationDialog: function (progresslog) {
        progresslog = JSON.parse(progresslog)
        $("#deleteProgressLogModal").modal("show");
        $("#delete-progresslog-body").html(
        "Do you want to delete progress log: " + progresslog.weight
        );
        $("#delete_progresslog_id").val(progresslog.id);
    },

    deleteProgressLog: function () {
        RestClient.delete('progresslogs/' + $("#delete_progresslog_id").val(), null, function(response){
            ProgressLogService.closeModal()
            toastr.success(response.message);
            ProgressLogService.getAllProgressLogs();
        }, function(response){
            ProgressLogService.closeModal()
            toastr.error(response.message);
        })
    }
}