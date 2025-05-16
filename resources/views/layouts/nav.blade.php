<!-- Header -->
<section class="header-section">
    <div class="container-fluid">
        <div class="header-wrap">
            <!-- Left -->
            <div class="header-left">
                <nav class="navbar navbar-expand-xl p-0">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                            aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="{{route('frontend.index')}}">
                        <img src="{{getSettingImage('app_logo')}}" alt=""/></a>
                    <div class="navbar-collapse menu-navbar-collapse offcanvas offcanvas-start" tabindex="-1"
                         id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                        <button type="button"
                                class="d-xl-none w-30 h-30 p-0 rounded-circle bg-white border-0 position-absolute top-10 right-10"
                                data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-times"></i>
                        </button>
                        <ul class="navbar-nav justify-content-center flex-wrap cg-28 rg-10 w-100">
                            @foreach($productType as $data)
                                <li class="nav-item"><a class="nav-link" href="{{ route('frontend.product_category',$data->uuid) }}">{{ $data->name }}</a>
                                </li>
                            @endforeach
                            <li class="nav-item"><a class="nav-link d-lg-none" href="{{route('frontend.pricing')}}">{{__('Pricing')}}</a></li>
                            <li class="nav-item"><a class="nav-link d-md-none" href="{{route('customer.products.create')}}">{{__('Upload')}}</a></li>
                            @guest
                               <li class="nav-item"><a class="nav-link d-md-none" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            @endguest

                            <!-- Language -->
                            <li class="nav-item d-md-none">
                                @if (!empty(getOption('show_language_switcher')) && getOption('show_language_switcher') == ACTIVE)
                                    <div class="dropdown lanDropdown lanDropdown-alt">
                                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            <div class="icon flex-shrink-0">
                                                <img src="{{selectedLanguage()?->flag}}" alt=""/>
                                            </div>
                                            <p class="text">{{selectedLanguage()?->language}}</p>
                                        </button>
                                        <div class="dropdown-menu dropdownItem-one">
                                            @foreach(appLanguages() as $app_lang)
                                                <div>
                                                    <a class="d-flex align-items-center cg-8"
                                                       href="{{ url('/local/'.$app_lang->iso_code) }}">
                                                        <div class="d-flex rounded-circle overflow-hidden flex-shrink-0">
                                                            <img src="{{$app_lang->flag}}" alt=""
                                                                 class="w-20 h-20 object-fit-cover"/>
                                                        </div>
                                                        <p class="fs-14 fw-400 lh-24 text-primary-dark-text">{{$app_lang->language}}</p>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- Right -->
            <div class="header-right">
                <a href="{{route('frontend.pricing')}}"
                   class="fs-16 fw-400 lh-26 text-primary linkDefault-hover d-none d-lg-block">{{__('Pricing')}}</a>
                <div class="d-flex align-items-center g-10">
                    @auth
                        @if(auth()->user()->contributor_status == CONTRIBUTOR_STATUS_APPROVED)
                            <!-- Sign Up / Upload -->
                            <a href="{{route('customer.products.create')}}" class="zaiStock-btn zaiStock-hover d-none d-md-block">{{__('Upload')}}</a>
                        @endif
                    @endauth
                    <!-- Language -->
                    @if (!empty(getOption('show_language_switcher')) && getOption('show_language_switcher') == ACTIVE)
                        <div class="dropdown lanDropdown d-none d-md-block">
                            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <div class="icon flex-shrink-0">
                                    <img src="{{selectedLanguage()?->flag}}" alt=""/>
                                </div>
                                <p class="text">{{selectedLanguage()?->language}}</p>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdownItem-one">
                                @foreach(appLanguages() as $app_lang)
                                    <li>
                                        <a class="d-flex align-items-center cg-8"
                                           href="{{ url('/local/'.$app_lang->iso_code) }}">
                                            <div class="d-flex rounded-circle overflow-hidden flex-shrink-0">
                                                <img src="{{$app_lang->flag}}" alt=""
                                                     class="w-20 h-20 object-fit-cover"/>
                                            </div>
                                            <p class="fs-14 fw-400 lh-24 text-primary-dark-text">{{$app_lang->language}}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @guest
                        <a href="{{route('login')}}" class="zaiStock-btn zaiStock-hover d-none d-md-block">{{__('Login')}}</a>
                    @else
                        <!-- User -->
                        <div class="dropdown headerUserDropdown">
                            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    data-bs-auto-close="outside">
                                <div class="icon flex-shrink-0"><img
                                        src="{{asset('assets/images/icon/header-user.svg')}}"
                                        alt=""/></div>
                                <p class="text d-none d-sm-block">{{auth()->user()->name}}</p>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end p-0">
                                <div class="headerUserDropdown-content">
                                    <div class="header-userInfo">
                                        <div class="upload-img-box profileImage-upload">
                                            <a href="{{route('customer.profile.index')}}" class="icon">
                                                <img src="{{asset('assets/images/icon/header-edit.svg')}}" alt=""/>
                                            </a>
                                            <img src="{{auth()->user()->image}}"/>
                                        </div>
                                        <div class="content">
                                            <h4 class="name">{{auth()->user()->name}}</h4>
                                            <p class="info">{{auth()->user()->email}}</p>
                                        </div>
                                    </div>
                                    @php
                                        $subscriptionData = getSubscriptionData(auth()->id());
                                    @endphp

                                    <div class="header-creditsInfo">
                                        @if($subscriptionData['subscriptionPlan'])
                                            <h4 class="title">
                                                {{ __('Remaining Credits ') }} (<span>{{ $subscriptionData['totalDownload'] }}</span> /
                                                {{ $subscriptionData['downloadLimit'] }})
                                            </h4>
                                            <a href="{{ route('customer.subscriptions.my_subscription') }}" class="link">{{ __('Upgrade') }}</a>
                                        @else
                                            <h4 class="title">{{ __('No Subscription Found') }}</h4>
                                            <a href="{{ route('frontend.pricing') }}" class="link">{{ __('Subscribe Now') }}</a>
                                        @endif
                                    </div>

                                    <ul class="header-menuList-block">
                                        @if(auth()->user()->contributor_status == CONTRIBUTOR_STATUS_APPROVED)
                                            <li>
                                                <ul class="menuItem-block">
                                                    <li>
                                                        <a href="{{route('customer.products.create')}}" class="link">
                                                            <div class="content">
                                                                <div class="icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                         height="20" viewBox="0 0 20 20" fill="none">
                                                                        <path
                                                                            d="M6.48555 14.2593C5.56857 14.7858 3.1643 15.8609 4.62866 17.2062C5.34399 17.8633 6.14068 18.3333 7.14232 18.3333H12.8578C13.8595 18.3333 14.6562 17.8633 15.3715 17.2062C16.8358 15.8609 14.4316 14.7858 13.5146 14.2593C11.3643 13.0247 8.63583 13.0247 6.48555 14.2593Z"
                                                                            stroke="#1F2224" stroke-width="1.5"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"/>
                                                                        <path
                                                                            d="M12.9166 8.33333C12.9166 9.94416 11.6108 11.25 9.99992 11.25C8.38909 11.25 7.08325 9.94416 7.08325 8.33333C7.08325 6.7225 8.38909 5.41666 9.99992 5.41666C11.6108 5.41666 12.9166 6.7225 12.9166 8.33333Z"
                                                                            stroke="#1F2224" stroke-width="1.5"/>
                                                                        <path
                                                                            d="M2.37841 13.3333C1.92092 12.3053 1.66675 11.1675 1.66675 9.9705C1.66675 5.38441 5.39771 1.66666 10.0001 1.66666C14.6024 1.66666 18.3334 5.38441 18.3334 9.9705C18.3334 11.1675 18.0792 12.3053 17.6217 13.3333"
                                                                            stroke="#1F2224" stroke-width="1.5"
                                                                            stroke-linecap="round"/>
                                                                    </svg>
                                                                </div>
                                                                <p class="text">{{__('Contributor')}}</p>
                                                            </div>
                                                            <i class="fa-solid fa-angle-right"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @else
                                            <li>
                                                <ul class="menuItem-block">
                                                    <li>
                                                        <a href="{{route('customer.be_a_contributor')}}" class="link">
                                                            <div class="content">
                                                                <div class="icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                         height="20" viewBox="0 0 20 20" fill="none">
                                                                        <path
                                                                            d="M6.48555 14.2593C5.56857 14.7858 3.1643 15.8609 4.62866 17.2062C5.34399 17.8633 6.14068 18.3333 7.14232 18.3333H12.8578C13.8595 18.3333 14.6562 17.8633 15.3715 17.2062C16.8358 15.8609 14.4316 14.7858 13.5146 14.2593C11.3643 13.0247 8.63583 13.0247 6.48555 14.2593Z"
                                                                            stroke="#1F2224" stroke-width="1.5"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"/>
                                                                        <path
                                                                            d="M12.9166 8.33333C12.9166 9.94416 11.6108 11.25 9.99992 11.25C8.38909 11.25 7.08325 9.94416 7.08325 8.33333C7.08325 6.7225 8.38909 5.41666 9.99992 5.41666C11.6108 5.41666 12.9166 6.7225 12.9166 8.33333Z"
                                                                            stroke="#1F2224" stroke-width="1.5"/>
                                                                        <path
                                                                            d="M2.37841 13.3333C1.92092 12.3053 1.66675 11.1675 1.66675 9.9705C1.66675 5.38441 5.39771 1.66666 10.0001 1.66666C14.6024 1.66666 18.3334 5.38441 18.3334 9.9705C18.3334 11.1675 18.0792 12.3053 17.6217 13.3333"
                                                                            stroke="#1F2224" stroke-width="1.5"
                                                                            stroke-linecap="round"/>
                                                                    </svg>
                                                                </div>
                                                                <p class="text">{{__('Be a Contributor')}}</p>
                                                            </div>
                                                            <i class="fa-solid fa-angle-right"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif
                                        <li>
                                            <ul class="menuItem-block">
                                                <li>
                                                    <a href="{{route('customer.boards.index')}}" class="link">
                                                        <div class="content">
                                                            <div class="icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                     height="20" viewBox="0 0 20 20" fill="none">
                                                                    <path
                                                                        d="M12.0834 5.83333H7.91675C5.17718 5.83333 3.8074 5.83333 2.88544 6.58996C2.71666 6.72848 2.5619 6.88324 2.42338 7.05202C1.66675 7.97398 1.66675 9.34374 1.66675 12.0833C1.66675 14.8229 1.66675 16.1927 2.42338 17.1147C2.5619 17.2834 2.71666 17.4382 2.88544 17.5767C3.8074 18.3333 5.17718 18.3333 7.91675 18.3333H12.0834C14.823 18.3333 16.1927 18.3333 17.1147 17.5767C17.2835 17.4382 17.4382 17.2834 17.5767 17.1147C18.3334 16.1927 18.3334 14.8229 18.3334 12.0833C18.3334 9.34374 18.3334 7.97398 17.5767 7.05202C17.4382 6.88324 17.2835 6.72848 17.1147 6.58996C16.1927 5.83333 14.823 5.83333 12.0834 5.83333Z"
                                                                        stroke="#1F2224"
                                                                        stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                    />
                                                                    <path
                                                                        d="M10 5.83334V4.16667C10 3.70644 10.3731 3.33334 10.8333 3.33334C11.2936 3.33334 11.6667 2.96024 11.6667 2.50001V1.66667"
                                                                        stroke="#1F2224" stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"/>
                                                                    <path d="M5.83325 10H6.66659" stroke="#1F2224"
                                                                          stroke-width="1.5" stroke-linecap="round"
                                                                          stroke-linejoin="round"/>
                                                                    <path d="M9.58325 10H10.4166" stroke="#1F2224"
                                                                          stroke-width="1.5" stroke-linecap="round"
                                                                          stroke-linejoin="round"/>
                                                                    <path d="M13.3333 10H14.1666" stroke="#1F2224"
                                                                          stroke-width="1.5" stroke-linecap="round"
                                                                          stroke-linejoin="round"/>
                                                                    <path d="M5.83325 14.1667H14.1666" stroke="#1F2224"
                                                                          stroke-width="1.5" stroke-linecap="round"
                                                                          stroke-linejoin="round"/>
                                                                </svg>
                                                            </div>
                                                            <p class="text">{{__('Boards')}}</p>
                                                        </div>
                                                        <i class="fa-solid fa-angle-right"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{route('customer.favourite')}}" class="link">
                                                        <div class="content">
                                                            <div class="icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                     height="18" viewBox="0 0 20 18" fill="none">
                                                                    <path
                                                                        d="M16.2189 2.32846C13.9842 0.957693 12.0337 1.51009 10.8621 2.39001C10.3816 2.7508 10.1414 2.93119 10.0001 2.93119C9.85875 2.93119 9.61858 2.7508 9.13808 2.39001C7.96643 1.51009 6.01599 0.957693 3.78128 2.32846C0.848472 4.12745 0.184848 10.0624 6.94969 15.0695C8.23818 16.0232 8.88241 16.5 10.0001 16.5C11.1177 16.5 11.762 16.0232 13.0505 15.0695C19.8153 10.0624 19.1517 4.12745 16.2189 2.32846Z"
                                                                        stroke="#1F2224" stroke-width="1.5"
                                                                        stroke-linecap="round"/>
                                                                </svg>
                                                            </div>
                                                            <p class="text">{{__('Favorites')}}</p>
                                                        </div>
                                                        <i class="fa-solid fa-angle-right"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{route('customer.wallets.index')}}" class="link">
                                                        <div class="content">
                                                            <div class="icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                     height="20" viewBox="0 0 20 20" fill="none">
                                                                    <path
                                                                        d="M2.5 7.08334H12.5C14.857 7.08334 16.0355 7.08334 16.7677 7.81558C17.5 8.54784 17.5 9.72634 17.5 12.0833V12.9167C17.5 15.2737 17.5 16.4522 16.7677 17.1844C16.0355 17.9167 14.857 17.9167 12.5 17.9167H7.5C5.14297 17.9167 3.96447 17.9167 3.23223 17.1844C2.5 16.4522 2.5 15.2737 2.5 12.9167V7.08334Z"
                                                                        stroke="#1F2224" stroke-width="1.5"
                                                                        stroke-linecap="square"
                                                                        stroke-linejoin="round"/>
                                                                    <path
                                                                        d="M12.5 7.08194V3.42525C12.5 2.68413 11.8992 2.08333 11.1581 2.08333C10.9447 2.08333 10.7343 2.13423 10.5445 2.23181L3.13525 6.04105C2.7452 6.24159 2.5 6.64335 2.5 7.08194"
                                                                        stroke="#1F2224" stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"/>
                                                                </svg>
                                                            </div>
                                                            <p class="text">{{__('Wallet')}}</p>
                                                        </div>
                                                        <i class="fa-solid fa-angle-right"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul class="menuItem-block">
                                                <li>
                                                    <a href="{{route('customer.subscriptions.my_subscription')}}"
                                                       class="link">
                                                        <div class="content">
                                                            <div class="icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                     height="20" viewBox="0 0 20 20" fill="none">
                                                                    <path
                                                                        d="M10.4547 8.10181H11.2374C12.1021 8.10181 12.8031 8.80657 12.8031 9.67591M12.8031 9.67591V10.4629M12.8031 9.67591C12.8031 9.24124 13.1535 8.88882 13.5858 8.88882C14.4505 8.88882 15.1515 9.59357 15.1515 10.4629M15.1515 10.4629V11.2499M15.1515 10.4629C15.1515 10.0509 15.5194 9.73749 15.9237 9.80524L16.1917 9.85016C16.9466 9.97666 17.4999 10.6333 17.4999 11.4028L17.4996 11.7747C17.4996 13.4852 17.4996 14.3405 17.2404 15.0214C17.0901 15.4163 16.6935 15.9201 16.3764 16.2841C16.1021 16.5989 15.934 16.9982 15.934 17.4167V18.3333M10.4545 9.67591V5.3472C10.4545 4.69521 9.92875 4.16666 9.28025 4.16666C8.63175 4.16666 8.10605 4.69521 8.10605 5.3472L8.10589 11.6139L6.8375 10.3347C6.28099 9.77332 5.36428 9.82457 4.87262 10.4444C4.49642 10.9187 4.48603 11.5896 4.84735 12.0755L7.66523 15.6944C8.20436 16.3867 8.49734 17.454 8.49734 18.3333"
                                                                        stroke="#1F2224"
                                                                        stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                    />
                                                                    <path
                                                                        d="M5.00008 6.66666H4.31381C3.06597 6.66666 2.44206 6.66666 2.0544 6.30054C1.66675 5.93442 1.66675 5.34516 1.66675 4.16666C1.66675 2.98815 1.66675 2.39889 2.0544 2.03277C2.44206 1.66666 3.06597 1.66666 4.31381 1.66666H14.0197C15.2675 1.66666 15.8914 1.66666 16.2791 2.03277C16.6667 2.39889 16.6667 2.98815 16.6667 4.16666C16.6667 5.34516 16.6667 5.93442 16.2791 6.30054C15.8914 6.66666 15.2675 6.66666 14.0197 6.66666H13.3334"
                                                                        stroke="#1F2224" stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"/>
                                                                </svg>
                                                            </div>
                                                            <p class="text">{{__('My Subscription')}}</p>
                                                        </div>
                                                        <i class="fa-solid fa-angle-right"></i>
                                                    </a>
                                                </li>
                                                @if(isAddonInstalled('PIXELAFFILIATE'))
                                                    @if (getOption('referral_status') == 1)
                                                        <li>
                                                            <a href="{{route('customer.referral.index')}}" class="link">
                                                                <div class="content">
                                                                    <div class="icon">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             width="20"
                                                                             height="20" viewBox="0 0 20 20"
                                                                             fill="none">
                                                                            <path
                                                                                d="M4.31681 12.747C3.26882 13.3612 0.521091 14.6155 2.19465 16.185C3.01216 16.9517 3.92266 17.5 5.06739 17.5H11.5994C12.7442 17.5 13.6547 16.9517 14.4722 16.185C16.1457 14.6155 13.398 13.3612 12.35 12.747C9.8925 11.3066 6.7743 11.3066 4.31681 12.747Z"
                                                                                stroke="#1F2224" stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"/>
                                                                            <path
                                                                                d="M11.6667 5.83333C11.6667 7.67428 10.1742 9.16667 8.33333 9.16667C6.49238 9.16667 5 7.67428 5 5.83333C5 3.99238 6.49238 2.5 8.33333 2.5C10.1742 2.5 11.6667 3.99238 11.6667 5.83333Z"
                                                                                stroke="#1F2224" stroke-width="1.5"/>
                                                                            <path
                                                                                d="M16.2501 3.33334V7.50001M18.3334 5.41668H14.1667"
                                                                                stroke="#1F2224" stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"/>
                                                                        </svg>
                                                                    </div>
                                                                    <p class="text">{{__('Referrals')}}</p>
                                                                </div>
                                                                <i class="fa-solid fa-angle-right"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endif
                                            </ul>
                                        </li>
                                    </ul>
                                    <div class="header-logoutWrap">
                                        <a href="{{route('logout')}}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                           class="logoutBtn">
                                            {{__('Log Out')}}
                                            <div class="icon">
                                                <img src="{{asset('assets/images/icon/logout-icon.svg')}}" alt=""/>
                                            </div>
                                        </a>
                                    </div>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if(!isset($searchDisable))
            <!-- Search -->
            <form action="{{route('frontend.search-result')}}" method="GET">
                <div class="header-search">
                    <!--  -->
                    <div class="headerSearchDropdown">
                        <select name="asset_type" class="sf-select-two">
                            <option
                                value="all" {{(request()->get('asset_type') == 'all') ? 'selected' : ''}}>{{__("All Asset")}}</option>
                            @foreach($productType as $data)
                                <option
                                    {{(request()->get('asset_type') == $data->uuid) ? 'selected' : ''}} value="{{$data->uuid}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(request('sort_by'))
                        <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                    @endif
                    @if(request('license'))
                        <input type="hidden" name="license" value="{{ request('license') }}">
                    @endif
                    @if(request('file_type'))
                        <input type="hidden" name="file_type" value="{{ request('file_type') }}">
                    @endif
                    @if(request('choice'))
                        <input type="hidden" name="choice" value="{{ request('choice') }}">
                    @endif
                    @foreach(request('category', []) as $category)
                        <input type="hidden" name="category[]" value="{{ $category }}">
                    @endforeach
                    <!-- Input -->
                    <div class="inputWrap">
                        <input name="search_key" value="{{request()->get('search_key')}}" type="text"
                               placeholder="{{__('Search Items')}}" id=""/>
                        <button id="reset-search" type="button">
                            <i class="fa-solid fa-times"></i></button>
                    </div>
                    <!-- Button -->
                    <div class="buttonWrap">
                        <button type="submit">
                            <img src="{{asset('assets/images/icon/search_light.svg')}}" alt=""/>
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</section>
