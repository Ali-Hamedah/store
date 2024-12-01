<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>
    <div class="main-header-right">
        <ul class="nav">
            <li class="">
                <div class="dropdown  nav-itemd-none d-md-flex">
                    <a href="#" class="d-flex nav-item nav-link pl-0 country-flag1" data-toggle="dropdown"
                        aria-expanded="false">

                        @if (App::getLocale() == 'en')
                            <span class="avatar country-Flag mr-0 align-self-center bg-transparent">
                                <img src="{{ URL::asset('images/us_flag.jpg') }}" alt="US Flag"
                                    style="width: 20px; height: 20px; border-radius: 50%;">
                            </span>
                            <strong class="mr-2 ml-2 my-auto">{{ LaravelLocalization::getCurrentLocaleName() }}</strong>
                        @elseif(App::getLocale() == 'de')
                            <span class="avatar country-Flag mr-0 align-self-center bg-transparent">
                                <img src="{{ URL::asset('images/AT.png') }}" alt="Austria Flag"
                                    style="width: 20px; height: 20px; border-radius: 50%;">
                            </span>
                            <strong class="mr-2 ml-2 my-auto">{{ LaravelLocalization::getCurrentLocaleName() }}</strong>
                      
                        @else
                        <span class="avatar country-Flag mr-0 align-self-center bg-transparent">
                            <img src="{{ URL::asset('images/YE.png') }}" alt="Yemen Flag"
                                style="width: 20px; height: 20px; border-radius: 50%;">
                        </span>
                        <strong class="mr-2 ml-2 my-auto">{{ LaravelLocalization::getCurrentLocaleName() }}</strong>
                    @endif
                        <div class="my-auto">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                @if ($properties['native'] == 'English')
                                    <i class="flag-icon flag-icon-us"></i>
                                @elseif ($properties['native'] == 'Deutsch')
                                    <i class="flag-icon flag-icon-at"></i>
                                    @else
                                     <i class="flag-icon flag-icon-ye"></i>
                                @endif
                                {{ $properties['native'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>

        <!-- Notifications Dropdown Menu -->
        <x-dashboard.notifications />

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
