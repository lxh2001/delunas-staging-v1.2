$(function() {
    attachBookAppointmentListener();

    //INIT
    localStorage.setItem('refreshFirstPage', true);

});


const attachBookAppointmentListener=()=> {
    $(document).on('click', '#bookAppointmentBtn', function() {

        //COVID QUESTIONAIRRE
        let q1 = $("input[type='radio'][name='question1']:checked").val();
        let q2 = $("input[type='radio'][name='question2']:checked").val();
        let q3 = $("input[type='radio'][name='question3']:checked").val();
        let q4 = $("input[type='radio'][name='question4']:checked").val();
        let q5 = $("input[type='radio'][name='question5']:checked").val();
        let q6 = $("input[type='radio'][name='question6']:checked").val();
        let q7 = $("input[type='radio'][name='question7']:checked").val();
        let q8 = $("input[type='radio'][name='question8']:checked").val();
        let q9 = $("input[type='radio'][name='question9']:checked").val();
        let q10 = $("input[type='radio'][name='question10']:checked").val();
        let q11 = $("input[type='radio'][name='question11']:checked").val();

        //validate
        let isCovidValid = true;

        for (let i = 1; i <= 11; i++) {
            let q = $("input[type='radio'][name='question" + i + "']:checked").val();
            if (typeof q === 'undefined') {
                isValid = false;
            }
        }

        if (!isCovidValid) {
            alert('Complete the survey by selecting answers for all questions');
            return;
        }

        //MEDICAL QUESTIONAIRRE
        let mq1 = $("input[type='radio'][name='allergyM']:checked").val();
        let mq2 = $("input[type='radio'][name='allergyAM']:checked").val();
        let mq3 = $("input[type='radio'][name='diabetes']:checked").val();
        let mq4 = $("input[type='radio'][name='hypertension']:checked").val();

        if(typeof mq1 === "undefined" || typeof mq2 === "undefined" || typeof mq3 === "undefined" || typeof mq4 === "undefined" ) {
            alertify.warning("Complete the survey by selecting Yes or No answers for all questions");
            return;
        }

        let appointmentObj = {};
        let doctor_id = $('#doctor_id').val();
        let service = $('#service').val();
        let start_time = $('#start_time').val();
        let end_time = $('#end_time').val();
        let date_schedule = $('#date_schedule').val();
        let availability_id = $('#availability_id').val();

        appointmentObj = {
            doctor_id, service, start_time, end_time, date_schedule, availability_id
        }

        appointmentObj.covidForm = {
            q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11
        };

        appointmentObj.mqForm = {
            mq1,mq2,mq3,mq4
        };

        postAjaxRequest(appointmentObj);
    });
}

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
            alertify.success("Thank you for submitting an appointment. Please wait for the approval of the Admin.");
            setTimeout(function() {
                window.location.href = '/patient/my-appointments';
            }, 2000);
        } else {
            alertify.warning("Conflict to your schedule.");
        }
    })
}
