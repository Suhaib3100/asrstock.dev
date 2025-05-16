<div class="admin-section-left">
    @if(auth()->user()->contributor_status == CONTRIBUTOR_STATUS_APPROVED)
        <!-- Contributor Panel -->
        <div class="item">
            <button class="leftSidebar-btn" type="button" data-bs-toggle="collapse"
                    data-bs-target="#adminSectionLeft-one"
                    aria-expanded="false" aria-controls="adminSectionLeft-one">
                <p class="text">{{__('Contributor Panel')}}</p>
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="6" viewBox="0 0 8 6" fill="none">
                        <path
                            d="M4.79261 5.26867C4.39625 5.85712 3.53019 5.85712 3.13382 5.26867L0.971639 2.05866C0.524231 1.39443 1.00018 0.499999 1.80103 0.499999L6.1254 0.5C6.92625 0.5 7.4022 1.39443 6.95479 2.05866L4.79261 5.26867Z"
                            fill="#1F2224"/>
                    </svg>
                </div>
            </button>
            <div class="collapse" id="adminSectionLeft-one">
                <ul class="leftSidebar-content">
                    <li>
                        <a href="{{route('customer.products.create')}}" class="content {{$uploadProductActive ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M9.16699 18.3333C8.48516 18.3333 7.83382 18.0582 6.5311 17.5079C3.28836 16.1381 1.66699 15.4532 1.66699 14.3011C1.66699 13.9785 1.66699 8.38709 1.66699 5.83334M9.16699 18.3333V9.46234M9.16699 18.3333C9.77099 18.3333 10.2445 18.1174 11.2503 17.6855M16.667 5.83334V9.16667"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M12.5 14.5833H18.3333M15.4167 17.5V11.6667" stroke="#686B8B" stroke-width="1.5"
                                    stroke-linecap="round"/>
                              <path
                                  d="M6.10526 8.07615L3.67093 6.89821C2.33497 6.25175 1.66699 5.92852 1.66699 5.41666C1.66699 4.90481 2.33497 4.58158 3.67093 3.93512L6.10526 2.75718C7.60768 2.03017 8.35891 1.66666 9.16699 1.66666C9.97508 1.66666 10.7263 2.03016 12.2287 2.75718L14.6631 3.93512C15.999 4.58158 16.667 4.90481 16.667 5.41666C16.667 5.92852 15.999 6.25175 14.6631 6.89821L12.2287 8.07615C10.7263 8.80316 9.97508 9.16666 9.16699 9.16666C8.35891 9.16666 7.60768 8.80316 6.10526 8.07615Z"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M4.16699 10L5.83366 10.8333" stroke="#686B8B" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M13.3333 3.33334L5 7.5" stroke="#686B8B" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('Upload Product')}}</p>
                        </span>
                            <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('customer.products.index')}}" class="content {{$myProductActive ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M10 18.3333C9.31817 18.3333 8.66683 18.0538 7.36411 17.4949C4.12137 16.1036 2.5 15.4079 2.5 14.2378V6.45625M10 18.3333C10.6818 18.3333 11.3332 18.0538 12.6359 17.4949C15.8787 16.1036 17.5 15.4079 17.5 14.2378V6.45625M10 18.3333V10.1422M2.5 6.45625C2.5 6.95937 3.16797 7.27708 4.50393 7.9125L6.93827 9.07033C8.44067 9.78492 9.19192 10.1422 10 10.1422M2.5 6.45625C2.5 5.95313 3.16797 5.63542 4.50393 5M17.5 6.45625C17.5 6.95937 16.832 7.27708 15.4961 7.9125L13.0617 9.07033C11.5593 9.78492 10.8081 10.1422 10 10.1422M17.5 6.45625C17.5 5.95313 16.832 5.63542 15.4961 5M5.27669 11.0925L6.93826 11.8828"
                                  stroke="#686B8B"
                                  stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                              />
                              <path
                                  d="M10.0003 1.66667V3.33334M13.3337 2.50001L12.0837 4.16667M6.66699 2.50001L7.91699 4.16667"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('My Products')}}</p>
                        </span>
                            <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('customer.sales')}}" class="content {{$saleActive ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M14.583 4.16667C15.2733 4.16667 15.833 4.72631 15.833 5.41667C15.833 6.10703 15.2733 6.66667 14.583 6.66667C13.8927 6.66667 13.333 6.10703 13.333 5.41667C13.333 4.72631 13.8927 4.16667 14.583 4.16667Z"
                                  stroke="#686B8B" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                              <path
                                  d="M2.31219 9.28659C1.47623 10.2203 1.45824 11.6288 2.22546 12.6198C3.74792 14.5861 5.41428 16.2524 7.3806 17.7748C8.3715 18.5421 9.78008 18.5241 10.7137 17.6882C13.2486 15.4185 15.5699 13.0466 17.8102 10.4399C18.0317 10.1823 18.1702 9.86642 18.2013 9.52801C18.3388 8.03166 18.6213 3.72056 17.4506 2.54979C16.2797 1.37901 11.9687 1.66148 10.4723 1.79897C10.1339 1.83007 9.81808 1.96861 9.56033 2.1901C6.95376 4.43039 4.58184 6.75176 2.31219 9.28659Z"
                                  stroke="#686B8B" stroke-width="1.25"/>
                              <path
                                  d="M11.49 10.3055C11.5078 9.97133 11.6015 9.36 11.0934 8.89542M11.0934 8.89542C10.9362 8.75167 10.7213 8.62192 10.4288 8.51875C9.38159 8.1497 8.09538 9.385 9.00526 10.5157C9.49434 11.1235 9.87143 11.3105 9.83593 12.0007C9.81093 12.4862 9.33401 12.9935 8.70543 13.1867C8.15934 13.3546 7.55698 13.1323 7.17598 12.7066C6.71078 12.1868 6.75776 11.6967 6.75378 11.4832M11.0934 8.89542L11.6668 8.32199M7.21744 12.7714L6.67285 13.316"
                                  stroke="#686B8B" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('All Sales')}}</p>
                        </span>
                            <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                        </a>
                    </li>
                    @if(isAddonInstalled('PIXELDONATION'))
                        @if(getOption('donation_status', false))
                            <li>
                                <a href="{{route('customer.donations')}}" class="content {{$saleDonation ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M14.583 4.16667C15.2733 4.16667 15.833 4.72631 15.833 5.41667C15.833 6.10703 15.2733 6.66667 14.583 6.66667C13.8927 6.66667 13.333 6.10703 13.333 5.41667C13.333 4.72631 13.8927 4.16667 14.583 4.16667Z"
                                  stroke="#686B8B" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                              <path
                                  d="M2.31219 9.28659C1.47623 10.2203 1.45824 11.6288 2.22546 12.6198C3.74792 14.5861 5.41428 16.2524 7.3806 17.7748C8.3715 18.5421 9.78008 18.5241 10.7137 17.6882C13.2486 15.4185 15.5699 13.0466 17.8102 10.4399C18.0317 10.1823 18.1702 9.86642 18.2013 9.52801C18.3388 8.03166 18.6213 3.72056 17.4506 2.54979C16.2797 1.37901 11.9687 1.66148 10.4723 1.79897C10.1339 1.83007 9.81808 1.96861 9.56033 2.1901C6.95376 4.43039 4.58184 6.75176 2.31219 9.28659Z"
                                  stroke="#686B8B" stroke-width="1.25"/>
                              <path
                                  d="M11.49 10.3055C11.5078 9.97133 11.6015 9.36 11.0934 8.89542M11.0934 8.89542C10.9362 8.75167 10.7213 8.62192 10.4288 8.51875C9.38159 8.1497 8.09538 9.385 9.00526 10.5157C9.49434 11.1235 9.87143 11.3105 9.83593 12.0007C9.81093 12.4862 9.33401 12.9935 8.70543 13.1867C8.15934 13.3546 7.55698 13.1323 7.17598 12.7066C6.71078 12.1868 6.75776 11.6967 6.75378 11.4832M11.0934 8.89542L11.6668 8.32199M7.21744 12.7714L6.67285 13.316"
                                  stroke="#686B8B" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('All Donations')}}</p>
                        </span>
                                    <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                                </a>
                            </li>
                        @endif
                    @endif
                    <li>
                        <a href="{{route('customer.downloads')}}" class="content {{$downloadActive ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M5.3125 12.5C3.76925 12.4387 2.45883 11.1526 2.501 9.42967C2.51083 9.02883 2.6505 8.53342 2.93 7.5426C3.60267 5.15801 4.73309 3.08796 7.26542 2.5913C7.73084 2.5 8.25467 2.5 9.30225 2.5L10.6978 2.5C11.7453 2.5 12.2691 2.5 12.7346 2.5913C15.267 3.08796 16.3974 5.15801 17.07 7.5426C17.3495 8.53342 17.4892 9.02883 17.499 9.42967C17.5412 11.1526 16.2308 12.4387 14.6875 12.5"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"/>
                              <path
                                  d="M9.99967 17.5L9.99967 8.33333M9.99967 17.5C10.5832 17.5 11.6734 15.8381 12.083 15.4167M9.99967 17.5C9.41617 17.5 8.32592 15.8381 7.91634 15.4167"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('All Download')}}</p>
                        </span>
                            <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('customer.my_earning')}}" class="content {{$myEarningActive ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M15.3476 6.79014C15.3476 4.881 12.9535 3.33334 10.0003 3.33334C7.04713 3.33334 4.6531 4.881 4.6531 6.79014C4.6531 8.69926 6.11143 9.75309 10.0003 9.75309C13.8892 9.75309 15.8337 10.7408 15.8337 13.2099C15.8337 15.679 13.222 16.6667 10.0003 16.6667C6.77867 16.6667 4.16699 15.119 4.16699 13.2099"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"/>
                              <path d="M10 1.66666V18.3333" stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('My Earnings')}}</p>
                        </span>
                            <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    @endif
    <!-- User Panel -->
    <div class="item">
        <button class="leftSidebar-btn" type="button" data-bs-toggle="collapse" data-bs-target="#adminSectionLeft-two"
                aria-expanded="false" aria-controls="adminSectionLeft-two">
            <p class="text">{{__('User Panel')}}</p>
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="6" viewBox="0 0 8 6" fill="none">
                    <path
                        d="M4.79261 5.26867C4.39625 5.85712 3.53019 5.85712 3.13382 5.26867L0.971639 2.05866C0.524231 1.39443 1.00018 0.499999 1.80103 0.499999L6.1254 0.5C6.92625 0.5 7.4022 1.39443 6.95479 2.05866L4.79261 5.26867Z"
                        fill="#1F2224"/>
                </svg>
            </div>
        </button>
        <div class="collapse" id="adminSectionLeft-two">
            <ul class="leftSidebar-content">
                <li>
                    <a href="{{route('customer.favourite')}}" class="content {{$activeFavorite ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M16.2192 3.32846C13.9844 1.95769 12.034 2.51009 10.8623 3.39001C10.3818 3.7508 10.1417 3.93119 10.0003 3.93119C9.85899 3.93119 9.61882 3.7508 9.13832 3.39001C7.96667 2.51009 6.01623 1.95769 3.78152 3.32846C0.848716 5.12745 0.185092 11.0624 6.94993 16.0695C8.23842 17.0232 8.88266 17.5 10.0003 17.5C11.118 17.5 11.7622 17.0232 13.0507 16.0695C19.8156 11.0624 19.1519 5.12745 16.2192 3.32846Z"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('Favorites')}}</p>
                        </span>
                        <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('customer.my_downloads')}}" class="content {{$downloadMyActive ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M5.3125 12.5C3.76925 12.4387 2.45883 11.1526 2.501 9.42967C2.51083 9.02883 2.6505 8.53342 2.93 7.5426C3.60267 5.15801 4.73309 3.08796 7.26542 2.5913C7.73084 2.5 8.25467 2.5 9.30225 2.5L10.6978 2.5C11.7453 2.5 12.2691 2.5 12.7346 2.5913C15.267 3.08796 16.3974 5.15801 17.07 7.5426C17.3495 8.53342 17.4892 9.02883 17.499 9.42967C17.5412 11.1526 16.2308 12.4387 14.6875 12.5"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"/>
                              <path
                                  d="M9.99967 17.5L9.99967 8.33333M9.99967 17.5C10.5832 17.5 11.6734 15.8381 12.083 15.4167M9.99967 17.5C9.41617 17.5 8.32592 15.8381 7.91634 15.4167"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('My Download')}}</p>
                        </span>
                        <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('customer.my_purchase')}}" class="content {{$myPurchaseActive ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M16.667 10.4167C16.6462 10.3447 16.6252 10.2717 16.604 10.1978C15.7399 7.19769 14.58 6.25 11.1912 6.25H8.04215C4.78807 6.25 3.52932 7.0733 2.62941 10.1978C1.81885 13.012 1.41358 14.4191 1.83729 15.5103C2.09679 16.1786 2.55751 16.7581 3.16111 17.1753C4.31008 17.9697 7.19355 18.3651 10.0003 18.3313"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"/>
                              <path
                                  d="M5.83301 6.66666V5.30302C5.83301 3.29471 7.51194 1.66666 9.58301 1.66666C11.6541 1.66666 13.333 3.29471 13.333 5.30302V6.66666"
                                  stroke="#686B8B" stroke-width="1.5"/>
                              <path
                                  d="M11.667 15.8333C11.667 15.8333 12.5003 15.8333 13.3337 17.5C13.3337 17.5 15.9807 13.3333 18.3337 12.5"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M8.75 9.16666H10.4167" stroke="#686B8B" stroke-width="1.5"
                                    stroke-linecap="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('My Purchases')}}</p>
                        </span>
                        <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('customer.followings')}}" class="content {{$activeFollowing ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M4.31705 12.747C3.26907 13.3612 0.521335 14.6155 2.19489 16.185C3.01241 16.9517 3.92291 17.5 5.06763 17.5H11.5997C12.7444 17.5 13.6549 16.9517 14.4724 16.185C16.146 14.6155 13.3982 13.3612 12.3502 12.747C9.89274 11.3066 6.77454 11.3066 4.31705 12.747Z"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path
                                  d="M11.6667 5.83333C11.6667 7.67428 10.1742 9.16667 8.33333 9.16667C6.49238 9.16667 5 7.67428 5 5.83333C5 3.99238 6.49238 2.5 8.33333 2.5C10.1742 2.5 11.6667 3.99238 11.6667 5.83333Z"
                                  stroke="#686B8B" stroke-width="1.5"/>
                              <path d="M16.2503 3.33331V7.49998M18.3337 5.41665H14.167" stroke="#686B8B"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('Following')}}</p>
                        </span>
                        <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('customer.boards.index')}}" class="content {{$activeBoard ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M12.0837 5.83331H7.91699C5.17743 5.83331 3.80764 5.83331 2.88568 6.58995C2.7169 6.72846 2.56214 6.88322 2.42363 7.052C1.66699 7.97396 1.66699 9.34373 1.66699 12.0833C1.66699 14.8229 1.66699 16.1926 2.42363 17.1146C2.56214 17.2834 2.7169 17.4381 2.88568 17.5766C3.80764 18.3333 5.17743 18.3333 7.91699 18.3333H12.0837C14.8232 18.3333 16.193 18.3333 17.115 17.5766C17.2837 17.4381 17.4385 17.2834 17.577 17.1146C18.3337 16.1926 18.3337 14.8229 18.3337 12.0833C18.3337 9.34373 18.3337 7.97396 17.577 7.052C17.4385 6.88322 17.2837 6.72846 17.115 6.58995C16.193 5.83331 14.8232 5.83331 12.0837 5.83331Z"
                                  stroke="#686B8B"
                                  stroke-width="1.5"
                                  stroke-linecap="round"
                              />
                              <path
                                  d="M10 5.83335V4.16669C10 3.70645 10.3731 3.33335 10.8333 3.33335C11.2936 3.33335 11.6667 2.96025 11.6667 2.50002V1.66669"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M5.83301 10H6.66634" stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"/>
                              <path d="M9.58301 10H10.4163" stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"/>
                              <path d="M13.333 10H14.1663" stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"/>
                              <path d="M5.83301 14.1667H14.1663" stroke="#686B8B" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('Boards')}}</p>
                        </span>
                        <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('customer.profile.index')}}" class="content {{$profileActive ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M5.48131 12.9013C4.30234 13.6033 1.21114 15.0367 3.09389 16.8305C4.01359 17.7066 5.03791 18.3333 6.32573 18.3333H13.6743C14.9621 18.3333 15.9864 17.7066 16.9061 16.8305C18.7888 15.0367 15.6977 13.6033 14.5187 12.9013C11.754 11.2551 8.24599 11.2551 5.48131 12.9013Z"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path
                                  d="M13.75 5.41669C13.75 7.48775 12.0711 9.16669 10 9.16669C7.92893 9.16669 6.25 7.48775 6.25 5.41669C6.25 3.34562 7.92893 1.66669 10 1.66669C12.0711 1.66669 13.75 3.34562 13.75 5.41669Z"
                                  stroke="#686B8B" stroke-width="1.5"/>
                            </svg>
                          </div>
                          <p class="text">{{__('Profile')}}</p>
                        </span>
                        <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('customer.wallets.index')}}" class="content {{$activeWallet ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M2.5 7.08331H12.5C14.857 7.08331 16.0355 7.08331 16.7677 7.81555C17.5 8.54781 17.5 9.72631 17.5 12.0833V12.9166C17.5 15.2736 17.5 16.4521 16.7677 17.1844C16.0355 17.9166 14.857 17.9166 12.5 17.9166H7.5C5.14297 17.9166 3.96447 17.9166 3.23223 17.1844C2.5 16.4521 2.5 15.2736 2.5 12.9166V7.08331Z"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round"/>
                              <path
                                  d="M12.5 7.08192V3.42523C12.5 2.68411 11.8992 2.08331 11.1581 2.08331C10.9447 2.08331 10.7343 2.13421 10.5445 2.2318L3.13525 6.04104C2.7452 6.24157 2.5 6.64334 2.5 7.08192"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('Wallet')}}</p>
                        </span>
                        <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                    </a>
                </li>

                @if(isAddonInstalled('PIXELAFFILIATE'))
                    @if (getOption('referral_status') == 1)
                        <li>
                            <a href="{{route('customer.referral.index')}}" class="content {{$referralActive ?? ''}}">
                        <span class="left">
                         <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                                    <g clip-path="url(#clip0_962_899)">
                                    <mask id="mask0_962_899" style="mask-type:luminance" maskUnits="userSpaceOnUse"
                                          x="0" y="0" width="20" height="20">
                                    <path d="M0 1.90735e-06H20V20H0V1.90735e-06Z" fill="white"/>
                                    </mask>
                                    <g mask="url(#mask0_962_899)">
                                    <path
                                        d="M3.57574 15.7715C1.92453 15.7715 0.585938 17.1101 0.585938 18.7613V19.4141H6.56551V18.7613C6.56551 17.1101 5.22695 15.7715 3.57574 15.7715Z"
                                        stroke="#686B8B" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                    <path
                                        d="M5.33398 14.0137C5.33398 14.9845 4.54699 15.7715 3.57617 15.7715C2.60535 15.7715 1.81836 14.9845 1.81836 14.0137C1.81836 13.0429 2.60535 12.2559 3.57617 12.2559C4.54699 12.2559 5.33398 13.0429 5.33398 14.0137Z"
                                        stroke="#686B8B" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                    <path
                                        d="M16.4243 15.7715C14.7731 15.7715 13.4346 17.1101 13.4346 18.7613V19.4141H19.4141V18.7613C19.4141 17.1101 18.0755 15.7715 16.4243 15.7715Z"
                                        stroke="#686B8B" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                    <path
                                        d="M18.1826 14.0137C18.1826 14.9845 17.3956 15.7715 16.4248 15.7715C15.454 15.7715 14.667 14.9845 14.667 14.0137C14.667 13.0429 15.454 12.2559 16.4248 12.2559C17.3956 12.2559 18.1826 13.0429 18.1826 14.0137Z"
                                        stroke="#686B8B" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                    <path
                                        d="M9.99957 4.10156C8.34836 4.10156 7.00977 5.44016 7.00977 7.09133V7.74414H12.9894V7.09133C12.9894 5.44016 11.6508 4.10156 9.99957 4.10156Z"
                                        stroke="#686B8B" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                    <path
                                        d="M11.7578 2.34375C11.7578 3.31457 10.9708 4.10156 10 4.10156C9.02918 4.10156 8.24219 3.31457 8.24219 2.34375C8.24219 1.37293 9.02918 0.585938 10 0.585938C10.9708 0.585938 11.7578 1.37293 11.7578 2.34375Z"
                                        stroke="#686B8B" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                    <path
                                        d="M7.4707 15.3902C8.25117 15.6371 9.0918 15.7715 9.96836 15.7715C10.8766 15.7715 11.7465 15.6273 12.5504 15.3633"
                                        stroke="#686B8B" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                    <path
                                        d="M5.00559 5.27771C4.41625 5.84579 3.89703 6.52044 3.47879 7.29079C3.04543 8.08896 2.75699 8.92224 2.60547 9.7547"
                                        stroke="#686B8B" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                    <path
                                        d="M17.3943 9.7547C17.2427 8.9222 16.9543 8.08892 16.521 7.29079C16.1027 6.52044 15.5835 5.84579 14.9941 5.27771"
                                        stroke="#686B8B" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_962_899">
                                    <rect width="20" height="20" fill="white"/>
                                    </clipPath>
                                    </defs>
                                    </svg>
                        </div>
                          <p class="text">{{__('Referral')}}</p>
                        </span>
                                <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                            </a>
                        </li>
                    @endif
                @endif
                @if(auth()->user()->contributor_status != CONTRIBUTOR_STATUS_APPROVED)
                    <li>
                        <a href="{{route('customer.my_earning')}}" class="content {{$myEarningActive ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M15.3476 6.79014C15.3476 4.881 12.9535 3.33334 10.0003 3.33334C7.04713 3.33334 4.6531 4.881 4.6531 6.79014C4.6531 8.69926 6.11143 9.75309 10.0003 9.75309C13.8892 9.75309 15.8337 10.7408 15.8337 13.2099C15.8337 15.679 13.222 16.6667 10.0003 16.6667C6.77867 16.6667 4.16699 15.119 4.16699 13.2099"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"/>
                              <path d="M10 1.66666V18.3333" stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('My Earnings')}}</p>
                        </span>
                            <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{route('customer.devices.index')}}" class="content {{$deviceActive ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M11.667 2.5H8.33366C5.19096 2.5 3.61962 2.5 2.6433 3.47631C1.66699 4.45262 1.66699 6.02397 1.66699 9.16667C1.66699 12.3093 1.66699 13.8807 2.6433 14.857C3.61962 15.8333 5.19096 15.8333 8.33366 15.8333H11.667C14.8097 15.8333 16.3811 15.8333 17.3573 14.857C18.3337 13.8807 18.3337 12.3093 18.3337 9.16667C18.3337 6.02397 18.3337 4.45262 17.3573 3.47631C16.3811 2.5 14.8097 2.5 11.667 2.5Z"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"/>
                              <path d="M15 15.8333L15.8333 17.5" stroke="#686B8B" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M5.00033 15.8333L4.16699 17.5" stroke="#686B8B" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('Devices')}}</p>
                        </span>
                        <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('customer.orders.my_order_list')}}" class="content {{$orderActive ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M3.33301 15.5382V6.7119C3.33301 4.33356 3.33301 3.1444 4.06524 2.40555C4.79747 1.66669 5.97598 1.66669 8.33301 1.66669H11.6663C14.0233 1.66669 15.2018 1.66669 15.9341 2.40555C16.6663 3.1444 16.6663 4.33356 16.6663 6.7119V15.5382C16.6663 16.7979 16.6663 17.4278 16.2813 17.6757C15.6523 18.0809 14.6798 17.2312 14.1906 16.9228C13.7864 16.6679 13.5844 16.5404 13.3601 16.5331C13.1178 16.5251 12.9121 16.6474 12.4754 16.9228L10.883 17.927C10.4534 18.1979 10.2387 18.3334 9.99967 18.3334C9.76067 18.3334 9.54592 18.1979 9.11634 17.927L7.52395 16.9228C7.1198 16.6679 6.91772 16.5404 6.69345 16.5331C6.45111 16.5251 6.24545 16.6474 5.80873 16.9228C5.31963 17.2312 4.34707 18.0809 3.71797 17.6757C3.33301 17.4278 3.33301 16.7979 3.33301 15.5382Z"
                                  stroke="#686B8B"
                                  stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                              />
                              <path d="M13.3337 5H6.66699" stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"/>
                              <path d="M8.33366 8.33331H6.66699" stroke="#686B8B" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                              <path
                                  d="M12.083 8.22917C11.3927 8.22917 10.833 8.71883 10.833 9.32292C10.833 9.927 11.3927 10.4167 12.083 10.4167C12.7733 10.4167 13.333 10.9063 13.333 11.5104C13.333 12.1145 12.7733 12.6042 12.083 12.6042M12.083 8.22917C12.6273 8.22917 13.0903 8.5335 13.2618 8.95833M12.083 8.22917V7.5M12.083 12.6042C11.5388 12.6042 11.0758 12.2998 10.9042 11.875M12.083 12.6042V13.3333"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('Order History')}}</p>
                        </span>
                        <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('customer.subscriptions.my_subscription')}}"
                       class="content {{$mySubscriptionActive ?? ''}}">
                        <span class="left">
                          <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                              <path
                                  d="M10.4544 8.10184H11.2372C12.1018 8.10184 12.8028 8.8066 12.8028 9.67594M12.8028 9.67594V10.4629M12.8028 9.67594C12.8028 9.24127 13.1533 8.88885 13.5856 8.88885C14.4503 8.88885 15.1513 9.5936 15.1513 10.4629M15.1513 10.4629V11.2499M15.1513 10.4629C15.1513 10.0509 15.5192 9.73752 15.9234 9.80527L16.1914 9.85019C16.9463 9.97669 17.4997 10.6334 17.4997 11.4029L17.4993 11.7748C17.4993 13.4853 17.4993 14.3405 17.2402 15.0214C17.0898 15.4164 16.6933 15.9201 16.3762 16.2841C16.1018 16.5989 15.9338 16.9983 15.9338 17.4168V18.3334M10.4543 9.67594V5.34723C10.4543 4.69524 9.92851 4.16669 9.28001 4.16669C8.63151 4.16669 8.10581 4.69524 8.10581 5.34723L8.10565 11.6139L6.83726 10.3347C6.28074 9.77335 5.36403 9.8246 4.87237 10.4444C4.49617 10.9187 4.48578 11.5896 4.84711 12.0755L7.66498 15.6944C8.20412 16.3868 8.49709 17.454 8.49709 18.3334"
                                  stroke="#686B8B"
                                  stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                              />
                              <path
                                  d="M5.00033 6.66669H4.31405C3.06622 6.66669 2.4423 6.66669 2.05464 6.30057C1.66699 5.93445 1.66699 5.3452 1.66699 4.16669C1.66699 2.98818 1.66699 2.39892 2.05464 2.0328C2.4423 1.66669 3.06622 1.66669 4.31405 1.66669H14.0199C15.2677 1.66669 15.8917 1.66669 16.2793 2.0328C16.667 2.39892 16.667 2.98818 16.667 4.16669C16.667 5.3452 16.667 5.93445 16.2793 6.30057C15.8917 6.66669 15.2677 6.66669 14.0199 6.66669H13.3337"
                                  stroke="#686B8B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          </div>
                          <p class="text">{{__('My Subscription')}}</p>
                        </span>
                        <span class="right d-flex"><i class="fa-solid fa-angle-right"></i></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
