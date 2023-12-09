@extends('portals.patients.layouts.master', ['isMyAppointmentsActive' => 'active', 'title' => 'My Appointments'])

@section('content')
<div class="content-body">
  <div class="row my-appointments-wrapper">
    <div class="col-12 col-md-8">
      <div class="custom-section mt-0">
        <div class="header-title">
          <div>
            <h5>My Calendar</h5>
            <p>View and set your calendar events</p>
          </div>
        </div>

        <div class="calendar-wrapper">
          <p>
            You can view/manage your appoinments here by clicking each dates
            of the calendar.
          </p>
          <div id="calendar" class="calendar"></div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
    <div class="schedule-wrapper">
        <div>
          <div class="row">
            <div class="col-12">
              <label>Book an Appointment:</label>
              <select id="service" class="form-control">
                <option disabled selected value="">Choose a service</option>
                @if($countapp > 0 && !$hasUncompletedCheckup)
                    @forelse ( $services as $service )
                        <option value="{{ $service->id }}">{{ $service->title }}</option>
                    @empty
                        <option disabled selected value="">No Services found</option>
                    @endforelse
                @else
                    <option value="Check-up">Check-up</option>
                @endif
              </select>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-12">
              <label>Choose a Dentist:</label>
              <select class="form-control" name="doctor" id="doctor">
                <option disabled selected value="">Choose a doctor</option>
                @forelse ( $doctors as $doctor )
                    <option value="{{ $doctor->id }}">{{ $doctor->full_name }}</option>
                @empty
                    <option disabled selected value="">No Doctors found</option>
                @endforelse
              </select>
            </div>
          </div>

          <div class="d-flex justify-content-end align-items-center mb-3">
            <div class="d-flex justify-content-end align-items-center gap-2 date-filter-wrapper mt-4">
              <label>Filter date:</label>
              <input id="filterDate" type="date" class="form-control w-auto" min="{{ now()->toDateString() }}" />
            </div>
          </div>

          <div class="tbl-overflow">
            <table class="table table-striped mt-3" style="width:100%;">
              <thead>
                <tr>
                  <th scope="col" class="text-center">Patients on Queue</th>
                  <th scope="col">Date</th>
                  <th scope="col">Dentist's Availability</th>
                  <th scope="col" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody id="availabilityTbl">
                <!-- <tr>
                  <th class="text-center">8</th>
                  <td>November 25, 2023</td>
                  <td>08:00 AM - 05:00 PM</td>
                  <td class="text-center">
                    <a
                      onclick="GoToBookingStep2()"
                      href="{{ route('patient.book-appointments') }}"
                      class="view-appointment-btn p-1"
                    >
                      <img src="{{ asset('icons/check.png') }}" />
                    </a>
                  </td>
                </tr> -->
              </tbody>
            </table>
          </div>
        </div>

        <div class="btn-wrapper d-none">
          <button class="btn book-appointment-btn">
            Book this schedule
          </button>
        </div>
      </div>
    </div>
  </div>


    <!-- Footer -->
    <div class="footer">
      <p>© 2023 All Rights Reserved by DeLunas Dental Centre</p>
    </div>
  </div>

<!-- Modal for Confirm Reschuling Appointment -->
<div
class="modal fade appointment-info-modal"
id="appointmentSummaryModal"
tabindex="-1"
role="dialog"
aria-hidden="true"
>
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title text-center">Appointment Summary</h5>
      <button type="button" class="btn close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <div class="modal-body">
      <div class="d-flex align-items-center gap-1">
        <label>Date:</label>
        <p id="appDate"></p>
      </div>
      <div class="d-flex align-items-center gap-1">
          <label>Dentist:</label>
          <p id="appDentist"></p>
      </div>
      <div class="d-flex align-items-center gap-1">
          <label>Dentist's Availability:</label>
          <p id="appAvailability"></p>
      </div>
      <div class="d-flex align-items-center gap-1">
        <label>Service:</label>
        <p id="appService"></p>
      </div>
    </div>
    <div class="modal-footer">
      <button id="submitAppointmentBtn" class="submit-btn w-100">Submit</button>
    </div>
  </div>
</div>
</div>
@endsection

@section('js')

<script src="{{ asset('js/patient-my-appointment.js') }}"></script>
<script src="{{ asset('js/fullcalendar.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>

{{-- <script src="{{ asset('js/appointment.js') }}"></script> --}}
@endsection
