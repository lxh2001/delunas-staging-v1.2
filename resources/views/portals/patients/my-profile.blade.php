@extends('portals.patients.layouts.master', ['isMyProfileActive' => 'active', 'title' => 'My Profile'])

@section('content')
<div class="content-body doctor-profile-wrapper">
    <div class="custom-section mt-0 info-content w-75 m-auto">
      <div class="d-flex flex-column w-100">
        <div class="header-title">
          <div>
            <h5>Profile</h5>
            <p>Here you can edit and update your profile.</p>
          </div>
        </div>

        <div class="mt-5 p-4 upload-wrapper">
            <form action="{{ route('patient.upload.photo') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-5 text-center">
                    <div class="profile-photo-wrapper">
                        <img id="viewPhoto" src="/storage/{{ auth()->user()->image_url }}" />
                    </div>
                    </div>
                    <div class="col-12 col-md-7 d-flex align-items-center">
                    <div class="upload-btn-wrapper">
                        <input type="file" name="image" id="photo" required class="upload-photo-btn" />
                        <p>
                        Make sure you're uploading a clear and high-quality photo
                        to ensure the best visual representation of your profile.
                        </p>
                    </div>
                    </div>
                    <div
                    class="d-flex flex-row justify-content-between align-items-center gap-2"
                >
                    <h5></h5>
                    <div>
                    <button type="submit" class="save-profile">
                        <img src="{{ asset('icons/save.png') }}" />Upload photo
                    </button>
                    </div>
                </div>
                </div>
            </form>
        </div>

        <div class="more-info">
            <form action="{{ route('patient.update.info') }}" method="POST">
            <div
                class="d-flex flex-row justify-content-between align-items-center gap-2"
            >
                <h5>Personal Info</h5>
                <div>
                <button id="editPersonalInfoBtn" class="edit-profile">
                    <img src="{{ asset('icons/edit.png') }}" />Edit
                </button>
                <button type="submit" class="save-profile">
                    <img src="{{ asset('icons/save.png') }}" />Save Changes
                </button>
                </div>
            </div>
            @csrf
            <div class="row mt-4">
                <div class="col-12 col-md-4">
                <label>First Name</label>
                <input
                    type="text"
                    class="form-control personalInfoField"
                    value="{{ auth()->user()->firstname }}"
                    disabled
                    name="firstname"
                    required
                />

                @if ($errors->has('firstname'))
                    <span class="error-msg">{{ $errors->first('firstname') }}</span>
                @endif

                </div>
                <div class="col-12 col-md-4">
                <label>Middle Name</label>
                <input
                    type="text"
                    class="form-control personalInfoField"
                    value="{{ auth()->user()->middlename }}"
                    disabled
                    name="middlename"
                />
                </div>
                <div class="col-12 col-md-4">
                <label>Last Name</label>
                <input
                    type="text"
                    class="form-control personalInfoField"
                    value="{{ auth()->user()->lastname }}"
                    disabled
                    name="lastname"
                    required
                />

                @if ($errors->has('lastname'))
                    <span class="error-msg">{{ $errors->first('lastname') }}</span>
                @endif
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 col-md-4">
                <label>Email</label>
                <input
                    type="email"
                    class="form-control "
                    value="{{ auth()->user()->email }}"
                    disabled
                    name="email"
                    required
                />
                </div>
                <div class="col-12 col-md-4">
                <label>Contact Number</label>
                <input
                    type="text"
                    class="form-control personalInfoField"
                    value="{{ auth()->user()->contact_number }}"
                    disabled
                    name="contact_number"
                    required
                />
                @if ($errors->has('contact_number'))
                    <span class="error-msg">{{ $errors->first('contact_number') }}</span>
                @endif
                </div>
                <div class="col-12 col-md-4">
                    <label>Birth Date</label>
                    <input
                    type="date"
                    class="form-control personalInfoField"
                    value="{{ auth()->user()->birthdate }}"
                    disabled
                    name="birthdate"
                    required
                    />
                    @if ($errors->has('birthdate'))
                        <span class="error-msg">{{ $errors->first('birthdate') }}</span>
                    @endif
                </div>
            </div>
        </form>
        </div>

        <div class="more-info">
        <form action="{{ route('patient.update.account') }}" method="POST">
            @csrf
          <div
            class="d-flex flex-row justify-content-between align-items-center gap-2"
          >
            <h5>Account</h5>
            <div>
              <button id="editAccount" class="edit-profile">
                <img src="{{ asset('icons/edit.png') }}" />Edit
              </button>

              <button type="submit" class="save-profile">
                <img src="{{ asset('icons/save.png') }}" />Save Changes
              </button>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-6">
              <label>Password</label>
              <input
                type="password"
                class="form-control accountField"
                disabled
                required
                name="password"
              />
              @if ($errors->has('password'))
                <span class="error-msg">{{ $errors->first('password') }}</span>
              @endif
            </div>
            <div class="col-6">
              <label>Confirm Password</label>
              <input
                type="password"
                class="form-control accountField"
                disabled
                required
                name="confirm_password"
              />
              @if ($errors->has('confirm_password'))
                <span class="error-msg">{{ $errors->first('confirm_password') }}</span>
              @endif
            </div>
          </div>
        </form>
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

<script src="{{ asset('js/patient-my-profile.js') }}"></script>
@if (session('success_message'))
<script>
   $(document).ready(function() {
        alertify.success('Profile successfully updated');
    });
</script>
@endif
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/doctor.css') }}" />
@endsection
