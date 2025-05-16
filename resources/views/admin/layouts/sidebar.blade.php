<!-- Sidebar -->
<div data-aos="fade-right" data-aos-duration="1000" class="zSidebar">
    <div class="zSidebar-overlay"></div>
    <div class="zSidebar-wrap h-100">
        <!-- Logo -->
        <a href="{{ route('admin.dashboard') }}" class="zSidebar-logo">
            <img class="max-h-30 max-w-150" src="{{ getSettingImage('app_logo') }}" alt=""/>
        </a>
        <!-- Menu & Logout -->
        <div class="zSidebar-fixed">
            <ul class="zSidebar-menu" id="sidebarMenu">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                       class="d-flex align-items-center cg-10 {{ @$navDashboard }}">
                        <span class="d-flex">
                            <span class="iconify" data-icon="bxs:dashboard"></span>
                        </span>
                        <span class="">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                @canany(['all_contributor','pending_contributor','approve_contributor','hold_contributor','cancel_contributor'])
                    <li>
                        <a href="#"
                           class="d-flex align-items-center cg-10 {{ isset($showContributor) ? 'active' : 'collapsed' }}"
                           data-bs-toggle="collapse" data-bs-target="#collapseExampleContributor"
                           aria-expanded="{{ isset($showContributor) ? 'true' : 'false' }}"
                           aria-controls="collapseExampleContributor">
                            <div class="d-flex">
                                <span class="iconify" data-icon="mdi:user-check-outline"></span>
                            </div>
                            <span class="">{{ __('Contributor') }}</span>
                        </a>
                        <div class="collapse {{ $showContributor ?? '' }}" id="collapseExampleContributor"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                @can('all_contributor')
                                    <li>
                                        <a href="{{ route('admin.contributor.index') }}"
                                           class="{{ @$subNavAllContributorActiveClass ? 'active' : '' }}">{{ __('All Contributor') }}</a>
                                    </li>
                                @endcan
                                @can('pending_contributor')
                                    <li>
                                        <a href="{{ route('admin.contributor.index', CONTRIBUTOR_STATUS_PENDING) }}"
                                           class="{{ @$subNavPendingContributorActiveClass ? 'active' : '' }}">{{ __('Pending Contributor') }}</a>
                                    </li>
                                @endcan
                                @can('approve_contributor')
                                    <li>
                                        <a href="{{ route('admin.contributor.index', CONTRIBUTOR_STATUS_APPROVED) }}"
                                           class="{{ @$subNavApprovedContributorActiveClass ? 'active' : '' }}">{{ __('Approve Contributor') }} </a>
                                    </li>
                                @endcan
                                @can('hold_contributor')
                                    <li>
                                        <a href="{{ route('admin.contributor.index', CONTRIBUTOR_STATUS_HOLD) }}"
                                           class="{{ @$subNavHoldContributorActiveClass ? 'active' : '' }}">{{ __('Hold Contributor') }}</a>
                                    </li>
                                @endcan
                                @can('cancel_contributor')
                                    <li>
                                        <a href="{{ route('admin.contributor.index', CONTRIBUTOR_STATUS_CANCELLED) }}"
                                           class="{{ @$subNavCancelledContributorActiveClass ? 'active' : '' }}">{{ __('Cancel Contributor') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['manage_customer','all_customer','active_customer','pending_customer', 'disable_customer'])
                    <li>
                        <a href="#"
                           class="d-flex align-items-center cg-10 {{ isset($showCustomer) ? 'active' : 'collapsed' }}"
                           data-bs-toggle="collapse" data-bs-target="#collapseExampleCustomer"
                           aria-expanded="{{ isset($showCustomer) ? 'true' : 'false' }}"
                           aria-controls="collapseExampleCustomer">
                            <div class="d-flex">
                                <span class="iconify" data-icon="mdi:user-multiple-check-outline"></span>
                            </div>
                            <span class="">{{ __('Customer') }}</span>
                        </a>
                        <div class="collapse {{ $showCustomer ?? '' }}" id="collapseExampleCustomer"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                @can('all_customer')
                                    <li>
                                        <a href="{{ route('admin.customer.index') }}"
                                           class="{{ @$subNavAllCustomerActiveClass ? 'active' : '' }}">{{ __('All Customer') }}</a>
                                    </li>
                                @endcan
                                @can('active_customer')
                                    <li>
                                        <a href="{{ route('admin.customer.index', ACTIVE) }}"
                                           class="{{ @$subNavActiveCustomerActiveClass ? 'active' : '' }}">{{ __('Active Customer') }}</a>
                                    </li>
                                @endcan
                                @can('pending_customer')
                                    <li>
                                        <a href="{{ route('admin.customer.index', PENDING) }}"
                                           class="{{ @$subNavPendingCustomerActiveClass ? 'active' : '' }}">{{ __('Pending Customer') }}</a>
                                    </li>
                                @endcan
                                @can('disable_customer')
                                    <li>
                                        <a href="{{ route('admin.customer.index', DISABLE) }}"
                                           class="{{ @$subNavDisableCustomerActiveClass ? 'active' : '' }}">{{ __('Disable Customer') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['manage_products','product_setting','all_products','add_new_product','in_house_products','contributor_products','published_products','pending_product','hold_product','product_type','category','tags','product_comment'])
                    <li>
                        <a href="#"
                           class="d-flex align-items-center cg-10 {{ isset($showProducts) ? 'active' : 'collapsed' }}"
                           data-bs-toggle="collapse" data-bs-target="#collapseExampleProducts"
                           aria-expanded="{{ isset($showProducts) ? 'true' : 'false' }}"
                           aria-controls="collapseExampleProducts">
                            <div class="d-flex">
                                <span class="iconify" data-icon="ri:product-hunt-line"></span>
                            </div>
                            <span class="">{{ __('Products') }}</span>
                        </a>
                        <div class="collapse {{ $showProducts ?? '' }}" id="collapseExampleProducts"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                @can('product_setting')
                                    <li class="">
                                        <a class="{{ @$subNavProductSettingActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.product.setting') }}">
                                            {{ __('Product Setting') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('all_products')
                                    <li class="">
                                        <a class="{{ @$subNavAllProductsActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.product.status') }}">
                                            {{ __('All Products') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('add_new_product')
                                    <li class="">
                                        <a class="{{ @$subNavAddProductActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.product.create') }}">
                                            {{ __('Add New Product') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('in_house_products')
                                    <li class="">
                                        <a class="{{ @$subNavAdminProductsActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.product.status',4) }}">
                                            {{ __('In House Products') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('contributor_products')
                                    <li class="">
                                        <a class="{{ @$subNavContributorProductsActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.product.status',5) }}">
                                            {{ __('Contributor Products') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('published_products')
                                    <li class="">
                                        <a class="{{ @$subNavPublishedProductsActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.product.status', PRODUCT_STATUS_PUBLISHED) }}">
                                            {{ __('Published Product') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('pending_product')
                                    <li class="">
                                        <a class="{{ @$subNavPendingProductsActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.product.status', PRODUCT_STATUS_PENDING) }}">
                                            {{ __('Pending Product') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('hold_product')
                                    <li class="">
                                        <a class="{{ @$subNavHoldProductsActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.product.status', PRODUCT_STATUS_HOLD) }}">
                                            {{ __('Hold Product') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('product_type')
                                    <li class="">
                                        <a class="{{ @$subNavProductTypeActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.product.product-type.index') }}">
                                            {{ __('Product Type') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('category')
                                    <li class="">
                                        <a class="{{ @$subNavCategoryIndexActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.product.category.index') }}">
                                            {{ __('Category') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('tags')
                                    <li>
                                        <a class="{{ @$subNavTagActiveClass ? 'active' : '' }}"
                                           href="{{route('admin.product.tag.index')}}">
                                            {{ __('Tags') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('product_bulk_upload')
                                    <li>
                                        <a class="{{ @$subNavProductBulkUploadActiveClass ? 'active' : '' }}"
                                           href="{{route('admin.product.bulk-upload.index')}}">
                                            {{ __('Bulk Upload') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('product_comment')
                                    <li>
                                        <a class="{{ @$subNavProductCommentActiveClass ? 'active' : '' }}"
                                           href="{{route('admin.product.comment.index')}}">
                                            {{ __('Product Comment') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @canany(['manage_orders','all_orders','paid_orders','pending_orders','cancelled_orders','bank_payment_orders','bank_payment_pending_orders'])
                    <li class="">
                        <a href="#"
                           class="d-flex align-items-center cg-10 {{ isset($showOrders) ? 'active' : 'collapsed' }}"
                           data-bs-toggle="collapse" data-bs-target="#collapseExampleOrders"
                           aria-expanded="{{ isset($showOrders) ? 'true' : 'false' }}"
                           aria-controls="collapseExampleOrders">
                            <div class="d-flex">
                                <span class="iconify" data-icon="ic:sharp-shopping-cart-checkout"></span>
                            </div>
                            <span class="">{{ __('Orders') }}</span>
                        </a>
                        <div class="collapse {{ $showOrders ?? '' }}" id="collapseExampleOrders"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                @can('all_orders')
                                    <li>
                                        <a class="{{ @$subNavAllOrdersActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.order.all-orders') }}">
                                            {{ __('All Orders') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('paid_orders')
                                    <li>
                                        <a class="{{ @$subNavPaidOrdersActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.order.all-orders',ORDER_PAYMENT_STATUS_PAID) }}">
                                            {{ __('Paid Orders') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('pending_orders')
                                    <li>
                                        <a class="{{ @$subNavPendingOrdersActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.order.all-orders',ORDER_PAYMENT_STATUS_PENDING) }}">
                                            {{ __('Pending Orders') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('cancelled_orders')
                                    <li>
                                        <a class="{{ @$subNavCancelledOrdersActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.order.all-orders',ORDER_PAYMENT_STATUS_CANCELLED) }}">
                                            {{ __('Cancelled Orders') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('bank_payment_orders')
                                    <li>
                                        <a class="{{ @$subNavBankPaymentOrdersActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.order.bank-payment-orders',5) }}">
                                            {{ __('Bank Payment Orders') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('bank_payment_pending_orders')
                                    <li>
                                        <a class="{{ @$subNavBankPaymentPendingOrdersActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.order.bank-payment-orders',6) }}">
                                            {{ __('Bank/Cash Pending') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @canany(['manage_wallet','wallet_setting','all_wallet_list','paid_wallet_list','pending_wallet_list', 'cancelled_wallet_list'])
                    <li class="">
                        <a href="#"
                           class="d-flex align-items-center cg-10 {{ isset($showWallet) ? 'active' : 'collapsed' }}"
                           data-bs-toggle="collapse" data-bs-target="#collapseExampleWallet"
                           aria-expanded="{{ isset($showWallet) ? 'true' : 'false' }}"
                           aria-controls="collapseExampleWallet">
                            <div class="d-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" fill="none">
                                    <path d="M16.4154 4.41667H15.4987V3.5C15.4987 2.77065 15.209 2.07118 14.6932 1.55546C14.1775 1.03973 13.478 0.75 12.7487 0.75H3.58203C2.85269 0.75 2.15321 1.03973 1.63749 1.55546C1.12176 2.07118 0.832031 2.77065 0.832031 3.5V14.5C0.832031 15.2293 1.12176 15.9288 1.63749 16.4445C2.15321 16.9603 2.85269 17.25 3.58203 17.25H16.4154C17.1447 17.25 17.8442 16.9603 18.3599 16.4445C18.8756 15.9288 19.1654 15.2293 19.1654 14.5V7.16667C19.1654 6.43732 18.8756 5.73785 18.3599 5.22212C17.8442 4.7064 17.1447 4.41667 16.4154 4.41667ZM3.58203 2.58333H12.7487C12.9918 2.58333 13.225 2.67991 13.3969 2.85182C13.5688 3.02373 13.6654 3.25688 13.6654 3.5V4.41667H3.58203C3.33892 4.41667 3.10576 4.32009 2.93385 4.14818C2.76194 3.97627 2.66536 3.74312 2.66536 3.5C2.66536 3.25688 2.76194 3.02373 2.93385 2.85182C3.10576 2.67991 3.33892 2.58333 3.58203 2.58333ZM17.332 11.75H16.4154C16.1722 11.75 15.9391 11.6534 15.7672 11.4815C15.5953 11.3096 15.4987 11.0764 15.4987 10.8333C15.4987 10.5902 15.5953 10.3571 15.7672 10.1852C15.9391 10.0132 16.1722 9.91667 16.4154 9.91667H17.332V11.75ZM17.332 8.08333H16.4154C15.686 8.08333 14.9865 8.37306 14.4708 8.88879C13.9551 9.40451 13.6654 10.104 13.6654 10.8333C13.6654 11.5627 13.9551 12.2622 14.4708 12.7779C14.9865 13.2936 15.686 13.5833 16.4154 13.5833H17.332V14.5C17.332 14.7431 17.2355 14.9763 17.0635 15.1482C16.8916 15.3201 16.6585 15.4167 16.4154 15.4167H3.58203C3.33892 15.4167 3.10576 15.3201 2.93385 15.1482C2.76194 14.9763 2.66536 14.7431 2.66536 14.5V6.09417C2.95986 6.19777 3.26985 6.25046 3.58203 6.25H16.4154C16.6585 6.25 16.8916 6.34658 17.0635 6.51849C17.2355 6.69039 17.332 6.92355 17.332 7.16667V8.08333Z" fill="#686B8B"/>
                                </svg>
                            </div>
                            <span class="">{{ __('Wallet') }}</span>
                        </a>
                        <div class="collapse {{ $showWallet ?? '' }}" id="collapseExampleWallet"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                @can('wallet_setting')
                                    <li>
                                        <a class="{{ @$subNavWalletSettingActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.wallet.walletSetting') }}">
                                            {{ __('Wallet Setting') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('all_wallet_list')
                                    <li>
                                        <a class="{{ @$subNavAllWalletListActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.wallet.all-wallet-list') }}">
                                            {{ __('All Wallet') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('paid_wallet_list')
                                    <li>
                                        <a class="{{ @$subNavPaidWalletListActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.wallet.all-wallet-list',WALLET_MONEY_STATUS_PAID) }}">
                                            {{ __('Paid Wallet') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('pending_wallet_list')
                                    <li>
                                        <a class="{{ @$subNavPendingWalletListActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.wallet.all-wallet-list',WALLET_MONEY_STATUS_PENDING) }}">
                                            {{ __('Pending Wallet') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('cancelled_wallet_list')
                                    <li>
                                        <a class="{{ @$subNavCancelledWalletListActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.wallet.all-wallet-list',WALLET_MONEY_STATUS_CANCELLED) }}">
                                            {{ __('Cancelled Wallet') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @canany(['manage_earning','download_products','product_history','commission_setting','commission_distribution'])
                    <li class="">
                        <a href="#"
                           class="d-flex align-items-center cg-10 {{ isset($showEarning) ? 'active' : 'collapsed' }}"
                           data-bs-toggle="collapse" data-bs-target="#collapseExample"
                           aria-expanded="{{ isset($showEarning) ? 'true' : 'false' }}" aria-controls="collapseExample">
                            <div class="d-flex">
                                <span class="iconify" data-icon="ph:money-fill"></span>
                            </div>
                            <span class="">{{ __('Earning') }}</span>
                        </a>
                        <div class="collapse {{ $showEarning ?? '' }}" id="collapseExample"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                @can('download_products')
                                    <li>
                                        <a class="{{ @$subNavDownloadProductsActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.earning.downloadProducts') }}">
                                            {{ __('Download Products') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('product_history')
                                    <li>
                                        <a class="{{ @$subNavProductEarningHistoryActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.earning.productHistory') }}">
                                            {{ __('Product History') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('commission_setting')
                                    <li>
                                        <a class="{{ @$subNavCommissionSettingActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.earning.commissionSetting') }}">
                                            {{ __('Commission Setting') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('commission_distribution')
                                    <li>
                                        <a class="{{ @$subNavEarningManagementActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.earning.earningManagement') }}">
                                            {{ __('Commission Distribution') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @if(isAddonInstalled('PIXELAFFILIATE'))
                    @canany(['manage_referral','referral_setting','referral_history'])
                        <li class="">
                            <a href="#"
                               class="d-flex align-items-center cg-10 {{ isset($showReferral) ? 'active' : 'collapsed' }}"
                               data-bs-toggle="collapse" data-bs-target="#collapseExampleReferral"
                               aria-expanded="{{ isset($showReferral) ? 'true' : 'false' }}"
                               aria-controls="collapseExampleReferral">
                                <div class="d-flex">
                                    <span class="iconify" data-icon="octicon:cross-reference-16"></span>
                                </div>
                                <span class="">{{ __('Referral') }}</span>
                            </a>
                            <div class="collapse {{ $showReferral ?? '' }}" id="collapseExampleReferral"
                                 data-bs-parent="#sidebarMenu">
                                <ul class="zSidebar-submenu">
                                    @can('referral_setting')
                                        <li>
                                            <a class="{{ @$subNavReferralSettingActiveClass ? 'active' : ''  }}"
                                               href="{{ route('admin.referral.setting') }}">
                                                {{ __('Referral Setting') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('referral_history')
                                        <li>
                                            <a class="{{ @$subNavReferralHistoryActiveClass ? 'active' : ''  }}"
                                               href="{{ route('admin.referral.history') }}">
                                                {{ __('Referral History') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcanany
                @endif
                @canany(['manage_coupon','all_coupon','add_coupon'])
                    <li class="">
                        <a href="#"
                           class="d-flex align-items-center cg-10 {{ isset($showCoupon) ? 'active' : 'collapsed' }}"
                           data-bs-toggle="collapse" data-bs-target="#collapseExampleCoupon"
                           aria-expanded="{{ isset($showCoupon) ? 'true' : 'false' }}"
                           aria-controls="collapseExampleCoupon">
                            <div class="d-flex">
                                <span class="iconify" data-icon="ri:coupon-3-line"></span>
                            </div>
                            <span class="">{{ __('Coupon') }}</span>
                        </a>
                        <div class="collapse {{ $showCoupon ?? '' }}" id="collapseExampleCoupon"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                @can('all_coupon')
                                    <li>
                                        <a class="{{ @$subNavCouponIndexActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.coupon.index') }}">
                                            {{ __('All Coupon') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('add_coupon')
                                    <li>
                                        <a class="{{ @$subNavAddCouponActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.coupon.create') }}">
                                            {{ __('Add Coupon') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @can('subscription_plan')
                    <li>
                        <a href="{{ route('admin.subscriptionPlan') }}"
                           class="d-flex align-items-center cg-10 {{ @$navSubscriptionPlan }}">
                            <div class="d-flex">
                                <span class="iconify" data-icon="eos-icons:activate-subscriptions-outlined"></span>
                            </div>
                            <span class="">{{ __('Subscription Plan') }}</span>
                        </a>
                    </li>
                @endcan
                @canany(['manage_plan','all_plan','add_plan'])
                    <li class="">
                        <a href="#"
                           class="d-flex align-items-center cg-10 {{ isset($showPlan) ? 'active' : 'collapsed' }}"
                           data-bs-toggle="collapse" data-bs-target="#collapseExamplePlan"
                           aria-expanded="{{ isset($showPlan) ? 'true' : 'false' }}"
                           aria-controls="collapseExamplePlan">
                            <div class="d-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M10.0065 19.1694C4.94376 19.1694 0.839844 15.0655 0.839844 10.0027C0.839844 4.93998 4.94376 0.83606 10.0065 0.83606C15.0693 0.83606 19.1732 4.93998 19.1732 10.0027C19.1732 15.0655 15.0693 19.1694 10.0065 19.1694ZM10.0065 17.3361C11.9514 17.3361 13.8167 16.5634 15.192 15.1882C16.5672 13.8129 17.3398 11.9476 17.3398 10.0027C17.3398 8.05781 16.5672 6.19254 15.192 4.81728C13.8167 3.44201 11.9514 2.66939 10.0065 2.66939C8.06159 2.66939 6.19633 3.44201 4.82106 4.81728C3.44579 6.19254 2.67318 8.05781 2.67318 10.0027C2.67318 11.9476 3.44579 13.8129 4.82106 15.1882C6.19633 16.5634 8.06159 17.3361 10.0065 17.3361ZM8.21901 9.08606H12.7565V10.9194H8.21901C8.29855 11.3092 8.47819 11.6716 8.74027 11.9709C9.00235 12.2702 9.33784 12.4962 9.71373 12.6265C10.0896 12.7568 10.493 12.787 10.8841 12.7142C11.2752 12.6413 11.6406 12.4679 11.9443 12.211L13.5027 13.2505C12.9672 13.8337 12.2753 14.2505 11.5094 14.4512C10.7435 14.6518 9.93609 14.6278 9.18348 14.382C8.43087 14.1362 7.76489 13.6791 7.26504 13.0651C6.7652 12.4511 6.45261 11.7062 6.36459 10.9194H5.42318V9.08606H6.36459C6.45246 8.29904 6.76501 7.55395 7.26491 6.93978C7.76481 6.3256 8.43094 5.8683 9.18373 5.6225C9.93652 5.37669 10.7442 5.35277 11.5102 5.55358C12.2762 5.7544 12.9682 6.17147 13.5036 6.75498L11.9443 7.79448C11.6405 7.53755 11.275 7.36416 10.8839 7.29136C10.4927 7.21856 10.0893 7.24886 9.71341 7.37928C9.3375 7.5097 9.00203 7.73574 8.74 8.03517C8.47797 8.3346 8.29842 8.69618 8.21901 9.08606Z" fill="#686B8B"/>
                                </svg>
                            </div>
                            <span class="">{{ __('Plan') }}</span>
                        </a>
                        <div class="collapse {{ $showPlan ?? '' }}" id="collapseExamplePlan"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                @can('all_plan')
                                    <li>
                                        <a class="{{ @$subNavPlanIndexActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.plan.index') }}">
                                            {{ __('All Plan') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('add_plan')
                                    <li>
                                        <a class="{{ @$subNavPlanCreateActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.plan.create') }}">
                                            {{ __('Add Plan') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @canany(['manage_withdraw','pending_withdraw','complete_withdraw','cancelled_withdraw'])
                    <li class="">
                        <a href="#"
                           class="d-flex align-items-center cg-10 {{ isset($showWithdraw) ? 'active' : 'collapsed' }}"
                           data-bs-toggle="collapse" data-bs-target="#collapseExampleWithdraw"
                           aria-expanded="{{ isset($showWithdraw) ? 'true' : 'false' }}"
                           aria-controls="collapseExampleWithdraw">
                            <div class="d-flex">
                                <span class="iconify" data-icon="uil:money-withdraw"></span>
                            </div>
                            <span class="">{{__('Withdraw')}}</span>
                        </a>
                        <div class="collapse {{ $showWithdraw ?? '' }}" id="collapseExampleWithdraw"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                @can('pending_withdraw')
                                    <li>
                                        <a class="{{ @$subNavPendingWithdrawActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.withdraw.pending') }}">
                                            {{ __('Pending Withdraw') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('complete_withdraw')
                                    <li>
                                        <a class="{{ @$subNavCompletedWithdrawActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.withdraw.completed') }}">
                                            {{ __('Complete Withdraw') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('cancelled_withdraw')
                                    <li>
                                        <a class="{{ @$subNavCancelledWithdrawActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.withdraw.cancelled') }}">
                                            {{ __('Cancelled Withdraw') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @can('configure_settings')
                    <li>
                        <a href="{{ route('admin.setting.configuration-settings') }}"
                           class="d-flex align-items-center cg-10 {{ @$navConfigureActiveClass }}">
                            <div class="d-flex">
                                <span class="iconify" data-icon="eos-icons:activate-subscriptions-outlined"></span>
                            </div>
                            <span class="">{{ __('Configuration') }}</span>
                        </a>
                    </li>
                @endcan
                @can('settings')
                    <li>
                        <a href="{{ route('admin.setting.application-settings') }}"
                           class="d-flex align-items-center cg-10 {{ @$navSettingsActiveClass }}">
                            <div class="d-flex">
                                <span class="iconify" data-icon="eos-icons:activate-subscriptions-outlined"></span>
                            </div>
                            <span class="">{{ __('Settings') }}</span>
                        </a>
                    </li>
                @endcan
                @canany(['reported','product_reported','reported_category'])
                    <li class="">
                        <a href="#"
                           class="d-flex align-items-center cg-10 {{ isset($showReported) ? 'active' : 'collapsed' }}"
                           data-bs-toggle="collapse" data-bs-target="#collapseExampleReported"
                           aria-expanded="{{ isset($showReported) ? 'true' : 'false' }}"
                           aria-controls="collapseExampleReported">
                            <div class="d-flex">
                                <span class="iconify" data-icon="ic:outline-report"></span>
                            </div>
                            <span class="">{{__('Reported')}}</span>
                        </a>
                        <div class="collapse {{ $showReported ?? '' }}" id="collapseExampleReported"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                @can('product_reported')
                                    <li>
                                        <a class="{{ @$navProductReportedActiveClass ? 'active' : '' }}"
                                           href="{{route('admin.reported.products.index')}}">
                                            {{__('Products Reported')}}
                                        </a>
                                    </li>
                                @endcan
                                @can('reported_category')
                                    <li>
                                        <a class="{{ @$navReportedCategoryActiveClass ? 'active' : '' }}"
                                           href="{{route('admin.reported.category.index')}}">
                                            {{__('Reported Category')}}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @can('frontend_settings')
                    <li>
                        <a href="{{ route('admin.setting.location.country.index') }}"
                           class="d-flex align-items-center cg-10 {{ @$navFrontendSettingsActiveClass }}">
                            <div class="d-flex">
                                <span class="iconify" data-icon="fluent:news-16-regular"></span>
                            </div>
                            <span class="">{{ __('Frontend Settings') }}</span>
                        </a>
                    </li>
                @endcan
                @canany(['admin_management','admin_list','add_admin','add_role'])
                    <li>
                        <a href="#"
                           class="d-flex align-items-center cg-10 {{ isset($showAdminManagement) ? 'active' : 'collapsed' }}"
                           data-bs-toggle="collapse" data-bs-target="#collapseExampleAdminManagement"
                           aria-expanded="{{ isset($showAdminManagement) ? 'true' : 'false' }}"
                           aria-controls="collapseExampleAdminManagement">
                            <div class="d-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path d="M20.625 16.5V15.125H19.1806C19.0914 14.6948 18.9205 14.2857 18.6773 13.9198L19.7017 12.8954L18.7296 11.9233L17.7052 12.9477C17.3393 12.7045 16.9302 12.5336 16.5 12.4444V11H15.125V12.4444C14.6948 12.5336 14.2857 12.7045 13.9198 12.9477L12.8954 11.9233L11.9233 12.8954L12.9477 13.9198C12.7045 14.2857 12.5336 14.6948 12.4444 15.125H11V16.5H12.4444C12.5336 16.9302 12.7045 17.3393 12.9477 17.7052L11.9233 18.7296L12.8954 19.7017L13.9198 18.6773C14.2857 18.9205 14.6948 19.0914 15.125 19.1806V20.625H16.5V19.1806C16.9302 19.0914 17.3393 18.9205 17.7052 18.6773L18.7296 19.7017L19.7017 18.7296L18.6773 17.7052C18.9205 17.3393 19.0914 16.9302 19.1806 16.5H20.625ZM15.8125 17.875C15.4046 17.875 15.0058 17.754 14.6666 17.5274C14.3275 17.3008 14.0631 16.9787 13.907 16.6018C13.7509 16.2249 13.71 15.8102 13.7896 15.4101C13.8692 15.01 14.0656 14.6425 14.3541 14.3541C14.6425 14.0656 15.01 13.8692 15.4101 13.7896C15.8102 13.71 16.2249 13.7509 16.6018 13.907C16.9787 14.0631 17.3008 14.3275 17.5274 14.6666C17.754 15.0058 17.875 15.4046 17.875 15.8125C17.8745 16.3593 17.657 16.8836 17.2703 17.2703C16.8836 17.657 16.3593 17.8745 15.8125 17.875Z" fill="#686B8B"/>
                                    <path d="M19.25 2.75H2.75C2.38533 2.75 2.03559 2.89487 1.77773 3.15273C1.51987 3.41059 1.375 3.76033 1.375 4.125V17.875C1.375 18.2397 1.51987 18.5894 1.77773 18.8473C2.03559 19.1051 2.38533 19.25 2.75 19.25H9.625V17.875H2.75V8.25H19.25V10.3125H20.625V4.125C20.625 3.76033 20.4801 3.41059 20.2223 3.15273C19.9644 2.89487 19.6147 2.75 19.25 2.75ZM19.25 6.875H2.75V4.125H19.25V6.875Z" fill="#686B8B"/>
                                    <path d="M13.75 6.1875C14.1297 6.1875 14.4375 5.8797 14.4375 5.5C14.4375 5.1203 14.1297 4.8125 13.75 4.8125C13.3703 4.8125 13.0625 5.1203 13.0625 5.5C13.0625 5.8797 13.3703 6.1875 13.75 6.1875Z" fill="#686B8B"/>
                                    <path d="M15.8125 6.1875C16.1922 6.1875 16.5 5.8797 16.5 5.5C16.5 5.1203 16.1922 4.8125 15.8125 4.8125C15.4328 4.8125 15.125 5.1203 15.125 5.5C15.125 5.8797 15.4328 6.1875 15.8125 6.1875Z" fill="#686B8B"/>
                                    <path d="M17.875 6.1875C18.2547 6.1875 18.5625 5.8797 18.5625 5.5C18.5625 5.1203 18.2547 4.8125 17.875 4.8125C17.4953 4.8125 17.1875 5.1203 17.1875 5.5C17.1875 5.8797 17.4953 6.1875 17.875 6.1875Z" fill="#686B8B"/>
                                </svg>
                            </div>
                            <span class="">{{ __('Admin Manage') }}</span>
                        </a>
                        <div class="collapse {{ $showAdminManagement ?? '' }}" id="collapseExampleAdminManagement"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                @can('admin_list')
                                    <li>
                                        <a class="{{ @$subNavAdminIndexActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.user.index') }}">
                                            {{ __('Admin List') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('add_admin')
                                    <li>
                                        <a class="{{ @$subNavAddAdminActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.user.create') }}">
                                            {{ __('Add Admin') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('add_role')
                                    <li>
                                        <a class="{{ @$subNavRoleIndexActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.role.index') }}">
                                            {{ __('Role') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @canany(['manage_blog','all_blog','add_blog','blog_category','blog_comment_list'])
                    <li>
                        <a href="#"
                           class="d-flex align-items-center cg-10 {{ isset($showAdminBlog) ? 'active' : 'collapsed' }}"
                           data-bs-toggle="collapse" data-bs-target="#collapseExampleBlog"
                           aria-expanded="{{ isset($showAdminBlog) ? 'true' : 'false' }}"
                           aria-controls="collapseExampleBlog">
                            <div class="d-flex">
                                <span class="iconify" data-icon="jam:blogger-square"></span>
                            </div>
                            <span class="">{{ __('Blog') }}</span>
                        </a>
                        <div class="collapse {{ $showAdminBlog ?? '' }}" id="collapseExampleBlog"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                @can('all_blog')
                                    <li>
                                        <a class="{{ @$subNavBlogIndexActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.blog.index') }}">
                                            {{ __('All Blog') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('add_blog')
                                    <li>
                                        <a class="{{ @$subNavBlogCreateActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.blog.create') }}">
                                            {{ __('Add Blog') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('blog_category')
                                    <li>
                                        <a class="{{ @$subNavBlogCategoryIndexActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.blog.category.index') }}">
                                            {{ __('Blog Category') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('blog_comment_list')
                                    <li>
                                        <a class="{{ @$subNavBlogCommentListActiveClass ? 'active' : '' }}"
                                           href="{{route('admin.blog.comment.index')}}">
                                            {{ __('Blog Comment List') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @can('newsletter_subscriber')
                    <li>
                        <a href="{{ route('admin.newsletter.index') }}"
                           class="d-flex align-items-center cg-10 {{ @$navNewsletterActiveClass }}">
                            <div class="d-flex">
                                <span class="iconify" data-icon="fluent:news-16-regular"></span>
                            </div>
                            <span class="">{{ __('Newsletter') }}</span>
                        </a>
                    </li>
                @endcan
                @canany(['contact_us','all_contact_us','contact_us_topic'])
                    <li class="{{ @$navContactUsParentActiveClass }}">
                        <a href="#"
                           class="d-flex align-items-center cg-10 {{ isset($showContactUs) ? 'active' : 'collapsed' }}"
                           data-bs-toggle="collapse" data-bs-target="#collapseExampleContactUs"
                           aria-expanded="{{ isset($showContactUs) ? 'true' : 'false' }}"
                           aria-controls="collapseExampleContactUs">
                            <div class="d-flex">
                                <span class="iconify" data-icon="fluent:contact-card-32-regular"></span>
                            </div>
                            <span class="">{{__('Contact Us')}}</span>
                        </a>
                        <div class="collapse {{ $showContactUs ?? '' }}" id="collapseExampleContactUs"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                @can('all_contact_us')
                                    <li>
                                        <a class="{{ @$subNavContactUsIndexActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.contact.index') }}">
                                            {{__('All Contact Us')}}
                                        </a>
                                    </li>
                                @endcan
                                @can('contact_us_topic')
                                    <li>
                                        <a class="{{ @$subNavContactUsTopicIndexActiveClass ? 'active' : '' }}"
                                           href="{{ route('admin.contact.topic.index') }}">
                                            {{__('Contact Us Topic')}}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @can('manage_version_update')
                    <li class="d-none">
                        <a href="{{ route('admin.version-update') }}"
                           class="d-flex align-items-center cg-10 {{ @$subNavVersionUpdateActiveClass }}">
                            <div class="d-flex">
                                <i class="fa fa-circle"></i>
                            </div>
                            <span class="">{{__('Version Update')}}</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
