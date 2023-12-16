@extends('portals.admins.layouts.master', ['isHomePageActive' => 'active' , 'title' => 'Admin Homepage Settings'])

@section('content')

<!-- Main Content -->
  <div class="content-body">
    <!-- BANNER SETTINGS -->
    <div class="custom-section my-0">
      <div class="header-title">
        <div>
          <h5>Homepage Banner Settings</h5>
          <p>Customize the content of your Homepage's Banner here.</p>
        </div>
      </div>
      <div class="cms-wrapper">
        <div class="mt-4 w-100">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button
                  class="nav-link active"
                  data-toggle="tab"
                  data-target="#slider1-tab"
                  type="button"
                  role="tab"
                  aria-selected="true"
                >
                  Banner Slider 1
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button
                  class="nav-link"
                  data-toggle="tab"
                  data-target="#slider2-tab"
                  type="button"
                  role="tab"
                  aria-selected="false"
                >
                  Banner Slider 2
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button
                  class="nav-link"
                  data-toggle="tab"
                  data-target="#slider3-tab"
                  type="button"
                  role="tab"
                  aria-selected="false"
                >
                  Banner Slider 3
                </button>
              </li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane fade show active" id="slider1-tab" role="tabpanel">
                <form method="POST" action="{{ route('admin.homepage.home.save') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $homebanners[0]->id ?? '' }}">
                    <div class="row">
                    <div class="col-5">
                        <label>Image for Slider 1:</label>
                        <input type="file" id="home1" name="image" class="form-control" />
                        <div class="img-wrapper">
                        @if($homebanners)
                            <img id="viewHome1" src="{{ asset('/'. ($homebanners[0]->image_url ?? 'img/hero-banner1.png') ) }}" style="width: 100%; height:460px" alt="image description">
                        @else
                            <img id="viewHome1" src="" />
                        @endif
                        </div>
                    </div>
                    <div class="col-7">
                        <div>
                        <label>Header:</label>
                        <input type="text" name="header" required class="form-control" value="{{ $homebanners[0]->header ?? '' }}"/>
                        </div>
                        <div class="mt-3">
                        <label>Text Description:</label>
                        <textarea name="description" class="mytextarea"> {{ $homebanners[0]->description ?? '' }}</textarea>
                        </div>
                    </div>
                    </div>
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn save-settings">
                        <img src="{{ asset('icons/save.png') }}" />Save Changes
                      </button>
                    </div>
                </form>
              </div>
              <div class="tab-pane fade" id="slider2-tab" role="tabpanel">
                <form method="POST" action="{{ route('admin.homepage.home.save') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $homebanners[1]->id ?? '' }}">
                    <div class="row">
                    <div class="col-5">
                        <label>Image for Slider 1:</label>
                        <input type="file" id="home2" name="image" class="form-control" />

                        <div class="img-wrapper">
                        @if($homebanners)
                            <img id="viewHome2" src="{{ asset('/'. ($homebanners[1]->image_url ?? 'img/hero-banner1.png') ) }}" style="width: 100%; height:460px" alt="image description">
                        @else
                            <img id="viewHome2" src="" />
                        @endif
                        </div>
                    </div>
                    <div class="col-7">
                        <div>
                        <label>Header:</label>
                        <input type="text" name="header" required class="form-control" value="{{ $homebanners[1]->header ?? '' }}"/>
                        </div>
                        <div class="mt-3">
                        <label>Text Description:</label>
                        <textarea name="description" class="mytextarea"> {{ $homebanners[1]->description ?? '' }}</textarea>
                        </div>
                    </div>
                    </div>
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn save-settings">
                        <img src="{{ asset('icons/save.png') }}" />Save Changes
                      </button>
                    </div>
                </form>
              </div>
              <div class="tab-pane fade" id="slider3-tab" role="tabpanel">
                <form method="POST" action="{{ route('admin.homepage.home.save') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $homebanners[2]->id ?? '' }}">
                    <div class="row">
                    <div class="col-5">
                        <label>Image for Slider 1:</label>
                        <input type="file" id="home3" name="image" class="form-control" />

                        <div class="img-wrapper">
                        @if($homebanners)
                            <img  id="viewHome3" src="{{ asset('/'. ($homebanners[2]->image_url ?? 'img/hero-banner1.png') ) }}" style="width: 100%; height:460px" alt="image description">
                        @else
                            <img id="viewHome3" src="" />
                        @endif
                        </div>
                    </div>
                    <div class="col-7">
                        <div>
                        <label>Header:</label>
                        <input type="text" name="header" required class="form-control" value="{{ $homebanners[2]->header ?? '' }}"/>
                        </div>
                        <div class="mt-3">
                        <label>Text Description:</label>
                        <textarea name="description" class="mytextarea"> {{ $homebanners[2]->description ?? '' }}</textarea>
                        </div>
                    </div>
                    </div>
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn save-settings">
                        <img src="{{ asset('icons/save.png') }}" />Save Changes
                      </button>
                    </div>
                </form>
              </div>
            </div>
        </div>
      </div>
    </div>

    <div class="custom-section mt-4">
      <div class="header-title">
        <div>
          <h5>Vision & Mission Settings</h5>
          <p>Customize the content of your Vision & Mission section here.</p>
        </div>
      </div>
      <div class="cms-wrapper mt-4">
        <div class="row mt-5">
          <div class="col-12 col-md-5">
            <form method="POST" action="{{ route('admin.homepage.mv.upload') }}"  enctype="multipart/form-data">
                @csrf
              <input type="hidden" name="id" value="{{ $mv->id ?? '' }}">
              <label>Upload :</label>
              <input id="home4" name="image" type="file" class="form-control" />
              <div class="img-wrapper">
                @if($mv)
                    <img id="viewHome4" src="{{ asset($mv->image_url) }}" style="width: 100%; height:460px" alt="image description">
                @else
                    <img id="viewHome4" src=""  style="width: 100%; height:460px" />
                @endif
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn save-settings">
                  <img src="{{ asset('icons/save.png') }}" />Upload
                </button>
              </div>
            </form>
          </div>
          <div class="col-12 col-md-7">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item w-50" role="presentation">
                <button
                  class="nav-link active"
                  data-toggle="tab"
                  data-target="#vision-tab"
                  type="button"
                  role="tab"
                  aria-selected="true"
                >
                  Vision
                </button>
              </li>
              <li class="nav-item w-50" role="presentation">
                <button
                  class="nav-link"
                  data-toggle="tab"
                  data-target="#mission-tab"
                  type="button"
                  role="tab"
                  aria-selected="false"
                >
                  Mission
                </button>
              </li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane fade show active" id="vision-tab" role="tabpanel">
                <form action="{{ route('admin.homepage.vision') }}" method="POST">
                    @csrf
                  <input type="hidden" name="id" value="{{ $mv->id ?? '' }}">
                  <div>
                    <label>Header:</label>
                    <input type="text" name="vision_header" required class="form-control" value="{{ $mv->vision_header ?? 'Vision' }}" />
                    </div>
                    <div class="mt-3">
                    <label>Text Description:</label>
                    <textarea name="vision_description" class="mytextarea">{{ $mv->vision_description ?? '' }}</textarea>
                  </div>
                  <div class="d-flex justify-content-end">
                      <button type="submit" class="btn save-settings">
                        <img src="{{ asset('icons/save.png') }}" />Save Changes
                      </button>
                    </div>
                </form>
              </div>
              <div class="tab-pane fade" id="mission-tab" role="tabpanel">
                <form action="{{ route('admin.homepage.mission') }}" method="POST">
                    @csrf
                  <input type="hidden" name="id" value="{{ $mv->id ?? '' }}">
                  <div>
                    <label>Header:</label>
                    <input type="text" name="mission_header" required class="form-control" value="{{ $mv->mission_header ?? 'Mission' }}" />
                    </div>
                    <div class="mt-3">
                    <label>Text Description:</label>
                    <textarea name="mission_description" class="mytextarea">{{ $mv->mission_description ?? '' }}</textarea>
                  </div>
                  <div class="d-flex justify-content-end">
                      <button type="submit" class="btn save-settings">
                        <img src="{{ asset('icons/save.png') }}" />Save Changes
                      </button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="custom-section mt-4">
        <div class="header-title">
          <div>
            <h5>About Us Settings</h5>
            <p>Customize the content of your About Us section here.</p>
          </div>
        </div>
        <div class="cms-wrapper mt-4">
          <div class="row mt-5">
            <div class="col-12 col-md-5">
              <form method="POST" action="{{ route('admin.homepage.about-us') }}"  enctype="multipart/form-data">
                  @csrf
                <input type="hidden" name="id" value="{{ $aboutus->id ?? '' }}">
                <label>Upload :</label>
                <input id="home5" name="image" type="file" class="form-control" />
                <div class="img-wrapper">
                  @if($aboutus)
                      <img id="viewHome5" src="{{ asset($aboutus->image_url) }}" style="width: 100%; height:460px" alt="image description">
                  @else
                      <img id="viewHome5" src="" style="width: 100%; height:460px" />
                  @endif
                </div>
                <div class="d-flex justify-content-end">
                  <button type="submit" class="btn save-settings">
                    <img src="{{ asset('icons/save.png') }}" />Upload
                  </button>
                </div>
            </div>
            <div class="col-12 col-md-7">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item w-50" role="presentation">
                  <button
                    class="nav-link active"
                    data-toggle="tab"
                    data-target="#about-us-tab"
                    type="button"
                    role="tab"
                    aria-selected="true"
                  >
                    About Us
                  </button>
                </li>
              </ul>

              <div class="tab-content">
                <div class="tab-pane fade show active" id="about-us-tab" role="tabpanel">
                    <div>
                      <label>Header:</label>
                      <input type="text" name="header" required class="form-control" value="{{ $aboutus->header ?? 'About Us' }}" />
                      </div>
                      <div class="mt-3">
                      <label>Text Description:</label>
                      <textarea name="description" class="mytextarea">{{ $aboutus->description ?? '' }}</textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn save-settings">
                          <img src="{{ asset('icons/save.png') }}" />Save Changes
                        </button>
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    <!-- SERVICES SETTINGS -->
<div class="custom-section mt-4">
  <div class="header-title">
    <div>
      <h5>Services Settings</h5>
      <p>Customize the content of your Services' section here.</p>
    </div>
  </div>
  <div class="cms-wrapper">
    <div class="d-flex justify-content-end mb-4">
      <button class="add-services-btn" data-toggle="modal" data-target="#addServicesModal"><img
          src="{{ asset('icons/plus.png') }}" />Add Services</button>
    </div>

    <div class="tbl-overflow">
      <table class="table table-striped mt-0">
        <thead>
          <tr>
            <th scope="col">Title</th>
            <th scope="col" class="w-50">Description</th>
            {{-- <th scope="col">Image</th> --}}
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($services as $service)
          <tr>
            <td>{{ $service->title }}</td>
            <td>
              {!! htmlspecialchars_decode(strip_tags($service->description)) !!}
            </td>
            {{-- <td>[file_name_image.png]</td> --}}
            <td>
              <button data-service="{{ json_encode($service) }}" class="view-item-btn editServiceModalBtn"
                data-toggle="modal" data-target="#viewServicesModal">
                <img src="{{ asset('icons/eye.png') }}" />
              </button>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center"> No Services found </td>
          </tr>
          @endforelse

        </tbody>
      </table>

      {{ $services->links() }}
    </div>
  </div>
</div>

    <!-- CONTACT US SETTINGS -->
    <div class="custom-section mt-4">
        <div class="header-title">
          <div>
            <h5>Contact Us Settings</h5>
          </div>
        </div>
        <div class="cms-wrapper">

          <div class="tbl-overflow">
            <table class="table table-striped mt-0">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col" class="w-50">Email</th>
                  {{-- <th scope="col">Image</th> --}}
                  <th scope="col">Message</th>
                  <th scope="col"> Date Received </th>
                </tr>
              </thead>
              <tbody>
                @forelse ($contactus as $cu)
                <tr>
                  <td>{{ $cu->name }}</td>
                  <td>{{ $cu->email }}</td>
                  <td>
                    {!! htmlspecialchars_decode(strip_tags($cu->message)) !!}
                  </td>
                  <td>
                    {{ $cu->created_at }}
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center"> No Contact found </td>
                </tr>
                @endforelse

              </tbody>
            </table>

            {{ $contactus->links() }}
          </div>
        </div>
      </div>
<!-- Modal for Viewing/Editing Services -->
<div class="modal fade" id="viewServicesModal" tabindex="-1" role="dialog" aria-hidden="true">
  <input type="hidden" id="editServiceId">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Services</h5>
        <button type="button" class="btn close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          <div class="img-wrapper">
            <img id="viewEditImage" src="" />
          </div>
          <label>Upload Photo:</label>
          <input id="editImage" type="file" class="form-control" required />
        </div>
        <div class="mt-3">
          <label>Title:</label>
          <input id="editTitle" type="text" class="form-control" value="Tooth Extraction" required />
        </div>
        <div class="mt-3">
          <label>Description:</label>
          <textarea id="editDescription" class="form-control" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button id="editServiceBtn" class="submit-btn w-100"><img src="{{ asset('icons/save.png') }}" />Save</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal for Adding Services -->
<div class="modal fade" id="addServicesModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Service to Offer</h5>
        <button type="button" class="btn close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          <div class="img-wrapper">
            <img id="image_input1" src="" />
          </div>
          <label>Upload Photo:</label>
          <input type="file" id="image_input" class="form-control" required />
        </div>
        <div class="mt-3">
          <label>Title:</label>
          <input id="title" type="text" class="form-control" required />
        </div>
        <div class="mt-3">
          <label>Description:</label>
          <textarea id="description" class="form-control" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button id="addServicesBtn" class="submit-btn w-100"><img src="{{ asset('icons/save.png') }}" />Save</button>
      </div>
    </div>
  </div>
</div>

{{-- <!-- Modal for Viewing/Editing Services -->
<div class="modal fade" id="viewServicesModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Service to Offer</h5>
        <button type="button" class="btn close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          <div class="img-wrapper">
            <img id="image_input1" src="" />
          </div>
          <label>Upload Photo:</label>
          <input type="file" id="image_input" class="form-control" required />
        </div>
        <div class="mt-3">
          <label>Title:</label>
          <input id="title" type="text" class="form-control" required />
        </div>
        <div class="mt-3">
          <label>Description:</label>
          <textarea id="editdescription" class="form-control" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button id="addServicesBtn" class="submit-btn w-100"><img src="{{ asset('icons/save.png') }}" />Save</button>
      </div>
    </div>
  </div>
</div> --}}
@endsection

@section('js')
{{-- <!-- CDN for TinyMCE -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> --}}
{{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> --}}
<script src="https://cdn.tiny.cloud/1/rek62knz6nujhcisvnrx8dbki5o3ospggljrcai1m0k83u9o/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script src="{{ asset('js/home-page-settings.js') }}"></script>
@endsection
