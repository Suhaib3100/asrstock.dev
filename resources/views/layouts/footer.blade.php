<!-- Start Footer -->
<section class="footer-section">
    <div class="footer-overlay" data-background="{{asset('assets/images/footer-grid-bg.png')}}">
        <div class="container">
            <div class="footer-subscribe">
                <h4 class="title">{{ getOption('footer_news_letter_title') }}</h4>
                <p class="info">{{ getOption('footer_news_letter_description') }}</p>
                <form class="ajax reset" data-handler="commonResponse" action="{{route('frontend.newsletter')}}"
                      method="POST">
                    <div class="subscribe-form">
                        @csrf
                        <input required type="email" name="email" placeholder="{{__('Enter your email address')}}"/>
                        <button type="submit" class="zaiStock-hover">{{__('Subscribe Now')}}</button>
                    </div>
                </form>
            </div>
            <div class="footer-top">
                <div class="row rg-20 justify-content-between">
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6 order-0">
                        <h4 class="footer-menu-title">{{__('Company')}}</h4>
                        <ul class="footer-menu">
                            <li><a href="{{ route('frontend.blogs.list') }}" class="link">{{__('Blog')}}</a></li>
                            <li><a href="{{route('frontend.about-us')}}" class="link">{{__('About Us')}}</a></li>
                            <li><a href="{{ route('frontend.pricing') }}" class="link">{{__('Pricing')}}</a></li>
                            <li><a href="{{ route('frontend.contact-us') }}" class="link">{{__('Contact Us')}}</a></li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-7 col-12 order-2 order-sm-1">
                        <h4 class="footer-menu-title">{{__('Content')}}</h4>
                        <div class="row rg-12">
                            <div class="col-6">
                                <ul class="footer-menu">
                            @foreach($productType->take(5) as $data)
                                <li><a href="{{ route('frontend.product_category',$data->uuid) }}"
                                       class="link">{{ $data->name }}</a></li>
                            @endforeach
                        </ul>
                            </div>
                            <div class="col-6">
                                <ul class="footer-menu">
                            @foreach($productType->skip(5) as $data)
                                <li><a href="{{ route('frontend.product_category',$data->uuid) }}"
                                       class="link">{{ $data->name }}</a></li>
                            @endforeach
                        </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6 order-1 order-sm-2">
                        <h4 class="footer-menu-title">{{__('Policy')}}</h4>
                        <ul class="footer-menu">
                            <li><a href="{{ route('frontend.page',COOKIE_POLICY) }}"
                                   class="link {{ @$activePage }}">{{__('Cookie policy')}}</a></li>
                            <li><a href="{{ route('frontend.page',PRIVACY_POLICY) }}"
                                   class="link {{@$activePage}}">{{__('Privacy policy')}} </a></li>
                            <li><a href="{{ route('frontend.page',TERMS_AND_CONDITION) }}"
                                   class="link {{@$activePage}}">{{__('Terms & condition')}}</a></li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-12 col-sm-7 order-3">
                        <h4 class="footer-menu-title">{{__('Contact Us')}}</h4>
                        <ul class="zList-pb-12">
                            <li><p class="fs-16 fw-400 lh-26 text-footer-menu-text">{{__('Location')}}
                                    : {{ getOption('app_location') }}</p></li>
                            <li><p class="fs-16 fw-400 lh-26 text-footer-menu-text">{{__('Email')}}
                                    : {{ getOption('app_email') }}</p></li>
                            <li><p class="fs-16 fw-400 lh-26 text-footer-menu-text">{{__('Phone')}}
                                    : {{ getOption('app_contact_number') }}</p></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row rg-20 align-items-center">
                    <div class="col-lg-6">
                        <p class="text">{{ getOption('app_copyright') }} | <a href="{{ getOption('develop_by_link') }}"
                                                                              target="_blank"
                                                                              class="link">{{ getOption('develop_by') }}</a>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <ul class="footer-social justify-content-lg-end">
                            <li>
                                <a href="{{ getOption('facebook_url') }}"><i class="fa-brands fa-facebook-f"></i></a>
                            </li>
                            <li>
                                <a href="{{ getOption('linkedin_url') }}"><i class="fa-brands fa-linkedin-in"></i></a>
                            </li>
                            <li>
                                <a href="{{ getOption('instagram_url') }}"><i class="fa-brands fa-instagram"></i></a>
                            </li>
                            <li class="d-none">
                                <a href="{{ getOption('twitter_url') }}"><i class="fa-brands fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="{{ getOption('pinterest_url') }}"><i class="fa-brands fa-pinterest-p"></i></a>
                            </li>
                            <li>
                                <a href="{{ getOption('tiktok_url') }}"><i class="fa-brands fa-tiktok"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Footer -->
