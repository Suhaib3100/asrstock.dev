<?php

//Status
const PENDING = 2;
const ACTIVE = 1;
const DISABLE = 0;

//Page
const TERMS_AND_CONDITION = 1;
const PRIVACY_POLICY = 2;
const COOKIE_POLICY = 3;

const GATEWAY_MODE_LIVE = 1;
const GATEWAY_MODE_SANDBOX = 2;

const DEFAULT_COLOR = 1;
const CUSTOM_COLOR = 2;

//Customer Role
const CUSTOMER_ROLE_CUSTOMER = 1;
const CUSTOMER_ROLE_CONTRIBUTOR = 2;

const CONTRIBUTOR_STATUS_PENDING = 0;
const CONTRIBUTOR_STATUS_APPROVED = 1;
const CONTRIBUTOR_STATUS_HOLD = 2;
const CONTRIBUTOR_STATUS_CANCELLED = 3;

// storage driver
const STORAGE_DRIVER_PUBLIC = 'public';
const STORAGE_DRIVER_AWS = 'aws';
const STORAGE_DRIVER_WASABI = 'wasabi';
const STORAGE_DRIVER_VULTR = 'vultr';
const STORAGE_DRIVER_DO = 'do';

//Contributor Apply
const CONTRIBUTOR_APPLY_YES = 1;
const CONTRIBUTOR_APPLY_NO = 0;

//Coupon
const DISCOUNT_TYPE_PERCENTAGE = 1;
const DISCOUNT_TYPE_AMOUNT = 2;

const DISCOUNT_USE_TYPE_SINGLE = 1;
const DISCOUNT_USE_TYPE_MULTIPLE = 2;

//Customer Plan
const CUSTOMER_PLAN_CANCELLED_BY_ADMIN = 1;
const CUSTOMER_PLAN_CANCELLED_BY_CUSTOMER = 2;

//Order Plan
const ORDER_PLAN_DURATION_TYPE_YEAR = 1;
const ORDER_PLAN_DURATION_TYPE_MONTH = 2;

const PLAN_DOWNLOAD_LIMIT_TYPE_UNLIMITED = 1;
const PLAN_DOWNLOAD_LIMIT_TYPE_LIMITED = 2;

//Product
const PRODUCT_ACCESSIBILITY_PAID = 1;
const PRODUCT_ACCESSIBILITY_FREE = 2;

const PRODUCT_IS_FEATURED_YES = 1;
const PRODUCT_IS_FEATURED_NO = 0;

const PRODUCT_STATUS_PUBLISHED = 1;
const PRODUCT_STATUS_PENDING = 2;
const PRODUCT_STATUS_HOLD = 3;

const PRODUCT_UPLOADED_BY_ADMIN = 1;
const PRODUCT_UPLOADED_BY_CONTRIBUTOR = 2;

//Order Payment, Type
const ORDER_PAYMENT_STATUS_PENDING = 1;
const ORDER_PAYMENT_STATUS_PAID = 2;
const ORDER_PAYMENT_STATUS_CANCELLED = 3;

const ORDER_PAYMENT_TYPE_BANK = 1;
const ORDER_PAYMENT_TYPE_ONLINE = 2;
const ORDER_PAYMENT_TYPE_CASH = 3;

const ORDER_TYPE_PLAN = 1;
const ORDER_TYPE_PRODUCT = 2;
const ORDER_TYPE_DONATE = 3;
const ORDER_TYPE_WALLET = 4;

//Gateway Name
const PAYPAL = 'paypal';
const STRIPE = 'stripe';
const RAZORPAY = 'razorpay';
const INSTAMOJO = 'instamojo';
const MOLLIE = 'mollie';
const PAYSTACK = 'paystack';
const SSLCOMMERZ = 'sslcommerz';
const MERCADOPAGO = 'mercadopago';
const FLUTTERWAVE = 'flutterwave';
const BINANCE = 'binance';
const ALIPAY = 'alipay';
const BANK = 'bank';
const CASH = 'cash';
const WALLET = 'wallet';
const COINBASE = 'coinbase';
const PAYTM = 'paytm';
const MAXICASH = 'maxicash';
const IYZICO = 'iyzico';
const BITPAY = 'bitpay';
const ZITOPAY = 'zitopay';
const PAYHERE = 'payhere';
const CINETPAY = 'cinetpay';
const VOGUEPAY = 'voguepay';
const TOYYIBPAY = 'toyyibpay';
const PAYMOB = 'paymob';
const AUTHORIZE = 'authorize';
const XENDIT = 'xendit';
const PADDLE = 'paddle';

//Withdraw
const WITHDRAW_STATUS_PENDING = 1;
const WITHDRAW_STATUS_COMPLETED = 2;
const WITHDRAW_STATUS_CANCELLED = 3;

const WITHDRAW_GATEWAY_NAME_PAYPAL = 'paypal';
const WITHDRAW_GATEWAY_NAME_CARD = 'card';
const WITHDRAW_GATEWAY_NAME_BANK = 'bank';
const WITHDRAW_GATEWAY_NAME_MOBILE_BANKING = 'mobile_banking';

//Download Product
const DOWNLOAD_ACCESSIBILITY_TYPE_PAID = 1;
const DOWNLOAD_ACCESSIBILITY_TYPE_FREE = 2;

//Referral
const REFERRAL_STATUS_PAID = 1;
const REFERRAL_STATUS_DUE = 2;

//Referral History
const REFERRAL_HISTORY_STATUS_PAID = 1;
const REFERRAL_HISTORY_STATUS_DUE = 2;

//Message
const SOMETHING_WENT_WRONG = "Something went wrong! Please try again";
const CREATED_SUCCESSFULLY = "Created Successfully";
const UPDATED_SUCCESSFULLY = "Updated Successfully";
const DELETED_SUCCESSFULLY = "Deleted Successfully";
const UPLOADED_SUCCESSFULLY = "Uploaded Successfully";
const DATA_FETCH_SUCCESSFULLY = "Data Fetch Successfully";
const SENT_SUCCESSFULLY = "Sent Successfully";
const FETCH_DATA_SUCCESSFULLY = "Fetch Data Successfully";
const DO_NOT_HAVE_PERMISSION = 7;

//Wallet Money
const WALLET_MONEY_STATUS_PAID = 1;
const WALLET_MONEY_STATUS_PENDING = 2;
const WALLET_MONEY_STATUS_CANCELLED = 3;

const RECURRING_GATEWAY = ['stripe', 'paypal'];

//Product type category
const PRODUCT_TYPE_IMAGE = 1;
const PRODUCT_TYPE_VIDEO = 2;
const PRODUCT_TYPE_AUDIO = 3;
const PRODUCT_TYPE_FILE = 4;
const PRODUCT_TYPE_OTHERS = 5;

//Meta type
const META_TYPE_PAGE = 1;
const META_TYPE_PRODUCT_CATEGORY = 2;
const META_TYPE_PRODUCT_TAG = 3;
const META_TYPE_PRODUCT = 4;
const META_TYPE_BLOG_CATEGORY = 5;
const META_TYPE_BLOG = 6;


//beneficiary type

const BENEFICIARY_BANK = 1;
const BENEFICIARY_CARD = 2;
const BENEFICIARY_PAYPAL = 3;
const BENEFICIARY_OTHER = 4;
