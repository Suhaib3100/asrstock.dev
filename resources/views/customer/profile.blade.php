@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush

@section('content')
    <!-- Main content -->
    <section class="admin-section">
        <div class="container">
            <div class="row rg-20">
                <div class="col-xl-3 col-lg-4 col-md-4">
                    @include('customer.layouts.sidebar')
                </div>
                <!--  -->
                <div class="col-xl-9 col-lg-8 col-md-8">
                    <div class="admin-section-right">
                        <div class="personalInfo-content">
                            <ul class="nav nav-tabs zTab-reset zTab-one flex-wrap flex-sm-nowrap" id="myTab"
                                role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="personalInformation-tab" data-bs-toggle="tab"
                                            data-bs-target="#personalInformation-tab-pane" type="button" role="tab"
                                            aria-controls="personalInformation-tab-pane" aria-selected="true">
                                        <div class="icon">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5.48131 12.9013C4.30234 13.6033 1.21114 15.0368 3.09389 16.8305C4.01359 17.7067 5.03791 18.3333 6.32573 18.3333H13.6743C14.9621 18.3333 15.9864 17.7067 16.9061 16.8305C18.7888 15.0368 15.6977 13.6033 14.5187 12.9013C11.754 11.2551 8.24599 11.2551 5.48131 12.9013Z"
                                                    stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                                <path
                                                    d="M13.75 5.41667C13.75 7.48773 12.0711 9.16667 10 9.16667C7.92893 9.16667 6.25 7.48773 6.25 5.41667C6.25 3.3456 7.92893 1.66667 10 1.66667C12.0711 1.66667 13.75 3.3456 13.75 5.41667Z"
                                                    stroke="#686B8B" stroke-width="1.5"/>
                                            </svg>
                                        </div>
                                        {{__('Personal Information')}}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="changePassword-tab" data-bs-toggle="tab"
                                            data-bs-target="#changePassword-tab-pane" type="button" role="tab"
                                            aria-controls="changePassword-tab-pane" aria-selected="false">
                                        <div class="icon">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.26781 18.8447C4.49269 20.515 5.87613 21.8235 7.55966 21.9009C8.97627 21.966 10.4153 22 12 22C13.5847 22 15.0237 21.966 16.4403 21.9009C18.1239 21.8235 19.5073 20.515 19.7322 18.8447C19.879 17.7547 20 16.6376 20 15.5C20 14.3624 19.879 13.2453 19.7322 12.1553C19.5073 10.485 18.1239 9.17649 16.4403 9.09909C15.0237 9.03397 13.5847 9 12 9C10.4153 9 8.97627 9.03397 7.55966 9.09909C5.87613 9.17649 4.49269 10.485 4.26781 12.1553C4.12105 13.2453 4 14.3624 4 15.5C4 16.6376 4.12105 17.7547 4.26781 18.8447Z"
                                                    stroke="#686B8B" stroke-width="1.5"/>
                                                <path
                                                    d="M7.5 9V6.5C7.5 4.01472 9.51472 2 12 2C14.4853 2 16.5 4.01472 16.5 6.5V9"
                                                    stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                                <path d="M16 15.49V15.5" stroke="#686B8B" stroke-width="2"
                                                      stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12 15.49V15.5" stroke="#686B8B" stroke-width="2"
                                                      stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M8 15.49V15.5" stroke="#686B8B" stroke-width="2"
                                                      stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        {{__('Change Password')}}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="deleteAccount-tab" data-bs-toggle="tab"
                                            data-bs-target="#deleteAccount-tab-pane" type="button" role="tab"
                                            aria-controls="deleteAccount-tab-pane" aria-selected="false">
                                        <div class="icon">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M19.5 5.5L18.8803 15.5251C18.7219 18.0864 18.6428 19.3671 18.0008 20.2879C17.6833 20.7431 17.2747 21.1273 16.8007 21.416C15.8421 22 14.559 22 11.9927 22C9.42312 22 8.1383 22 7.17905 21.4149C6.7048 21.1257 6.296 20.7408 5.97868 20.2848C5.33688 19.3626 5.25945 18.0801 5.10461 15.5152L4.5 5.5"
                                                    stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path
                                                    d="M3 5.5H21M16.0557 5.5L15.3731 4.09173C14.9196 3.15626 14.6928 2.68852 14.3017 2.39681C14.215 2.3321 14.1231 2.27454 14.027 2.2247C13.5939 2 13.0741 2 12.0345 2C10.9688 2 10.436 2 9.99568 2.23412C9.8981 2.28601 9.80498 2.3459 9.71729 2.41317C9.32164 2.7167 9.10063 3.20155 8.65861 4.17126L8.05292 5.5"
                                                    stroke="#686B8B" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M9.5 16.5V10.5" stroke="#686B8B" stroke-width="1.5"
                                                      stroke-linecap="round"/>
                                                <path d="M14.5 16.5V10.5" stroke="#686B8B" stroke-width="1.5"
                                                      stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                        {{__('Delete Account')}}
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="personalInformation-tab-pane" role="tabpanel"
                                     aria-labelledby="personalInformation-tab" tabindex="0">
                                    <form class="ajax" action="{{route('customer.profile.update')}}" method="POST"
                                          data-handler="commonResponseWithPageLoad">
                                        @csrf
                                        <div class="upload-img-box profileImage-upload mb-25">
                                            <div class="icon">
                                                <img src="{{asset('assets/images/icon/camera.svg')}}" alt=""/>
                                            </div>
                                            <img src="{{auth()->user()->image}}"/>
                                            <input type="file" name="image" id="zImageUpload" accept="image/*"
                                                   onchange="previewFile(this)"/>
                                        </div>
                                        <div class="personalInfo-input">
                                            <div class="row rg-25">
                                                <div class="col-lg-6">
                                                    <label for="firstName" class="zForm-label">{{__('First Name')}}
                                                        <span class="text-primary">*</span></label>
                                                    <input type="text" value="{{auth()->user()->first_name}}"
                                                           name="first_name" id="firstName" class="zForm-control"
                                                           placeholder="{{__('First Name')}}"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="lastName" class="zForm-label">{{__('Last Name')}} <span
                                                            class="text-primary">*</span></label>
                                                    <input type="text" value="{{auth()->user()->last_name}}"
                                                           name="last_name" id="lastName" class="zForm-control"
                                                           placeholder="{{__('Last Name')}}"/>
                                                </div>
                                                @if(auth()->user()->role == CUSTOMER_ROLE_CONTRIBUTOR)
                                                    <div class="col-lg-6">
                                                        <label class="zForm-label">{{__('Cover Photo')}}
                                                            @if(auth()->user()->cover_image_id)
                                                                <a target="_blank" href="{{auth()->user()->cover_image}}">{{__('View')}}</a>
                                                            @endif
                                                        </label>
                                                        <div class="file-upload-one">
                                                            <label for="cover_photo">
                                                                <p class="fileName fs-14 fw-400 lh-24 text-para-text">
                                                                    {{__('Choose File to upload')}}</p>
                                                                <p class="fs-14 fw-600 lh-24 text-white">{{__('Browse File')}}</p>
                                                            </label>
                                                            <input type="file" name="cover_photo" id="cover_photo"
                                                                   class="fileUploadInput invisible position-absolute top-0 w-100 h-100">
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-lg-6">
                                                    <label for="emailAddress"
                                                           class="zForm-label">{{__('Email Address')}} <span
                                                            class="text-primary">*</span></label>
                                                    <input type="email" value="{{auth()->user()->email}}" name="email"
                                                           id="emailAddress" class="zForm-control"
                                                           placeholder="{{__('Email')}}"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="phoneNumber" class="zForm-label">{{__('Phone Number')}}
                                                        <span class="text-primary">*</span></label>
                                                    <input type="text" value="{{auth()->user()->contact_number}}"
                                                           id="phoneNumber" name="contact_number" class="zForm-control"
                                                           placeholder="{{__('Contact Number')}}"/>
                                                </div>
                                                <div class="col-12">
                                                    <label for="addressInput"
                                                           class="zForm-label">{{__('Address')}}</label>
                                                    <input type="text" value="{{auth()->user()->address}}"
                                                           name="address" id="addressInput" class="zForm-control"
                                                           placeholder="{{__('Address')}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="zaiStock-btn">{{__('Update')}}</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="changePassword-tab-pane" role="tabpanel"
                                     aria-labelledby="changePassword-tab" tabindex="0">
                                    <form class="ajax" action="{{route('customer.profile.change_password')}}"
                                          method="POST"
                                          data-handler="commonResponse">
                                        @csrf
                                        <div class="personalInfo-input">
                                            <div class="row rg-25">
                                                <div class="col-12">
                                                    <label for="currentPassword"
                                                           class="zForm-label">{{__('Current Password')}}</label>
                                                    <input type="password" name="current_password" id="currentPassword"
                                                           class="zForm-control"
                                                           placeholder="{{__('Enter Current Password')}}"/>
                                                </div>
                                                <div class="col-12">
                                                    <label for="newPassword"
                                                           class="zForm-label">{{__('New Password')}}</label>
                                                    <input type="password" name="password" id="newPassword"
                                                           class="zForm-control"
                                                           placeholder="{{__('Enter New Password')}}"/>
                                                </div>
                                                <div class="col-12">
                                                    <label for="confirmPassword"
                                                           class="zForm-label">{{__('Confirm Password')}}</label>
                                                    <input type="password" name="password_confirmation"
                                                           id="confirmPassword" class="zForm-control"
                                                           placeholder="{{__('Enter Confirm Password')}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="zaiStock-btn">{{__('Update')}}</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="deleteAccount-tab-pane" role="tabpanel"
                                     aria-labelledby="deleteAccount-tab" tabindex="0">
                                    <div class="personalInfo-input">
                                        <div
                                            class="w-40 h-40 bd-ra-5 bg-red-light d-flex justify-content-center align-items-center mb-12">
                                            <img src="{{asset('assets/images/icon/userPanel-alert-icon.svg')}}"
                                                 alt=""/></div>
                                        <p class="fs-18 fw-400 lh-28 text-para-text">
                                            {{__('Are you absolutely sure that you want to delete your account?')}}
                                            <span
                                                class="text-primary-dark-text">{{__('Please note that there is no option to restore the account or its data nor reuse the username once it\'s deleted.')}}</span>
                                            {{__('If you click the button, we will send you an email with further
                                            instructions on deleting your account.')}}</p>
                                    </div>
                                    <button onclick="deleteItem('{{ route('customer.profile.delete_my_account') }}')"
                                            type="button" id="delete-account-btn"
                                            class="zaiStock-btn">{{__('Delete')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
