<div data-aos="fade-down" data-aos-duration="1000" class="main-header">
    <!-- Left -->
    <div class="d-flex align-items-center cg-15">
        <!-- Mobile Menu Button -->
        <div class="mobileMenu">
            <button
                class="bd-one bd-c-title-color rounded-circle w-30 h-30 d-flex justify-content-center align-items-center text-title-color p-0 bg-transparent">
                <i class="fa-solid fa-bars"></i></button>
        </div>
        <!-- Link -->
        <a href="{{ route('frontend.index') }}" target="_blank"
           class="d-inline-flex align-items-center g-10 bd-ra-8 bg-primary py-10 px-26 fs-15 fw-600 lh-25 text-white">{{__('Visit Site')}}
            <span class="iconify" data-icon="material-symbols:arrow-outward-rounded"></span></a>
    </div>
    <!-- Right -->
    <div class="right d-flex justify-content-end align-items-center cg-12">
        <!-- Language - Message - Notify -->
        @if (!empty(getOption('show_language_switcher')) && getOption('show_language_switcher') == ACTIVE)
            <div class="d-flex align-items-center cg-12">
                <!-- Language switcher -->
                <div class="dropdown lanDropdown-admin">
                    <button class="dropdown-toggle p-0 border-0 bg-transparent d-flex align-items-center cg-8"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{asset(selectedLanguage()->flag)}}" alt="icon"/>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdownItem-one">
                        @foreach(appLanguages() as $app_lang)
                            <li>
                                <a class="d-flex align-items-center cg-8"
                                   href="{{ url('/local/'.$app_lang->iso_code) }}">
                                    <div class="d-flex">
                                        <img src="{{asset($app_lang->flag)}}" alt="icon" class="max-w-26 w-100"/>
                                    </div>
                                    <p class="fs-13 fw-500 lh-16 text-title-black">{{$app_lang->language}}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <!-- User -->
        <div class="dropdown headerUserDropdown-admin">
            <button class="dropdown-toggle p-0 border-0 bg-transparent d-flex align-items-center cg-8" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-content">
                    <div class="wrap">
                        <div class="img">
                            <img src="{{ auth()->user()->image }}" alt="icon" class="rounded-circle"/>
                        </div>
                    </div>
                    <h4 class="text-start d-none d-md-block fs-13 fw-600 lh-16 text-title-color">{{auth()->user()->name}}</h4>
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdownItem-one">
                <li>
                    <a class="d-flex align-items-center cg-8" href="{{route('admin.profile.index')}}">
                        <div class="d-flex icon">
                            <svg width="12" height="13" viewBox="0 0 12 13" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.8966 11.6036C11.2651 11.5268 11.4846 11.1411 11.3015 10.8122C10.8978 10.0871 10.2617 9.44993 9.44812 8.96435C8.40026 8.33898 7.11636 8 5.79556 8C4.47475 8 3.19085 8.33897 2.14299 8.96435C1.32936 9.44993 0.693348 10.0871 0.289627 10.8122C0.106496 11.1411 0.325986 11.5268 0.694529 11.6036V11.6036C4.05907 12.3048 7.53204 12.3048 10.8966 11.6036V11.6036Z"
                                    fill="#63647B"/>
                                <circle cx="5.79574" cy="3.33333" r="3.33333" fill="#63647B"/>
                            </svg>
                        </div>
                        <p class="text-nowrap fs-14 fw-400 lh-17 text-para-text">{{__('Profile')}}</p>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center cg-8" href="{{ route('admin.profile.change-password') }}">
                        <div class="d-flex icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M9.56527 0.757929C9.58283 0.828314 9.59114 0.911478 9.60778 1.07781C9.63919 1.39198 9.6549 1.54907 9.68762 1.65049C9.87683 2.23715 10.5466 2.51458 11.0952 2.23355C11.1901 2.18497 11.3123 2.085 11.5566 1.88506C11.686 1.77922 11.7507 1.72629 11.8129 1.68894C12.1607 1.48005 12.6002 1.50197 12.9254 1.74443C12.9836 1.78779 13.0427 1.84688 13.1609 1.96507L13.8682 2.6724C13.9864 2.7906 14.0455 2.8497 14.0889 2.90786C14.3313 3.23313 14.3533 3.67264 14.1444 4.02042C14.107 4.0826 14.0541 4.14729 13.9482 4.27666C13.7483 4.52104 13.6483 4.64323 13.5997 4.73809C13.3187 5.28671 13.5961 5.95648 14.1828 6.14571C14.2842 6.17842 14.4413 6.19413 14.7555 6.22555L14.7555 6.22555L14.7555 6.22555C14.9219 6.24219 15.005 6.2505 15.0754 6.26807C15.469 6.36627 15.7643 6.69255 15.8229 7.09398C15.8333 7.16577 15.8333 7.24936 15.8333 7.41653V8.4169C15.8333 8.58398 15.8333 8.66752 15.8229 8.73927C15.7643 9.14077 15.469 9.4671 15.0753 9.56529C15.005 9.58284 14.9219 9.59115 14.7556 9.60777L14.7556 9.60778C14.4416 9.63918 14.2846 9.65487 14.1832 9.68755C13.5964 9.87672 13.3189 10.5467 13.6001 11.0954C13.6487 11.1901 13.7486 11.3122 13.9484 11.5564C14.0541 11.6857 14.107 11.7503 14.1443 11.8125C14.3533 12.1603 14.3314 12.5999 14.0888 12.9252C14.0455 12.9833 13.9865 13.0424 13.8684 13.1605L13.1609 13.8679C13.0427 13.9861 12.9836 14.0452 12.9255 14.0886C12.6002 14.331 12.1607 14.3529 11.8129 14.144C11.7507 14.1067 11.686 14.0538 11.5567 13.9479C11.3123 13.748 11.1901 13.648 11.0953 13.5994C10.5467 13.3184 9.87687 13.5958 9.68765 14.1825C9.65494 14.2839 9.63922 14.441 9.6078 14.7553L9.6078 14.7553C9.59115 14.9218 9.58282 15.0051 9.56524 15.0755C9.46702 15.469 9.14079 15.7643 8.73943 15.8228C8.6676 15.8333 8.58397 15.8333 8.4167 15.8333H7.41652C7.24935 15.8333 7.16577 15.8333 7.09398 15.8229C6.69255 15.7643 6.36627 15.469 6.26806 15.0754C6.2505 15.005 6.24218 14.9219 6.22555 14.7555L6.22555 14.7555L6.22555 14.7555C6.19413 14.4413 6.17842 14.2842 6.1457 14.1828C5.95647 13.5961 5.28671 13.3187 4.73809 13.5997C4.64323 13.6483 4.52104 13.7483 4.27664 13.9483L4.27663 13.9483C4.14725 14.0541 4.08256 14.1071 4.02037 14.1444C3.6726 14.3533 3.23309 14.3314 2.90784 14.0889C2.84967 14.0456 2.79057 13.9865 2.67236 13.8683L2.67235 13.8682L1.96505 13.1609L1.96503 13.1609C1.84684 13.0427 1.78774 12.9836 1.74439 12.9255C1.50193 12.6002 1.48001 12.1607 1.6889 11.8129C1.72625 11.7507 1.77917 11.6861 1.88502 11.5567L1.88504 11.5567C2.08498 11.3123 2.18496 11.1901 2.23354 11.0952C2.51457 10.5466 2.23714 9.87684 1.65048 9.68762C1.54906 9.65491 1.39197 9.6392 1.0778 9.60778L1.07778 9.60778C0.911469 9.59115 0.828312 9.58283 0.757931 9.56527C0.364306 9.46707 0.0690197 9.14078 0.0104693 8.73934C0 8.66755 0 8.58398 0 8.41683V7.41661C0 7.24936 0 7.16574 0.0104808 7.09392C0.0690547 6.69254 0.364294 6.3663 0.757855 6.26808C0.828276 6.25051 0.911482 6.24219 1.0779 6.22554C1.39224 6.19411 1.54942 6.17839 1.65089 6.14565C2.23744 5.95639 2.51482 5.28674 2.23389 4.73816C2.18529 4.64325 2.08525 4.52098 1.88517 4.27644L1.88517 4.27644C1.77922 4.14695 1.72625 4.0822 1.68888 4.01996C1.48007 3.67223 1.50198 3.23282 1.74436 2.9076C1.78774 2.84938 1.84688 2.79024 1.96518 2.67195L1.96518 2.67195L2.67239 1.96473L2.67239 1.96473C2.7906 1.84652 2.8497 1.78742 2.90787 1.74406C3.23313 1.50161 3.67263 1.47969 4.0204 1.68857C4.0826 1.72593 4.14731 1.77888 4.27673 1.88477C4.52106 2.08467 4.64322 2.18462 4.73801 2.23319C5.28669 2.51433 5.9566 2.23684 6.14578 1.65007C6.17846 1.5487 6.19416 1.3917 6.22556 1.07771L6.22556 1.0777L6.22556 1.07769C6.24218 0.911467 6.25049 0.828354 6.26804 0.75801C6.36623 0.36432 6.69257 0.0689842 7.09407 0.0104577C7.16582 0 7.24935 0 7.4164 0H8.41682C8.58397 0 8.66755 0 8.73933 0.0104697C9.14077 0.0690208 9.46706 0.364306 9.56527 0.757929ZM7.91666 11.0833C9.66556 11.0833 11.0833 9.66557 11.0833 7.91667C11.0833 6.16776 9.66556 4.75 7.91666 4.75C6.16776 4.75 4.75 6.16776 4.75 7.91667C4.75 9.66557 6.16776 11.0833 7.91666 11.0833Z"
                                    fill="#5D697A"
                                />
                            </svg>
                        </div>
                        <p class="text-nowrap fs-14 fw-400 lh-17 text-para-text">{{__('Change Password')}}</p>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center cg-8" href="{{route('admin.logout')}}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <div class="d-flex icon">
                            <svg width="10" height="14" viewBox="0 0 10 14" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M7.69547 0.823345L4.37659 0.301806C2.49791 0.00658503 1.55857 -0.141025 0.945912 0.382878C0.333252 0.906781 0.333252 1.85765 0.333252 3.75938V6.56258H4.75631L2.65829 3.94005L3.34155 3.39345L6.00821 6.72678L6.22686 7.00008L6.00821 7.27339L3.34155 10.6067L2.65829 10.0601L4.75631 7.43758H0.333252V10.2401C0.333252 12.1419 0.333252 13.0927 0.945912 13.6166C1.55857 14.1405 2.49791 13.9929 4.37658 13.6977L7.69547 13.1762C8.63623 13.0283 9.10661 12.9544 9.3866 12.627C9.66658 12.2996 9.66658 11.8234 9.66658 10.8711V3.12839C9.66658 2.17609 9.66658 1.69993 9.3866 1.37251C9.10661 1.0451 8.63623 0.971179 7.69547 0.823345Z"
                                    fill="#5D697A"
                                />
                            </svg>
                        </div>
                        <p class="text-nowrap fs-14 fw-400 lh-17 text-para-text">{{__('Logout')}}</p>
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
