@extends('portals.admins.layouts.master', ['isAccountActive' => 'active' , 'title' => 'Admin Accounts'])

@section('content')
<div class="content-body">
  <!-- Doctor List -->
  <div class="custom-section my-0">
    <div class="d-flex flex-column w-100">
      <div class="header-title">
        <div>
          <h5>Doctors List</h5>
          <p>View all your Doctors details.</p>
        </div>
        <button class="btn add-doctor-btn" data-toggle="modal" data-target="#addDoctorModal">
          <img src="{{ asset('icons/add-doctor.png') }}" />Add Doctor
        </button>
      </div>

      <div class="d-flex flex-column justify-content-between tbl-overflow">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Address</th>
              <th scope="col">Contact Number</th>
              <th scope="col" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($doctors as $doctor)
            <tr>
              <td>{{ $doctor->fullname  }}</td>
              <td>
                {{ $doctor->address }}
              </td>
              <td>{{ $doctor->contact_number }}</td>
              <td class="text-center">
                <button data-doctor="{{ json_encode($doctor) }}" class="view-item-btn viewDoctor" data-toggle="modal" data-target="#doctorModalDetails">
                  <img src="{{ asset('icons/eye.png') }}" />
                </button>
                <button id="deleteDoctorModalBtn" data-doctor="{{ json_encode($doctor) }}" class="view-item-btn mx-1" data-toggle="modal" data-target="#deleteConfirmationModal">
                  <img src="{{ asset('icons/delete.png') }}" />
                </button>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center">No Users Found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        {{ $doctors->links() }}
      </div>
    </div>
  </div>

  <!-- Client List -->
  <div class="custom-section mt-4">
    <div class="d-flex flex-column w-100">
      <div class="header-title">
        <div>
          <h5>Client List</h5>
          <p>
            Access the list of all the client of DeLunas Dental Centre.
          </p>
        </div>
      </div>

      <div class="d-flex flex-column justify-content-between tbl-overflow">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Contact Number</th>
              <th scope="col">Address</th>
              <th scope="col" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
            <tr>
              <td>{{ $user->full_name }}</td>
              <td>{{ $user->contact_number }}</td>
              <td>{{ $user->address }}</td>
              <td class="text-center">
                <button id="viewUserBtn" data-user="{{ json_encode($user) }}" class="view-item-btn viewUser" data-toggle="modal" data-target="#clientModalDetails">
                  <img src="{{ asset('icons/eye.png') }}" />
                </button>
                <button id="deleteUserModalBtn" data-user="{{ json_encode($user) }}" class="view-item-btn mx-1" data-toggle="modal" data-target="#deleteConfirmationModal">
                  <img src="{{ asset('icons/delete.png') }}" />
                </button>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center">No Doctors Found</td>
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


<!-- Modal for Adding New Doctor -->
<div class="modal fade appointment-info-modal" id="addDoctorModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Account: Doctor</h5>
        <button type="button" class="btn close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.create.user') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <label>First Name:</label>
              <input type="text" required name="firstname" class="form-control" value="{{ old('firstname') }}" />

              @if ($errors->has('firstname'))
              <span style="color: #dc3545!important;">{{ $errors->first('firstname') }}</span>
              @endif

            </div>
          </div>

          <div class="row mt-3">
            <div class="col-12">
              <label>Middle Name:</label>
              <input type="text" name="middlename" class="form-control" value="{{ old('middlename') }}" />
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-12">
              <label>Last Name:</label>
              <input type="text" required name="lastname" class="form-control" value="{{ old('lastname') }}" />

              @if ($errors->has('lastname'))
              <span style="color: #dc3545!important;">{{ $errors->first('lastname') }}</span>
              @endif
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-12">
              <label>Email:</label>
              <input type="email" required name="email" class="form-control" value="{{ old('email') }}" />

              @if ($errors->has('email'))
              <span style="color: #dc3545!important;">{{ $errors->first('email') }}</span>
              @endif
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-12">
              <label>Contact Number:</label>
              <input type="number" required name="contact_number" class="form-control" value="{{ old('contact_number') }}" />

              @if ($errors->has('contact_number'))
              <span style="color: #dc3545!important;">{{ $errors->first('contact_number') }}</span>
              @endif
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12">
              <label>Address:</label>
              <input type="text" name="address" class="form-control" value="{{ old('address') }}" />
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-12">
              <label>Password:</label>
              <input type="password" required name="password" class="form-control" />

              @if ($errors->has('password'))
              <span style="color: #dc3545!important;">{{ $errors->first('password') }}</span>
              @endif
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12">
              <label>Confirm Password:</label>
              <input type="password" required name="confirm_password" class="form-control" />

              @if ($errors->has('confirm_password'))
              <span style="color: #dc3545!important;">{{ $errors->first('confirm_password') }}</span>
              @endif
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn submit-btn w-100">
            <img src="{{ asset('icons/save.png') }}" />Save New Doctor
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal for Delete Confirmation -->
<div class="modal fade appointment-info-modal" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-hidden="true" id="deleteDoctorBtn">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">Delete User Confirmation</h5>
        <button type="button" class="btn close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-between gap-2">
          <div class="text-center">
            <img src="{{ asset('images/modal-delete.png') }}" />
          </div>
          <p class="mb-2">
            Are you sure you want to delete? <br />This
            action is irreversible and will permanently remove <br />all
            your the user's account data.
          </p>
        </div>
      </div>
      <div class="modal-footer">
        <button id="deleteUserBtn" class="submit-btn w-100">Yes, Delete this Account</button>
        <button class="cancel-btn w-100" data-dismiss="modal">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Viewing Doctor Details -->
<div class="modal fade appointment-info-modal" id="doctorModalDetails" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Doctor Information</h5>
        <button type="button" class="btn close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-between gap-3">
          <img src="{{ asset('images/default-img.png') }}" />
          <div class="info-wrapper">
            <div class="row">
              <div class="col-12">
                <span>Name:</span>
                <p id="viewFullname">Full name</p>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <span>Contact:</span>
                <p id="viewContactNo">Contact Number</p>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <span>Email:</span>
                <p id="viewEmail">email</p>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <span>Address:</span>
                <p id="viewAddress">
                  Address
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button id="accessDocModalBtn" class="btn submit-btn" data-toggle="modal" data-target="#updateDoctorSchedule" data-dismiss="modal">
          Access Doctor's Schedule
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Adding/Updating Doctor's Schedule -->
<div class="modal fade" id="updateDoctorSchedule" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="doctorName">Doctor [doctor_name]'s Schedule</h5>
        <button type="button" class="btn close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="info-wrapper">
          <div class="mb-3">
            <div>
              <button class="add-single-sched d-none" onclick="toggleSchedule('single')">
                Add Single Schedule
              </button>
              {{-- <button
                    class="add-recurring-sched"
                    onclick="toggleSchedule('recurring')"
                  >
                    Add Recurring Schedule
                  </button> --}}
            </div>

            <!-- ADDING SINGLE SCHEDULE -->
            {{-- <div id="singleScheduleDiv" class="add-sched-div d-none">
                  <div class="row">
                    <div class="col-5">
                      <label>Date:</label>
                      <input type="date" class="form-control w-100" />
                    </div>
                    <div class="col-3">
                        <label>Start Date:</label>
                        <input type="date" class="form-control w-100" />
                    </div>
                    <div class="col-3">
                      <label>Start Time:</label>
                      <input type="time" class="form-control w-100" />
                    </div>
                    <div class="col-3">
                      <label>End Time:</label>
                      <input type="time" class="form-control w-100" />
                    </div>
                    <div class="col-1 d-flex align-items-end">
                      <button class="view-item-btn"><img src="{{ asset('icons/check.png') }}" /></button>
          </div>
        </div>
      </div> --}}

      <!-- ADDING RECURRING SCHEDULE -->
      <div id="recurringScheduleDiv" class="add-sched-div d-block">
        <div class="row">
          <div class="col-3">
            <label>Start Date:</label>
            <input type="date" id="startDate" class="form-control w-100" min="<?php echo date('Y-m-d'); ?>"/>
          </div>

          <div class="col-3">
            <label>End Date:</label>
            <input type="date" id="endDate" class="form-control w-100" min="<?php echo date('Y-m-d'); ?>" />
          </div>

          <div class="col-6 d-flex align-items-center flex-wrap">
            <div><label>Choose Recurring Day/s:</label></div>
            <div class="d-flex">
              <label><input class="days" type="checkbox" value="1" /> MON</label>
              <label><input class="days" type="checkbox" value="2" /> TUES</label>
              <label><input class="days" type="checkbox" value="3" /> WED</label>
              <label><input class="days" type="checkbox" value="4" /> THU</label>
              <label><input class="days" type="checkbox" value="5" /> FRI</label>
              <label><input class="days" type="checkbox" value="6" /> SAT</label>
              <label><input class="days" type="checkbox" value="0" /> SUN</label>
            </div>
            @error('days')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-3">
            <label>Start Time:</label>
            <input type="time" id="startTime" class="form-control w-100" />
            @error('startTime')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-3">
            <label>End Time:</label>
            <input type="time" id="endTime" class="form-control w-100" />
            @error('endTime')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-3 d-flex align-items-end">
            <!-- <button class="view-item-btn" id="addRecBtn"><img src="{{ asset('icons/check.png') }}" /></button> -->
            <button class="btn submit-btn w-100" id="addRecBtn" style="font-size:10px;height:33.25px;padding:8px">
              ADD SCHEDULE
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end align-items-center mb-2">
      <div class="d-flex justify-content-end align-items-center gap-2 w-50">
        <label>Filter date:</label>
        <input type="date" id="filterDate" class="form-control" />
      </div>
    </div>
    <!-- Table of Doctor's Schedule -->
    <div class="tbl-overflow">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Recurring Day/s</th>
            <th scope="col">Doctor's Availability</th>
            <th scope="col" class="text-center">Patients on Queue</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody id="availabilitySlotTbl">
          <tr>
            <td colspan="4">No Schedules found</td>
          </tr>
          <tr>
            <td>November 22, 2023</td>
            <td>Mon, Tues, Weds, Thurs, Fri</td>
            <td>08:00 AM - 05:00 PM</td>
            <th class="text-center">14</th>
          </tr>
          <tr>
            <td>November 24, 2023</td>
            <td>Mon, Tues, Weds, Thurs, Fri</td>
            <td>08:00 AM - 05:00 PM</td>
            <th class="text-center">10</th>
          </tr>
          <tr>
            <td>November 25, 2023</td>
            <td>Mon, Tues, Weds, Thurs, Fri</td>
            <td>08:00 AM - 05:00 PM</td>
            <th class="text-center">8</th>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="modal-footer d-flex justify-content-between align-items-center">
  <button class="btn cancel-btn" data-toggle="modal" data-target="#doctorModalDetails" data-dismiss="modal">
    <img src="{{ asset('icons/back.png') }}" />
    Back to Doctor's Information
  </button>
  <button class="btn submit-btn" id="updateScheduleBtn">
    <img src="{{ asset('icons/loading.png') }}" />View Schedule
  </button>
</div>
</div>
</div>
</div>

<!-- Modal for Updating Doctor's Schedule -->
<div class="modal fade" id="editDoctorSchedule" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editDoctorName">Doctor [doctor_name]'s Schedule</h5>
          <button type="button" class="btn close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="info-wrapper">
            <div class="mb-3">
              <div>
                <button class="add-single-sched d-none" onclick="toggleSchedule('single')">
                  Add Single Schedule
                </button>
                {{-- <button
                      class="add-recurring-sched"
                      onclick="toggleSchedule('recurring')"
                    >
                      Add Recurring Schedule
                    </button> --}}
              </div>

        <!-- EDIT RECURRING SCHEDULE -->
        <div id="recurringScheduleDiv" class="add-sched-div d-block">
          <div class="row">
            <div class="col-3">
              <label>Start Date:</label>
              <input type="date" id="editStartDate" class="form-control w-100" min="<?php echo date('Y-m-d'); ?>"/>
            </div>

            <div class="col-3">
              <label>End Date:</label>
              <input type="date" id="editEndDate" class="form-control w-100" min="<?php echo date('Y-m-d'); ?>" />
            </div>

            <div class="col-6 d-flex align-items-center flex-wrap">
              <div><label>Choose Recurring Day/s:</label></div>
              <div class="d-flex">
                <label><input class="editDays" type="checkbox" value="1" /> MON</label>
                <label><input class="editDays" type="checkbox" value="2" /> TUES</label>
                <label><input class="editDays" type="checkbox" value="3" /> WED</label>
                <label><input class="editDays" type="checkbox" value="4" /> THU</label>
                <label><input class="editDays" type="checkbox" value="5" /> FRI</label>
                <label><input class="editDays" type="checkbox" value="6" /> SAT</label>
                <label><input class="editDays" type="checkbox" value="0" /> SUN</label>
              </div>
              @error('days')
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-3">
              <label>Start Time:</label>
              <input type="time" id="editStartTime" class="form-control w-100" />
              @error('startTime')
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3">
              <label>End Time:</label>
              <input type="time" id="editEndTime" class="form-control w-100" />
              @error('endTime')
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 d-flex align-items-end">
              <!-- <button class="view-item-btn" id="addRecBtn"><img src="{{ asset('icons/check.png') }}" /></button> -->
              <button class="btn submit-btn w-100" id="editRecBtn" style="font-size:10px;height:33.25px;padding:8px">
                UPDATE SCHEDULE
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer d-flex justify-content-between align-items-center">
    <button class="btn cancel-btn" data-toggle="modal" data-target="#doctorModalDetails" data-dismiss="modal">
      <img src="{{ asset('icons/back.png') }}" />
      Back to Doctor's Information
    </button>
  </div>
  </div>
  </div>
  </div>


<!-- Modal for Viewing Client Details -->
<div class="modal fade appointment-info-modal" id="clientModalDetails" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Client Information</h5>
        <button type="button" class="btn close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-between gap-3">
          <img src="{{ asset('images/default-img.png') }}" />
          <div class="info-wrapper">
            <div class="row">
              <div class="col-12">
                <span>Name:</span>
                <p id="viewUserFullname">Name</p>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <span>Email:</span>
                <p id="viewUserEmail">jimi_hendrix@email.com</p>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <span>Contact Number:</span>
                <p id="viewUserContactNo">+639 912 345 6789</p>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <span>Address:</span>
                <p id="viewUserAddress">ABC 123 Alabang, Muntinlupa City, PH</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
<script src=" {{ asset('js/admin-accounts.js') }}"> </script>
<script src="{{  asset('js/moment.js') }}"></script>
<!-- Modal for displaying errors -->
@if ($errors->any())
<script>
  $('#addDoctorModal').modal('show');
</script>
@endif
@endsection
