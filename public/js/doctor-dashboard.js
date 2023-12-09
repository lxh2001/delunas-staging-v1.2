$(function() {
    initDoctorAppointments();
});


const initDoctorAppointments=()=> {
    $.ajax({
        url: '/doctor/calendar/my-appointments',
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

            $.each(response.availabilities, function(i, e) {
                console.log(e);
                const eventObj = {};
                eventObj.title = `${moment(e.start_time, 'HH::mm').format('hh:mm a')} - ${moment(e.end_time, 'HH::mm').format('hh:mm a')}`;
                eventObj.startRecur =  e.start_date;
                eventObj.endRecur =  e.end_date;
                // eventObj.ranges = [
                //     {
                //       start: e.start_date,
                //       end: e.end_date
                //     }
                // ];
                eventObj.daysOfWeek = JSON.parse(e.recurring_days)
                eventList.push(eventObj);
            });

            $.each(response.appointments, function(i, e) {
                const eventObj = {};
                eventObj.title = ` ${e.service} : ${moment(e.start_time, 'HH::mm').format('hh:mm a')} - ${moment(e.end_time, 'HH::mm').format('hh:mm a')}`;
                eventObj.start = e.date_schedule;
                eventList.push(eventObj);
            });

            fullcalendar(eventList);
        }
    });
}



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
        let start = clickedEvent.start;

        // Do whatever you want with the clicked event data
        alert(`Appointment Time: ${title} `);
    },
    });

    calendar.render();
}
