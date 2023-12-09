<div class="sidebar">
    <img class="logo" src="{{ asset('icons/sidenav-logo.png') }}" />
    <div class="links">
      <a href="{{ route('admin.dashboard')}}" class="{{ $isDashboardActive ?? '' }}"
        ><img src="{{ asset('icons/dashboard.png') }}" /> Dashboard</a
      >
      <a href="{{ route('admin.doctor.appointment') }}" class="{{ $isDoctorAppActive ?? '' }}"
        ><img src="{{ asset('icons/doctor-logs.png') }}" /> Doctor Logs</a
      >
      {{-- <a href="{{ route('admin.patient.appointment') }}" class="{{ $isAppointmentActive ?? '' }}"
        ><img src="{{ asset('/icons/patient-logs.png') }}" /> Patient Logs</a
      > --}}
      <a href="{{ route('index') }}"> <img src="{{ asset('icons/homepage.png') }}" /> Go to Homepage</a>
      <a href="{{ route('admin.homepage') }}" class="{{ $isHomePageActive ?? '' }}"
        ><img src="{{ asset('icons/settings.png') }}"  /> Homepage Setttings</a
      >
      <a href="{{ route('admin.accounts') }}" class="{{ $isAccountActive ?? '' }}"
        ><img src="{{ asset('icons/accounts.png') }}" /> Accounts</a
      >
    </div>

    <a href="{{ route('auth.logout') }}" class="logout-btn"
      ><img src="{{ asset('icons/logout.png') }}" />Logout</a
    >
  </div>
