$(function(){
    attachViewAppointmentInfoModal();
    attachRescheduleAppointmentModal();
    attachRescheduledFilterDate();
    attachCancelAppointmentModal();
    attachCancelAppointment();
    attachRescheduleAppointmentBtn();
    attachViewReschuledAppointmentModal();
    attachApproveRescheduleBtn();
    attachDeclineRescheduleBtn();
    attachNotificationBtn();
    attachRateAppointmentModal();
    attachSendFeedbackBtn();
});

//GLOBAL VARIABLE
let dentist_name = '';
let date = '';
let formattedDate = '';
let service = '';
let time = '';
let doctor_id = null;
let appointment_id = null;
let rescheduleData = null;

const attachViewAppointmentInfoModal=()=> {
    $(document).on('click', '.viewAppointmentModalBtn', function() {
        let appointmentObj = $(this).data('appointment');
        let status = '';
        if(appointmentObj.status == 'pending') {
            status = 'Pending'
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
        dentist_name = appointmentObj.doctor.full_name;
        date = appointmentObj.date_schedule
        formattedDate = moment(appointmentObj.date_schedule).format("MMMM, DD, YYYY");
        service = appointmentObj.service;
        time = `${moment(appointmentObj.start_time, 'HH::mm').format('hh:mm a')} - ${moment(appointmentObj.end_time, 'HH::mm').format('hh:mm a')}`;

        $('#viewDentistName').text(appointmentObj.doctor.full_name);
        $('#viewDentistContactNo').text(appointmentObj.doctor.contact_number);
        $('#viewAppDate').text( moment(appointmentObj.date_schedule).format("MMMM, DD, YYYY"));
        $('#viewAppTime').text(`${moment(appointmentObj.start_time, 'HH::mm').format('hh:mm a')} - ${moment(appointmentObj.end_time, 'HH::mm').format('hh:mm a')}`);
        $('#viewService').text(appointmentObj.service)
        $('#viewStatus').text(`${status}`);
    });
}

const attachRescheduleAppointmentModal=()=> {
    $(document).on('click', '#rescheduleAppModalBtn', function() {
        $('#reschedDentistName').text(dentist_name);
        $('#reschedService').text(service);
        $('#reschedDate').text(moment(date).format("MMMM, DD, YYYY"));
        $('#reschedTime').text(time);
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

// const initGetAvailabilities=(doctor_id, filter_date)=> {
//     $.ajax({
//         url: `/admin/doctor/get-availabilities/${doctor_id}/${filter_date}`,
//         type: "GET",
//         dataType: "json",
//         contentType: "application/json",
//         mimeType: "application/json",
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
//                 "content"
//             ),
//         }
//     }).done(function(response) {
//         if(response.status) {
//             $('#availabilityTbl').empty();
//             const date = response.date;
//             const slots = response.available_slots;

//             if(slots.length > 0) {
//                 $.each(slots, (function(index, slot) {
//                     if(slot.status == 'Free') {
//                         let formattedFrom = moment(slot.from, 'HH::mm').format('hh:mm a');
//                         let formattedTo   = moment(slot.to, 'HH::mm').format('hh:mm a')
//                         let formattedDate = moment(date).format("MMMM D, YYYY");
//                        $('#availabilityTbl')
//                           .append(
//                            $('<tr />')
//                                .append($('<td />').text(formattedDate))
//                                .append($('<td />').text(`${formattedFrom} - ${formattedTo}`))
//                                .append($('<td />').addClass('text-center')
//                                     .append($('<a />').attr({'class' : 'view-appointment-btn p-1', 'href': '#'})
//                                     .bind('click', function() {
//                                         const data = {
//                                             service,
//                                             doctor_id,
//                                             start_time: slot.from,
//                                             end_time: slot.to,
//                                             date_schedule: date,
//                                             availability_id: slot.id,
//                                             appointment_id
//                                         }
//                                         postAjaxRequest(data);
//                                     })
//                                         .append($('<img />').attr('src', '/icons/check.png'))
//                                     )
//                                )
//                           )
//                     }
//                }));
//             } else {
//                 $('#availabilityTbl').append($('<tr />')
//                     .append($('<td />').attr({'colspan': 4, 'class':'text-center'}).text('No Schedule found'))
//                 )
//             }
//         }
//     });
// }

const initGetAvailabilities=(doctor_id, filter_date)=> {
    $.ajax({
        url: `/patient/doctor/get-availabilities/${doctor_id}/${filter_date}`,
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
        url: '/patient/reschedule-appointment',
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

const attachCancelAppointmentModal=()=> {
    $(document).on('click', '.cancelAppointmentBtn', function() {
        let appointment = $(this).data('appointment');
        appointment_id = appointment.id;

        $('#cancelDentistName').text(appointment.doctor.full_name);
    });
}

const attachCancelAppointment=()=> {
    $(document).on('click', '#cancelAppointmentBtn', function() {
        let reason = $('#reason').val();
        pageLoading();
        if(reason == '') {
            alertify.warning('Please fill up required fields.');
            return;
        }

        const data = {
            appointment_id, reason
        };

        cancelAppointmentAjaxRequest(data);

    });
}

const cancelAppointmentAjaxRequest=(appointmentObj)=> {
    $.ajax({
        type: "POST",
        url: '/patient/cancel-appointment',
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

            setTimeout(function() {
                location.reload();
            }, 2000);

            pageLoaded();
        } else {
            pageLoaded();
            alertify.warning(response.message);
        }
    })
}

const attachViewReschuledAppointmentModal=()=> {
    $(document).on('click', '.viewRescheduledAppointmentModalBtn', function() {
        let appointmentObj = $(this).data('appointment');
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
        url: '/patient/approve-reschedule-appointment',
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
        url: '/patient/decline-reschedule-appointment',
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
                url: '/patient/update-notification',
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

const attachRateAppointmentModal =()=> {
    $(document).on('click', '.add-feedback-btn', function() {
        let appointment = $(this).data('appointment');
        appointment_id = appointment.id;
        $('#rateDr').text(`Dr. ${appointment.doctor.full_name}`);
    });
}

const attachSendFeedbackBtn=()=> {
    $(document).on('click','#sendFeebackBtn', function() {
        pageLoading();
        let rate = $('.rateStar:checked').val() ?? 0;
        let message = $('#rateMessage').val();
        if(rate != 0 && message != '') {

            let appointmentObj = {
                rate, message, appointment_id
            };
            sendFeedbackAjaxRequest(appointmentObj);
            return;
        } else {
            pageLoaded();
            alertify.warning('All fields are required');
            return;
        }
    });
}

const sendFeedbackAjaxRequest=(appointmentObj)=> {
    $.ajax({
        type: "POST",
        url: '/patient/send-feedback',
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

            alertify.success('Feedback Successfully Sent.');
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
