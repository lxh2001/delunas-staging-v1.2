<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Appointment Page</title>

    <link rel="icon" type="image/png" href="../../assets/icons/favicon.png" />
    {{-- <link rel="stylesheet" href="../../css/appointment.css" /> --}}
    <link rel="stylesheet" href="{{ asset('css/appointment.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/alertify.min.css') }}"/>

    <!-- LINKS BOOTSTRAP -->
    <link rel="stylesheet" href="./css/bootstrap/bootstrap.min.css" />
  </head>
  <input type="hidden" id="doctor_id" value="{{ $data['doctor']['id'] }}">
  <input type="hidden" id="service" value="{{ $data['service']['title'] }}">
  <input type="hidden" id="start_time" value="{{ $data['startTime'] }}">
  <input type="hidden" id="end_time" value="{{ $data['endTime'] }}">
  <input type="hidden" id="date_schedule" value="{{ $data['date'] }}">
  <input type="hidden" id="availability_id" value="{{ $data['availability_id'] }}">

  <body>
    <main>
      <div class="appointment-wrapper">
        <div class="progress-container">
          <div class="progress" id="progress"></div>
          <div class="circle active">1</div>
          <div class="circle">2</div>
          <div class="circle">3</div>
        </div>

        <div id="step2" class="step-wrapper step">
            <div class="header">
              <div>
                <h2>Appointments</h2>
                <p>
                  ** We would like to ask for your cooperation to fill up this
                  form truthfully.
                </p>
              </div>
              <h5>Health Protocol Form - COVID 19</h5>
            </div>

            <div class="question-list">
              <div class="questions">
                <h5>
                  1. In the past 14 days, do you have or have any of the following
                  symptoms?
                </h5>
                <div class="row-question">
                  <p>Fever (Temperature > 38°C)</p>
                  <div class="radio-btns">
                    <input
                      type="radio"
                      id="feverYES"
                      name="question1"
                      value="Yes"
                    />
                    <label for="feverYES">Yes</label><br />

                    <input
                      type="radio"
                      id="feverNO"
                      name="question1"
                      value="No"
                    />
                    <label for="feverNO">No</label><br />
                  </div>
                </div>
                <div class="row-question">
                  <p>Cough</p>
                  <div class="radio-btns">
                    <input
                      type="radio"
                      id="q2Yes"
                      name="question2"
                      value="Yes"
                    />
                    <label for="q2Yes">Yes</label><br />

                    <input
                      type="radio"
                      id="q2No"
                      name="question2"
                      value="No"
                    />
                    <label for="q2No">No</label><br />
                  </div>
                </div>
                <div class="row-question">
                  <p>New onset or worsening shortness of breath:</p>
                  <div class="radio-btns">
                    <input
                      type="radio"
                      id="q3Yes"
                      name="question3"
                      value="Yes"
                    />
                    <label for="q3Yes">Yes</label><br />

                    <input
                      type="radio"
                      id="q3No"
                      name="question3"
                      value="No"
                    />
                    <label for="q3No">No</label><br />
                  </div>
                </div>
                <div class="row-question">
                  <p>Cold:</p>
                  <div class="radio-btns">
                    <input
                      type="radio"
                      id="q4Yes"
                      name="question4"
                      value="Yes"
                    />
                    <label for="q4Yes">Yes</label><br />

                    <input
                      type="radio"
                      id="q4No"
                      name="question4"
                      value="No"
                    />
                    <label for="q4No">No</label><br />
                  </div>
                </div>
                <div class="row-question">
                  <p>Sore Throat:</p>
                  <div class="radio-btns">
                    <input
                      type="radio"
                      id="q5Yes"
                      name="question5"
                      value="Yes"
                    />
                    <label for="q5Yes">Yes</label><br />

                    <input
                      type="radio"
                      id="q5No"
                      name="question5"
                      value="No"
                    />
                    <label for="q5No">No</label><br />
                  </div>
                </div>
                <div class="row-question">
                  <p>Body Ache/Muscle Pain:</p>
                  <div class="radio-btns">
                    <input
                      type="radio"
                      id="q6Yes"
                      name="question6"
                      value="Yes"
                    />
                    <label for="q6Yes">Yes</label><br />

                    <input
                      type="radio"
                      id="q6No"
                      name="question6"
                      value="No"
                    />
                    <label for="q6No">No</label><br />
                  </div>
                </div>
                <div class="row-question">
                  <p>Headache:</p>
                  <div class="radio-btns">
                    <input
                      type="radio"
                      id="q7Yes"
                      name="question7"
                      value="Yes"
                    />
                    <label for="q7Yes">Yes</label><br />

                    <input
                      type="radio"
                      id="q7No"
                      name="question7"
                      value="No"
                    />
                    <label for="q7No">No</label><br />
                  </div>
                </div>
                <div class="row-question">
                  <p>Fatigue:</p>
                  <div class="radio-btns">
                    <input
                      type="radio"
                      id="q8Yes"
                      name="question8"
                      value="Yes"
                    />
                    <label for="q8Yes">Yes</label><br />

                    <input
                      type="radio"
                      id="q8No"
                      name="question8"
                      value="No"
                    />
                    <label for="q8No">No</label><br />
                  </div>
                </div>
                <div class="row-question">
                  <p>Diarrhea:</p>
                  <div class="radio-btns">
                    <input
                      type="radio"
                      id="q9yes"
                      name="question9"
                      value="Yes"
                    />
                    <label for="q9yes">Yes</label><br />

                    <input
                      type="radio"
                      id="q9No"
                      name="question9"
                      value="No"
                    />
                    <label for="q9No">No</label><br />
                  </div>
                </div>
                <div class="row-question">
                  <p>New onset losso r decrease sense of smell and/or taste:</p>
                  <div class="radio-btns">
                    <input
                      type="radio"
                      id="q10Yes"
                      name="question10"
                      value="Yes"
                    />
                    <label for="q10Yes">Yes</label><br />

                    <input
                      type="radio"
                      id="q10No"
                      name="question10"
                      value="No"
                    />
                    <label for="q10No">No</label><br />
                  </div>
                </div>
              </div>

              <div class="questions">
                <h5>
                  2. In the past 14 days, did you have close contact with any COVID-19 positive/suspected/probable cause or people with the previously mentioned symptoms, while not wearing proper protective equipment (ex. facemask)?
                </h5>

                <div class="row-question">
                  <p>Answer:</p>
                  <div class="radio-btns">
                    <input
                      type="radio"
                      id="q11Yes"
                      name="question11"
                      value="Yes"
                    />
                    <label for="q11Yes">Yes</label><br />

                    <input
                      type="radio"
                      id="q11No"
                      name="question11"
                      value="No"
                    />
                    <label for="q11No">No</label><br />
                  </div>
                </div>
              </div>
            </div>
        </div>

        <div id="step3" class="step-wrapper step">
            <div class="header">
                <div>
                  <h2>Medical Questionnaire</h2>
                  <p>
                    ** We would like to ask for your cooperation to fill up this
                    form truthfully.
                  </p>
                </div>
                {{-- <h5>Health Protocol Form - COVID 19</h5> --}}
              </div>

              <div class="question-list">
                <div class="questions">
                  <div class="row-question">
                    <p>Are you Allergic to any medication?:</p>
                    <div class="radio-btns">
                      <input
                        type="radio"
                        id="allergyYes"
                        name="allergyM"
                        value="Yes"
                      />
                      <label for="allergyYes">Yes</label><br />

                      <input
                        type="radio"
                        id="allergyNo"
                        name="allergyM"
                        value="No"
                      />
                      <label for="allergyNo">No</label><br />
                    </div>
                  </div>

                  <div class="row-question">
                    <p>Are you Allergic to any Anaesthesia?:</p>
                    <div class="radio-btns">
                      <input
                        type="radio"
                        id="allergyAYes"
                        name="allergyAM"
                        value="Yes"
                      />
                      <label for="allergyAYes">Yes</label><br />

                      <input
                        type="radio"
                        id="allergyANo"
                        name="allergyAM"
                        value="No"
                      />
                      <label for="allergyANo">No</label><br />
                    </div>
                  </div>

                  <h4>Note: If Yes on these 2 questions requires you to provide medical clearance from your Doctor.</h4>

                  <div class="row-question">
                    <p>Do you have diabetes?:</p>
                    <div class="radio-btns">
                      <input
                        type="radio"
                        id="diabetesYes"
                        name="diabetes"
                        value="Yes"
                      />
                      <label for="diabetesYes">Yes</label><br />

                      <input
                        type="radio"
                        id="diabetesNo"
                        name="diabetes"
                        value="No"
                      />
                      <label for="diabetesNo">No</label><br />
                    </div>
                  </div>

                  <div class="row-question">
                    <p>Do you have hypertension?:</p>
                    <div class="radio-btns">
                      <input
                        type="radio"
                        id="hyperYes"
                        name="hypertension"
                        value="Yes"
                      />
                      <label for="hyperYes">Yes</label><br />

                      <input
                        type="radio"
                        id="hyperNo"
                        name="hypertension"
                        value="No"
                      />
                      <label for="hyperNo">No</label><br />
                    </div>
                  </div>


                  {{-- <div class="row-question">
                    <p>Cough</p>
                    <div class="radio-btns">
                      <input
                        type="radio"
                        name="question2"
                        value="Yes"
                      />
                      <label for="">Yes</label><br />

                      <input
                        type="radio"
                        name="question2"
                        value="No"
                      />
                      <label for="">No</label><br />
                    </div>
                  </div>
                  <div class="row-question">
                    <p>New onset or worsening shortness of breath:</p>
                    <div class="radio-btns">
                      <input
                        type="radio"
                        name="question3"
                        value="Yes"
                      />
                      <label for="feverYES">Yes</label><br />

                      <input
                        type="radio"
                        name="question3"
                        value="No"
                      />
                      <label for="">No</label><br />
                    </div>
                  </div>
                  <div class="row-question">
                    <p>Cold:</p>
                    <div class="radio-btns">
                      <input
                        type="radio"
                        name="question4"
                        value="Yes"
                      />
                      <label for="">Yes</label><br />

                      <input
                        type="radio"
                        name="question4"
                        value="No"
                      />
                      <label for="">No</label><br />
                    </div>
                  </div>
                  <div class="row-question">
                    <p>Sore Throat:</p>
                    <div class="radio-btns">
                      <input
                        type="radio"
                        name="question5"
                        value="Yes"
                      />
                      <label for="feverYES">Yes</label><br />

                      <input
                        type="radio"
                        name="question5"
                        value="No"
                      />
                      <label for="">No</label><br />
                    </div>
                  </div>
                  <div class="row-question">
                    <p>Body Ache/Muscle Pain:</p>
                    <div class="radio-btns">
                      <input
                        type="radio"
                        name="question6"
                        value="Yes"
                      />
                      <label for="">Yes</label><br />

                      <input
                        type="radio"
                        name="question6"
                        value="No"
                      />
                      <label for="">No</label><br />
                    </div>
                  </div>
                  <div class="row-question">
                    <p>Headache:</p>
                    <div class="radio-btns">
                      <input
                        type="radio"
                        name="question7"
                        value="Yes"
                      />
                      <label for="">Yes</label><br />

                      <input
                        type="radio"
                        name="question7"
                        value="No"
                      />
                      <label for="">No</label><br />
                    </div>
                  </div>
                  <div class="row-question">
                    <p>Fatigue:</p>
                    <div class="radio-btns">
                      <input
                        type="radio"
                        name="question8"
                        value="Yes"
                      />
                      <label for="">Yes</label><br />

                      <input
                        type="radio"
                        name="question8"
                        value="No"
                      />
                      <label for="">No</label><br />
                    </div>
                  </div>
                  <div class="row-question">
                    <p>Diarrhea:</p>
                    <div class="radio-btns">
                      <input
                        type="radio"
                        name="question9"
                        value="Yes"
                      />
                      <label for="">Yes</label><br />

                      <input
                        type="radio"
                        name="question9"
                        value="No"
                      />
                      <label for="">No</label><br />
                    </div>
                  </div>
                  <div class="row-question">
                    <p>New onset losso r decrease sense of smell and/or taste:</p>
                    <div class="radio-btns">
                      <input
                        type="radio"
                        name="question10"
                        value="No"
                      />
                      <label for="">Yes</label><br />

                      <input
                        type="radio"
                        name="question10"
                        value="No"
                      />
                      <label for="">No</label><br />
                    </div>
                  </div> --}}
                </div>


              </div>

        </div>

        <div id="step4" class="step-wrapper step">
          <div class="header">
            <div>
              <h2>Appointment Summary</h2>
            </div>
          </div>

          <div class="summary-wrapper">
            <h1>Date: {{ \Carbon\Carbon::parse($data['date'])->format('F j, Y') }}</h1>
            <br>
            <h1>Doctor: {{ $data['doctor']['full_name'] }}</h1>
            <br>
            <h1>Service: {{ $data['service']['title'] }} </h1>

            <p> {!! htmlspecialchars_decode(strip_tags($data['service']['description'] )) !!}</p>
            <button id="bookAppointmentBtn" type="submit" class="btn submit-appointment-btn">Book Appointment</button>
          </div>
        </div>

        <div class="button-wrapper">
          <button class="btn" id="prev" disabled>Prev</button>
          <button class="btn" id="next">Next</button>
        </div>
      </div>
    </main>

    <!-- SCRIPTS -->
    <script src="{{ asset('js/appointment.js') }}"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
      integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
      integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
      crossorigin="anonymous"
    ></script>

    <script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"
  ></script>


    <script src="{{ asset('js/book-appointment-forms.js') }}"></script>
    <script src="{{ asset('js/alertify.js') }}"></script>
  </body>
</html>
