<?php

use App\Models\Currency;
use App\Models\CustomerPlan;
use App\Models\DownloadProduct;
use App\Models\FileManager;
use App\Models\Language;
use App\Models\Order;
use App\Models\ProductType;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

function getOption($option_key, $default = '')
{
    $system_settings = config('settings');

    if ($option_key && isset($system_settings[$option_key])) {
        return $system_settings[$option_key];
    } elseif ($option_key && isset($system_settings[strtolower($option_key)])) {
        return $system_settings[strtolower($option_key)];
    } elseif ($option_key && isset($system_settings[strtoupper($option_key)])) {
        return $system_settings[strtoupper($option_key)];
    } else {
        return $default;
    }
}

if (!function_exists('getTimeZone')) {
    function getTimeZone()
    {
        return DateTimeZone::listIdentifiers(
            DateTimeZone::ALL
        );
    }
}
function getErrorMessage($e, $customMsg = null)
{
    if ($customMsg != null) {
        return $customMsg;
    }
    if (env('APP_DEBUG')) {
        return $e->getMessage() . $e->getLine();
    } else {
        return SOMETHING_WENT_WRONG;
    }
}

if (!function_exists('updateEnv')) {
    function updateEnv($values)
    {
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                setEnvironmentValue($envKey, $envValue);
            }
            return true;
        }
    }
}

if (!function_exists('setEnvironmentValue')) {
    function setEnvironmentValue($envKey, $envValue)
    {
        try {
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);
            $str .= "\n"; // In case the searched variable is in the last line without \n
            $keyPosition = strpos($str, "{$envKey}=");
            if ($keyPosition) {
                if (PHP_OS_FAMILY === 'Windows') {
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                } else {
                    $endOfLinePosition = strpos($str, PHP_EOL, $keyPosition);
                }
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                $envValue = str_replace(chr(92), "\\\\", $envValue);
                $envValue = str_replace('"', '\"', $envValue);
                $newLine = "{$envKey}=\"{$envValue}\"";
                if ($oldLine != $newLine) {
                    $str = str_replace($oldLine, $newLine, $str);
                    $str = substr($str, 0, -1);
                    $fp = fopen($envFile, 'w');
                    fwrite($fp, $str);
                    fclose($fp);
                }
            } else if (strtoupper($envKey) == $envKey) {
                $envValue = str_replace(chr(92), "\\\\", $envValue);
                $envValue = str_replace('"', '\"', $envValue);
                $newLine = "{$envKey}=\"{$envValue}\"\n";
                $str .= $newLine;
                $str = substr($str, 0, -1);
                $fp = fopen($envFile, 'w');
                fwrite($fp, $str);
                fclose($fp);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('makeFileUrl')) {
    function makeFileUrl($file = null)
    {
        if (!is_null($file)) {
            if (Storage::disk($file->storage_type)->exists($file->path)) {

                if ($file->storage_type == 'public') {
                    return asset('storage/' . $file->path);
                }

                if ($file->storage_type == 'wasabi') {
                    return Storage::disk('wasabi')->url($file->path);
                }


                return Storage::disk($file->storage_type)->url($file->path);
            }
        }

        return asset('assets/images/no-image.jpg');
    }
}

if (!function_exists('getFileUrl')) {
    function getFileUrl($id = null)
    {

        $file = FileManager::select('path', 'storage_type')->find($id);

        if (!is_null($file)) {
            if (Storage::disk($file->storage_type)->exists($file->path)) {

                if ($file->storage_type == 'public') {
                    return asset('storage/' . $file->path);
                }

                if ($file->storage_type == 'wasabi') {
                    return Storage::disk('wasabi')->url($file->path);
                }


                return Storage::disk($file->storage_type)->url($file->path);
            }
        }

        return asset('assets/images/no-image.jpg');
    }
}

function getSettingImage($option_key)
{
    try {
        $system_settings = config('settings');
        if ($option_key && isset($system_settings[$option_key])) {
            $fileManager = FileManager::find($system_settings[$option_key]);
            if ($fileManager) {
                $destinationPath = $fileManager->path;
                if (config('app.STORAGE_DRIVER') == "local" || config('app.STORAGE_DRIVER') == "public") {
                    return asset('storage/' . $destinationPath);
                } else {
                    $s3 = Storage::disk(config('app.STORAGE_DRIVER'));
                    return $s3->url($destinationPath);
                }
            }
        }
        return asset('assets/images/no-image.jpg');
    } catch (\Exception $e) {
        return asset('assets/images/no-image.jpg');
    }

}

function getDefaultImage()
{
    return asset('assets/images/no-image.jpg');
}

function settingImageStoreUpdate($option_id, $requestFile)
{
    try {
        if ($requestFile) {
            $new_file = new FileManager();
            $upload = $new_file->upload('Setting', $requestFile);
            if ($upload['status']) {
                $upload['file']->origin_id = $option_id;
                $upload['file']->origin_type = "App\Models\Setting";
                $upload['file']->save();
            }

            return $upload['file']->id;
        }
    } catch (\Exception $e) {

    }

    return null;

}

function getCurrencySymbol()
{
    $currency = Currency::where('current_currency', ACTIVE)->first();
    if ($currency) {
        $symbol = $currency->symbol . ' ';
        return $symbol;
    }
    return '';
}

function getCurrencyCode()
{
    $currency = Currency::where('current_currency', ACTIVE)->first();
    if ($currency) {
        $currency_code = $currency->currency_code;
        return $currency_code;
    }
    return '';
}

function getCurrencyPlacement()
{
    $currency = Currency::where('current_currency', ACTIVE)->first();
    $placement = 'before';
    if ($currency) {
        $placement = $currency->currency_placement;
        return $placement;
    }

    return $placement;
}

function getAmountPlace($value)
{
    $placement = getCurrencyPlacement();
    if ($placement == 'before') {
        $value = getCurrencySymbol() . ' ' . $value;
    } else {
        $value = $value . ' ' . getCurrencySymbol();
    }

    return $value;
}


function getIpInfo()
{
    $ip = request()->ip();
    $deep_detect = TRUE;

    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }

    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);

    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;
    $long = @$xml->geoplugin_longitude;
    $lat = @$xml->geoplugin_latitude;

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');


    return $data;
}

//moveable
function osBrowser()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    $browser = "Unknown Browser";
    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }

    $data['os_platform'] = $os_platform;
    $data['browser'] = $browser;

    return $data;
}

function appLanguages()
{
    return Language::where('status', 1)->get();
}

function selectedLanguage()
{
    $language = Language::where('iso_code', session()->get('local'))->first();
    if (!$language) {
        $language = Language::first();
        if ($language) {
            $ln = $language->iso_code;
            session(['local' => $ln]);
            App::setLocale(session()->get('local'));
        }
    }

    return $language;
}

function customerPlanExit($customer_id)
{
    return CustomerPlan::whereCustomerId($customer_id)->whereDate('end_date', '>=', now())->whereNull('cancelled_by')->whereHas('order', function ($q) {
        $q->wherePaymentStatus(ORDER_PAYMENT_STATUS_PAID);
    })->with(['order', 'plan'])->first();
}

function randomString()
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < 8; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}

function number_parser($value)
{
    return (float)str_replace(',', '', number_format(($value), 2));
}

function productSalesCount($product_id)
{
    return Order::where(['product_id' => $product_id, 'payment_status' => ORDER_PAYMENT_STATUS_PAID])->count();
}

function productSalesAmount($product_id)
{
    return Order::where(['product_id' => $product_id, 'payment_status' => ORDER_PAYMENT_STATUS_PAID])->sum('total');
}

function downloadFreeCount($product_id)
{
    return DownloadProduct::where(['product_id' => $product_id, 'download_accessibility_type' => DOWNLOAD_ACCESSIBILITY_TYPE_FREE])->count();
}

function downloadPaidCount($product_id)
{
    return DownloadProduct::where(['product_id' => $product_id, 'download_accessibility_type' => DOWNLOAD_ACCESSIBILITY_TYPE_PAID])->count();
}

function downloadPaidAmount($product_id)
{
    return DownloadProduct::where(['product_id' => $product_id, 'download_accessibility_type' => DOWNLOAD_ACCESSIBILITY_TYPE_FREE])->sum('earn_money');
}


function getColorPlate($image)
{

    $PREVIEW_WIDTH = 150;  //WE HAVE TO RESIZE THE IMAGE, BECAUSE WE ONLY NEED THE MOST SIGNIFICANT COLORS.
    $PREVIEW_HEIGHT = 150;
    $size = GetImageSize($image);
    $scale = 1;
    if ($size[0] > 0)
        $scale = min($PREVIEW_WIDTH / $size[0], $PREVIEW_HEIGHT / $size[1]);
    if ($scale < 1) {
        $width = floor($scale * $size[0]);
        $height = floor($scale * $size[1]);
    } else {
        $width = $size[0];
        $height = $size[1];
    }
    $image_resized = imagecreatetruecolor($width, $height);
    if ($size[2] == 1)
        $image_orig = imagecreatefromgif($image);
    if ($size[2] == 2)
        $image_orig = imagecreatefromjpeg($image);
    if ($size[2] == 3)
        $image_orig = imagecreatefrompng($image);
    imagecopyresampled($image_resized, $image_orig, 0, 0, 0, 0, $width, $height, $size[0], $size[1]); //WE NEED NEAREST NEIGHBOR RESIZING, BECAUSE IT DOESN'T ALTER THE COLORS
    $im = $image_resized;
    $imgWidth = imagesx($im);
    $imgHeight = imagesy($im);
    for ($y = 0; $y < $imgHeight; $y++) {
        for ($x = 0; $x < $imgWidth; $x++) {
            $index = imagecolorat($im, $x, $y);
            $Colors = imagecolorsforindex($im, $index);
            $Colors['red'] = intval((($Colors['red']) + 15) / 32) * 32;    //ROUND THE COLORS, TO REDUCE THE NUMBER OF COLORS, SO THE WON'T BE ANY NEARLY DUPLICATE COLORS!
            $Colors['green'] = intval((($Colors['green']) + 15) / 32) * 32;
            $Colors['blue'] = intval((($Colors['blue']) + 15) / 32) * 32;
            if ($Colors['red'] >= 256)
                $Colors['red'] = 240;
            if ($Colors['green'] >= 256)
                $Colors['green'] = 240;
            if ($Colors['blue'] >= 256)
                $Colors['blue'] = 240;
            $hexarray[] = substr("0" . dechex($Colors['red']), -2) . substr("0" . dechex($Colors['green']), -2) . substr("0" . dechex($Colors['blue']), -2);
        }
    }
    $hexarray = array_count_values($hexarray);
    natsort($hexarray);
    $hexarray = array_reverse($hexarray, true);
    $hexarray = array_slice($hexarray, 0, 5, true);

    $dataArray = array();
    foreach ($hexarray as $key => $value) {
        $keyHex = $key;
        array_push($dataArray, $keyHex);
    }

    return $dataArray;
}


if (!function_exists('getCustomerCurrentBuildVersion')) {
    function getCustomerCurrentBuildVersion()
    {
        $buildVersion = getOption('build_version', 1);
        return (int)$buildVersion;
    }
}

if (!function_exists('setCustomerBuildVersion')) {
    function setCustomerBuildVersion($version)
    {
        $option = Setting::firstOrCreate(['option_key' => 'build_version']);
        $option->option_value = $version;
        $option->save();
    }
}

if (!function_exists('setCustomerCurrentVersion')) {
    function setCustomerCurrentVersion()
    {
        $option = Setting::firstOrCreate(['option_key' => 'current_version']);
        $option->option_value = config('app.current_version');
        $option->save();
    }
}

if (!function_exists('get_domain_name')) {
    function get_domain_name($url)
    {
        $parseUrl = parse_url(trim($url));
        if (isset($parseUrl['host'])) {
            $host = $parseUrl['host'];
        } else {
            $path = explode('/', $parseUrl['path']);
            $host = $path[0];
        }
        return trim($host);
    }
}

if (!function_exists('getProductThumbnail')) {
    function getProductThumbnail($folderName, $fileName)
    {
        $destinationPath = $folderName . '/' . $fileName;
        if (Storage::disk(config('app.STORAGE_DRIVER'))->exists($destinationPath)) {
            if (config('app.STORAGE_DRIVER') != "public") {
                $s3 = Storage::disk(config('app.STORAGE_DRIVER'));
                return $s3->url($destinationPath);
            }
            return asset('storage/' . $destinationPath);
        }

        return asset('assets/images/no-image.jpg');

    }
}

if (!function_exists('getSlug')) {
    function getSlug($text)
    {
        if ($text) {
            $data = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $text);
            $slug = preg_replace("/[\/_|+ -]+/", "-", $data);
            return $slug;
        }
        return '';
    }
}
if (!function_exists('getProductUseOption')) {
    function getProductUseOption($id = null)
    {
        $options = json_decode(getOption('product_use_option', json_encode([])));
        if ($id !== null) {
            foreach ($options as $option) {
                if ($option->id == $id) {
                    return $option->name;
                }
            }
            return null; // Return null if ID is not found
        }

        return $options; // Return all options if no ID is provided
    }
}

if (!function_exists('getFileFromManager')) {
    function getFileFromManager($id)
    {
        $fileManager = FileManager::find($id);
        if ($fileManager) {
            $destinationPath = $fileManager->folder_name . DIRECTORY_SEPARATOR . $fileManager->file_name;
            if (Storage::disk(config('app.STORAGE_DRIVER'))->exists($destinationPath)) {
                if (config('app.STORAGE_DRIVER') == "local" || config('app.STORAGE_DRIVER') == "public") {
                    return asset('storage/' . $destinationPath);
                } else {
                    $s3 = Storage::disk(config('app.STORAGE_DRIVER'));
                    return $s3->url($destinationPath);
                }
            }
        }

        return NULL;
    }
}


if (!function_exists("showPrice")) {
    function showPrice($price)
    {
        $price = getNumberFormat($price);
        if (config('app.currencyPlacement') == 'after') {
            return $price.config('app.currencySymbol');
        } else {
            return config('app.currencySymbol').$price;
        }
    }
}


if (!function_exists("getNumberFormat")) {
    function getNumberFormat($amount)
    {
        return number_format($amount, 2, '.', '');
    }
}


if (!function_exists("getIsoCode")) {
    function getIsoCode()
    {
        $currency = Currency::where('current_currency', ACTIVE)->first();
        if ($currency) {
            $currency_code = $currency->currency_code;
            return $currency_code;
        }

        return '';
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date = null, $format = 'd M Y')
    {
        // Use current date if no date is provided
        $date = $date ? Carbon::parse($date) : Carbon::now();
        $formattedDate = $date->format($format);

        return $formattedDate;
    }
}
function gatewaySettings()
{
    $settings = [
        "paypal" => [
            ["label" => "Url", "name" => "url", "is_show" => 0],
            ["label" => "Client ID", "name" => "key", "is_show" => 1],
            ["label" => "Secret", "name" => "secret", "is_show" => 1]
        ],
        "stripe" => [
            ["label" => "Url", "name" => "url", "is_show" => 0],
            ["label" => "Public Key", "name" => "key", "is_show" => 0],
            ["label" => "Secret Key", "name" => "secret", "is_show" => 1]
        ],
        "razorpay" => [
            ["label" => "Url", "name" => "url", "is_show" => 0],
            ["label" => "Key", "name" => "key", "is_show" => 1],
            ["label" => "Secret", "name" => "secret", "is_show" => 1]
        ],
        "instamojo" => [
            ["label" => "Url", "name" => "url", "is_show" => 0],
            ["label" => "Api Key", "name" => "key", "is_show" => 1],
            ["label" => "Auth Token", "name" => "secret", "is_show" => 1]
        ],
        "mollie" => [
            ["label" => "Url", "name" => "url", "is_show" => 0],
            ["label" => "Mollie Key", "name" => "key", "is_show" => 1],
            ["label" => "Secret", "name" => "secret", "is_show" => 0]
        ],
        "paystack" => [
            ["label" => "Url", "name" => "url", "is_show" => 0],
            ["label" => "Public Key", "name" => "key", "is_show" => 1],
            ["label" => "Secret Key", "name" => "secret", "is_show" => 0]
        ],
        "mercadopago" => [
            ["label" => "Url", "name" => "url", "is_show" => 0],
            ["label" => "Client ID", "name" => "key", "is_show" => 1],
            ["label" => "Client Secret", "name" => "secret", "is_show" => 1]
        ],
        "sslcommerz" => [
            ["label" => "Url", "name" => "url", "is_show" => 0],
            ["label" => "Store ID", "name" => "key", "is_show" => 1],
            ["label" => "Store Password", "name" => "secret", "is_show" => 1]
        ],
        "flutterwave" => [
            ["label" => "Hash", "name" => "url", "is_show" => 1],
            ["label" => "Public Key", "name" => "key", "is_show" => 1],
            ["label" => "Client Secret", "name" => "secret", "is_show" => 1]
        ],
        "coinbase" => [
            ["label" => "Hash", "name" => "url", "is_show" => 0],
            ["label" => "API Key", "name" => "key", "is_show" => 1],
            ["label" => "Client Secret", "name" => "secret", "is_show" => 0]
        ],
        "binance" => [
            ["label" => "Url", "name" => "url", "is_show" => 0],
            ["label" => "Client ID", "name" => "key", "is_show" => 1],
            ["label" => "Client Secret", "name" => "secret", "is_show" => 1]
        ],
        "bitpay" => [
            ["label" => "Url", "name" => "url", "is_show" => 0],
            ["label" => "Key", "name" => "key", "is_show" => 1],
            ["label" => "Client Secret", "name" => "secret", "is_show" => 0]
        ],
        "iyzico" => [
            ["label" => "Url", "name" => "url", "is_show" => 0],
            ["label" => "Key", "name" => "key", "is_show" => 1],
            ["label" => "Secret", "name" => "secret", "is_show" => 1]
        ],
        "payhere" => [
            ["label" => "Url", "name" => "url", "is_show" => 0],
            ["label" => "Merchant ID", "name" => "key", "is_show" => 1],
            ["label" => "Merchant Secret", "name" => "secret", "is_show" => 1]
        ],
        "maxicash" => [
            ["label" => "Url", "name" => "url", "is_show" => 0],
            ["label" => "Merchant ID", "name" => "key", "is_show" => 1],
            ["label" => "Password", "name" => "secret", "is_show" => 1]
        ],
        "paytm" => [
            ["label" => "Industry Type", "name" => "url", "is_show" => 1],
            ["label" => "Merchant Key", "name" => "key", "is_show" => 1],
            ["label" => "Merchant ID", "name" => "secret", "is_show" => 1]
        ],
        "zitopay" => [
            ["label" => "Industry Type", "name" => "url", "is_show" => 0],
            ["label" => "Key", "name" => "key", "is_show" => 1],
            ["label" => "Merchant ID", "name" => "secret", "is_show" => 0]
        ],
        "cinetpay" => [
            ["label" => "Industry Type", "name" => "url", "is_show" => 0],
            ["label" => "API Key", "name" => "key", "is_show" => 1],
            ["label" => "Site ID", "name" => "secret", "is_show" => 1]
        ],
        "voguepay" => [
            ["label" => "Industry Type", "name" => "url", "is_show" => 0],
            ["label" => "Merchant ID", "name" => "key", "is_show" => 1],
            ["label" => "Merchant ID", "name" => "secret", "is_show" => 0]
        ],
        "toyyibpay" => [
            ["label" => "Industry Type", "name" => "url", "is_show" => 0],
            ["label" => "Secret Key", "name" => "key", "is_show" => 1],
            ["label" => "Category Code", "name" => "secret", "is_show" => 1]
        ],
        "paymob" => [
            ["label" => "Industry Type", "name" => "url", "is_show" => 0],
            ["label" => "API Key", "name" => "key", "is_show" => 1],
            ["label" => "Integration ID", "name" => "secret", "is_show" => 1]
        ],
        "alipay" => [
            ["label" => "APP ID", "name" => "url", "is_show" => 1],
            ["label" => "Public Key", "name" => "key", "is_show" => 1],
            ["label" => "Private Key", "name" => "secret", "is_show" => 1]
        ],
        "xendit" => [
            ["label" => "APP ID", "name" => "url", "is_show" => 0],
            ["label" => "Public Key", "name" => "key", "is_show" => 1],
            ["label" => "Secret", "name" => "secret", "is_show" => 0]
        ],
        "authorize" => [
            ["label" => "Industry Type", "name" => "url", "is_show" => 0],
            ["label" => "Login ID", "name" => "key", "is_show" => 1],
            ["label" => "Transaction Key", "name" => "secret", "is_show" => 1]
        ],
        "cash" => [
            ["label" => "Industry Type", "name" => "url", "is_show" => 0],
            ["label" => "Login ID", "name" => "key", "is_show" => 0],
            ["label" => "Transaction Key", "name" => "secret", "is_show" => 0]
        ]
    ];

    return json_encode($settings);
}


if (!function_exists('syncMissingGateway')) {
    function syncMissingGateway(): void
    {
        $users = \App\Models\User::all();
        $gateways = getPaymentServiceClass();

        foreach ($users as $user) {
            $existingGateways = \App\Models\Gateway::pluck('gateway_slug')->toArray();

            foreach ($gateways as $gatewaySlug => $gatewayService) {
                if (!in_array($gatewaySlug, $existingGateways)) {
                    $gateway = new \App\Models\Gateway();
                    $gateway->gateway_name = ucfirst($gatewaySlug);
                    $gateway->gateway_slug = $gatewaySlug;
                    $gateway->image = 'assets/images/gateway-icon/' . $gatewaySlug . '.png';
                    $gateway->status = 1;
                    $gateway->mode = 2;
                    $gateway->created_at = now();
                    $gateway->updated_at = now();
                    $gateway->save();
                }
            }
        }
    }
}


if (!function_exists('getProductType')) {
    function getProductType()
    {
        $productType = ProductType::where('status', ACTIVE)->get();

        return $productType;
    }
}

if (!function_exists('generateUniqueId')) {
    function generateUniqueId($prefix = '', $id = null)
    {
        $id = is_null($id) ? 1 : ($id + 1);
        return $prefix . sprintf('%08d', $id);
    }
}


if (!function_exists('getColorGroup')) {
    function getColorGroup($hexColor)
    {
        // Convert HEX to RGB
        list($r, $g, $b) = sscanf($hexColor, "%02x%02x%02x");

        // Define color groups
        if ($r < 50 && $g < 50 && $b < 50) {
            return 'Black';
        } elseif ($r > 200 && $g > 200 && $b > 200) {
            return 'White';
        } elseif ($r > 150 && $g > 150 && $b > 150) {
            return 'Gray';
        } elseif ($r > $g && $r > $b) {
            return 'Red';
        } elseif ($g > $r && $g > $b) {
            return 'Green';
        } elseif ($b > $r && $b > $g) {
            return 'Blue';
        } elseif ($r > 200 && $g > 200 && $b < 100) {
            return 'Yellow';
        } elseif ($r > 120 && $g > 70 && $b < 50) {
            return 'Brown';
        } else {
            return 'Other';
        }
    }
}

if(!function_exists("getAddonAppNameList")){
    function getAddonAppNameList($input = null): array|string
    {
        $output = ['PIXELAFFILIATE', 'PIXELDONATION', 'PIXELGATEWAY'];

        if (is_null($input)) {
            return $output;
        } else {
            return $output[$input];
        }
    }
}


if (!function_exists('getCustomerCurrentBuildVersion')) {
    function getCustomerCurrentBuildVersion()
    {
        $buildVersion = getOption('build_version');

        if (is_null($buildVersion)) {
            return 1;
        }

        return (int)$buildVersion;
    }
}

if (!function_exists('getCustomerAddonBuildVersion')) {
    function getCustomerAddonBuildVersion($code)
    {
        $buildVersion = getOption($code . '_build_version', 0);
        if (is_null($buildVersion)) {
            return 0;
        }
        return (int)$buildVersion;
    }
}

if (!function_exists('isAddonInstalled')) {
    function isAddonInstalled($code)
    {
        // return false;
        $buildVersion = getOption($code . '_build_version', 0);
        $codeBuildVersion = getAddonCodeBuildVersion($code);
        if ($buildVersion == 0 || $codeBuildVersion == 0) {
            return false;
        }
        return true;
    }
}

if (!function_exists('setCustomerAddonCurrentVersion')) {
    function setCustomerAddonCurrentVersion($code)
    {
        $option = Setting::firstOrCreate(['option_key' => $code . '_current_version']);
        $option->option_value = getAddonCodeCurrentVersion($code);
        $option->save();
    }
}

if (!function_exists('setCustomerAddonBuildVersion')) {
    function setCustomerAddonBuildVersion($code, $version)
    {
        $option = Setting::firstOrCreate(['option_key' => $code . '_build_version']);
        $option->option_value = $version;
        $option->save();
    }
}


if (!function_exists('getAddonCodeCurrentVersion')) {
    function getAddonCodeCurrentVersion($appCode)
    {
        Artisan::call("optimize:clear");
        return config('Addon.' . $appCode . '.current_version', 0);
    }
}

if (!function_exists('getAddonCodeBuildVersion')) {
    function getAddonCodeBuildVersion($appCode)
    {
        Artisan::call("optimize:clear");
        return config('Addon.' . $appCode . '.build_version', 0);
    }
}

if (!function_exists('setCustomerBuildVersion')) {
    function setCustomerBuildVersion($version)
    {
        $option = Setting::firstOrCreate(['option_key' => 'build_version']);
        $option->option_value = $version;
        $option->save();
    }
}

if (!function_exists('setCustomerCurrentVersion')) {
    function setCustomerCurrentVersion()
    {
        $option = Setting::firstOrCreate(['option_key' => 'current_version']);
        $option->option_value = config('app.current_version');
        $option->save();
    }
}


if (!function_exists('getDomainName')) {
    function getDomainName($url)
    {
        $parseUrl = parse_url(trim($url));
        if (isset($parseUrl['host'])) {
            $host = $parseUrl['host'];
        } else {
            $path = explode('/', $parseUrl['path']);
            $host = $path[0];
        }
        return trim($host);
    }
}

if (!function_exists('getSubscriptionData')) {
    function getSubscriptionData($customerId)
    {
        $subscriptionPlan = customerPlanExit($customerId);

        if (!$subscriptionPlan) {
            return [
                'subscriptionPlan' => null,
                'totalDownload' => 0,
                'downloadLimit' => 0,
            ];
        }

        $totalDownload = DownloadProduct::where('customer_id', $customerId)
            ->whereBetween('created_at', [$subscriptionPlan->start_date, $subscriptionPlan->end_date])
            ->where('download_accessibility_type', PRODUCT_ACCESSIBILITY_PAID)
            ->count();

        return [
            'subscriptionPlan' => $subscriptionPlan,
            'totalDownload' => $totalDownload,
            'downloadLimit' => $subscriptionPlan->plan->download_limit_type == PLAN_DOWNLOAD_LIMIT_TYPE_UNLIMITED
                ? __('Unlimited')
                : ($subscriptionPlan->plan->download_limit ?? 0),
        ];
    }
}

