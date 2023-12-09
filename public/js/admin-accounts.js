$(function() {
    attachAViewDoctorListener();
    attachAddRecurringListener();
    attachUpdateDoctorAppointmentListener();
    attachAccessDoctorModalListener();
    attachDeleteDoctorModalListener();
    attachDeleteUserBtnListener();
    attachAViewUserListener();
    attachNotificationBtn();
    attachEditRecurringListener();
});

let doctor_id = null;
let user_id = null;
let availability_id = null;
const attachAViewDoctorListener= () => {
    $(document).on('click', '.viewDoctor', function() {

        let doctorObj = $(this).data('doctor');
        doctor_id = doctorObj.id;
        $('#viewFullname').text(doctorObj.full_name);
        $('#viewContactNo').text(doctorObj.contact_number);
        $('#viewEmail').text(doctorObj.email);
        $('#viewAddress').text(doctorObj.address);
    });
};


const attachAddRecurringListener=() => {
    $(document).on('click', '#addRecBtn', function(e) {
    e.preventDefault(); // Prevent the default form submission

    let start_date = $('#startDate').val();
    let end_date = $('#endDate').val();
    let start_time = $('#startTime').val();
    let end_time = $('#endTime').val();

    // Define an array to store the checked values
    let recurring_days = [];

    // Loop through each checked checkbox and push its value to the array
    $('.days:checked').each(function() {
        recurring_days.push($(this).val());
    });

    // Check if any of the fields is empty
    if (start_time === '' || end_time === '' || recurring_days.length === 0 || start_date === '' || end_date === '') {
        alertify.warning('All fields are required.');
        // alert('All fields are required.');
        return false; // Prevent form submission
    }

    const data = { doctor_id, start_time, end_time, recurring_days, start_date, end_date };

    $.ajax({
        type: "POST",
        url: '/admin/doctor/add-availability',
        data: JSON.stringify(data),
        dataType: "json",
        contentType: "application/json",
        mimeType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
    }).done(function (response) {
        if(response.status) {
            alertify.success('Successfully created.');
        } else {
            alertify.warning('Conflict Schedules.');
        }
    })
    .fail(function(response) {
        switch (response.status) {
            case 422:
                alert(response.responseJSON.message);
            break;
        }
    });


    $('#startDate').val('');
    $('#endDate').val('');
    $('#startTime').val('');
    $('#endTime').val('');
    $('.days').prop('checked', false);

    });
}


const attachUpdateDoctorAppointmentListener= ()=> {
    $(document).on('click', '#updateScheduleBtn', function() {
        let filter_date = $('#filterDate').val();
        filter_date = (filter_date) ? filter_date : null;
        console.log(filter_date);


        initGetAvailabilities(doctor_id, filter_date);
    });
}

const attachAccessDoctorModalListener=()=> {
    $(document).on('click', '#accessDocModalBtn', function() {
        let docName = $('#viewFullname').text();
        console.log(docName);
        $('#doctorName').text(`Doctor ${docName}'s Schedule`);
        initGetAvailabilities(doctor_id, null);
    });
}

const initGetAvailabilities=(doctor_id, filter_date)=> {
    $.ajax({
        url: `/admin/doctor/get-availabilities/${doctor_id}/${filter_date}`,
        type: "GET",
        dataType: "json",
        contentType: "application/json",
        mimeType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        }
    }).done(function(response) {
        if(response.status) {
            $('#availabilitySlotTbl').empty();
            const date = response.date;
            const slots = response.available_slots;

            if(slots.length > 0) {
                $.each(slots, (function(index, slot) {
                    let formattedFrom = moment(slot.start_time, 'HH:mm').format('hh:mm a');
                    console.log(slot.end_time);
                    let formattedTo = moment(slot.end_time, 'HH:mm').format('hh:mm a')
                    let recurring_days = JSON.parse(slot.recurring_days);
                    recurring_days = recurring_days.map(dayNumber => moment().isoWeekday(parseInt(dayNumber)).format('dddd'));
                    let patientQueue = slot.patients_queue;

                   $('#availabilitySlotTbl')
                      .append(
                       $('<tr />')
                           .append($('<td />').text(recurring_days))
                           .append($('<td />').text(`${formattedFrom} - ${formattedTo}`))
                           .append($('<td class="text-center"/>').text(patientQueue))
                           .append($('<td />').addClass('text-center')
                                    .append($('<a />').attr({'class' : 'view-appointment-btn p-1', 'href': '#'})
                                    .bind('click', function() {

                                        let docName = $('#viewFullname').text();
                                        availability_id = slot.id;
                                        $('#editDoctorName').text(`Doctor ${docName}'s Schedule`);
                                        $('#editStartDate').val(slot.start_date);
                                        $('#editEndDate').val(slot.end_date);
                                        $('#editStartTime').val(slot.start_time);
                                        $('#editEndTime').val(slot.end_time);

                                        let recurringDays = JSON.parse(slot.recurring_days);
                                        $('.editDays').each(function() {
                                            let checkboxValue = $(this).val();
                                            // Check if the value is in the recurringDays array
                                            if ($.inArray(checkboxValue, recurringDays) !== -1) {
                                                $(this).prop('checked', true);
                                            } else {
                                                $(this).prop('checked', false);
                                            }
                                        });

                                        $('#updateDoctorSchedule').modal('hide');
                                        $('#editDoctorSchedule').modal('show');

                                    })
                                        .text('Edit')
                                    )
                               )
                      )

               }));
            } else {
                $('#availabilitySlotTbl').append($('<tr />')
                    .append($('<td />').attr({'colspan': 4, 'class':'text-center'}).text('No Schedule found'))
                )
            }
        }
    });
}

const attachDeleteDoctorModalListener=()=> {
    $(document).on('click', '#deleteDoctorModalBtn', function() {
        const doctor = $(this).data('doctor');
        user_id = doctor.id;
    });

    $(document).on('click', '#deleteUserModalBtn', function() {
        const user = $(this).data('user');
        user_id = user.id;
    });
}


const attachDeleteUserBtnListener=()=> {
    $(document).on('click', '#deleteUserBtn', function() {


        $.ajax({
            type: "DELETE",
            url: `/admin/accounts/${user_id}`,
            dataType: "json",
            contentType: "application/json",
            mimeType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
        }).done(function (response) {
            if(response.status) {
                    alert('Successfully deleted!');
                    location.reload();
            }
            else {
                alert(response.message);
            }
        }).fail(function(response) {
            switch (response.status) {
                case 422:
                    alert(response.responseJSON.message);
                break;
            }
        });
    });


}

const attachAViewUserListener= () => {
    $(document).on('click', '.viewUser', function() {

        let user = $(this).data('user');
        user_id = user.id;
        $('#viewUserFullname').text(user.full_name);
        $('#viewUserContactNo').text(user.contact_number);
        $('#viewUserEmail').text(user.email);
        $('#viewUserAddress').text(user.address);
    });
};

const attachNotificationBtn=()=> {
    $(document).on('click', '#notificationBtn', function() {
        let count = $('.notif-count').data('count');

        if(count > 0) {
            $.ajax({
                type: "POST",
                url: '/admin/update-notification',
                dataType: "json",
                contentType: "application/json",
                mimeType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            }).done(function (response) {
                if(response.status) {
                    $('.notif-count').text(0);
                }
            })
        }
    });
}

const attachEditRecurringListener=() => {
    $(document).on('click', '#editRecBtn', function(e) {
    e.preventDefault(); // Prevent the default form submission
    pageLoading();
    let start_date = $('#editStartDate').val();
    let end_date = $('#editEndDate').val();
    let start_time = $('#editStartTime').val();
    let end_time = $('#editEndTime').val();

    // Define an array to store the checked values
    let recurring_days = [];

    // Loop through each checked checkbox and push its value to the array
    $('.editDays:checked').each(function() {
        recurring_days.push($(this).val());
    });

    // Check if any of the fields is empty
    if (start_time === '' || end_time === '' || recurring_days.length === 0 || start_date === '' || end_date === '') {
        alertify.warning('All fields are required.');
        return false; // Prevent form submission
    }

    const data = { doctor_id, start_time, end_time, recurring_days, start_date, end_date };

    $.ajax({
        type: "PUT",
        url: `/admin/doctor/edit-availability/${availability_id}`,
        data: JSON.stringify(data),
        dataType: "json",
        contentType: "application/json",
        mimeType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
    }).done(function (response) {
        if(response.status) {
            alertify.success('Successfully updated.');
            setTimeout(function() {
                location.reload();
            }, 2000);
            pageLoaded();
        } else {
            alertify.warning('Conflict Schedules.');
            pageLoaded();
        }
    })
    .fail(function(response) {
        switch (response.status) {
            case 422:
                alert(response.responseJSON.message);
            break;
        }
    });

    });
}
