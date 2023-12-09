<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $title }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <!-- Linksf or Bootstrap Local -->
  <link rel="icon" type="image/png" href="{{ asset('icons/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css' )}}" />
  <link rel="stylesheet" href="{{ asset('/css/global.css' )}}" />
  <link rel="stylesheet" href="{{ asset('css/main.css' )}}" />
  <link rel="stylesheet" href="{{ asset('css/admin.css' )}}" />
  <link rel="stylesheet" href="{{ asset('css/media-queries.css' )}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/alertify.min.css') }}"/>
  @yield('css')
  <!-- Links for Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;700&family=Plus+Jakarta+Sans:wght@300;400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
</head>

<body>
  <main>
    @include('portals.patients.layouts.sidebar')

    <div class="content">
      <!-- Top Navigations -->
      @include('portals.patients.layouts.navbar');

      <!-- Main Content -->
      @yield('content')
    </div>
  </main>

  <!-- Notification Box -->
  <div id="notificationBox" class="notification-box">
    <h5 class="mb-3">Notifications</h5>
    @forelse (auth()->user()->notifications as $notification)
    <div class="notif-item border-bottom py-3">
        <p class="mb-0">{{ $notification->description }}</p>
        <br>
        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
    </div>
    @empty
    <div class="notif-item">
        <p>No notifications found</p>
    </div>
    @endforelse

    {{-- <div class="notif-item">
      <div class="notif-img-wrapper">
        <img src="" />
      </div>
      <p>
        <span>Tony Stark</span>cancelled an appointment with <span>Dra. Zenaida Delunas for</span><span>Dental Filling/Pasta</span> on<span>October 22, 2023</span>.
        <i>Reason: "Sorry Doc, emergency. I have to cancel our appointment."</i>
      </p>
    </div>
    <div class="notif-item">
      <div class="notif-img-wrapper">
        <img src="" />
      </div>
      <p><span>John Doe</span>requesting to have an appointment with <span>Dra. Zenaida Delunas</span> for<span>Dental Braces</span>on<span>October 22, 2023 - 11:30am.</span> Check your <a href="../admin/patient-appointment-logs.html">Patient Logs</a> now.
      </p>
    </div>
    <div class="notif-item">
      <div class="notif-img-wrapper">
        <img src="" />
      </div>
      <p>
        <span>Jimi Hendrix</span> requesting to reschedule the <span>Dental Filling/Pasta</span>appointment for<span>October 22, 2023</span>to<span>October 22, 2023</span>
      </p>
      <div class="d-flex justify-content-center align-items-center gap-1 mt-2">
        <button class="accept-resched">Accept</button>
        <button class="deny-resched">Deny</button>
      </div>
    </div>
    <div class="notif-item">
        <div class="notif-img-wrapper">
          <img src="" />
        </div>
        <p>
          <span>Jimi Hendrix</span> requesting to reschedule the <span>Dental Filling/Pasta</span>appointment for<span>October 22, 2023</span>to<span>October 22, 2023</span>
        </p>
        <div class="d-flex justify-content-center align-items-center gap-1 mt-2">
          <button class="accept-resched">Accept</button>
          <button class="deny-resched">Deny</button>
        </div>
    </div> --}}
    {{-- <div class="notif-item">
    <div class="notif-img-wrapper">
        <img src="" />
    </div>
    <p>
        <span>Jimi Hendrix</span> requesting to reschedule the <span>Dental Filling/Pasta</span>appointment for<span>October 22, 2023</span>to<span>October 22, 2023</span>
    </p>
    <div class="d-flex justify-content-center align-items-center gap-1 mt-2">
        <button class="accept-resched">Accept</button>
        <button class="deny-resched">Deny</button>
    </div>
    </div> --}}

  </div>

  <!-- Loading Overlay -->
  <div id="loading-overlay">
    <div class="loader"></div>
  </div>

  <!-- Scripts  -->
  <script src="{{ asset('js/loading-overlay.js') }}"></script>
  <script src="{{ asset('js/admin.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  @yield('js')
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('js/alertify.js') }}"></script>
</body>

</html>
