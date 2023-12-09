<div class="sidebar">
    <img class="logo" src="{{ asset('icons/sidenav-logo.png') }}" />
    <div class="links">
      <a href="{{ route('patient.dashboard')}}" class="{{ $isDashboardActive ?? '' }}"
        ><img src="{{ asset('icons/dashboard.png') }}" /> Dashboard</a
      >
      <a href="{{ route('patient.appointment') }}" class="{{ $isMyAppointmentsActive ?? '' }}"
        ><img src="{{ asset('icons/calendar.png') }}" /> My Appointments</a
      >
      <a href="{{ route('patient.my-profile') }}" class="{{ $isMyProfileActive ?? '' }}"
        ><img src="{{ asset('icons/accounts.png') }}" /> Profile</a
      >
      <a href="{{ route('index') }}"
        ><img src="{{ asset('icons/homepage.png') }}" /> Go to Homepage</a
      >
    </div>
    <a href="{{ route('auth.logout') }}" class="logout-btn"
      ><img src="{{ asset('icons/logout.png') }}" />Logout</a
    >
  </div>
