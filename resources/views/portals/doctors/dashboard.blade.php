@extends('portals.doctors.layouts.master', ['isDashboardActive' => 'active', 'title' => 'Dashboard'])

@section('content')
<div class="content-body">
<div class="analytics-section">
      <div class="analytics-card analytics-booked">
        <img src="{{ asset('icons/analytics-1.png') }}">
        <div>
          <p>{{ $appmonthly }}</p>
          <h5>Clients Scheduled this Month</h5>
        </div>
      </div>
      <div class="analytics-card analytics-cancelled">
        <img src="{{ asset('icons/analytics-2.png') }}">
        <div>
          <p>{{ $appclientcancelled }}</p>
          <h5>Clients Cancelled</h5>
        </div>
      </div>
      <div class="analytics-card analytics-done">
        <img src="{{ asset('icons/analytics-3.png') }}">
        <div>
          <p>{{ $totalClients }}</p>
          <h5>Total Clients</h5>
        </div>
      </div>
    </div>

    <div class="custom-section">
      <div class="calendar-wrapper w-100">
        <div class="header-title">
          <div>
            <h5>My Calendar</h5>
            <p>View all appointments by your client/doctor.</p>
          </div>
        </div>
        <div id="calendar" class="calendar">
          <!-- INSERT CALENDAR HERE -->
        </div>
      </div>
    </div>

    <div class="custom-section">
      <div class="d-flex flex-column w-100">
        <div class="header-title">
          <div>
            <h5>Recent Activities</h5>
            <p>List of your previous activities with your patients.</p>
          </div>
        </div>

        <div class="d-flex justify-content-end align-items-center">
          <div class="d-flex justify-content-end align-items-center gap-2 w-25 date-filter-wrapper">
            <label>Filter date:</label>
            <input type="date" class="form-control w-auto">
          </div>
        </div>

        <div class="tbl-overflow">
          <table class="table table-striped mt-0">
            <thead>
              <tr>
                <th scope="col">Patient Name</th>
                <th scope="col">Service</th>
                <th scope="col">Date & Time</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
             @forelse ($appointments as  $appointment)
                <tr>
                    <td>{{ $appointment->bookedUser->full_name }}</td>
                    <td>{{ $appointment->service }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($appointment->date)->format('F j, Y') }}
                        -
                        {{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('g:i A') }}
                    </td>
                    <td>
                        @if ($appointment->status == 'pending')
                            <span class="status-approval"> For Confirmation </span>
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
                </tr>
             @empty
                 <tr>
                    <td colspan="4" class="text-center" > No Appointments found </td>
                 </tr>
             @endforelse
            </tbody>
          </table>

          {{ $appointments->links() }}
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <p>© 2023 All Rights Reserved by DeLunas Dental Centre</p>
    </div>
  </div>
@endsection

@section('js')
    <script src="{{ asset('js/doctor-dashboard.js') }}"></script>
    <script src="{{ asset('js/fullcalendar.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
@endsection
