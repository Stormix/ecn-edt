@extends('layouts.app')

@section('title', 'Home')
@section('content')

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="kt-portlet">
        <div class="kt-portlet__body">
          <div class="kt-infobox">
            <div class="kt-infobox__header">
              <h2 class="kt-infobox__title">How it works ?</h2>
            </div>
            <div class="kt-infobox__body">
              <div class="kt-infobox__section">
                <h3 class="kt-infobox__subtitle">Magic 101!</h3>
                <div class="kt-infobox__content">
                  TLDR; Downloads the current months' planning (the .ics file) from OnBoard and inserts it to your GCal.
                  <br>
                  <br>
                  Once the onboard logins are saved, a new extraction job is queued and calls an <a class="kt-link">api</a> to fetch this months planning (uses Selenium to login & download). Once the ics file is retrieved, it uses Google's API to create a new calendar and imports the events listed in the ics file. If the calendar already exists, it clears it and inserts the freshly imported events.
                  This operation is repeated everyday at 12AM (exact time might be diffrent) to sync up your calendar.
                  <br>
                  <b>Next step:</b> The manual syncing is stupid, the api should provide a direct link to the ics file so that can be used directly on GCal or any calendar and have them sync up things.

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6">

      <!--begin::Portlet-->
      <form class="kt-form" action="/store" method="POST">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
              <i class="flaticon-cogwheel-1"></i>
            </span>
            <h3 class="kt-portlet__head-title">
              OnBoard Login Info <small>Stored in plaintext!</small>
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          @if ($message = Session::get('success'))
          <div class="alert alert-success">
            <div class="alert-icon"><i class="flaticon-interface-5"></i></div>
            <div class="alert-text"> {{ $message }}
            </div>
          </div>
          @endif
          @if ($errors->any())
          <div class="alert alert-danger">
            <div class="alert-text">

              <div class="row">
                <strong>Whoops!</strong> There were some problems with your input.
              </div>
              <div class="row">
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
            <div class="alert-close">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="la la-close"></i></span>
              </button>
            </div>
          </div>
          @endif

          <!--begin::Form-->
            @csrf
            @php
            $onboard = Auth::user()->account;
            @endphp
            @if(!$onboard)
            <div class="form-group form-group-last">
              <div class="alert alert-secondary" role="alert">
                <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                <div class="alert-text">
                  Please add your onboard login info.
                </div>
                <div class="alert-close">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="la la-close"></i></span>
                  </button>
                </div>
              </div>
            </div>
            @endif
            <div class="form-group">
              <label>OnBoard Username</label>
              <input name="username" type="text" required autocomplete="off" class="form-control" aria-describedby="" placeholder="OnBoard username" value="{{ $onboard ? $onboard->username : ''}}">
              <span class="form-text text-muted">First name initial + Last name + Registration year (e.g
                John Doe 2018 : <b>jdoe2018</b>) </span>
            </div>
            <div class="form-group">
              <label for="password">OnBoard Password</label>
              <input type="password" required autocomplete="off" class="form-control" id="password" name="password" placeholder="Password" value="{{ $onboard ? $onboard->password : ''}}">
            </div>

            <!--end::Form-->
        </div>
        <div class="kt-portlet__foot">
          <div class="kt-form__actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
          </div>
        </div>
      </div>
    </form>

      <!--end::Portlet-->

    </div>
    <div class="col-lg-6">
      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
              <i class="flaticon-calendar"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-primary">
              Import to Google Calendar
            </h3>
          </div>
          <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
              <a href="#" class="btn btn-brand btn-elevate btn-sm">
                Sync to GCal
              </a>
              <a href="/jobs/add" class="btn btn-outline-brand btn-sm">
                Fetch Planning
              </a>
            </div>
          </div>
        </div>
        <div class="kt-portlet__body">

          @if ($message = Session::get('info'))
          <div class="alert alert-success">
            <div class="alert-icon"><i class="flaticon-interface-5"></i></div>
            <div class="alert-text"> {{ $message }}
            </div>
          </div>
          @endif
          @if ($message = Session::get('error'))
          <div class="alert alert-warning">
                <div class="alert-icon"><i class="flaticon-warning text-black"></i></div>
            <div class="alert-text"> {{ $message }}
            </div>
          </div>
          @endif
          @if(Auth::user()->google_id == NULL)
          <div class="row">
            <div class="col-lg-12 text-center">
              <a href="/login/google" class="btn btn-label-google"><i class="socicon-google"></i>
                Authorize access to Google Calendar</a>&nbsp;
            </div>
          </div>
          @endif
          <br>
          @if(!$onboard)
          <div class="alert alert-secondary" role="alert">
            <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
            <div class="alert-text">Please add your onboard login info.</div>
            <div class="alert-close">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="la la-close"></i></span>
              </button>
            </div>
          </div>
          @elseif(!$onboard->status)
          <div class="alert alert-secondary" role="alert">
            <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
            <div class="alert-text">Click on fetch planning to queue a new job!</div>
            <div class="alert-close">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="la la-close"></i></span>
              </button>
            </div>
          </div>
          @elseif($onboard->status == 1 && Cookie::get('extraction_job'))
            @yield('progress')
            <div class="row">
                <div class="col-lg-12">
                 <progress-component :job_id="{{ Cookie::get('extraction_job') }}"></progress-component>
                </div>
            </div>
          @elseif($onboard->status == 2 && Auth::user()->calendar)
          <div class="row">
            <div class="col-lg-12">
                <calendar-info></calendar-info>
            </div>
          </div>
          @endif

        </div>
      </div>

      <!--end::Portlet-->
      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
              <i class="flaticon-calendar"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-primary">
              Import to Apple Calendar
            </h3>
          </div>
          <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
              <a href="#" class="btn btn-brand btn-elevate btn-sm">
                Coming
              </a>
              <a href="#" class="btn btn-outline-brand btn-sm">
                Soon
              </a>
            </div>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="row">
            <div class="col-lg-12 text-center">
              <a href="#" class="btn btn-label-dark"><i class="socicon-apple"></i> Authorize access to
                Apple Calendar</a>&nbsp;
            </div>
          </div>

          {{-- <div class="row">
                        <div class="col-lg-12">
                            <p>Calendar name: </p>
                            <p>Last sync: </p>
                        </div>
                    </div> --}}
        </div>
      </div>

      <!--end::Portlet-->
    </div>
  </div>

</div>


<!-- end:: Content -->
@endsection
