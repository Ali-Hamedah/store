 <!-- Start Header Area -->
 <header class="header navbar-area">
    <!-- Start Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="top-left">
                        <ul class="menu-top-link">
                            <li>
                                <div class="select-position">
                                    <select id="select4">
                                        <option value="0" selected>$ USD</option>
                                        <option value="1">€ EURO</option>
                                        <option value="2">$ CAD</option>
                                        <option value="3">₹ INR</option>
                                        <option value="4">¥ CNY</option>
                                        <option value="5">৳ BDT</option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <div class="select-position">
                                    <select id="languageSelect" onchange="changeLanguage(this)">
                                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <option value="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" 
                                                {{ app()->getLocale() == $localeCode ? 'selected' : '' }}>
                                                {{ $properties['native'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="top-middle">
                        <ul class="useful-links">
                            <li><a href="{{route('home')}}">Home</a></li>
                            <li><a href="about-us.html">About Us</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="top-end">
                        @if (!auth()->check())
                        <ul class="user-login">
                            <li>
                                <a href="{{ route('choose.login') }}">Sign In</a>
                            </li>
                            <li>
                                <a href="{{ route('choose.registration') }}">Register</a>
                            </li>
                        </ul>
                        @else
                            <div class="user">
                           
                            <a href="{{ route('customer.dashboard') }}"> <i class="lni lni-user">{{auth()->user()->name}}</i></a>
                            
                        </div>
                        @endif
                        
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <!-- Start Header Middle -->
    <div class="header-middle">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-3 col-7">
                    <!-- Start Header Logo -->
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ asset('assets/images/logo/logo.svg') }}" alt="Logo">
                    </a>
                    <!-- End Header Logo -->
                </div>
                <div class="col-lg-5 col-md-7 d-xs-none">
                    <!-- Start Main Menu Search -->
                    <div class="main-menu-search">
                        <!-- navbar search start -->
                        <div class="navbar-search search-style-5">
                            <div class="search-select">
                                <div class="select-position">
                                    <select id="select1">
                                        <option selected>All</option>
                                        <option value="1">option 01</option>
                                        <option value="2">option 02</option>
                                        <option value="3">option 03</option>
                                        <option value="4">option 04</option>
                                        <option value="5">option 05</option>
                                    </select>
                                </div>
                            </div>
                            <div class="search-input">
                                <input type="text" placeholder="Search">
                            </div>
                            <div class="search-btn">
                                <button><i class="lni lni-search-alt"></i></button>
                            </div>
                        </div>
                        <!-- navbar search Ends -->
                    </div>
                    <!-- End Main Menu Search -->
                </div>
                <div class="col-lg-4 col-md-2 col-5">
                    <div class="middle-right-area">
                        <div class="nav-hotline">
                            <i class="lni lni-phone"></i>
                            <h3>Hotline:
                                <span>(+100) 123 456 7890</span>
                            </h3>
                        </div>
                        <div class="navbar-cart">
                         
                            <div class="wishlist">
                                <a href="javascript:void(0)">
                                    <i class="lni lni-heart"></i>
                                    <span class="total-items">0</span>
                                </a>
                            </div>
                            
                        {{-- cart menu --}}
                           <x-Cart-menu>
                            </x-cart-menu>

                            {{-- <x-notification>
                            </x-notification> --}}
                           
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Middle -->
    <!-- Start Header Bottom -->
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-6 col-12">
                <div class="nav-inner">
                    <!-- Start Mega Category Menu -->
                    <div class="mega-category-menu">
                        <span class="cat-button"><i class="lni lni-menu"></i>All Categories</span>
                        <ul class="sub-category">
                            <li><a href="product-grids.html">Electronics <i class="lni lni-chevron-right"></i></a>
                                <ul class="inner-sub-category">
                                    <li><a href="product-grids.html">Digital Cameras</a></li>
                                    <li><a href="product-grids.html">Camcorders</a></li>
                                    <li><a href="product-grids.html">Camera Drones</a></li>
                                    <li><a href="product-grids.html">Smart Watches</a></li>
                                    <li><a href="product-grids.html">Headphones</a></li>
                                    <li><a href="product-grids.html">MP3 Players</a></li>
                                    <li><a href="product-grids.html">Microphones</a></li>
                                    <li><a href="product-grids.html">Chargers</a></li>
                                    <li><a href="product-grids.html">Batteries</a></li>
                                    <li><a href="product-grids.html">Cables & Adapters</a></li>
                                </ul>
                            </li>
                            <li><a href="product-grids.html">accessories</a></li>
                            <li><a href="product-grids.html">Televisions</a></li>
                            <li><a href="product-grids.html">best selling</a></li>
                            <li><a href="product-grids.html">top 100 offer</a></li>
                            <li><a href="product-grids.html">sunglass</a></li>
                            <li><a href="product-grids.html">watch</a></li>
                            <li><a href="product-grids.html">man’s product</a></li>
                            <li><a href="product-grids.html">Home Audio & Theater</a></li>
                            <li><a href="product-grids.html">Computers & Tablets </a></li>
                            <li><a href="product-grids.html">Video Games </a></li>
                            <li><a href="product-grids.html">Home Appliances </a></li>
                        </ul>
                    </div>
                    <!-- End Mega Category Menu -->
                    <!-- Start Navbar -->
                    <nav class="navbar navbar-expand-lg">
                        <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a href="index.html" class="active" aria-label="Toggle navigation">Home</a>
                                </li>
                                @foreach($categories as $category)
                                <li class="nav-item">
                                    <a class="dd-menu collapsed" href="{{route('frontend.shop')}}" data-bs-toggle="collapse"
                                        data-bs-target="#submenu-{{ $category->id }}" aria-controls="navbarSupportedContent"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                        {{ $category->name }}
                                    </a>
                                    <!-- التحقق من وجود أقسام فرعية -->
                                    @if($category->children->isNotEmpty())
                                        <ul class="sub-menu collapse" id="submenu-{{ $category->id }}">
                                            @foreach($category->children as $child)
                                                <li class="nav-item">
                                                    <a href="{{route('frontend.shop', $child->slug)}}">
                                                        {{ $child->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                            
                                <li class="nav-item">
                                    <a href="contact.html" aria-label="Toggle navigation">Contact Us</a>
                                </li>
                            </ul>
                        </div> <!-- navbar collapse -->
                    </nav>
                    <!-- End Navbar -->
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <!-- Start Nav Social -->
                <div class="nav-social">
                    <h5 class="title">Follow Us:</h5>
                    <ul>
                        <li>
                            <a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><i class="lni lni-instagram"></i></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><i class="lni lni-skype"></i></a>
                        </li>
                    </ul>
                </div>
                <!-- End Nav Social -->
            </div>
        </div>
    </div>
    <!-- End Header Bottom -->
</header>
<!-- End Header Area -->