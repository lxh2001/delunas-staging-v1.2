@extends('portals.patients.layouts.master', ['isDashboardActive' => 'active', 'title' => 'Dashboard'])

@section('content')
<div class="content-body">
  <div class="analytics-section">
    <div class="analytics-card analytics-booked">
      <img src="{{ asset('icons/analytics-1.png') }}">
      <div>
        <p>{{ $appbooked }}</p>
        <h5>Appointments Booked</h5>
      </div>
    </div>
    <div class="analytics-card analytics-cancelled">
      <img src="{{ asset('icons/analytics-2.png') }}">
      <div>
        <p>{{ $appcancelled }}</p>
        <h5>Appointments Cancelled</h5>
      </div>
    </div>
    <div class="analytics-card analytics-done">
      <img src="{{ asset('icons/analytics-3.png') }}">
      <div>
        <p>{{ $appdone }}</p>
        <h5>Appointments Done</h5>
      </div>
    </div>
  </div>

  <div class="custom-section">
    <div class="d-flex flex-column w-100">
      <div class="header-title">
        <div>
          <h5>My Appointments</h5>
          <p>Access all your upcoming appointments.</p>
        </div>
      </div>

      <div class="d-flex flex-column justify-content-between tbl-overflow">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col"> Slot #</th>
              <th scope="col">Doctor's Name</th>
              <th scope="col">Date</th>
              <th scope="col">Time</th>
              <th scope="col">Service</th>
              <th scope="col">Status</th>
              <th scope="col" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ( $appointments as $appointment)
            <tr>
                <td>{{ $appointment->slot_no }}</td>
              <td>{{ $appointment->doctor->full_name }}</td>
              <td>{{ \Carbon\Carbon::parse($appointment->date_schedule)->format('F j, Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('g:i A') }}</td>
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
                @endif
              </td>
              @if ($appointment->status == 'pending')
              <td class="text-center">
                <button data-appointment="{{  json_encode($appointment) }}" class="view-appointment-btn viewAppointmentModalBtn" type="button" data-toggle="modal" data-target="#viewDoctorAppointmentLogs">
                  <img src="{{ asset('icons/eye.png') }}" />
                </button>
                <button data-appointment="{{ json_encode($appointment) }}" class="view-appointment-btn ml-2 cancelAppointmentBtn" type="button" data-toggle="modal" data-target="#cancelAppointmentModal">
                  <img src="{{ asset('icons/cross.png') }}" />
                </button>
              </td>
              @elseif ($appointment->status == 'done')
              <td class="text-center">
                @if(!$appointment->is_rated)
                    <button data-appointment="{{ json_encode($appointment) }}" class="add-feedback-btn" data-toggle="modal" data-target="#addFeedbackModal">
                    <img src="{{ asset('icons/feedback.png') }}" />Rate
                    </button>
                @else
                -
                @endif
              </td>
              @elseif ($appointment->status == 'rescheduled')
              <td class="text-center">
                @if($appointment->reschedule_status == 'rescheduled_by_admin')
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
                <button data-appointment="{{ json_encode($appointment) }}" class="view-appointment-btn ml-2 cancelAppointmentBtn" type="button" data-toggle="modal" data-target="#cancelAppointmentModal">
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

                            <button data-appointment="{{ json_encode($appointment) }}" class="view-appointment-btn ml-2 cancelAppointmentBtn" type="button" data-toggle="modal" data-target="#cancelAppointmentModal">
                                <img src="{{ asset('icons/cross.png') }}" />
                              </button>
                        </td>

              @elseif ($appointment->status == 'cancelled')
              <td class="text-center">
                -
                {{-- <button
                          class="view-appointment-btn"
                          type="button"
                          data-toggle="modal"
                          data-target="#viewDoctorAppointmentLogs"
                        >
                          <img src="{{ asset('icons/eye.png') }}" />
                </button>
                <button class="view-appointment-btn ml-2" type="button" data-toggle="modal" data-target="#cancelAppointmentModal">
                  <img src="{{ asset('icons/cross.png') }}" />
                </button> --}}
              </td>
              @endif
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center"> No Appointments Found</td>
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
<div class="modal fade appointment-info-modal" id="viewDoctorAppointmentLogs" tabindex="-1" role="dialog" aria-hidden="true">
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
            <div class="col-6">
              <span>Dentist:</span>
              <p id="viewDentistName"></p>
            </div>
            <div class="col-6">
              <span>Contact Number:</span>
              <p id="viewDentistContactNo"></p>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <span>Date:</span>
              <p id="viewAppDate"></p>
            </div>
            <div class="col-6">
              <span>Dentist's Availability:</span>
              <p id="viewAppTime"></p>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <span>Booked Service:</span>
              <p id="viewService"></p>
            </div>
            <div class="col-6">
              <span>Status:</span>
              <p id="viewStatus"></p>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button id="rescheduleAppModalBtn" class="btn submit-btn w-100" data-toggle="modal" data-target="#viewDoctorFreeScheduleModal" data-dismiss="modal">
          Reschedule Appointment
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Appointment Reschedule -->
<div class="modal fade appointment-info-modal" id="viewDoctorFreeScheduleModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Appointment Reschedule Request</h5>
        <button type="button" class="btn close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="info-wrapper">
          <div class="row">
            <div class="col-6">
              <span>Dentist:</span>
              <p id="reschedDentistName"></p>
            </div>
            <div class="col-6">
              <span>Service:</span>
              <p id="reschedService"></p>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <span>Date:</span>
              <p id="reschedDate"></p>
            </div>
            <div class="col-6">
              <span>Time:</span>
              <p id="reschedTime"></p>
            </div>
          </div>

          <div class="mt-5 border-top pt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 id="dentistNameSchedule"></h5>
              <div class="d-flex justify-content-end align-items-center gap-2 w-50">
                <label>Filter date:</label>
                <input id="rescheduledFilterDate" type="date" min="{{ now()->toDateString() }}" class="form-control" />
              </div>
            </div>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Date</th>
                  <th scope="col">Dentint's Availability</th>
                  <th scope="col" class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody id="availabilityTbl">
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="modal-footer">

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

<!-- Modal for Cancelling Appointment -->
<div class="modal fade appointment-info-modal" id="cancelAppointmentModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">Cancel Appointment</h5>
        <button type="button" class="btn close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center gap-1">
          <label>Send To Dentist:</label>
          <p id="cancelDentistName"></p>
        </div>
        <div>
          <label>Reason:</label>
          <textarea id="reason" class="form-control mt-2" style="height: 140px"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button id="cancelAppointmentBtn" class="submit-btn w-100">Cancel Appointment</button>
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

<!-- Modal for Adding Feedback/Rating -->
<div class="modal fade appointment-info-modal" id="addFeedbackModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">Rate your Experience</h5>
        <button type="button" class="btn close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-1">
          <div>
            <label>Send To:</label>
            <p id="rateDr"></p>
          </div>
          <div>
            <label>Rating:</label>
            <div class="rate p-0">
              <input class="rateStar" type="radio" id="star5" name="rate" value="5" />
              <label for="star5" title="text"></label>
              <input class="rateStar" type="radio" id="star4" name="rate" value="4" />
              <label for="star4" title="text"></label>
              <input class="rateStar" type="radio" id="star3" name="rate" value="3" />
              <label for="star3" title="text"></label>
              <input class="rateStar" type="radio" id="star2" name="rate" value="2" />
              <label for="star2" title="text"></label>
              <input class="rateStar" type="radio" id="star1" name="rate" value="1" />
              <label for="star1" title="text"></label>
            </div>
          </div>
        </div>
        <div class="mt-3">
          <label>Message:</label>
          <textarea id="rateMessage" class="form-control mt-2" style="height: 140px"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button id="sendFeebackBtn" class="submit-btn w-100">Send Feedback</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/ratings.css') }}" />
@endsection

@section('js')
<script src="{{ asset('js/patient-dashboard.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
@endsection
