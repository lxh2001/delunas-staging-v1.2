$(function(){
    attachViewAppointmentInfoModal();
    attachApproveAppointmentBtn();
    attachRescheduleAppointmentModal();
    attachRescheduledFilterDate();
    attachRescheduleAppointmentBtn();
    attachCancelAppointmentModal();
    attachCancelAppointment();
    attachViewReschuledAppointmentModal();
    attachApproveRescheduleBtn();
    attachDeclineRescheduleBtn();
    attachNotificationBtn();
    attachMarkAsDoneBtn();
});

//GLOBAL
let client_name  = '';
let dentist_name = '';
let date = '';
let formattedDate = '';
let service = '';
let time = '';
let doctor_id = null;
let appointment_id = null;
let user_id = null;
let contact_number = '';
let rescheduleData = null;
const attachViewAppointmentInfoModal=()=> {
    $(document).on('click', '.viewAppointmentModalBtn', function() {
        let appointmentObj = $(this).data('appointment');
        let status = '';
        if(appointmentObj.status == 'pending') {
            status = 'For Confirmation'
        }

        if(appointmentObj.status == 'approved') {
            status = 'Approved'
            $('#approveAppointmentBtn').remove();
        }

        if(appointmentObj.status == 'done') {
            status = 'Done'
        }

        if(appointmentObj.status == 'rescheduled') {
            status = 'Rescheduled'
        }

        if(appointmentObj.status == 'cancelled') {
            status = 'Cancelled'
        }

        appointment_id = appointmentObj.id;
        doctor_id = appointmentObj.doctor_id;
        user_id = appointmentObj.user_id;
        dentist_name = appointmentObj.doctor.full_name;
        contact_number = appointmentObj.booked_user.contact_number;
        date = appointmentObj.date_schedule
        formattedDate = moment(appointmentObj.date_schedule).format("MMMM, DD, YYYY");
        service = appointmentObj.service;
        time = `${moment(appointmentObj.start_time, 'HH::mm').format('hh:mm a')} - ${moment(appointmentObj.end_time, 'HH::mm').format('hh:mm a')}`;
        client_name = appointmentObj.booked_user.full_name;

        $('#viewClientName').text(appointmentObj.booked_user.full_name);
        $('#viewDentistName').text(appointmentObj.doctor.full_name);
        $('#viewContactNo').text(appointmentObj.booked_user.contact_number);
        $('#viewAppDate').text( moment(appointmentObj.date_schedule).format("MMMM, DD, YYYY"));
        $('#viewAppTime').text(`${moment(appointmentObj.start_time, 'HH::mm').format('hh:mm a')} - ${moment(appointmentObj.end_time, 'HH::mm').format('hh:mm a')}`);
        $('#viewService').text(appointmentObj.service)
        $('#viewStatus').text(`${status}`);
    });
}

const attachApproveAppointmentBtn=()=> {
    $(document).on('click', '#approveAppointmentBtn', function() {

        const data = {
            appointment_id
        };
        pageLoading();
        $.ajax({
            type: "POST",
            url: '/admin/approve-appointment',
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
                alertify.success('Appointment Successfully Approved.');

                pageLoaded();
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                alertify.warning(response.message);
                pageLoaded();
            }
        })

    });
}

const attachRescheduleAppointmentModal=()=> {
    $(document).on('click', '#rescheduleAppModalBtn', function() {
        $('#reschedClientName').text(client_name);
        $('#reschedContactNo').text(contact_number);
        $('#reschedService').text(service);
        $('#reschedAppDate').text(formattedDate);
        $('#reschedAppTime').text(time);
        $('#dentistNameSchedule').text(`${dentist_name}' Schedule **`);

        initGetAvailabilities(doctor_id, date);
    });
}

const attachRescheduledFilterDate=()=> {
    $(document).on('change', '#rescheduledFilterDate', function() {
        let filter_date = $(this).val();
        initGetAvailabilities(doctor_id, filter_date);
    });
}

const attachCancelAppointmentModal=()=> {
    $(document).on('click', '.cancelAppointmentBtn', function() {
        let appointment = $(this).data('appointment');
        appointment_id = appointment.id;

        $('#patientDoctorEmail')
            .append(
                $('<p />').text(appointment.booked_user.full_name)
            )
            .append(',')
            .append($('<p />').text(appointment.doctor.full_name))

    });
}

const attachCancelAppointment=()=> {
    $(document).on('click', '#cancelAppointmentBtn', function() {
        let reason = $('#reason').val();

        if(reason == '') {
            alertify.warning('Reason field is required.');
            return;
        }

        pageLoading();

        const data = {
            appointment_id, reason
        };

        cancelAppointmentAjaxRequest(data);

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
            $('#availabilityTbl').empty();
            const resDate = response.date;
            const slots = response.available_slots;

            if(slots.length > 0) {
                $.each(slots, (function(index, slot) {
                    let compareDate = moment(formattedDate, "MMMM, DD, YYYY");
                    let dateMoment = moment(resDate);
                    // Compare if both moments represent the same date
                    let isSameDate = compareDate.isSame(dateMoment, 'day');

                    if(!isSameDate)  {

                        let formattedFrom = moment(slot.start_time, 'HH::mm').format('hh:mm a');
                        let formattedTo   = moment(slot.end_time, 'HH::mm').format('hh:mm a')
                        let recurring_days = JSON.parse(slot.recurring_days);
                        recurring_days = recurring_days.map(dayNumber => moment().isoWeekday(parseInt(dayNumber)).format('dddd'));
                        let patientQueue = slot.patients_queue;

                        $('#availabilityTbl')
                        .append(
                            $('<tr />')
                                .append($('<td class="text-center"/>').text(patientQueue))
                                .append($('<td />').text(moment(resDate).format('MMMM DD, YYYY')))
                                .append($('<td />').text(`${formattedFrom} - ${formattedTo}`))
                                .append($('<td />').addClass('text-center')
                                            .append($('<a />').attr({'class' : 'view-appointment-btn p-1', 'href': '#'})
                                            .bind('click', function() {

                                                rescheduleData = {
                                                    suggested_availability: slot.id,
                                                    appointment_id,
                                                    suggested_date: resDate
                                                }

                                                $('#resCurrentDate').text(formattedDate);
                                                $('#resSuggestedDate').text(moment(resDate).format("MMMM D, YYYY"));
                                                $('#dentistAvailability').text(`${formattedFrom} - ${formattedTo}`);
                                                $('#confirmRescheduleAppointmentModal').modal('show');
                                            })
                                                .append($('<img />').attr('src', '/icons/check.png'))
                                            )
                                    )
                            )
                    } else {
                        if(slots.length == 1) {
                            $('#availabilityTbl').append($('<tr />')
                                .append($('<td />').attr({'colspan': 4, 'class':'text-center'}).text('No Schedule found'))
                            )
                        }
                    }
               }));
            } else {
                $('#availabilityTbl').append($('<tr />')
                    .append($('<td />').attr({'colspan': 4, 'class':'text-center'}).text('No Schedule found'))
                )
            }
        }
    });
}

const attachRescheduleAppointmentBtn=()=> {
    $(document).on('click', '#submitReschedule', function() {
        pageLoading();
        let resReason = $('#resReason').val();
        if(resReason) {
            rescheduleData.reason = resReason;
            postAjaxRequest(rescheduleData);
        } else {
            alertify.warning('Reason field is required');
            pageLoaded();
        }
    });
}

const postAjaxRequest=(appointmentObj)=> {
    $.ajax({
        type: "POST",
        url: '/admin/reschedule-appointment',
        data: JSON.stringify(appointmentObj),
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

            alertify.success('Appointment Successfully Rescheduled.');
            pageLoaded();

            setTimeout(function() {
                location.reload();
            }, 2000);

        } else {
            alertify.warning(response.message);
            pageLoaded();
        }
    })
}

const cancelAppointmentAjaxRequest=(appointmentObj)=> {
    $.ajax({
        type: "POST",
        url: '/admin/cancel-appointment',
        data: JSON.stringify(appointmentObj),
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
            alertify.success('Appointment Successfully Canceled');

            pageLoaded();
            setTimeout(function() {
                location.reload();
            }, 2000);

        } else {
            alertify.warning(response.message);
            pageLoaded();
        }
    })
}

const attachViewReschuledAppointmentModal=()=> {
    $(document).on('click', '.viewRescheduledAppointmentModalBtn', function() {
        let appointmentObj = $(this).data('appointment');
        console.log(appointmentObj);
        let formattedFrom = moment(appointmentObj.start_time, 'HH::mm').format('hh:mm a');
        let formattedTo   = moment(appointmentObj.end_time, 'HH::mm').format('hh:mm a')

        rescheduleData = { appointment_id: appointmentObj.id };

        $('#resAppCurrentDate').text(moment(appointmentObj.date_schedule).format("MMMM D, YYYY"));
        $('#resAppSuggestedDate').text(moment(appointmentObj.suggested_date).format("MMMM D, YYYY"));
        $('#resAppDentistAvailability').text(`${formattedFrom} - ${formattedTo}`);
        $('#resAppReason').val(appointmentObj.reason);
    });
}

const attachApproveRescheduleBtn=()=> {
    $(document).on('click', '#approveReschedule', function() {
        pageLoading();
        approveResheduleAjaxRequest(rescheduleData);
    });
}

const attachDeclineRescheduleBtn=()=> {
    $(document).on('click', '#declineReschedule', function() {
        pageLoading();
        declineResheduleAjaxRequest(rescheduleData);
    });
}

const approveResheduleAjaxRequest=(appointmentObj)=> {
    $.ajax({
        type: "POST",
        url: '/admin/approve-reschedule-appointment',
        data: JSON.stringify(appointmentObj),
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

            alertify.success('Appointment Successfully Approved.');
            pageLoaded();

            setTimeout(function() {
                location.reload();
            }, 2000);

        } else {
            alertify.warning(response.message);
            pageLoaded();
        }
    })
}

const declineResheduleAjaxRequest=(appointmentObj)=> {
    $.ajax({
        type: "POST",
        url: '/admin/decline-reschedule-appointment',
        data: JSON.stringify(appointmentObj),
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

            alertify.success('Appointment Successfully Approved.');
            pageLoaded();

            setTimeout(function() {
                location.reload();
            }, 2000);

        } else {
            alertify.warning(response.message);
            pageLoaded();
        }
    })
}

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


const attachMarkAsDoneBtn=()=> {
    $(document).on('click', '.doneBtn', function() {
        let appointment = $(this).data('appointment');

        let appointmentObj = {
            appointment_id: appointment.id
        }

        markAsDoneAjaxRequest(appointmentObj);
    });
}

const markAsDoneAjaxRequest=(appointmentObj)=> {
    $.ajax({
        type: "POST",
        url: '/admin/mark-as-done-appointment',
        data: JSON.stringify(appointmentObj),
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

            alertify.success('Appointment successfully marked as done.');
            pageLoaded();

            setTimeout(function() {
                location.reload();
            }, 2000);

        } else {
            alertify.warning(response.message);
            pageLoaded();
        }
    })
}
