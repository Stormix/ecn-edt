<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!--begin::Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <!--end::Fonts -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    @yield('header')
    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />

</head>

<!-- begin::Body -->

<body
    class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-topbar kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

    <!-- begin::Page loader -->

    <!-- end::Page Loader -->

    <!-- begin:: Page -->

    <!-- begin:: Header Mobile -->
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            <a href="index.html">
                <img alt="Logo" src="assets/media/logos/logo-2-sm.png" />
            </a>
        </div>
        <div class="kt-header-mobile__toolbar">
            <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                    class="flaticon-more-1"></i></button>
        </div>
    </div>

    <!-- end:: Header Mobile -->
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

                <!-- begin:: Header -->
                <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed " data-ktheader-minimize="on">
                    <div class="kt-header__top">
                        <div class="kt-container ">

                            <!-- begin:: Brand -->
                            <div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
                                <div class="kt-header__brand-logo">
                                    <a href="index.html">
                                        <img alt="Logo" src="assets/media/logos/logoCN_icon.png" height="48px"
                                            class="kt-header__brand-logo-default" />
                                        <img alt="Logo" src="assets/media/logos/logoCN_icon.png" height="48px"
                                            class="kt-header__brand-logo-sticky" />
                                    </a>
                                </div>

                            </div>

                            <!-- end:: Brand -->

                            <!-- begin:: Header Topbar -->
                            <div class="kt-header__topbar">

                                <!--begin: Language bar -->
                                <div class="kt-header__topbar-item kt-header__topbar-item--langs">
                                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown"
                                        data-offset="10px,10px">
                                        <span class="kt-header__topbar-icon">
                                            <img class="" src="assets/media/flags/226-united-states.svg" alt="" />
                                        </span>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim">
                                        <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
                                            <li class="kt-nav__item kt-nav__item--active">
                                                <a href="#" class="kt-nav__link">
                                                    <span class="kt-nav__link-icon"><img
                                                            src="assets/media/flags/226-united-states.svg"
                                                            alt="" /></span>
                                                    <span class="kt-nav__link-text">English</span>
                                                </a>
                                            </li>
                                            <li class="kt-nav__item">
                                                <a href="#" class="kt-nav__link">
                                                    <span class="kt-nav__link-icon"><img
                                                            src="assets/media/flags/195-france.svg" alt="" /></span>
                                                    <span class="kt-nav__link-text">Français</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!--end: Language bar -->

                                <!--begin: User bar -->
                                <div class="kt-header__topbar-item kt-header__topbar-item--user">
                                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown"
                                        data-offset="10px,10px" aria-expanded="false">
                                        <span class="kt-header__topbar-welcome">Hello,</span>
                                        <span class="kt-header__topbar-username">{{ Auth::user()->name }}</span>
                                        @if(Auth::user()->avatar)
                                        <img alt="Pic" src="{{ Auth::user()->avatar }}" />
                                        @else
                                        <span
                                            class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold ">{{Auth::user()->name[0]}}</span>
                                        @endif
                                    </div>
                                    <div
                                        class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">


                                        <!--begin: Navigation -->
                                        <div class="kt-notification">

                                            <div class="kt-notification__custom kt-space-between">
                                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();"
                                                    class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>


                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>

                                        <!--end: Navigation -->
                                    </div>
                                </div>

                                <!--end: User bar -->
                            </div>

                            <!-- end:: Header Topbar -->
                        </div>
                    </div>
                </div>

                <!-- end:: Header -->
                <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch"
                    id="kt_body">
                    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                        <!-- begin:: Content Head -->
                        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                            <div class="kt-container ">
                                <div class="kt-subheader__main">
                                    <h3 class="kt-subheader__title">@yield('title')</h3>
                                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                                    <span class="kt-subheader__desc">{{ config('app.name', 'Laravel') }}</span>
                                    {{-- <a href="#" class="btn btn-label-primary btn-bold btn-icon-h kt-margin-l-10">
											Add New
										</a> --}}
                                </div>
                            </div>
                        </div>

                        <!-- end:: Content Head -->

                        @yield('content')


                    </div>

                    <!-- begin:: Footer -->
                    <div class="kt-footer  kt-footer--extended  kt-grid__item" id="kt_footer">
                        <div class="kt-footer__bottom">
                            <div class="kt-container ">
                                <div class="kt-footer__wrapper">
                                    <div class="kt-footer__logo">
                                        <div class="kt-footer__copyright">
                                            2020&nbsp;&nbsp;&copy;

                                        <a href="https://anasmazouni.dev" target="_blank">
                                            <img alt="Logo" src="https://stormix.co/assets/img/logo/logo.svg"
                                                height="15px">
                                        </a>
                                        . All product names, trademarks and registered trademarks are property of their respective owners.
                                        </div>
                                    </div>
                                    <div class="kt-footer__menu">
                                        <a href="https://anasmazouni.dev" target="_blank">Contact</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- end:: Footer -->
                </div>
            </div>
        </div>

        <!-- end:: Page -->
        <!-- begin::Scrolltop -->
        <div id="kt_scrolltop" class="kt-scrolltop">
            <i class="fa fa-arrow-up"></i>
        </div>

        <!-- end::Scrolltop -->



        <!-- begin::Global Config(global config for global JS sciprts) -->
        <script>
            var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#5d78ff",
						"dark": "#282a3c",
						"light": "#ffffff",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": [
							"#c5cbe3",
							"#a1a8c3",
							"#3d4465",
							"#3e4466"
						],
						"shape": [
							"#f0f3ff",
							"#d9dffa",
							"#afb4d4",
							"#646c9a"
						]
					}
				}
			};
        </script>

        <!-- end::Global Config -->

        {{-- <!--begin::Page Vendors(used by this page) -->
<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
<script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
<script src="assets/plugins/custom/gmaps/gmaps.js" type="text/javascript"></script>

<!--end::Page Vendors --> --}}


        <!--begin::Page Scripts(used by this page) -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/dashboard.js') }}" type="text/javascript"></script>

        <!--end::Page Scripts -->
</body>

<!-- end::Body -->

</html>
