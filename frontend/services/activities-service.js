let ActivitiesService = {
    init: function () {
        $("#activity-form").validate({
             rules: {
                activitytype: 'required',
                duration: {
                    required: true,
                    minlength: 1,
                    digits: true
                },
                distacnce: {
                    required: true,
                    minlength: 1,
                    digits: true
                }
            },
            messages: {
                activitytype: 'Please select an activity type',
                duration: {
                    required: 'Please enter the duration',
                    digits: 'Please enter a valid number for duration'
                },
                distance: {
                    required: 'Please enter the distance',
                    digits: 'Please enter a valid number for distance'
                }
            },
            submitHandler: function (form) {
              let activity = Object.fromEntries(new FormData(form).entries());
              ActivitiesService.addActivity(activity);
              form.reset();
            },
          });
       
        $("#editActivityForm").validate({
            submitHandler: function (form) {
              let activity = Object.fromEntries(new FormData(form).entries());
              ActivitiesService.editActivity(activity);
            },
        });

        ActivitiesService.getAllActivities();
    },

    openAddModal : function() {
        $('#addActivityModal').show();
    }, 

    addActivity: function (activity) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.post('activity', activity, function(response){
            toastr.success("Activity added successfully")
            $.unblockUI();
            ActivitiesService.getAllActivities();
            ActivitiesService.closeModal();
        }, function(response){
            ActivitiesService.closeModal()
            toastr.error(response.message);
        })
    },

    getAllActivities : function(){
        RestClient.get("activities", function(data){
            Utils.datatable('activities-table', [
                { data: 'activityType', title: 'Activity Type' },
                { data: 'duration', title: 'Duration (min)' },
                { data: 'distance', title: 'Distance (km)' },
                {
                title: 'Actions',
                    render: function (data, type, row, meta) {
                        const rowStr = encodeURIComponent(JSON.stringify(row)); 

                        return `<div class="d-flex justify-content-center gap-2 mt-3">
                            <button class="btn btn-primary" onclick="ActivitiesService.openEditModal('${row.id}')">Edit Activity</button>
                            <button class="btn btn-danger" onclick="ActivitiesService.openConfirmationDialog(decodeURIComponent('${rowStr}'))">Delete Activity</button>
                            <button class="btn btn-secondary" onclick="ActivitiesService.openViewMore('${row.id}')">View More</button>
                        </div>
                        `;
                    }
                }
            ], data, 10);
        }, function (xhr, status, error) {
            console.error('Error fetching data from file:', error);
        });
    },

    getActivityById : function(id) {
        RestClient.get('activity_by_id?id='+id, function (data) {
            localStorage.setItem('selected_activity', JSON.stringify(data))
            $('input[name="activityType"]').val(data.activityType)
            $('input[name="duration"]').val(data.duration)
            $('input[name="distance"]').val(data.distance)
            $.unblockUI();
        }, function (xhr, status, error) {
            console.error('Error fetching data');
            $.unblockUI();
        });
    }, 

    openViewMore : function(id) {
        window.location.replace("#view_more");
        ActivitiesService.getActivityById(id) 
    },

    populateViewMore : function(){
        let selected_activity = JSON.parse(localStorage.getItem('selected_activity'))
        $("#activity-type").text(selected_activity.activityType)
        $("#user-email").text(selected_user.email)
    },

    openEditModal : function(id) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        $('#editActivityModal').show();
        ActivitiesService.getActivityById(id)  
    }, 

    closeModal : function() {
        $('#editActivityModal').hide();
        $("#deleteActivityModal").modal("hide");
        $('#addActivityModal').hide();
    },

    editActivity : function(activity){
        console.log(activity)
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.patch('activity/' + activity.id, activity, function (data) {
            $.unblockUI();
            toastr.success("Activity edited successfully")
            ActivitiesService.closeModal()
            ActivitiesService.getAllActivities();
        }, function (xhr, status, error) {
            console.error('Error');
            $.unblockUI();
        });
    },

    openConfirmationDialog: function (activity) {
        activity = JSON.parse(activity)
        $("#deleteActivityModal").modal("show");
        $("#delete-activity-body").html(
        "Do you want to delete activity: " + activity.activityType + "?"
        );
        $("#delete_user_id").val(user.id);
    },

    deleteActivity: function () {
        RestClient.delete('activities/' + $("#delete_activity_id").val(), null, function(response){
            ActivitiesService.closeModal()
            toastr.success(response.message);
            ActivitiesService.getAllActivities();
        }, function(response){
            ActivitiesService.closeModal()
            toastr.error(response.message);
        })
    }
}