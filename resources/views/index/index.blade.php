<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>De Lunas Dental Centre</title>

    <!-- Import Links -->
    <link rel="icon" type="image/png" href="{{ asset('/icons/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('/css/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/media-queries.css') }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Links for Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;700&family=Plus+Jakarta+Sans:wght@300;400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <!-- Slick slider -->
    <link
      rel="stylesheet"
      type="text/css"
      href="{{ asset('/js/slick-1.8.1/slick/slick.css') }}"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="{{ asset('/js/slick-1.8.1/slick/slick-theme.css') }}"
    />
  </head>
  <body>
    <!-- NAVIGATION BAR-->
    <header class="header homepage-header">
      <div class="container">
        <a href="#"
          ><img
            class="logo"
            src="{{ asset('/images/delunas-logo2.png') }}"
            alt="nav-logo"
        /></a>
        <nav id="homepageMenu" class="navbar homepage-nav">
          <ul class="navbar-list">
            <li>
              <a href="#" class="navbar-link" data-nav-link="">Home</a>
            </li>
            <li>
              <a href="#about" class="navbar-link" data-nav-link="">About Us</a>
            </li>
            <li>
              <a href="#service" class="navbar-link" data-nav-link=""
                >Services</a
              >
            </li>
            <li>
              <a href="#reviews" class="navbar-link" data-nav-link=""
                >Reviews</a
              >
            </li>
            <li>
              <a href="#doctors" class="navbar-link" data-nav-link=""
                >Our Team</a
              >
            </li>
            <li>
              <a href="#contact" class="navbar-link" data-nav-link=""
                >Contact</a
              >
            </li>
            <li>
             @guest
                <a href="{{ route('auth.index') }}" class="book-appointment-btn">Login</a>
             @endguest

            @auth
                @if(auth()->user()->user_type == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="book-appointment-btn">Back to Dashboard</a>
                @elseif(auth()->user()->user_type == 'user')
                    <a href="{{ route('patient.dashboard') }}" class="book-appointment-btn">Back to Dashboard</a>
                @elseif(auth()->user()->user_type == 'doctor')
                    <a href="{{ route('doctor.dashboard') }}" class="book-appointment-btn">Back to Dashboard</a>
                @endif
            @endauth
            </li>
          </ul>
        </nav>
        <button id="homepageMenuBtn" onclick="toggleHomepageMenu()">
          <img id="menuIcon" src="{{ asset('/icons/navbar-menu.png') }}" />
          <img id="closeIcon" src="{{ asset('/icons/navbar-close.png') }}" />
        </button>
      </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="homepage">
      <!-- slider hero section -->
      <section class="hero-section">
        <div class="hero-slider">
         @foreach ($banners as $banner)
            <div class="slider-wrapper">
                <div class="overlay"></div>
                <img src="/storage/{{ $banner->image_url  }}" />
                <div class="slider-caption">
                <h1>{{ $banner->header  }}</h1>
                <p>
                    {!! htmlspecialchars_decode(strip_tags($banner->description)) !!}
                </p>
                </div>
            </div>
        @endforeach
        {{-- <div class="slider-wrapper">
            <div class="overlay"></div>
            <img src="{{ asset('/images/hero-section/slider0.jpg') }}" />
            <div class="slider-caption">
            <h1>Dental Clinic That You Can Trust</h1>
            <p>
                Looking for a trusted dentist? You've made a right place to book
                an appointment. <br />Delunas Dental Centre is here to make your
                smile even better and make sure that the services we provide to
                you is good. We have many different services that can be seen
                below.
            </p>
            </div>
        </div>
        <div class="slider-wrapper">
        <div class="overlay"></div>
        <img src="{{ asset('/images/hero-section/slider0.jpg') }}" />
        <div class="slider-caption">
        <h1>Dental Clinic That You Can Trust</h1>
        <p>
        Looking for a trusted dentist? You've made a right place to book
        an appointment. <br />Delunas Dental Centre is here to make your
        smile even better and make sure that the services we provide to
        you is good. We have many different services that can be seen
        below.
        </p>
        </div>
        </div>
        <div class="slider-wrapper">
        <div class="overlay"></div>
        <img src="{{ asset('/images/hero-section/slider1.jpg') }}" />
        <div class="slider-caption">
            <h1>Discover Our Comprehensive Dental Services</h1>
            <p>
            Transforming Smiles with Expert Care and Cutting-Edge Dentistry,
            Where Your Comfort is Our Priority. We're here to make every
            visit a pleasant experience, so you can achieve the smile of
            your dreams with confidence.
            </p>
        </div>
        </div>
        <div class="slider-wrapper">
        <div class="overlay"></div>
        <img src="{{ asset('/images/hero-section/slider2.jpg') }}" />
        <div class="slider-caption">
            <h1>Advanced Dental Equipment</h1>
            <p>
            Enhancing Your Dental Care with Advanced Technology. Our
            practice is equipped with the latest advancements in dental
            equipment, ensuring precision, comfort, and efficiency in every
            procedure. Discover how our equipment enhances your oral health
            journey.
            </p>
        </div>
        </div>
        </div> --}}
      </section>
      <!-- ABOUT US -->
      <section id="about" class="about-section">
        <div class="row m-0 h-100">
          <div class="col-6">
            <img src="/storage/{{ asset($aboutus->image_url) }}" />
          </div>
          <div class="col-6 d-flex flex-column justify-content-center">
            <h5>Who We Are</h5>
            <h1>{{ $aboutus->header ?? '' }}</h1>
            <p>
                {!! htmlspecialchars_decode(strip_tags($aboutus->description)) !!}
            </p>
          </div>
        </div>
      </section>
      <!-- VISION MISSION SECTION -->
      <section class="vision-mission">
        <div class="vision-mission-left">
          <div>
            <h1>{{ $mv->vision_header ?? 'Vision' }}</h1>
            <p>
                {{ $mv->vision_description ?? '
              To create an extraordinary dental practice that is recognized as
              the best in the community for providing amazing quality and
              service to both children and adults in a caring family
              environment. ' }}
            </p>
          </div>

          <div>
            <h1>{{ $mv->mission_header ?? '' }}</h1>
            <p>
                {{ $mv->mission_description ?? '
              To help every person attain optimum dental health through the best
              education and state-of-the-art, comfortable dentistry.' }}
            </p>
          </div>
        </div>
        <div class="vision-mission-right"></div>
      </section>
      <!-- SERVICES SECTION -->
      <section id="service" class="services">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <h5 class="text-center">Our Services</h5>
              <h2 class="text-center">What services we offer</h2>
              <p class="text-center">
                Explore a wide range of dental solutions designed to meet your
                unique needs. From preventive care to cosmetic treatments and
                restorative procedures, our comprehensive services ensure a
                healthy and beautiful smile for you and your family.
              </p>
            </div>
          </div>
          <div class="services-row">
            @forelse ($services as  $service)
            <div class="services-card">
                <div class="image-wrapper">
                  <img src="/storage/{{ asset($service->image_url) }}" />
                  <div class="overlay"></div>
                </div>
                <div>
                  <h3>{{ $service->title }}</h3>
                  <p>
                    {!! htmlspecialchars_decode(strip_tags($service->description)) !!}
                  </p>

                  @guest
                    <a href="{{ route('patient.appointment',  ['book_now' => true]) }}" class="book-now">Book Now</a>
                  @endguest

                    @auth
                        @if(auth()->user()->user_type == 'user')
                            <a href="{{ route('patient.appointment') }}" class="book-now">Book Now</a>
                        @endif
                    @endauth
                </div>
              </div>
            @empty

            @endforelse
            {{-- <div class="services-card">
              <div class="image-wrapper">
                <img src="{{ asset('/images/services/complete denture2.jpg') }}" />
                <div class="overlay"></div>
              </div>
              <div>
                <h3>Complete Denture</h3>
                <p>
                  Takes up the whole mouth rather than just a part of it. It's a
                  removable device that can be used to replace missing teeth and
                  is used by someone who has lost all of their teeth.
                </p>
                <a href="#" class="book-now">Book Now</a>
              </div>
            </div>
            <div class="services-card">
              <div class="image-wrapper">
                <img
                  src="{{ asset('/images/services/removable-partial-dentures.jpg') }}"
                />
                <div class="overlay"></div>
              </div>
              <div>
                <h3>Removable Partial Denture</h3>
                <p>
                  A removable partial denture (RPD) is a dental prosthesis that
                  is used to replace multiple missing teeth.
                </p>
                <a href="#" class="book-now">Book Now</a>
              </div>
            </div>
            <div class="services-card">
              <div class="image-wrapper">
                <img src="{{ asset('/images/services/flexible denture.jpg') }}" />
                <div class="overlay"></div>
              </div>
              <div>
                <h3>Flexible Denture</h3>
                <p>
                  Between the acrylic base, metal support structure, and
                  porcelain or resin teeth, a denture is quite rigid, often
                  causing sores and irritation in the mouth.
                </p>
                <a href="#" class="book-now">Book Now</a>
              </div>
            </div>
            <div class="services-card">
              <div class="image-wrapper">
                <img src="{{ asset('/images/services/dental braces.png') }}" />
                <div class="overlay"></div>
              </div>
              <div>
                <h3>Dental Braces</h3>
                <p>
                  Braces can correct a wide range of dental issues, including
                  crooked, gapped, rotated or crowded teeth.
                </p>
                <a href="#" class="book-now">Book Now</a>
              </div>
            </div>
            <div class="services-card">
              <div class="image-wrapper">
                <img src="{{ asset('/images/services/Tooth-Extractions.jpg') }}" />
                <div class="overlay"></div>
              </div>
              <div>
                <h3>Tooth Extraction</h3>
                <p>
                  A tooth extraction is a dental procedure during which your
                  tooth is completely removed from its socket.
                </p>
                <a href="#" class="book-now">Book Now</a>
              </div>
            </div>
            <div class="services-card">
              <div class="image-wrapper">
                <img src="{{ asset('/images/services/oral prophylaxis.jpg') }}" />
                <div class="overlay"></div>
              </div>
              <div>
                <h3>Oral Prophylaxis</h3>
                <p>
                  Oral prophylaxis is a thorough examination of your oral health
                  combined with a scale and clean.
                </p>
                <a href="#" class="book-now">Book Now</a>
              </div>
            </div>
            <div class="services-card">
              <div class="image-wrapper">
                <img src="{{ asset('/images/services/dental filling.jpg') }}" />
                <div class="overlay"></div>
              </div>
              <div>
                <h3>Dental Filling/Pasta</h3>
                <p>
                  Tooth Filling or what is commonly known as Dental Pasta is
                  performed to restore proper function and structure.
                </p>
                <a href="#" class="book-now">Book Now</a>
              </div>
            </div>
            <div class="services-card">
              <div class="image-wrapper">
                <img src="{{ asset('/images/services/dental veneers.jpg') }}" />
                <div class="overlay"></div>
              </div>
              <div>
                <h3>Dental Veneers</h3>
                <p>
                  Dental veneers are custom-made shells that fit over the front
                  surfaces of your teeth.
                </p>
                <a href="#" class="book-now">Book Now</a>
              </div>
            </div>
            <div class="services-card">
              <div class="image-wrapper">
                <img src="{{ asset('/images/services/dental bridges.jpg') }}" />
                <div class="overlay"></div>
              </div>
              <div>
                <h3>Dental Bridges</h3>
                <p>
                  Dental bridges replace missing teeth. They can restore chewing
                  function, enhance your appearance and improve your oral
                  health.
                </p>
                <a href="#" class="book-now">Book Now</a>
              </div>
            </div> --}}
          </div>
        </div>
      </section>
      <!-- REVIEWS -->
      <div id="reviews" class="reviews-section">
        <div class="reviews-left"></div>
        <div class="reviews-right">
          <h1>Discover What Our Valued Clients Have to Say</h1>
          <div class="reviews-list">
            @forelse ($feedbacks as $feedback)
                <div class="reviews-card">
                    <img src="{{ asset('/images/quote.png') }}" />
                    <p>
                     {{ $feedback->message }}
                    </p>
                    <h5>- {{ $feedback->user->full_name ?? '' }}</h5>
                </div>
            @empty
            <div class="reviews-card">
                <img src="{{ asset('/images/quote.png') }}" />
                <p>
                    Amazing dental service! Delunas Dental Centre provides top-notch
                    care with a friendly staff. My teeth have never felt better, and
                    I couldn't be happier with the results..
                  </p>
                  <h5>- John Smith</h5>
            </div>
            @endforelse
          </div>
        </div>
      </div>
      <!-- DOCTORS -->
      <section id="doctors" class="doctors-section">
        <div class="container">
          <div class="row m-0 h-100">
            <div class="col-12">
              <h5 class="text-center">Our Team</h5>
              <h1 class="text-center">Professional Members</h1>
              <div class="doctor-list">
                <div class="doctor-card">
                  <img src="{{ asset('/images/doctor.png') }}" alt="doctor-2" />
                  <div class="d-flex flex-column text-left">
                    <h5 class="m-0">Dra. Zenaida Tutanes De Lunas</h5>
                    <p>Dental Specialist</p>
                    {{-- <div class="doc-socials">
                      <a href="#"><img src="{{ asset('/icons/fb-small.png') }}" /></a>
                      <a href="#"><img src="{{ asset('/icons/ig-small.png') }}" /></a>
                      <a href="#"><img src="{{ asset('/icons/twt-small.png') }}" /></a>
                    </div> --}}
                  </div>
                </div>
                <div class="doctor-card">
                  <img src="{{ asset('/images/staff.png') }}" alt="doctor-2" />
                  <div class="d-flex flex-column text-left">
                    <h5 class="m-0">Hiyas Pamila Geralde</h5>
                    <p>Assistant</p>
                    {{-- <div class="doc-socials">
                      <a href="#"><img src="{{ asset('/icons/fb-small.png') }}" /></a>
                      <a href="#"><img src="{{ asset('/icons/ig-small.png') }}" /></a>
                      <a href="#"><img src="{{ asset('/icons/twt-small.png') }}" /></a>
                    </div> --}}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- CONTACT US -->
      <section id="contact" class="contact-section">
        <div class="container h-100">
          <div class="row m-0 h-100">
            <div class="col-6 d-flex flex-column justify-content-center">
              <h5>Contact Us</h5>
              <h1>Get in touch. Book your first appointment with us</h1>
              <p>
                Contact us today and our friendly team will be happy to assist
                you.
              </p>
            </div>
            <div class="col-6 px-5">

            @if (session('success_contact'))
              <div class="alert alert-success">{{{   session('success_contact')   }}}</div>
            @endif

              <form action="{{ route('index.contact_us') }}" method="POST">
                @csrf
                <div class="row">
                  <div class="col-12 mb-3">
                    <div class="form-group">
                      <label for="fullName">Name</label>
                      <input
                        type="text"
                        class="form-control"
                        id="fullName"
                        name="name"
                        placeholder="Full Name"
                      />
                    </div>
                    @if ($errors->has('name'))
                        <span class="error-msg">{{ $errors->first('name') }}</span>
                    @endif
                  </div>
                  <div class="col-12 mb-3">
                    <div class="form-group">
                      <label for="emailAddress">Email Address</label>
                      <input
                        type="email"
                        class="form-control"
                        id="emailAddress"
                        name="email"
                        placeholder="example@email.com"
                      />
                    </div>

                    @if ($errors->has('email'))
                        <span class="error-msg">{{ $errors->first('email') }}</span>
                    @endif
                  </div>
                  <div class="col-12 mb-3">
                    <div class="form-group">
                      <label for="phoneNo">Phone Number</label>
                      <input
                        type="text"
                        class="form-control"
                        id="phoneNo"
                        name="phone_number"
                        placeholder="+639 912 345 6789"
                      />
                    </div>
                    @if ($errors->has('phone_number'))
                        <span class="error-msg">{{ $errors->first('phone_number') }}</span>
                    @endif
                  </div>
                  <div class="col-12 mb-3">
                    <div class="form-group">
                      <label for="serviceType">Service</label>
                      <input
                        type="text"
                        class="form-control"
                        id="serviceType"
                        name="service"
                        placeholder="Type of Service to Inquire"
                      />
                    </div>
                    @if ($errors->has('service'))
                        <span class="error-msg">{{ $errors->first('service') }}</span>
                    @endif
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="message">Message</label>
                      <textarea
                        class="form-control"
                        placeholder="Write your message here..."
                        name="message"
                        id="message"
                      ></textarea>
                    </div>
                    @if ($errors->has('message'))
                        <span class="error-msg">{{ $errors->first('message') }}</span>
                    @endif
                  </div>
                </div>
                <button type="submit" class="btn submit-form-btn mt-4">
                  Submit
                </button>
              </form>
            </div>
          </div>
        </div>
      </section>

      <!-- Chatbox -->
      {{-- <button class="open-chatbox" onclick="toggleChatbox()"><img src="{{ asset('/icons/chatbox.png') }}" /></button> --}}

      {{-- <div id="chatbox" class="animate__animated animate__fadeInUp animate__faster">
        <div class="header">
          <div class="logo">
            <img src="{{ asset('/icons/footer-tooth.png') }}" />
            <div class="dot"></div>
          </div>
          <div class="d-flex flex-column justify-content-center gap-2">
            <h5>Chatbot<h5>
            <p>Online</p>
          </div>

          <button class="close-chatbox" onclick="toggleChatbox()"><img src="{{ asset('/icons/close.png') }}" /></button>
        </div>

        <div class="body">
          <div class="message">Hi there, great to see you!</div>
          <div class="message">What information are you looking for? Please use the navigation below to start.</div>

          <div class="my-2 d-flex flex-column gap-2">
            <a href="" class="topics">Dynamic Topic 1</a>
            <a href=""  class="topics">Dynamic Topic 2</a>
            <a href=""  class="topics">Dynamic Topic 3</a>
          </div>
        </div>

        <div class="footer">
          <p>Powered by DeLunas Dental Clinic</p>
        </div>
      </div> --}}
    </main>

    <!-- FOOTER SECTION -->
    <footer>
      <div class="row pb-5">
        <div class="col-md-5">
          <img src="{{ asset('/images/delunas-logo2.png') }}" alt="nav-logo" />
          <div class="px-4">
            <p>3rd floor Starmall Corner EDSA Shaw blvd. Mandaluyong City</p>
            <p>Monday - Saturday: 10AM - 6PM</p>
            <p>(046) 123-45678 | delunasdentalclinic@email.com</p>
          </div>
        </div>
        <div class="col-md-2">
          <h5>Pages</h5>
          <div class="d-flex flex-column">
            <a href="#">Home</a>
            <a href="#service">Services</a>
            <a href="#about">About Us</a>
            <a href="#reviews">Reviews</a>
            <a href="#contact">Contact</a>
            <a href="#doctors">Doctors</a>
          </div>
        </div>
        <div class="col-md-5">
          <h5>Services</h5>
          <div class="d-flex flex-row gap-5">
            <div class="d-flex flex-column w-50">
              <a href="#">Root Canal Therapy</a>
              <a href="#">Complete Denture</a>
              <a href="#">Removable Partial Denture</a>
              <a href="#">Flexible Denture</a>
              <a href="#">Dental Braces</a>
            </div>
            <div class="d-flex flex-column w-50">
              <a href="#">Tooth Extraction</a>
              <a href="#">Oral Prophylaxis</a>
              <a href="#">Dental Filling/Pasta</a>
              <a href="#">Dental Veneers</a>
              <a href="#">Dental Bridges</a>
            </div>
          </div>
        </div>
      </div>
      <div class="copyright">
        <p>© 2023 All Rights Reserved by DeLunas Dental Centre</p>
      </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- script for sliders -->
    <script
      type="text/javascript"
      src="./js/slick-1.8.1/slick/slick.min.js"
    ></script>
    <script src="{{ asset('js/main.js') }}"></script>
  </body>
</html>
