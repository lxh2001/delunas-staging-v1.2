@extends('portals.admins.layouts.master', ['isDoctorAppActive' => 'active' , 'title' => 'Admin Doctor Appointment'])

@section('content')
<div class="content-body">
    <div class="d-flex justify-content-end align-items-center mb-3">
      {{-- <div class="d-flex gap-2">
        <input type="text" class="form-control" placeholder="Name of Doctor" style="font-size:13px;width:300px" />
        <input type="date" class="form-control w-auto" style="font-size:13px" />
        <button class="search-btn m-0"><img src="{{ asset('icons/search.png') }}" />Search</button>
      </div> --}}
    </div>
    <div class="custom-section my-0">
      <div class="d-flex flex-column w-100">
        <div class="header-title">
          <div>
            <h5>Doctor's Appointment Logs</h5>
            <p>Access all your Doctor's appointments and transactions.</p>
          </div>
        </div>

        <div class="d-flex flex-column justify-content-between tbl-overflow">
          <table class="table table-striped" id="dataTable">
            <thead>
              <tr>
                <th scope="col">Slot #</th>
                <th scope="col">Doctor</th>
                <th scope="col">Date & Time</th>
                <th scope="col">Client</th>
                <th scope="col">Service</th>
                <th scope="col">Status</th>
                <th scope="col">View</th>
              </tr>
            </thead>
            <tbody>
                @forelse ( $appointments as  $appointment)
                <tr>
                    <td>{{ $appointment->slot_no }}</td>
                    <td>{{ $appointment->doctor->full_name }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($appointment->date_schedule)->format('F j, Y') }}
                        -
                        {{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('g:i A') }}
                    </td>
                    <td>{{ $appointment->bookedUser->full_name }}</td>
                    <td>{{ $appointment->service }}</td>
                    <td>
                        @if ($appointment->status == 'pending')
                            <span class="status-cancelled"> Pending </span>
                        @elseif($appointment->status == 'approved')
                            <span class="status-approved">Approved</span>
                        @elseif ($appointment->status == 'done')
                            <span class="status-done">Done</span>
                        @elseif ($appointment->status == 'rescheduled')
                            <span class="status-resched">Rescheduled</span>
                        @elseif ($appointment->status == 'cancelled')
                            <span class="status-cancelled">Cancelled</span>
                        @elseif ($appointment->status == 'declined')
                            <span class="status-cancelled">Declined</span>
                        @endif
                    </td>
                    @if ($appointment->status == 'pending')
                        <td class="text-center">
                            <button
                            data-appointment="{{  json_encode($appointment) }}"
                            class="view-appointment-btn viewAppointmentModalBtn"
                            type="button"
                            data-toggle="modal"
                            data-target="#viewDoctorAppointmentLogs"
                            >
                            <img src="{{ asset('icons/eye.png') }}" />
                            </button>
                            <button
                            data-appointment= "{{ json_encode($appointment) }}"
                            class="view-appointment-btn ml-2 cancelAppointmentBtn"
                            type="button"
                            data-toggle="modal"
                            data-target="#cancelAppointmentModal"
                            >
                            <img src="{{ asset('icons/cross.png') }}" />
                            </button>
                        </td>
                    @elseif ($appointment->status == 'done')
                        <td class="text-center">
                            -
                            {{-- <button
                            class="add-feedback-btn"
                            data-toggle="modal"
                            data-target="#addFeedbackModal"
                            >
                            <img src="{{ asset('icons/feedback.png') }}" />Rate
                            </button> --}}
                        </td>
                    @elseif ($appointment->status == 'rescheduled')
                        <td class="text-center">
                            @if($appointment->reschedule_status == 'rescheduled_by_patient')
                                <button
                                data-appointment="{{  json_encode($appointment) }}"
                                class="view-appointment-btn viewRescheduledAppointmentModalBtn"
                                type="button"
                                data-toggle="modal"
                                data-target="#viewRescheduleAppointmentModal"
                                >
                                <img src="{{ asset('icons/eye.png') }}" />
                                </button>
                            @endif
                            <button
                            data-appointment="{{ json_encode($appointment) }}"
                            class="view-appointment-btn ml-2 cancelAppointmentBtn"
                            type="button"
                            data-toggle="modal"
                            data-target="#cancelAppointmentModal"
                            >
                            <img src="{{ asset('icons/cross.png') }}" />
                            </button>
                        </td>
                    @elseif ($appointment->status == 'approved')
                        <td class="text-center">
                            <button
                            data-appointment="{{  json_encode($appointment) }}"
                            class="view-appointment-btn viewAppointmentModalBtn"
                            type="button"
                            data-toggle="modal"
                            data-target="#viewDoctorAppointmentLogs"
                            >
                            <img src="{{ asset('icons/eye.png') }}" />
                            </button>

                            @if(\Carbon\Carbon::parse($appointment->date_schedule)->isSameDay(\Carbon\Carbon::today()) || \Carbon\Carbon::parse($appointment->date_schedule)->isPast())
                                <button
                                class="view-appointment-btn p-1 doneBtn"
                                data-appointment="{{  json_encode($appointment) }}"
                                >
                                    <img src="{{ asset('icons/check.png') }}">
                                </button>
                            @endif
                        </td>
                    @elseif ($appointment->status == 'cancelled' || $appointment->status == 'declined')
                        <td class="text-center">
                            -
                      </td>
                    @endif
                  </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" > No Appointments Found</td>
                    </tr>
                @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <p>© 2023 All Rights Reserved by DeLunas Dental Centre</p>
    </div>
  </div>

  <!-- Modal for Viewing Client Appointments Log -->
  <div
  class="modal fade appointment-info-modal"
  id="viewDoctorAppointmentLogs"
  tabindex="-1"
  role="dialog"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Appointment Info</h5>
        <button type="button" class="btn close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="info-wrapper">
          <div class="row">
            <div class="col-12 col-md-6">
              <span>Client:</span>
              <p id="viewClientName"></p>
            </div>
            <div class="col-12 col-md-6">
              <span>Contact Number:</span>
              <p id="viewContactNo"></p>
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-md-6">
              <span>Date:</span>
              <p id="viewAppDate"></p>
            </div>
            <div class="col-12 col-md-6">
              <span>Dentist's Availability:</span>
              <p id="viewAppTime"></p>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-12 col-md-6">
              <span>Dentist:</span>
              <p id="viewDentistName"></p>
            </div>
            <div class="col-12 col-md-6">
              <span>Booked Service:</span>
              <p id="viewService"></p>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12 col-md-6">
              <span>Status:</span>
              <p id="viewStatus"></p>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button id="approveAppointmentBtn" class="btn submit-btn w-100">
          Approve Appointment
        </button>
        <button
          id="rescheduleAppModalBtn"
          class="btn resched-btn w-100"
          data-toggle="modal"
          data-target="#viewDoctorFreeScheduleModal"
          data-dismiss="modal"
        >
          Reschedule Appointment
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for CLient Reschudule -->
<div
  class="modal fade appointment-info-modal"
  id="viewDoctorFreeScheduleModal"
  tabindex="-1"
  role="dialog"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Client Appointment Reschedule</h5>
        <button type="button" class="btn close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="info-wrapper">
          <div class="row">
            <div class="col-12 col-md-6">
              <span>Client:</span>
              <p id="reschedClientName"></p>
            </div>
            <div class="col-12 col-md-6">
              <span>Contact Number:</span>
              <p id="reschedContactNo">+63 912 3456 789</p>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-6">
              <span>Date:</span>
              <p id="reschedAppDate"></p>
            </div>
            <div class="col-12 col-md-6">
              <span>Dentist's Availability:</span>
              <p id="reschedAppTime"></p>
            </div>
          </div>

          <!-- Table of Doctor's Schedule -->
          <div class="mt-5 border-top pt-3">
            <div
              class="d-flex justify-content-between align-items-center mb-3"
            >
              <h5 id="dentistNameSchedule"></h5>
              <div
                class="d-flex justify-content-end align-items-center gap-2 w-50"
              >
                <label>Filter date:</label>
                <input id="rescheduledFilterDate" min="{{ now()->toDateString() }}"  type="date" class="form-control" />
              </div>
            </div>
            <table class="table table-striped">
              <thead>
                <tr>
                 <th scope="col" class="text-center">Patients on Queue</th>
                 <th scope="col">Date</th>
                 <th scope="col">Dentist's Availability</th>
                 <th scope="col" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody id="availabilityTbl">

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Confirm Reschuling Appointment -->
<div
 class="modal fade appointment-info-modal"
 id="confirmRescheduleAppointmentModal"
 tabindex="-1"
 role="dialog"
 aria-hidden="true"
>
 <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title text-center">Reschedule Appointment</h5>
       <button type="button" class="btn close" data-dismiss="modal">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">
       <div class="d-flex align-items-center gap-1">
         <label>Current Date:</label>
         <p id="resCurrentDate"></p>
       </div>
       <div class="d-flex align-items-center gap-1">
           <label>Suggested Date:</label>
           <p id="resSuggestedDate"></p>
       </div>
       <div class="d-flex align-items-center gap-1">
           <label>Dentist's Availability:</label>
           <p id="dentistAvailability"></p>
       </div>
       <div>
         <label>Reason:</label>
         <textarea class="form-control mt-2" style="height: 140px;" id="resReason"></textarea>
       </div>
     </div>
     <div class="modal-footer">
       <button id="submitReschedule" class="submit-btn w-100">Reschedule Appointment</button>
     </div>
   </div>
 </div>
</div>

<!-- Modal for View Reschuled Appointment -->
<div
 class="modal fade appointment-info-modal"
 id="viewRescheduleAppointmentModal"
 tabindex="-1"
 role="dialog"
 aria-hidden="true"
>
 <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title text-center">Rescheduled Appointment</h5>
       <button type="button" class="btn close" data-dismiss="modal">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">
       <div class="d-flex align-items-center gap-1">
         <label>Current Date:</label>
         <p id="resAppCurrentDate"></p>
       </div>
       <div class="d-flex align-items-center gap-1">
           <label>Suggested Date:</label>
           <p id="resAppSuggestedDate"></p>
       </div>
       <div class="d-flex align-items-center gap-1">
           <label>Dentist's Availability:</label>
           <p id="resAppDentistAvailability"></p>
       </div>

       <div>
           <label>Reason:</label>
           <textarea class="form-control mt-2" style="height: 140px;" id="resAppReason" readonly></textarea>
       </div>

     </div>
     <div class="modal-footer" >
       <button id="approveReschedule" class="submit-btn">Approve</button>
       <button id="declineReschedule" class="delete-btn">Decline</button>
     </div>
   </div>
 </div>
</div>

<!-- Modal for Cancelling Appointment -->
<div
  class="modal fade appointment-info-modal"
  id="cancelAppointmentModal"
  tabindex="-1"
  role="dialog"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">Cancel Appointment</h5>
        <button type="button" class="btn close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center gap-1" id="patientDoctorEmail">
          <label>Send To:</label>
          {{-- <p>Tony Stark</p>,<p>Dra. Zenaida Tutanes De Lunas</p> --}}
        </div>
        <div>
          <label>Reason:</label>
          <textarea id="reason" class="form-control mt-2" style="height: 140px;"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="submit-btn w-100" id="cancelAppointmentBtn">Cancel Appointment</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src=" {{ asset('js/admin-doctor-appointment.js') }}"> </script>
<script src="{{  asset('js/moment.js') }}"></script>
@endsection
