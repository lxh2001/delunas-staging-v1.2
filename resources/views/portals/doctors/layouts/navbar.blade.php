<div class="header">
    <div class="d-flex gap-3">
      <button class="menu-btn" onclick="toggleMobileMenu()">
        <img class="icon-menu" src="{{ asset('icons/menu.png') }}" />
        <img class="icon-close" src="{{ asset('icons/navbar-close.png') }}" />
      </button>
      <div>
        <h1>Hello, {{ auth()->user()->firstname }}</h1>
        <p>{{ \Carbon\Carbon::now()->format('F j, Y, l') }}</p>
      </div>
    </div>
    <div class="d-flex gap-1">
        <button id="notificationBtn" onclick="toggleNotification()" class="user-notifications">
            <img src="{{ asset('icons/icon-notif.png') }}" />
            <span class="notif-count" data-count="{{ $countunread }}">{{ $countunread }}</span>
          </button>
      <a href="#" class="user-icon"
        ><img src="{{ asset('icons/icon-user.png') }}"
      /></a>
    </div>
  </div>
