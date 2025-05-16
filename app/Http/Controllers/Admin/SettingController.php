<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Currency;
use App\Models\Faq;
use App\Models\FileManager;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\WhyUsPoint;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    use ResponseTrait;

    public function applicationSetting()
    {
        $data['pageTitle'] = __("Application Setting");
        $data['navSettingsActiveClass'] = 'active';
        $data['subApplicationSettingsActiveClass'] = 'active';
        $data['timezones'] = getTimeZone();

        return view('admin.setting.general_settings.application-settings')->with($data);
    }

    public function marketPlaceSetupSetting()
    {
        $data['pageTitle'] = __("Donation Setup");
        $data['navSettingsActiveClass'] = 'active';
        $data['navMarketPlaceSetUpActiveClass'] = 'active';

        return view('admin.setting.general_settings.marketplace-setup-settings')->with($data);
    }

    public function logoSettings()
    {
        $data['pageTitle'] = __("Logo Setting");
        $data['navSettingsActiveClass'] = 'active';
        $data['subLogoSettingsActiveClass'] = 'active';

        return view('admin.setting.general_settings.logo-settings')->with($data);
    }

    public function generalSetting()
    {
        $data['pageTitle'] = "General Setting";
        $data['navApplicationSettingParentActiveClass'] = 'active';
        $data['subNavGeneralSettingActiveClass'] = 'active';
        $data['subGeneralSettingActiveClass'] = 'active';
        $data['currencies'] = Currency::all();
        $data['current_currency'] = Currency::where('current_currency', ACTIVE)->first();
        $data['languages'] = Language::all();
        $data['default_language'] = Language::where('default_language', ACTIVE)->first();
        return view('admin.setting.general.general-settings')->with($data);
    }

    public function configurationSetting()
    {
        $data['pageTitle'] = __("Configuration Setting");
        $data['navConfigureActiveClass'] = 'active';

        return view('admin.setting.general_settings.configuration')->with($data);
    }

    public function configurationSettingUpdate(Request $request)
    {
        try {
            $option = Setting::firstOrCreate(['option_key' => $request->key]);
            $option->option_value = $request->value;
            $option->save();
            if ($request->key == 'app_debug') {
                $val = $option->option_value ? 'true' : 'false';
                setEnvironmentValue('APP_DEBUG', $val);
            }
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            return $this->failed([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function configurationSettingConfigure(Request $request)
    {
        if ($request->key == 'email_verification_status' || $request->key == 'app_mail_status') {
            return view('admin.setting.general_settings.configuration.form.email_configuration');
        } else if ($request->key == 'app_sms_status') {
            return view('admin.setting.general_settings.configuration.form.sms_configuration');
        } else if ($request->key == 'pusher_status') {
            return view('admin.setting.general_settings.configuration.form.pusher_configuration');
        } else if ($request->key == 'google_login_status') {
            return view('admin.setting.general_settings.configuration.form.social_login_google_configuration');
        } else if ($request->key == 'facebook_login_status') {
            return view('admin.setting.general_settings.configuration.form.social_login_facebook_configuration');
        } else if ($request->key == 'google_recaptcha_status') {
            return view('admin.setting.general_settings.configuration.form.google_recaptcha_configuration');
        } else if ($request->key == 'google_analytics_status') {
            return view('admin.setting.general_settings.configuration.form.google_analytics_configuration');
        } else if ($request->key == 'cookie_status') {
            return view('admin.setting.general_settings.configuration.form.cookie_configuration');
        }
    }

    public function applicationSettingUpdate(Request $request)
    {
        $validated = $request->validate([
            'app_preloader' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif',
            'app_logo' => 'nullable|mimes:jpeg,png,jpg,svg,webp,gif',
            'app_logo_white' => 'nullable|mimes:jpeg,png,jpg,svg,webp,gif',
            'app_fav_icon' => 'nullable|mimes:jpeg,png,jpg,svg,webp,gif',
            'water_mark_img' => 'nullable|mimes:jpeg,png,jpg',
        ]);
        $inputs = Arr::except($request->all(), ['_token']);

        foreach ($inputs as $key => $value) {

            $option = Setting::firstOrCreate(['option_key' => $key]);

            if ($request->hasFile('app_preloader') && $key == 'app_preloader') {
                $option->save();
                $upload = settingImageStoreUpdate($option->id, $request->app_preloader);
                $option->option_value = $upload;
                $option->save();
            } elseif ($request->hasFile('app_logo') && $key == 'app_logo') {
                $option->save();
                $upload = settingImageStoreUpdate($option->id, $request->app_logo);
                $option->option_value = $upload;
                $option->save();
            } elseif ($request->hasFile('app_logo_white') && $key == 'app_logo_white') {
                $option->save();
                $upload = settingImageStoreUpdate($option->id, $request->app_logo_white);
                $option->option_value = $upload;
                $option->save();
            } elseif ($request->hasFile('app_fav_icon') && $key == 'app_fav_icon') {
                $option->save();
                $upload = settingImageStoreUpdate($option->id, $request->app_fav_icon);
                $option->option_value = $upload;
                $option->save();
            } elseif ($request->hasFile('water_mark_img') && $key == 'water_mark_img') {
                $option->save();
                $upload = settingImageStoreUpdate($option->id, $request->water_mark_img);
                $option->option_value = $upload;
                $option->save();
            }else {
                $option->option_value = $value;
                $option->save();
            }
        }

        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }

    public function saveSetting(Request $request)
    {
        $inputs = Arr::except($request->all(), ['_token']);
        $this->updateSettings($inputs);
        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }

    private function updateSettings($inputs)
    {
        $keys = [];
        foreach ($inputs as $k => $v) {
            $keys[$k] = $k;
        }
        foreach ($inputs as $key => $value) {

            $option = Setting::firstOrCreate(['option_key' => $key]);
            $option->option_value = $value;
            $option->save();
            setEnvironmentValue($key, $value);
        }
    }

    public function configurationSettingHelp(Request $request)
    {
        if ($request->key == 'email_verification_status' || $request->key == 'app_mail_status') {
            return view('admin.setting.general_settings.configuration.help.email_help');
        } else if ($request->key == 'app_sms_status') {
            return view('admin.setting.general_settings.configuration.help.sms_help');
        } else if ($request->key == 'pusher_status') {
            return view('admin.setting.general_settings.configuration.help.pusher_help');
        } else if ($request->key == 'google_login_status') {
            return view('admin.setting.general_settings.configuration.help.social_login_google_help');
        } else if ($request->key == 'facebook_login_status') {
            return view('admin.setting.general_settings.configuration.help.social_login_facebook_help');
        } else if ($request->key == 'google_recaptcha_status') {
            return view('admin.setting.general_settings.configuration.help.google_recaptcha_credentials_help');
        } else if ($request->key == 'google_analytics_status') {
            return view('admin.setting.general_settings.configuration.help.google_analytics_help');
        } else if ($request->key == 'cookie_status') {
            return view('admin.setting.general_settings.configuration.help.cookie_consent_help');
        } else if ($request->key == 'referral_status') {
            return view('admin.setting.general_settings.configuration.help.referral_help');
        } else if ($request->key == 'two_factor_googleauth_status') {
            return view('admin.setting.general_settings.configuration.help.google_2fa_help');
        } else if ($request->key == 'app_preloader_status') {
            return view('admin.setting.general_settings.configuration.help.preloader_help');
        } else if ($request->key == 'disable_registration') {
            return view('admin.setting.general_settings.configuration.help.disable_registration_help');
        } else if ($request->key == 'registration_approval') {
            return view('admin.setting.general_settings.configuration.help.registration_approval_help');
        } else if ($request->key == 'force_secure_password') {
            return view('admin.setting.general_settings.configuration.help.force_secure_password_help');
        } else if ($request->key == 'show_agree_policy') {
            return view('admin.setting.general_settings.configuration.help.agree_policy_help');
        } else if ($request->key == 'enable_force_ssl') {
            return view('admin.setting.general_settings.configuration.help.enable_force_SSL_help');
        } else if ($request->key == 'enable_dark_mode') {
            return view('admin.setting.general_settings.configuration.help.enable_dark_mode_help');
        } else if ($request->key == 'show_language_switcher') {
            return view('admin.setting.general_settings.configuration.help.show_language_switcher_help');
        } else if ($request->key == 'register_file_required') {
            return view('admin.setting.general_settings.configuration.help.register_file_required_help');
        } else if ($request->key == 'app_debug') {
            return view('admin.setting.general_settings.configuration.help.app_debug_help');
        }
    }

    public function generalSettingUpdate(Request $request)
    {
        $inputs = Arr::except($request->all(), ['_token']);
        $keys = [];

        foreach ($inputs as $k => $v) {
            $keys[$k] = $k;
        }

        foreach ($inputs as $key => $value) {
            $option = Setting::firstOrCreate(['option_key' => $key]);

            if ($request->hasFile('app_preloader') && $key == 'app_preloader') {
                $upload = settingImageStoreUpdate($option->id, $request->app_preloader);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } elseif ($request->hasFile('app_logo') && $key == 'app_logo') {
                $upload = settingImageStoreUpdate($option->id, $request->app_logo);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } elseif ($request->hasFile('pwa_logo') && $key == 'pwa_logo') {
                $upload = settingImageStoreUpdate($option->id, $request->pwa_logo);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } elseif ($request->hasFile('app_fav_icon') && $key == 'app_fav_icon') {
                $upload = settingImageStoreUpdate($option->id, $request->app_fav_icon);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } elseif ($request->hasFile('app_logo_white') && $key == 'app_logo_white') {
                $upload = settingImageStoreUpdate($option->id, $request->app_logo_white);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } elseif ($request->hasFile('water_mark_img') && $key == 'water_mark_img') {
                $upload = settingImageStoreUpdate($option->id, $request->water_mark_img);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } elseif ($request->hasFile('contributor_third_portion_image') && $key == 'contributor_third_portion_image') {
                $request->validate([
                    'contributor_third_portion_image' => 'mimes:jpg,png,jpeg|file'
                ]);

                $upload = settingImageStoreUpdate($option->id, $request->contributor_third_portion_image);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } elseif ($request->hasFile('contributor_second_portion_image') && $key == 'contributor_second_portion_image') {
                $request->validate([
                    'contributor_second_portion_image' => 'mimes:jpg,png,jpeg|file'
                ]);

                $upload = settingImageStoreUpdate($option->id, $request->contributor_second_portion_image);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } elseif ($request->hasFile('contributor_fourth_portion_image') && $key == 'contributor_fourth_portion_image') {
                $request->validate([
                    'contributor_fourth_portion_image' => 'mimes:jpg,png,jpeg|file'
                ]);

                $upload = settingImageStoreUpdate($option->id, $request->contributor_fourth_portion_image);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } elseif ($request->hasFile('banner_image') && $key == 'banner_image') {
                $request->validate([
                    'banner_image' => 'mimes:jpg,png,jpeg|file'
                ]);

                $upload = settingImageStoreUpdate($option->id, $request->banner_image);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            }
            else {
                $request->validate([
                    'admin_product_commission' => 'numeric|min:0|max:100',
                    'admin_download_commission' => 'numeric|min:0|max:100',
                    'admin_donate_commission' => 'numeric|min:0|max:100',
                    'referral_commission' => 'numeric|min:0|max:100',
                ]);
                $option->option_value = $value;
                $option->type = 1;
                $option->save();
            }
        }

        /**  ====== Set Currency ====== */
        if ($request->currency_id) {
            Currency::where('id', $request->currency_id)->update(['current_currency' => ACTIVE]);
            Currency::where('id', '!=', $request->currency_id)->update(['current_currency' => DISABLE]);
        }

        /**  ====== Set Language ====== */
        if ($request->language_id) {
            Language::where('id', $request->language_id)->update(['default_language' => ACTIVE]);
            Language::where('id', '!=', $request->language_id)->update(['default_language' => DISABLE]);
            $language = Language::where('default_language', ACTIVE)->first();
            if ($language) {
                $ln = $language->iso_code;
                session(['local' => $ln]);
                App::setLocale(session()->get('local'));
            }
        }

        if ($request->get('app_color_design_type')) {
            $path = public_path('api/css/dynamic-color.css');
            if (file_exists($path)) {
                unlink($path);
            }

            $color = '';

            if ($request->get('app_color_design_type') == 2) {
                $color = ':root{   --section-bg: ' . getOption('app_section_bg_color') . ';
                --hero-bg: ' . getOption('app_hero_bg_color') . ';
                --primary-color: ' . getOption('app_primary_color') . ';
                --secondary-color: ' . getOption('app_secondary_color') . ';
                --white-color: #ffffff;
                --text-color: ' . getOption('app_text_color') . ';}';
            }

            file_put_contents($path, $color);
        }

        $path = public_path('api/manifest/manifest.json');
        if (file_exists($path)) {
            unlink($path);
        }

        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function generalSettingEnvUpdate(Request $request)
    {
        $inputs = Arr::except($request->all(), ['_token']);
        $keys = [];

        foreach ($inputs as $k => $v) {
            $keys[$k] = $k;
        }

        foreach ($inputs as $key => $value) {
            if ($key == 'app_mail_status') {
                $option = Setting::firstOrCreate(['option_key' => $key]);
                $option->option_value = $value;
                $option->type = 1;
                $option->save();
            }
            setEnvironmentValue($key, $value);
        }

        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function contactUsCMS()
    {
        $data['pageTitle'] = 'Contact Us CMS';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subContactUsCMSActiveClass'] = 'active';

        return view('admin.setting.contact-us', $data);
    }

    public function faq()
    {
        $data['pageTitle'] = 'FAQ Question & Answer';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subFaqActiveClass'] = 'active';
        $data['faqs'] = Faq::all();

        return view('admin.setting.faq', $data);
    }

    public function faqUpdate(Request $request)
    {
        $now = now();
        if ($request['faqs']) {
            if (count(@$request['faqs']) > 0) {
                foreach ($request['faqs'] as $faqs) {
                    if (@$faqs['question']) {
                        if (@$faqs['id']) {
                            $question_answer = Faq::find($faqs['id']);
                        } else {
                            $question_answer = new Faq();
                        }
                        $question_answer->question = @$faqs['question'];
                        $question_answer->answer = @$faqs['answer'];
                        $question_answer->updated_at = $now;
                        $question_answer->save();
                    }
                }
            }
        }

        Faq::where('updated_at', '!=', $now)->get()->map(function ($q) {
            $q->delete();
        });

        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function homeSettings()
    {
        $data['pageTitle'] = 'Home Setting';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subHomeActiveClass'] = 'active';

        return view('admin.setting.home.home-settings', $data);
    }

    public function whyUs()
    {
        $data['pageTitle'] = 'Why Us';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subWhyUsActiveClass'] = 'active';
        $data['points'] = WhyUsPoint::all();

        return view('admin.setting.home.why-us')->with($data);
    }

    public function whyUsUpdate(Request $request)
    {
        $request->validate([
            'why_us_title' => 'required|max:255',
            'why_us_subtitle' => 'required',
        ]);

        $inputs = Arr::except($request->all(), ['_token', 'why_us_points']);
        $keys = [];

        foreach ($inputs as $k => $v) {
            $keys[$k] = $k;
        }

        foreach ($inputs as $key => $value) {
            $option = Setting::firstOrCreate(['option_key' => $key]);
            if ($request->hasFile('why_us_image') && $key == 'why_us_image') {
                $request->validate([
                    'why_us_image' => 'mimes:jpg,png|file|dimensions:min_width=815,min_height=639,max_width=815,max_height=639'
                ]);

                $upload = settingImageStoreUpdate($option->id, $request->why_us_image);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } else {
                $option->option_value = $value;
                $option->type = 1;
                $option->save();
            }
        }

        $now = now();
        if ($request['why_us_points']) {
            if (count(@$request['why_us_points']) > 0) {
                foreach ($request['why_us_points'] as $why_us_point) {
                    if (@$why_us_point['id']) {
                        $point = WhyUsPoint::find($why_us_point['id']);
                    } else {
                        $point = new WhyUsPoint();
                    }
                    $point->updated_at = now();
                    $point->title = @$why_us_point['title'];
                    $point->save();

                    /*File Manager Call upload*/
                    if (@$why_us_point['id']) {
                        if (@$why_us_point['image']) {
                            $new_file = FileManager::where('origin_type', 'App\Models\WhyUsPoint')->where('origin_id', $point->id)->first();
                            if ($new_file) {
                                $new_file->removeFile();
                                $new_file->delete();
                            } else {
                                $new_file = new FileManager();
                            }
                            $upload = $new_file->upload('WhyUsPoint', $why_us_point['image']);
                            if ($upload['status']) {
                                $upload['file']->origin_id = $point->id;
                                $upload['file']->origin_type = "App\Models\WhyUsPoint";
                                $upload['file']->save();
                            }
                        }
                    } else {
                        if (@$why_us_point['image']) {
                            $new_file = new FileManager();
                            $upload = $new_file->upload('WhyUsPoint', $why_us_point['image']);

                            if ($upload['status']) {
                                $upload['file']->origin_id = $point->id;
                                $upload['file']->origin_type = "App\Models\WhyUsPoint";
                                $upload['file']->save();
                            }
                        }
                    }
                    /* End */

                }
            }
        }

        WhyUsPoint::where('updated_at', '!=', $now)->delete();

        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function testimonial()
    {
        $data['pageTitle'] = 'Testimonial';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subTestimonialActiveClass'] = 'active';
        $data['testimonials'] = Testimonial::all();

        return view('admin.setting.home.testimonial', $data);
    }

    public function testimonialUpdate(Request $request)
    {
        $request->validate([
            'testimonial_title' => 'required|max:255',
            'testimonial_subtitle' => 'required'
        ]);

        /*Setting Create or Update*/
        $inputs = Arr::except($request->all(), ['_token', 'testimonials']);
        $keys = [];

        foreach ($inputs as $k => $v) {
            $keys[$k] = $k;
        }

        foreach ($inputs as $key => $value) {
            $option = Setting::firstOrCreate(['option_key' => $key]);
            $option->option_value = $value;
            $option->type = 1;
            $option->save();
        }
        /*End*/

        $now = now();
        if ($request['testimonials']) {
            if (count($request['testimonials']) > 0) {
                foreach ($request['testimonials'] as $testimonial) {
                    if ($testimonial['name'] && $testimonial['designation'] && $testimonial['quote'] || @$testimonial['image']) {
                        if (@$testimonial['id']) {
                            $item = Testimonial::find($testimonial['id']);
                        } else {
                            $item = new Testimonial();
                        }

                        $item->name = $testimonial['name'];
                        $item->designation = $testimonial['designation'];
                        $item->quote = $testimonial['quote'];
                        $item->rating = $testimonial['rating'];
                        $item->updated_at = $now;
                        $item->save();

                        /*File Manager Call upload*/
                        if (@$testimonial['id']) {
                            if (@$testimonial['image']) {
                                $new_file = FileManager::where('origin_type', 'App\Models\Testimonial')->where('origin_id', $item->id)->first();
                                if ($new_file) {
                                    $new_file->removeFile();
                                    $new_file->delete();
                                } else {
                                    $new_file = new FileManager();
                                }
                                $upload = $new_file->upload('Testimonial', $testimonial['image']);
                                if ($upload['status']) {
                                    $upload['file']->origin_id = $item->id;
                                    $upload['file']->origin_type = "App\Models\Testimonial";
                                    $upload['file']->save();
                                }
                            }
                        } else {
                            if (@$testimonial['image']) {
                                $new_file = new FileManager();
                                $upload = $new_file->upload('Testimonial', $testimonial['image']);

                                if ($upload['status']) {
                                    $upload['file']->origin_id = $item->id;
                                    $upload['file']->origin_type = "App\Models\Testimonial";
                                    $upload['file']->save();
                                }
                            }
                        }
                        /*End*/
                    }
                }
            }
        }

        Testimonial::where('updated_at', '!=', $now)->get()->map(function ($q) {
            $file = FileManager::where('origin_type', 'App\Models\Testimonial')->where('origin_id', $q->id)->first();
            if ($file) {
                $file->removeFile();
                $file->delete();
            }
            $q->delete();
        });

        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function mailConfiguration()
    {
        $data['pageTitle'] = 'Mail Configuration';
        $data['navApplicationSettingParentActiveClass'] = 'active';
        $data['subNavMailConfigSettingsActiveClass'] = 'active';
        $data['subMailConfigSettingsActiveClass'] = 'active';
        return view('admin.setting.mail-configuration', $data);
    }

    public function sendTestMail(Request $request)
    {
        $data = $request;
        try {
            Mail::to($request->to)->send(new TestMail($data));
        } catch (\Exception $exception) {
            if (env('APP_DEBUG')) {
                return redirect()->back()->with('error', $exception->getMessage());
            } else {
                return redirect()->back()->with('error', 'Something is wrong. Please check your email settings');
            }
        }
        return redirect()->back()->with('success', 'Mail Successfully send.');
    }

    public function colorSettings()
    {
        $data['pageTitle'] = 'Color Setting';
        $data['navSettingsActiveClass'] = 'active';
        $data['subColorSettingActiveClass'] = 'active';
        return view('admin.setting.general.color-settings', $data);
    }

    public function storageSetting()
    {
        $data['pageTitle'] = "Storage Setting";
        $data['navSettingsActiveClass'] = 'active';
        $data['subStorageSettingsActiveClass'] = 'active';
        return view('admin.setting.general_settings.storage-setting')->with($data);
    }

    public function storageSettingsUpdate(Request $request)
    {
        if ($request->STORAGE_DRIVER == STORAGE_DRIVER_AWS) {
            $values = $request->validate([
                'AWS_ACCESS_KEY_ID' => 'bail|required',
                'AWS_SECRET_ACCESS_KEY' => 'bail|required',
                'AWS_DEFAULT_REGION' => 'bail|required',
                'AWS_BUCKET' => 'bail|required',
            ]);
        } elseif ($request->STORAGE_DRIVER == STORAGE_DRIVER_WASABI) {
            $values = $request->validate([
                'WASABI_ACCESS_KEY_ID' => 'bail|required',
                'WASABI_SECRET_ACCESS_KEY' => 'bail|required',
                'WASABI_DEFAULT_REGION' => 'bail|required',
                'WASABI_BUCKET' => 'bail|required',
            ]);
        } elseif ($request->STORAGE_DRIVER == STORAGE_DRIVER_VULTR) {
            $values = $request->validate([
                'VULTR_ACCESS_KEY_ID' => 'bail|required',
                'VULTR_SECRET_ACCESS_KEY' => 'bail|required',
                'VULTR_DEFAULT_REGION' => 'bail|required',
                'VULTR_BUCKET' => 'bail|required',
            ]);
        } elseif ($request->STORAGE_DRIVER == STORAGE_DRIVER_DO) {
            $values = $request->validate([
                'DO_ACCESS_KEY_ID' => 'bail|required',
                'DO_SECRET_ACCESS_KEY' => 'bail|required',
                'DO_DEFAULT_REGION' => 'bail|required',
                'DO_BUCKET' => 'bail|required',
                'DO_FOLDER' => 'bail|required',
                'DO_CDN_ID' => 'bail|required',
            ]);
        }
        $values['STORAGE_DRIVER'] = $request->STORAGE_DRIVER;
        if (!updateEnv($values)) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        } else {
            Artisan::call('optimize:clear');
            $this->updateSettings($values);
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        }
    }

    public function storageLink()
    {
        try {
            if (file_exists(public_path('storage'))) {
                Artisan::call('storage:link');
                return redirect()->back()->with('success', 'Created Storage Link Updated Successfully');
            } else {
                Artisan::call('storage:link');
            }
            return redirect()->back()->with('success', 'Created Storage Link Updated Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function googleAdsenseSetting()
    {
        $data['pageTitle'] = "Google Adsense Setting";
        $data['navSettingsActiveClass'] = 'active';
        $data['subGoogleAdsenseSettingActiveClass'] = 'active';
        return view('admin.setting.general.google-adsense')->with($data);
    }

    public function google2faSetting()
    {
        $data['pageTitle'] = "Google 2FA Setting";
        $data['navApplicationSettingParentActiveClass'] = 'active';
        $data['subNavGeneralSettingActiveClass'] = 'active';
        $data['subExtensionSettingActiveClass'] = 'active';
        return view('admin.setting.general.google-2fa')->with($data);
    }

    public function socialLoginSetting()
    {
        $data['pageTitle'] = "Social Login Setting";
        $data['navApplicationSettingParentActiveClass'] = 'active';
        $data['subNavGeneralSettingActiveClass'] = 'active';
        $data['subSocialLoginSettingActiveClass'] = 'active';
        return view('admin.setting.general.social-login-settings')->with($data);
    }

    public function beAContributor()
    {
        $data['pageTitle'] = 'Be A Contributor CMS';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subNavBeAContributorActiveClass'] = 'active';
        return view('admin.setting.be-a-contributor')->with($data);
    }

    public function googleRecaptchaSetting()
    {
        $data['pageTitle'] = "Google Recaptcha Setting";
        $data['navApplicationSettingParentActiveClass'] = 'active';
        $data['subNavGeneralSettingActiveClass'] = 'active';
        $data['subExtensionSettingActiveClass'] = 'active';
        return view('admin.setting.general.google-recaptcha-settings')->with($data);
    }

    public function googleAnalytics()
    {
        $data['pageTitle'] = __("Analytics Setting");
        $data['navApplicationSettingParentActiveClass'] = 'active';
        $data['subNavGeneralSettingActiveClass'] = 'active';
        $data['subExtensionSettingActiveClass'] = 'active';
        return view('admin.setting.general.google_analytics')->with($data);
    }

    public function maintenanceMode()
    {
        $data['pageTitle'] = 'Maintenance Mode Settings';
        $data['navSettingsActiveClass'] = 'active';
        $data['subMaintenanceModeActiveClass'] = 'active';

        return view('admin.setting.general_settings.maintenance-mode', $data);
    }

    public function maintenanceModeChange(Request $request)
    {
        if ($request->maintenance_mode == 1) {
            $request->validate(
                [
                    'maintenance_mode' => 'required',
                    'maintenance_secret_key' => 'required|min:6'
                ],
                [
                    'maintenance_secret_key.required' => 'The maintenance mode secret key is required.',
                ]
            );
        } else {
            $request->validate([
                'maintenance_mode' => 'required',
            ]);
        }

        $inputs = Arr::except($request->all(), ['_token']);
        $keys = [];

        foreach ($inputs as $k => $v) {
            $keys[$k] = $k;
        }

        foreach ($inputs as $key => $value) {
            $option = Setting::firstOrCreate(['option_key' => $key]);
            $option->option_value = $value;
            $option->save();
        }

        if ($request->maintenance_mode == 1) {
            Artisan::call('up');
            $secret_key = 'down --secret="' . $request->maintenance_secret_key . '"';
            Artisan::call($secret_key);
        } else {
            $option = Setting::firstOrCreate(['option_key' => 'maintenance_secret_key']);
            $option->option_value = null;
            $option->save();
            Artisan::call('up');
        }

        return redirect()->back()->with('success', 'Maintenance Mode Has Been Changed');
    }

    public function cacheSettings()
    {
        $data['pageTitle'] = 'Cache Settings';
        $data['navSettingsActiveClass'] = 'active';
        $data['subCacheActiveClass'] = 'active';

        return view('admin.setting.cache-settings', $data);
    }

    public function authPageSettings()
    {
        $data['pageTitle'] = 'Auth Page Settings';
        $data['navApplicationSettingParentActiveClass'] = 'active';
        $data['subAuthPageSettingsActiveClass'] = 'active';
        $data['subCacheActiveClass'] = 'active';

        return view('admin.setting.auth-page', $data);
    }

    public function cacheUpdate($id)
    {
        if ($id == 1) {
            Artisan::call('view:clear');
            return redirect()->back()->with('success', 'Views cache cleared successfully');
        } elseif ($id == 2) {
            Artisan::call('route:clear');
            return redirect()->back()->with('success', 'Route cache cleared successfully');
        } elseif ($id == 3) {
            Artisan::call('config:clear');
            return redirect()->back()->with('success', 'Configuration cache cleared successfully');
        } elseif ($id == 4) {
            Artisan::call('cache:clear');
            return redirect()->back()->with('success', 'Application cache cleared successfully');
        } elseif ($id == 5) {
            try {
                $dirname = public_path("storage");
                if (is_dir($dirname)) {
                    rmdir($dirname);
                }

                Artisan::call('storage:link');
                return redirect()->back()->with('success', 'Application Storage Linked successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
        return redirect()->back();
    }


    public function migrateUpdate()
    {
        Artisan::call('migrate');
        return redirect()->back()->with('success', 'Migrated Successfully');
    }
}
