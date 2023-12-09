@extends('portals.doctors.layouts.master', ['isMyProfileActive' => 'active', 'title' => 'My Profile'])

@section('content')
<div class="content-body doctor-profile-wrapper">
    <div class="custom-section mt-0 info-content m-auto">
      <div class="d-flex flex-column w-100">
        <div class="header-title">
          <div>
            <h5>Profile</h5>
            <p>Here you can edit and update your profile.</p>
          </div>
        </div>

        <div class="mt-5 p-4 upload-wrapper">
          <div class="row">
            <div class="col-12 col-md-5 text-center">
              <div class="profile-photo-wrapper">
                <img src="/assets/" />
              </div>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <div class="upload-btn-wrapper">
                <button class="upload-photo-btn">Upload new photo</button>
                <p>
                  Make sure you're uploading a clear and high-quality photo
                  to ensure the best visual representation of your profile.
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="more-info">
          <div
            class="d-flex flex-row justify-content-between align-items-center gap-2"
          >
            <h5>Personal Info</h5>
            <div>
              <button class="edit-profile">
                <img src="{{ asset('icons/edit.png') }}" />Edit
              </button>
              <button class="save-profile">
                <img src="{{ asset('icons/save.png') }}" />Save Changes
              </button>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-4">
              <label>First Name</label>
              <input
                type="text"
                class="form-control"
                value="Zenaida"
                disabled
              />
            </div>
            <div class="col-4">
              <label>Middle Name</label>
              <input
                type="text"
                class="form-control"
                value="Tutanes"
                disabled
              />
            </div>
            <div class="col-4">
              <label>Last Name</label>
              <input
                type="text"
                class="form-control"
                value="De Lunas"
                disabled
              />
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-4">
              <label>Email</label>
              <input
                type="email"
                class="form-control"
                value="delunasdentalclinic@email.com"
                disabled
              />
            </div>
            <div class="col-4">
              <label>Contact Number</label>
              <input
                type="text"
                class="form-control"
                value="(046) 123-45678"
                disabled
              />
            </div>
          </div>
        </div>

        <div class="more-info">
          <div
            class="d-flex flex-row justify-content-between align-items-center gap-2"
          >
            <h5>Bio</h5>
            <div>
              <button class="edit-profile">
                <img src="{{ asset('icons/edit.png') }}" />Edit
              </button>
              <button class="save-profile">
                <img src="{{ asset('icons/save.png') }}" />Save Changes
              </button>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-12">
              <textarea class="form-control" disabled>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex architecto commodi veniam accusantium adipisci voluptas quis earum repellat eligendi consectetur, cumque fugit nobis voluptates nam consequatur, porro, deserunt maiores doloremque. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi, nemo recusandae quidem excepturi ab ut doloribus animi, alias reprehenderit architecto voluptas error fuga et unde cupiditate corrupti impedit tempora ad.
              </textarea>
            </div>
          </div>
        </div>

        <div class="more-info">
          <div
            class="d-flex flex-row justify-content-between align-items-center gap-2"
          >
            <h5>Account</h5>
            <div>
              <button class="edit-profile">
                <img src="{{ asset('icons/edit.png') }}" />Edit
              </button>
              <button class="save-profile">
                <img src="{{ asset('icons/save.png') }}" />Save Changes
              </button>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-6">
              <label>Password</label>
              <input type="password" class="form-control" value="password123"  disabled/>
            </div>
            <div class="col-6">
              <label>Confirm Password</label>
              <input type="password" class="form-control" value="password123"  disabled/>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer -->
    <div class="footer">
      <p>© 2023 All Rights Reserved by DeLunas Dental Centre</p>
    </div>
  </div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/doctor.css') }}" />
@endsection
