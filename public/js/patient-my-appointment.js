$(function(){
    attachGetDoctorAvailabilities();
    initGetMyAppointments();
    attachChooseDentistSelectTag();
    attachNotificationBtn();
    attachSubmitAppointmentBtn();

    //init
    $('#availabilityTbl').append($('<tr />')
        .append($('<td />').attr({'colspan': 4, 'class':'text-center'}).text('No Schedule found'))
    )

    // let isRefreshPage = localStorage.getItem('refreshFirstPage');

    // if(isRefreshPage) {
    //     localStorage.removeItem('refreshFirstPage');
    //     window.location.reload(); // Refresh the first page
    // }
});

let appData = null;

const fullcalendar = (eventList) => {
    var calendarEl = document.getElementById('calendar');

    let currentDate = new Date().toJSON().slice(0, 10);

    // //init get my appointments
    // getMyAppointments(moment(currentDate).format('YYYY-MM-D'));

    var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    },
    initialDate: currentDate,
    navLinks: true, // can click day/week names to navigate views
    businessHours: true, // display business hours
    editable: true,
    selectable: true,
    validRange: function(currentDate) {
        let startDate = new Date(currentDate.valueOf());
        startDate.setDate(startDate.getDate() - 1);
        return { start: startDate }
    },
    events:eventList,
    eventClick: function(info) {
        // `info.event` contains information about the clicked event
        let clickedEvent = info.event;
        // You can access the event properties, e.g., title, start, etc.
        let title = clickedEvent.title;
        let status = clickedEvent.extendedProps.status;

        // Do whatever you want with the clicked event data
        alertify.success(`${title}`)
    },
    });

    calendar.render();
}

const attachGetDoctorAvailabilities=()=> {
    $(document).on('change', '#filterDate', function() {

        let service = $('#service').val();
        let serviceName = $('#service option:selected').text();
        let doctor = $('#doctor').val();
        let doctorName = $('#doctor option:selected').text();
        let filter_date = $(this).val();

        if (service == null || doctor == null ) {
            alertify.warning('All fields are required.');
            return false;
        }

        pageLoading();
        initGetAvailabilities(doctor, filter_date, service, serviceName, doctorName);

    });
}


const initGetAvailabilities= (doctor_id, filter_date, service, serviceName, doctorName) => {

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
            const date = response.date;
            const slots = response.available_slots;

            if(slots.length > 0) {
                $.each(slots, (function(index, slot) {
                    let formattedFrom = moment(slot.start_time, 'HH::mm').format('hh:mm a');
                    let formattedTo   = moment(slot.end_time, 'HH::mm').format('hh:mm a')
                    let recurring_days = JSON.parse(slot.recurring_days);
                    recurring_days = recurring_days.map(dayNumber => moment().isoWeekday(parseInt(dayNumber)).format('dddd'));
                    let patientQueue = slot.patients_queue;

                   $('#availabilityTbl')
                      .append(
                       $('<tr />')
                           .append($('<td class="text-center"/>').text(patientQueue))
                           .append($('<td />').text(moment(date).format('MMMM DD, YYYY')))
                           .append($('<td />').text(`${formattedFrom} - ${formattedTo}`))
                           .append($('<td />').addClass('text-center')
                                    .append($('<a />').attr({'class' : 'view-appointment-btn p-1', 'href': '#'})
                                    .bind('click', function() {

                                        $.ajax({
                                            url: '/patient/check-uncompleted-appointment',
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
                                                if(!response.uncompleted_app) {
                                                    //TEMPORARY FIXES
                                                    service = $('#service').val();
                                                    serviceName = $('#service option:selected').text();
                                                    doctorName = $('#doctor option:selected').text();

                                                    $('#appDate').text(moment(date).format('MMMM DD, YYYY'));
                                                    $('#appDentist').text(doctorName);
                                                    $('#appAvailability').text(`${formattedFrom} - ${formattedTo}`);
                                                    $('#appService').text(serviceName);

                                                    $('#appointmentSummaryModal').modal('show');

                                                    appData = {
                                                        service: serviceName,
                                                        doctor_id,
                                                        start_time: slot.start_time,
                                                        end_time: slot.end_time,
                                                        date_schedule: date,
                                                        availability_id: slot.id
                                                    }
                                                } else {
                                                    alertify.warning('Oops! It looks like you have an ongoing appointment. Please complete it before proceeding.');
                                                }
                                            }
                                        });



                                    })
                                        .append($('<img />').attr('src', '/icons/check.png'))
                                    )
                               )
                      )

               }));
            } else {
                $('#availabilityTbl').append($('<tr />')
                    .append($('<td />').attr({'colspan': 4, 'class':'text-center'}).text('No Schedule found'))
                )
            }
        }
    });

    pageLoaded();
}

function initGetMyAppointments(date) {
    $.ajax({
        url: '/calendar/my-appointments',
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
            const eventList = [];

            $.each(response.appointments, function(i, e) {
                const eventObj = {};
                eventObj.color = getStatusColor(e.status);
                eventObj.title = e.service;
                eventObj.start = e.date_schedule;
                eventObj.status = e.status;

                eventList.push(eventObj);
            });

            fullcalendar(eventList);
        }
    });
}

const getStatusColor = (status) => {
    return (status === 'pending') ? 'red' :
           (status === 'approved') ? 'green' :
           (status === 'rescheduled') ? 'orange' :
           (status === 'cancelled') ? 'red' :
           'blue';
};

const postAjaxRequest=(appointmentObj)=> {
    $.ajax({
        type: "POST",
        url: '/patient/book-appointment-forms',
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
            alertify.success(response.message);
            setTimeout(function() {
                location.reload();
            }, 2000);
            pageLoaded();
        } else {
            alertify.warning(response.message);
            pageLoaded();
        }
    })
}


const attachChooseDentistSelectTag=()=> {
    $(document).on('change', '#doctor', function() {
        let service = $('#service').val();
        let serviceName = $('#service option:selected').text();
        let doctor = $(this).val();
        let doctorName = $('#doctor option:selected').text();
        let filter_date = $('#filterDate').val() ?? null;

        if (service != null && doctor != null && filter_date != '' ) {
            pageLoading();
            initGetAvailabilities(doctor, filter_date, service, serviceName, doctorName);
        }
    });
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


const attachSubmitAppointmentBtn=()=> {
    $(document).on('click', '#submitAppointmentBtn', function() {
        pageLoading();
        postAjaxRequest(appData);
    });
}
