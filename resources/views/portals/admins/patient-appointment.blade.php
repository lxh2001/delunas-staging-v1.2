@extends('portals.admins.layouts.master', ['isAppointmentActive' => 'active' , 'title' => 'Admin Patient Appointments'])

@section('content')
<div class="content-body"> <div class="custom-section my-0"> <div class="d-flex flex-column w-100">
  <div class="header-title">
  <div>
  <h5>Client's Appointment Logs</h5>
  <p>Access all your Doctor's appointments and transactions.</p>
  </div>
</div>

<div class="d-flex flex-column justify-content-between tbl-overflow">
<table class="table table-striped">
  <thead>
  <tr>
  <th scope="col">Client</th>
  <th scope="col">Date & Time</th>
  <th scope="col">Doctor</th>
  <th scope="col">Service</th>
  <th scope="col">Status</th>
  <th scope="col">Actions</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td><span>Tony Stark</span></td>
    <td>10-Oct-23 | 10:30 am</td>
    <td>Dra. Zenaida Tutanes De Lunas</td>
    <td>Dental Filling/Pasta</td>
    <td>
    <span class="status-approval">For Confirmation</span>
    </td>
    <td>
    <button class="view-appointment-btn" type="button" data-toggle="modal" data-target="#viewDoctorAppointmentLogs">
      <img src="{{ asset('icons/eye.png') }}" />
    </button>
    <button class="view-appointment-btn ml-2" type="button" data-toggle="modal" data-target="#cancelAppointmentModal">
      <img src="{{ asset('icons/cross.png') }}" />
    </button>
    </td>
  </tr>
  <tr>
    <td><span>John Smith</span></td>
    <td>10-Oct-23 | 10:30 am</td>
    <td>Dra. Zenaida Tutanes De Lunas</td>
    <td>Dental Filling/Pasta</td>
    <td><span>-</span></td>
    <td>
      <button class="view-appointment-btn" type="button" data-toggle="modal" data-target="#viewDoctorAppointmentLogs">
        <img src="{{ asset('icons/eye.png') }}" />
      </button>
      <button class="view-appointment-btn ml-2" type="button" data-toggle="modal" data-target="#cancelAppointmentModal">
        <img src="{{ asset('icons/cross.png') }}" />
      </button>
    </td>
  </tr>
  <tr>
    <td><span>John Smith</span></td>
    <td>10-Oct-23 | 10:30 am</td>
    <td>Dra. Zenaida Tutanes De Lunas</td>
    <td>Dental Filling/Pasta</td>
    <td><span class="status-done">Done</span></td>
    <td>
      <button class="view-appointment-btn" type="button" data-toggle="modal" data-target="#viewDoctorAppointmentLogs">
        <img src="{{ asset('icons/eye.png') }}" />
      </button>
      <button class="view-appointment-btn ml-2" type="button" data-toggle="modal" data-target="#cancelAppointmentModal">
        <img src="{{ asset('icons/cross.png') }}" />
      </button>
    </td>
  </tr>
  <tr>
    <td><span>John Smith</span></td>
    <td>10-Oct-23 | 10:30 am</td>
    <td>Dra. Zenaida Tutanes De Lunas</td>
    <td>Dental Filling/Pasta</td>
    <td><span class="status-resched">Reschedule</span></td>
    <td>
      <button class="view-appointment-btn" type="button" data-toggle="modal" data-target="#viewDoctorAppointmentLogs">
        <img src="{{ asset('icons/eye.png') }}" />
      </button>
      <button class="view-appointment-btn ml-2" type="button" data-toggle="modal" data-target="#cancelAppointmentModal">
        <img src="{{ asset('icons/cross.png') }}" />
      </button>
    </td>
  </tr>
  <tr>
    <td><span>John Smith</span></td>
    <td>10-Oct-23 | 10:30 am</td>
    <td>Dra. Zenaida Tutanes De Lunas</td>
    <td>Dental Filling/Pasta</td>
    <td><span class="status-cancelled">Cancelled</span></td>
    <td>
      <button class="view-appointment-btn" type="button" data-toggle="modal" data-target="#viewDoctorAppointmentLogs">
        <img src="{{ asset('icons/eye.png') }}" />
      </button>
      <button class="view-appointment-btn ml-2" type="button" data-toggle="modal" data-target="#cancelAppointmentModal">
        <img src="{{ asset('icons/cross.png') }}" />
      </button>
    </td>
  </tr>
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
<div class="modal fade appointment-info-modal" id="viewDoctorAppointmentLogs" tabindex="-1" role="dialog"
  aria-hidden="true">
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
              <p>John Smith</p>
            </div>
            <div class="col-12 col-md-6">
              <span>Contact Number:</span>
              <p>+63 912 3456 789</p>
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-md-6">
              <span>Date:</span>
              <p>October 10, 2023</p>
            </div>
            <div class="col-12 col-md-6">
              <span>Time:</span>
              <p>10:30 am</p>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-12 col-md-6">
              <span>Dentist:</span>
              <p>Dra. Zenaida Tutanes De Lunas</p>
            </div>
            <div class="col-12 col-md-6">
              <span>Booked Service:</span>
              <p>Dental Filling/Pasta</p>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12 col-md-6">
              <span>Status:</span>
              <p>-</p>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn submit-btn w-100">
          Set Appointment to Done
        </button>
        <button class="btn resched-btn w-100" data-toggle="modal" data-target="#viewDoctorFreeScheduleModal"
          data-dismiss="modal">
          Reschedule Appointment
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Viewing Doctors Schedule for Client -->
<div class="modal fade appointment-info-modal" id="viewDoctorFreeScheduleModal" tabindex="-1" role="dialog"
  aria-hidden="true">
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
              <p>John Smith</p>
            </div>
            <div class="col-12 col-md-6">
              <span>Contact Number:</span>
              <p>+63 912 3456 789</p>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-6">
              <span>Date:</span>
              <p>October 10, 2023</p>
            </div>
            <div class="col-12 col-md-6">
              <span>Time:</span>
              <p>10:30 am</p>
            </div>
          </div>

          <!-- Table of Doctor's Schedule -->
          <div class="mt-5 border-top pt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5>Dra. Zenaida Tutanes De Lunas' Schedule **</h5>
              <div class="d-flex justify-content-end align-items-center gap-2 w-50">
                <label>Filter date:</label>
                <input type="date" class="form-control" />
              </div>
            </div>
            <div class="tbl-overflow">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>October 11, 2023</td>
                    <td>9:30am - 11:30pm</td>
                    <td>Free</td>
                    <td class="text-center">
                      <input type="radio" name="chooseSchedule" />
                    </td>
                  </tr>
                  <tr>
                    <td>October 11, 2023</td>
                    <td>1:00pm - 2:30pm</td>
                    <td>Free</td>
                    <td class="text-center">
                      <input type="radio" name="chooseSchedule" />
                    </td>
                  </tr>
                  <tr>
                    <td>October 12, 2023</td>
                    <td>9:30am - 1:30pm</td>
                    <td>Booked</td>
                    <td class="text-center">
                      <input type="radio" name="chooseSchedule" disabled />
                    </td>
                  </tr>
                  <tr>
                    <td>October 12, 2023</td>
                    <td>1:30pm - 2:30pm</td>
                    <td>Booked</td>
                    <td class="text-center">
                      <input type="radio" name="chooseSchedule" disabled />
                    </td>
                  </tr>
                  <tr>
                    <td>October 12, 2023</td>
                    <td>3:30am - 4:45pm</td>
                    <td>Free</td>
                    <td class="text-center">
                      <input type="radio" name="chooseSchedule" />
                    </td>
                  </tr>
                  <tr>
                    <td>October 13, 2023</td>
                    <td>9:30am - 1:30pm</td>
                    <td>Free</td>
                    <td class="text-center">
                      <input type="radio" name="chooseSchedule" />
                    </td>
                  </tr>
                  <tr>
                    <td>October 14, 2023</td>
                    <td>9:30am - 1:30pm</td>
                    <td>Booked</td>
                    <td class="text-center">
                      <input type="radio" name="chooseSchedule" disabled />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn submit-btn w-100">
          Set Reschedule Appointment
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Cancelling Appointment -->
<div class="modal fade appointment-info-modal" id="cancelAppointmentModal" tabindex="-1" role="dialog"
  aria-hidden="true">
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
          <label>Send To:</label>
          <p>Tony Stark</p>,<p>Dra. Zenaida Tutanes De Lunas</p>
        </div>
        <div>
          <label>Reason:</label>
          <textarea class="form-control mt-2" style="height: 140px;"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="submit-btn w-100">Cancel Appointment</button>
      </div>
    </div>
  </div>
</div>
@endsection