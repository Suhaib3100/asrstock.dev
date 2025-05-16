<?php
function getCurrency($currency = null, $only_symbol = false)
{
    $currency_list = array(
        "AFA" => array("name" => "Afghan Afghani", "symbol" => "؋"),
        "ALL" => array("name" => "Albanian Lek", "symbol" => "Lek"),
        "DZD" => array("name" => "Algerian Dinar", "symbol" => "دج"),
        "AOA" => array("name" => "Angolan Kwanza", "symbol" => "Kz"),
        "ARS" => array("name" => "Argentine Peso", "symbol" => "$"),
        "AMD" => array("name" => "Armenian Dram", "symbol" => "֏"),
        "AWG" => array("name" => "Aruban Florin", "symbol" => "ƒ"),
        "AUD" => array("name" => "Australian Dollar", "symbol" => "$"),
        "AZN" => array("name" => "Azerbaijani Manat", "symbol" => "m"),
        "BSD" => array("name" => "Bahamian Dollar", "symbol" => "B$"),
        "BHD" => array("name" => "Bahraini Dinar", "symbol" => ".د.ب"),
        "BDT" => array("name" => "Bangladeshi Taka", "symbol" => "৳"),
        "BBD" => array("name" => "Barbadian Dollar", "symbol" => "Bds$"),
        "BYR" => array("name" => "Belarusian Ruble", "symbol" => "Br"),
        "BEF" => array("name" => "Belgian Franc", "symbol" => "fr"),
        "BZD" => array("name" => "Belize Dollar", "symbol" => "$"),
        "BMD" => array("name" => "Bermudan Dollar", "symbol" => "$"),
        "BTN" => array("name" => "Bhutanese Ngultrum", "symbol" => "Nu."),
        "BTC" => array("name" => "Bitcoin", "symbol" => "฿"),
        "BOB" => array("name" => "Bolivian Boliviano", "symbol" => "Bs."),
        "BAM" => array("name" => "Bosnia", "symbol" => "KM"),
        "BWP" => array("name" => "Botswanan Pula", "symbol" => "P"),
        "BRL" => array("name" => "Brazilian Real", "symbol" => "R$"),
        "GBP" => array("name" => "British Pound Sterling", "symbol" => "£"),
        "BND" => array("name" => "Brunei Dollar", "symbol" => "B$"),
        "BGN" => array("name" => "Bulgarian Lev", "symbol" => "Лв."),
        "BIF" => array("name" => "Burundian Franc", "symbol" => "FBu"),
        "KHR" => array("name" => "Cambodian Riel", "symbol" => "KHR"),
        "CAD" => array("name" => "Canadian Dollar", "symbol" => "$"),
        "CVE" => array("name" => "Cape Verdean Escudo", "symbol" => "$"),
        "KYD" => array("name" => "Cayman Islands Dollar", "symbol" => "$"),
        "XOF" => array("name" => "CFA Franc BCEAO", "symbol" => "CFA"),
        "XAF" => array("name" => "CFA Franc BEAC", "symbol" => "FCFA"),
        "XPF" => array("name" => "CFP Franc", "symbol" => "₣"),
        "CLP" => array("name" => "Chilean Peso", "symbol" => "$"),
        "CNY" => array("name" => "Chinese Yuan", "symbol" => "¥"),
        "COP" => array("name" => "Colombian Peso", "symbol" => "$"),
        "KMF" => array("name" => "Comorian Franc", "symbol" => "CF"),
        "CDF" => array("name" => "Congolese Franc", "symbol" => "FC"),
        "CRC" => array("name" => "Costa Rican ColÃ³n", "symbol" => "₡"),
        "HRK" => array("name" => "Croatian Kuna", "symbol" => "kn"),
        "CUC" => array("name" => "Cuban Convertible Peso", "symbol" => "$, CUC"),
        "CZK" => array("name" => "Czech Republic Koruna", "symbol" => "Kč"),
        "DKK" => array("name" => "Danish Krone", "symbol" => "Kr."),
        "DJF" => array("name" => "Djiboutian Franc", "symbol" => "Fdj"),
        "DOP" => array("name" => "Dominican Peso", "symbol" => "$"),
        "XCD" => array("name" => "East Caribbean Dollar", "symbol" => "$"),
        "EGP" => array("name" => "Egyptian Pound", "symbol" => "ج.م"),
        "ERN" => array("name" => "Eritrean Nakfa", "symbol" => "Nfk"),
        "EEK" => array("name" => "Estonian Kroon", "symbol" => "kr"),
        "ETB" => array("name" => "Ethiopian Birr", "symbol" => "Nkf"),
        "EUR" => array("name" => "Euro", "symbol" => "€"),
        "FKP" => array("name" => "Falkland Islands Pound", "symbol" => "£"),
        "FJD" => array("name" => "Fijian Dollar", "symbol" => "FJ$"),
        "GMD" => array("name" => "Gambian Dalasi", "symbol" => "D"),
        "GEL" => array("name" => "Georgian Lari", "symbol" => "ლ"),
        "DEM" => array("name" => "German Mark", "symbol" => "DM"),
        "GHS" => array("name" => "Ghanaian Cedi", "symbol" => "GH₵"),
        "GIP" => array("name" => "Gibraltar Pound", "symbol" => "£"),
        "GRD" => array("name" => "Greek Drachma", "symbol" => "₯, Δρχ, Δρ"),
        "GTQ" => array("name" => "Guatemalan Quetzal", "symbol" => "Q"),
        "GNF" => array("name" => "Guinean Franc", "symbol" => "FG"),
        "GYD" => array("name" => "Guyanaese Dollar", "symbol" => "$"),
        "HTG" => array("name" => "Haitian Gourde", "symbol" => "G"),
        "HNL" => array("name" => "Honduran Lempira", "symbol" => "L"),
        "HKD" => array("name" => "Hong Kong Dollar", "symbol" => "$"),
        "HUF" => array("name" => "Hungarian Forint", "symbol" => "Ft"),
        "ISK" => array("name" => "Icelandic KrÃ³na", "symbol" => "kr"),
        "INR" => array("name" => "Indian Rupee", "symbol" => "₹"),
        "IDR" => array("name" => "Indonesian Rupiah", "symbol" => "Rp"),
        "IRR" => array("name" => "Iranian Rial", "symbol" => "﷼"),
        "IQD" => array("name" => "Iraqi Dinar", "symbol" => "د.ع"),
        "ILS" => array("name" => "Israeli New Sheqel", "symbol" => "₪"),
        "ITL" => array("name" => "Italian Lira", "symbol" => "L,£"),
        "JMD" => array("name" => "Jamaican Dollar", "symbol" => "J$"),
        "JPY" => array("name" => "Japanese Yen", "symbol" => "¥"),
        "JOD" => array("name" => "Jordanian Dinar", "symbol" => "ا.د"),
        "KZT" => array("name" => "Kazakhstani Tenge", "symbol" => "лв"),
        "KES" => array("name" => "Kenyan Shilling", "symbol" => "KSh"),
        "KWD" => array("name" => "Kuwaiti Dinar", "symbol" => "ك.د"),
        "KGS" => array("name" => "Kyrgystani Som", "symbol" => "лв"),
        "LAK" => array("name" => "Laotian Kip", "symbol" => "₭"),
        "LVL" => array("name" => "Latvian Lats", "symbol" => "Ls"),
        "LBP" => array("name" => "Lebanese Pound", "symbol" => "£"),
        "LSL" => array("name" => "Lesotho Loti", "symbol" => "L"),
        "LRD" => array("name" => "Liberian Dollar", "symbol" => "$"),
        "LYD" => array("name" => "Libyan Dinar", "symbol" => "د.ل"),
        "LTL" => array("name" => "Lithuanian Litas", "symbol" => "Lt"),
        "MOP" => array("name" => "Macanese Pataca", "symbol" => "$"),
        "MKD" => array("name" => "Macedonian Denar", "symbol" => "ден"),
        "MGA" => array("name" => "Malagasy Ariary", "symbol" => "Ar"),
        "MWK" => array("name" => "Malawian Kwacha", "symbol" => "MK"),
        "MYR" => array("name" => "Malaysian Ringgit", "symbol" => "RM"),
        "MVR" => array("name" => "Maldivian Rufiyaa", "symbol" => "Rf"),
        "MRO" => array("name" => "Mauritanian Ouguiya", "symbol" => "MRU"),
        "MUR" => array("name" => "Mauritian Rupee", "symbol" => "₨"),
        "MXN" => array("name" => "Mexican Peso", "symbol" => "$"),
        "MDL" => array("name" => "Moldovan Leu", "symbol" => "L"),
        "MNT" => array("name" => "Mongolian Tugrik", "symbol" => "₮"),
        "MAD" => array("name" => "Moroccan Dirham", "symbol" => "MAD"),
        "MZM" => array("name" => "Mozambican Metical", "symbol" => "MT"),
        "MMK" => array("name" => "Myanmar Kyat", "symbol" => "K"),
        "NAD" => array("name" => "Namibian Dollar", "symbol" => "$"),
        "NPR" => array("name" => "Nepalese Rupee", "symbol" => "₨"),
        "ANG" => array("name" => "Netherlands Antillean Guilder", "symbol" => "ƒ"),
        "TWD" => array("name" => "New Taiwan Dollar", "symbol" => "$"),
        "NZD" => array("name" => "New Zealand Dollar", "symbol" => "$"),
        "NIO" => array("name" => "Nicaraguan CÃ³rdoba", "symbol" => "C$"),
        "NGN" => array("name" => "Nigerian Naira", "symbol" => "₦"),
        "KPW" => array("name" => "North Korean Won", "symbol" => "₩"),
        "NOK" => array("name" => "Norwegian Krone", "symbol" => "kr"),
        "OMR" => array("name" => "Omani Rial", "symbol" => ".ع.ر"),
        "PKR" => array("name" => "Pakistani Rupee", "symbol" => "₨"),
        "PAB" => array("name" => "Panamanian Balboa", "symbol" => "B/."),
        "PGK" => array("name" => "Papua New Guinean Kina", "symbol" => "K"),
        "PYG" => array("name" => "Paraguayan Guarani", "symbol" => "₲"),
        "PEN" => array("name" => "Peruvian Nuevo Sol", "symbol" => "S/."),
        "PHP" => array("name" => "Philippine Peso", "symbol" => "₱"),
        "PLN" => array("name" => "Polish Zloty", "symbol" => "zł"),
        "QAR" => array("name" => "Qatari Rial", "symbol" => "ق.ر"),
        "RON" => array("name" => "Romanian Leu", "symbol" => "lei"),
        "RUB" => array("name" => "Russian Ruble", "symbol" => "₽"),
        "RWF" => array("name" => "Rwandan Franc", "symbol" => "FRw"),
        "SVC" => array("name" => "Salvadoran ColÃ³n", "symbol" => "₡"),
        "WST" => array("name" => "Samoan Tala", "symbol" => "SAT"),
        "SAR" => array("name" => "Saudi Riyal", "symbol" => "﷼"),
        "RSD" => array("name" => "Serbian Dinar", "symbol" => "din"),
        "SCR" => array("name" => "Seychellois Rupee", "symbol" => "SRe"),
        "SLL" => array("name" => "Sierra Leonean Leone", "symbol" => "Le"),
        "SGD" => array("name" => "Singapore Dollar", "symbol" => "$"),
        "SKK" => array("name" => "Slovak Koruna", "symbol" => "Sk"),
        "SBD" => array("name" => "Solomon Islands Dollar", "symbol" => "Si$"),
        "SOS" => array("name" => "Somali Shilling", "symbol" => "Sh.so."),
        "ZAR" => array("name" => "South African Rand", "symbol" => "R"),
        "KRW" => array("name" => "South Korean Won", "symbol" => "₩"),
        "XDR" => array("name" => "Special Drawing Rights", "symbol" => "SDR"),
        "LKR" => array("name" => "Sri Lankan Rupee", "symbol" => "Rs"),
        "SHP" => array("name" => "St. Helena Pound", "symbol" => "£"),
        "SDG" => array("name" => "Sudanese Pound", "symbol" => ".س.ج"),
        "SRD" => array("name" => "Surinamese Dollar", "symbol" => "$"),
        "SZL" => array("name" => "Swazi Lilangeni", "symbol" => "E"),
        "SEK" => array("name" => "Swedish Krona", "symbol" => "kr"),
        "CHF" => array("name" => "Swiss Franc", "symbol" => "CHf"),
        "SYP" => array("name" => "Syrian Pound", "symbol" => "LS"),
        "STD" => array("name" => "São Tomé and Príncipe Dobra", "symbol" => "Db"),
        "TJS" => array("name" => "Tajikistani Somoni", "symbol" => "SM"),
        "TZS" => array("name" => "Tanzanian Shilling", "symbol" => "TSh"),
        "THB" => array("name" => "Thai Baht", "symbol" => "฿"),
        "TOP" => array("name" => "Tongan pa'anga", "symbol" => "$"),
        "TTD" => array("name" => "Trinidad & Tobago Dollar", "symbol" => "$"),
        "TND" => array("name" => "Tunisian Dinar", "symbol" => "ت.د"),
        "TRY" => array("name" => "Turkish Lira", "symbol" => "₺"),
        "TMT" => array("name" => "Turkmenistani Manat", "symbol" => "T"),
        "UGX" => array("name" => "Ugandan Shilling", "symbol" => "USh"),
        "UAH" => array("name" => "Ukrainian Hryvnia", "symbol" => "₴"),
        "AED" => array("name" => "United Arab Emirates Dirham", "symbol" => "إ.د"),
        "UYU" => array("name" => "Uruguayan Peso", "symbol" => "$"),
        "USD" => array("name" => "US Dollar", "symbol" => "$"),
        "UZS" => array("name" => "Uzbekistan Som", "symbol" => "лв"),
        "VUV" => array("name" => "Vanuatu Vatu", "symbol" => "VT"),
        "VEF" => array("name" => "Venezuelan BolÃvar", "symbol" => "Bs"),
        "VND" => array("name" => "Vietnamese Dong", "symbol" => "₫"),
        "YER" => array("name" => "Yemeni Rial", "symbol" => "﷼"),
        "ZMK" => array("name" => "Zambian Kwacha", "symbol" => "ZK"),
        "MaxiDollar" => array("name" => "Maxi Dollar", "symbol" => "$"),
    );
    if (is_null($currency)) {
        $all_currency = [];
        foreach ($currency_list as $key => $item) {
            if ($only_symbol) {
                $all_currency[$key] = $item['symbol'];
            } else {
                $all_currency[$key] = $item['name'] . '(' . $item['symbol'] . ')';
            }
        }
        return $all_currency;
    } else {
        if ($only_symbol) {
            return $currency_list[$currency]['symbol'];
        } else {
            return $currency_list[$currency]['name'] . '(' . $currency_list[$currency]['symbol'] . ')';
        }
    }
}

function languageIsoCode($input = null)
{
    $output = [
        "af" => "Afrikaans",
        "sq" => "shqip",
        "am" => "አማርኛ",
        "ar" => "العربية",
        "an" => "aragonés",
        "hy" => "հայերեն",
        "ast" => "asturianu",
        "az" => "azərbaycan dili",
        "eu" => "euskara",
        "be" => "беларуская",
        "bn" => "বাংলা",
        "bs" => "bosanski",
        "br" => "brezhoneg",
        "bg" => "български",
        "ca" => "català",
        "ckb" => "کوردی (دەستنوسی عەرەبی)",
        "zh" => "中文",
        "zh-HK" => "中文（香港）",
        "zh-CN" => "中文（简体）",
        "zh-TW" => "中文（繁體）",
        "co" => "Corsican",
        "hr" => "hrvatski",
        "cs" => "čeština",
        "da" => "dansk",
        "nl" => "Nederlands",
        "en" => "English",
        "en-AU" => "English (Australia)",
        "en-CA" => "English (Canada)",
        "en-IN" => "English (India)",
        "en-NZ" => "English (New Zealand)",
        "en-ZA" => "English (South Africa)",
        "en-GB" => "English (United Kingdom)",
        "en-US" => "English (United States)",
        "eo" => "esperanto",
        "et" => "eesti",
        "fo" => "føroyskt",
        "fil" => "Filipino",
        "fi" => "suomi",
        "fr" => "français",
        "fr-CA" => "français (Canada)",
        "fr-FR" => "français (France)",
        "fr-CH" => "français (Suisse)",
        "gl" => "galego",
        "ka" => "ქართული",
        "de" => "Deutsch",
        "de-AT" => "Deutsch (Österreich)",
        "de-DE" => "Deutsch (Deutschland)",
        "de-LI" => "Deutsch (Liechtenstein)",
        "de-CH" => "Deutsch (Schweiz)",
        "el" => "Ελληνικά",
        "gn" => "Guarani",
        "gu" => "ગુજરાતી",
        "ha" => "Hausa",
        "haw" => "ʻŌlelo Hawaiʻi",
        "he" => "עברית",
        "hi" => "हिन्दी",
        "hu" => "magyar",
        "is" => "íslenska",
        "id" => "Indonesia",
        "ia" => "Interlingua",
        "ga" => "Gaeilge",
        "it" => "italiano",
        "it-IT" => "italiano (Italia)",
        "it-CH" => "italiano (Svizzera)",
        "ja" => "日本語",
        "kn" => "ಕನ್ನಡ",
        "kk" => "қазақ тілі",
        "km" => "ខ្មែរ",
        "ko" => "한국어",
        "ku" => "Kurdî",
        "ky" => "кыргызча",
        "lo" => "ລາວ",
        "la" => "Latin",
        "lv" => "latviešu",
        "ln" => "lingála",
        "lt" => "lietuvių",
        "mk" => "македонски",
        "ms" => "Bahasa Melayu",
        "ml" => "മലയാളം",
        "mt" => "Malti",
        "mr" => "मराठी",
        "mn" => "монгол",
        "ne" => "नेपाली",
        "no" => "norsk",
        "nb" => "norsk bokmål",
        "nn" => "nynorsk",
        "oc" => "Occitan",
        "or" => "ଓଡ଼ିଆ",
        "om" => "Oromoo",
        "ps" => "پښتو",
        "fa" => "فارسی",
        "pl" => "polski",
        "pt" => "português",
        "pt-BR" => "português (Brasil)",
        "pt-PT" => "português (Portugal)",
        "pa" => "ਪੰਜਾਬੀ",
        "qu" => "Quechua",
        "ro" => "română",
        "mo" => "română (Moldova)",
        "rm" => "rumantsch",
        "ru" => "русский",
        "gd" => "Scottish Gaelic",
        "sr" => "српски",
        "sh" => "Croatian",
        "sn" => "chiShona",
        "sd" => "Sindhi",
        "si" => "සිංහල",
        "sk" => "slovenčina",
        "sl" => "slovenščina",
        "so" => "Soomaali",
        "st" => "Southern Sotho",
        "es" => "español",
        "es-AR" => "español (Argentina)",
        "es-419" => "español (Latinoamérica)",
        "es-MX" => "español (México)",
        "es-ES" => "español (España)",
        "es-US" => "español (Estados Unidos)",
        "su" => "Sundanese",
        "sw" => "Kiswahili",
        "sv" => "svenska",
        "tg" => "тоҷикӣ",
        "ta" => "தமிழ்",
        "tt" => "Tatar",
        "te" => "తెలుగు",
        "th" => "ไทย",
        "ti" => "ትግርኛ",
        "to" => "lea fakatonga",
        "tr" => "Türkçe",
        "tk" => "Turkmen",
        "tw" => "Twi",
        "uk" => "українська",
        "ur" => "اردو",
        "ug" => "Uyghur",
        "uz" => "o‘zbek",
        "vi" => "Tiếng Việt",
        "wa" => "wa",
        "cy" => "Cymraeg",
        "fy" => "Western Frisian",
        "xh" => "Xhosa",
        "yi" => "Yiddish",
        "yo" => "Èdè Yorùbá",
        "zu" => "isiZulu"
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

function getProductTypeCategory($input = null)
{
    $output = array(
        PRODUCT_TYPE_IMAGE => __("Image"),
        PRODUCT_TYPE_VIDEO => __("Video"),
        PRODUCT_TYPE_AUDIO => __("Audio"),
        PRODUCT_TYPE_FILE => __("File"),
        PRODUCT_TYPE_OTHERS => __("Others"),
    );
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input] ?? '';
    }
}

function getProductTypeCategorySlug($input = null)
{
    $output = array(
        PRODUCT_TYPE_IMAGE => __("image"),
        PRODUCT_TYPE_VIDEO => __("video"),
        PRODUCT_TYPE_AUDIO => __("audio"),
        PRODUCT_TYPE_FILE => __("file"),
        PRODUCT_TYPE_OTHERS => __("others"),
    );
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input] ?? '';
    }
}

function getPageType($input = null)
{
    $output = array(
        META_TYPE_PAGE => __('Page'),
        META_TYPE_PRODUCT_CATEGORY => __('Product Category'),
        META_TYPE_PRODUCT_TAG => __('Product Tag'),
        META_TYPE_PRODUCT => __('Product'),
        META_TYPE_BLOG_CATEGORY => __('Blog Category'),
        META_TYPE_BLOG => __('Blog'),
    );
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input] ?? '';
    }
}

function getPageName($input = null)
{
    $output = array(
        1 => __('Home'),
        2 => __('Pricing'),
        3 => __('About Us'),
        4 => __('Contact Us'),
        5 => __('Cookie Policy'),
        6 => __('Privacy Policy'),
        7 => __('Terms & Condition'),
        8 => __('All Product'),
        9 => __('All Blog'),
        10 => __('Be A Contributor'),
        11 => __('Customer Profile'),
        12 => __('Customer Follower'),
        13 => __('Customer Follwoing'),
        14 => __('Thank You'),
        15 => __('Login'),
        16 => __('Payment Processing'),
        17 => __('Cancel Payment'),
    );
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input] ?? '';
    }
}

if (!function_exists("getMessage")) {
    function getMessage($input = null)
    {
        $output = [
            CREATED_SUCCESSFULLY => __("Created Successfully"),
            UPDATED_SUCCESSFULLY => __("Updated Successfully"),
            DELETED_SUCCESSFULLY => __("Deleted Successfully"),
            UPLOADED_SUCCESSFULLY => __("Uploaded Successfully"),
            DATA_FETCH_SUCCESSFULLY => __("Data Fetch Successfully"),
            SENT_SUCCESSFULLY => __("Sent Successfully"),
            SOMETHING_WENT_WRONG => __("Something went wrong! Please try again"),
            DO_NOT_HAVE_PERMISSION => __("You don\'t have the permission"),
        ];


        if (is_null($input)) {
            return $output;
        } else {
            return $output[$input];
        }
    }
}


if (!function_exists("getOrderType")) {
    function getOrderType($input = null)
    {
        $output = [
            ORDER_TYPE_PLAN => __('Plan'),
            ORDER_TYPE_PRODUCT => __('Product'),
            ORDER_TYPE_DONATE => __('Donation'),
        ];


        if (is_null($input)) {
            return $output;
        } else {
            return $output[$input];
        }
    }
}


if (!function_exists("getOrderStatus")) {
    function getOrderStatus($input = null)
    {
        $output = [
            ORDER_PAYMENT_STATUS_PENDING => '<p class="zBadge zBadge-pending">' . __("Pending") . '</p>',
            ORDER_PAYMENT_STATUS_PAID => '<p class="zBadge zBadge-paid">' . __("Paid") . '</p>',
            ORDER_PAYMENT_STATUS_CANCELLED => '<p class="zBadge zBadge-cancel">' . __("Cancelled") . '</p>',
        ];

        if (is_null($input)) {
            return $output;
        } else {
            return $output[$input];
        }
    }
}

if (!function_exists("getProductStatus")) {
    function getProductStatus($input = null)
    {
        $output = [
            PRODUCT_STATUS_PENDING => '<p class="zBadge zBadge-pending">' . __("Pending") . '</p>',
            PRODUCT_STATUS_PUBLISHED => '<p class="zBadge zBadge-paid">' . __("Published") . '</p>',
            PRODUCT_STATUS_HOLD => '<p class="zBadge zBadge-cancel">' . __("Hold") . '</p>',
        ];

        if (is_null($input)) {
            return $output;
        } else {
            return $output[$input];
        }
    }
}

if (!function_exists("getWalletMoneyStatus")) {
    function getWalletMoneyStatus($input = null)
    {
        $output = [
            WALLET_MONEY_STATUS_PENDING => '<p class="zBadge zBadge-pending">' . __("Pending") . '</p>',
            WALLET_MONEY_STATUS_PAID => '<p class="zBadge zBadge-paid">' . __("Completed") . '</p>',
            WALLET_MONEY_STATUS_CANCELLED => '<p class="zBadge zBadge-cancel">' . __("Cancelled") . '</p>',
        ];

        if (is_null($input)) {
            return $output;
        } else {
            return $output[$input];
        }
    }
}


if (!function_exists("getOrderPlanDuration")) {
    function getOrderPlanDuration($input = null)
    {
        $output = [
            ORDER_PLAN_DURATION_TYPE_MONTH => __('Monthly'),
            ORDER_PLAN_DURATION_TYPE_YEAR => __('Yearly'),
        ];

        if (is_null($input)) {
            return $output;
        } else {
            return $output[$input];
        }
    }
}


if (!function_exists("getBeneficiary")) {
    function getBeneficiary($input = null)
    {
        $output = [
            BENEFICIARY_BANK => __('Bank'),
            BENEFICIARY_CARD => __('Card'),
            BENEFICIARY_PAYPAL => __('Paypal'),
            BENEFICIARY_OTHER => __('Others'),
        ];

        if (is_null($input)) {
            return $output;
        } else {
            return $output[$input];
        }
    }
}

if (!function_exists("getWithdrawStatus")) {
    function getWithdrawStatus($input = null, $cancel_reason = null)
    {
        $output = [
            WITHDRAW_STATUS_PENDING => '<p class="zBadge zBadge-pending">' . __("Pending") . '</p>',
            WITHDRAW_STATUS_COMPLETED => '<p class="zBadge zBadge-paid">' . __("Completed") . '</p>',
            WITHDRAW_STATUS_CANCELLED => '<p class="zBadge zBadge-cancel" data-bs-toggle="tooltip" title="' . htmlspecialchars($cancel_reason) . '">' . __("Cancelled") . '</p>',
        ];

        if (is_null($input)) {
            return $output;
        } else {
            return isset($output[$input]) ? $output[$input] : '';
        }
    }
}


function getPaymentServiceClass($input = null)
{
    $output = array(
        PAYPAL => 'App\Http\Services\Payment\PaypalService',
        STRIPE => 'App\Http\Services\Payment\StripeService',
        RAZORPAY => 'App\Http\Services\Addon\Gateway\RazorpayService',
        INSTAMOJO => 'App\Http\Services\Addon\Gateway\InstamojoService',
        MOLLIE => 'App\Http\Services\Addon\Gateway\MollieService',
        COINBASE => 'App\Http\Services\Addon\Gateway\CoinbaseService',
        PAYSTACK => 'App\Http\Services\Addon\Gateway\PaystackService',
        SSLCOMMERZ => 'App\Http\Services\Addon\Gateway\SslCommerzService',
        MERCADOPAGO => 'App\Http\Services\Addon\Gateway\MercadoPagoService',
        FLUTTERWAVE => 'App\Http\Services\Addon\Gateway\FlutterwaveService',
        IYZICO => 'App\Http\Services\Addon\Gateway\IyziPayService',
        BITPAY => 'App\Http\Services\Addon\Gateway\BitPayService',
        ZITOPAY => 'App\Http\Services\Addon\Gateway\ZitoPayService',
        BINANCE => 'App\Http\Services\Addon\Gateway\BinancePaymentService',
        PAYTM => 'App\Http\Services\Addon\Gateway\PaytmService',
        PAYHERE => 'App\Http\Services\Addon\Gateway\PayHerePaymentService',
        MAXICASH => 'App\Http\Services\Addon\Gateway\MaxiCashService',
        CINETPAY => 'App\Http\Services\Addon\Gateway\CinetPayService',
        VOGUEPAY => 'App\Http\Services\Addon\Gateway\VoguePayService',
        TOYYIBPAY => 'App\Http\Services\Addon\Gateway\ToyyibPayService',
        PAYMOB => 'App\Http\Services\Addon\Gateway\PaymobService',
        AUTHORIZE => 'App\Http\Services\Addon\Gateway\AuthorizeNetService',
        ALIPAY => 'App\Http\Services\Addon\Gateway\AlipayService',
        PADDLE => 'App\Http\Services\Addon\Gateway\PaddleService',
        XENDIT => 'App\Http\Services\Addon\Gateway\XenditService',
        BANK => 'App\Http\Services\Payment\BankService',  // Add the bank service here
        CASH => 'App\Http\Services\Payment\CashService',  // Add the cash service here
        WALLET => 'App\Http\Services\Payment\WalletService',  // Add the wallet service here
    );
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input] ?? '';
    }
}
