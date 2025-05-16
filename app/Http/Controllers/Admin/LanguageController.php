<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileManager;
use App\Models\Language;
use App\Tools\Repositories\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class LanguageController extends Controller
{
    protected $model;
    public function __construct(Language $language)
    {
        $this->model = new Crud($language);
    }

    public function index()
    {
        $data['pageTitle'] = 'Manage Language';
        $data['navLanguageActiveClass'] = 'active';
        $data['navSettingsActiveClass'] = 'active';
        $data['languages'] = $this->model->getOrderById('DESC', 25);
        return view('admin.setting.language.index', $data);
    }

    public function create()
    {
        $data['pageTitle'] = 'Add Language';
        $data['navLanguageActiveClass'] = 'active';
        $data['navSettingsActiveClass'] = 'active';
        return view('admin.setting.language.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'language' => 'required|unique:languages,language',
            'iso_code' => 'required|unique:languages,iso_code'
        ]);

        $language = new Language();
        $language->language = $request->language;
        $language->iso_code = $request->iso_code;
        $language->rtl = $request->rtl ?? 0;
        $language->default_language = $request->default_language ?? 0;
        $language->status = $request->status ?? 0;
        $language->save();

        if ($request->hasFile('flag')) {
            $new_file = new FileManager();
            $upload = $new_file->upload('Language', $request->flag);
            if ($upload['status']) {
                $upload['file']->origin_id = $language->id;
                $upload['file']->origin_type = "App\Models\Language";
                $upload['file']->save();
            }
        }

        if ($request->default_language == ACTIVE) {
            Language::where('id', '!=', $language->id)->update(['default_language' => DISABLE]);
        }

        $defaultLanguage = Language::where('default_language', ACTIVE)->first();
        if ($defaultLanguage) {
            $ln = $defaultLanguage->iso_code;
            session(['local' => $ln]);
            App::setLocale(session()->get('local'));
        }
        // End:: Default language setup local

        $path = resource_path('lang/');
        fopen($path . "$request->iso_code.json", "w");
        file_put_contents($path . "$request->iso_code.json", '{}');

        return redirect()->route('admin.setting.language.translate', [$language->id])->with('success', __('Created Successfully'));
    }

    public function edit($id)
    {
        $data['pageTitle'] = 'Edit Language';
        $data['navLanguageActiveClass'] = 'active';
        $data['navSettingsActiveClass'] = 'active';
        $data['language'] = Language::findOrFail($id);
        return view('admin.setting.language.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $language = Language::findOrFail($id);
        $language->language = $request->language;
        $language->rtl = $request->rtl ?? 0;
        $language->default_language = $request->default_language ?? 0;
        $language->status = $request->status ?? 0;
        $language->save();

        if ($request->hasFile('flag')) {
            /*File Manager Call upload*/
            $new_file = FileManager::where('origin_type', 'App\Models\Language')->where('origin_id', $language->id)->first();
            if ($new_file) {
                $new_file->removeFile();
                $new_file->delete();
            } else {
                $new_file = new FileManager();
            }
            $upload = $new_file->upload('Language', $request->flag);
            if ($upload['status']) {
                $upload['file']->origin_id = $language->id;
                $upload['file']->origin_type = "App\Models\Language";
                $upload['file']->save();
            }
        }


        // Start:: Default language setup local
        if ($request->default_language == ACTIVE) {
            Language::where('id', '!=', $language->id)->update(['default_language' => DISABLE]);
        }

        $defaultLanguage = Language::where('default_language', ACTIVE)->first();
        if ($defaultLanguage) {
            $ln = $defaultLanguage->iso_code;
            session(['local' => $ln]);
            App::setLocale(session()->get('local'));
        }
        // End:: Default language setup local

        $path = resource_path() . "/lang/$language->iso_code.json";

        if (file_exists($path)) {
            $file_data = json_encode(file_get_contents($path));
            unlink($path);
            file_put_contents($path, json_decode($file_data));
        } else {
            fopen(resource_path() . "/lang/$language->iso_code.json", "w");
            file_put_contents(resource_path() . "/lang/$language->iso_code.json", '{}');
        }

        return redirect()->route('admin.setting.language.index')->with('success', __('Updated Successfully'));
    }


    public function translateLanguage($id)
    {
        $data['pageTitle'] = 'Translate';
        $data['navLanguageActiveClass'] = 'active';
        $data['navSettingsActiveClass'] = 'active';
        $data['language'] = Language::findOrFail($id);
        $iso_code = $data['language']->iso_code;

        $path = resource_path() . "/lang/$iso_code.json";
        if (!file_exists($path)) {
            fopen(resource_path() . "/lang/$iso_code.json", "w");
            file_put_contents(resource_path() . "/lang/$iso_code.json", '{}');
        }

        $data['translators'] = json_decode(file_get_contents(resource_path() . "/lang/$iso_code.json"), true);
        $data['languages'] = Language::where('iso_code', '!=', $iso_code)->get();

        return view('admin.setting.language.translate', $data);
    }

    public function updateTranslate(Request $request, $id)
    {
        try {
            $language =  Language::findOrFail($id);
            $keyArray = array();
            foreach ($request->key ?? [] as $value) {
                $keyArr = explode(' ', $value);
                foreach ($keyArr as $word) {
                    if (!str_contains($word, '_')) {
                        $strLowerWord = strtolower($word);
                        $modifiedWord = ucwords(trim($strLowerWord));
                        $value = str_replace($word, $modifiedWord, $value);
                    }
                }
                array_push($keyArray, $value);
            }

            $translator = array_filter(array_combine($keyArray, $request->value));
            file_put_contents(resource_path() . "/lang/$language->iso_code.json", json_encode($translator));

            $msgStatus = 'success';
            $msg = 'Save Successfully';
        } catch (\Exception $e) {
            $msgStatus = 'error';
            $msg = SOMETHING_WENT_WRONG;
        }

        return redirect()->back()->with($msgStatus, $msg);
    }

    public function delete($id)
    {
        $lang =  Language::findOrFail($id);
        if ($lang->default_language == ACTIVE) {
            return redirect()->back()->with('warning', __('You Cannot delete default language'));
        }

        $path = resource_path() . "/lang/$lang->iso_code.json";
        if (file_exists($path)) {
            @unlink($path);
        }

        $file = FileManager::where('origin_type', 'App\Models\Language')->where('origin_id', $lang->id)->first();
        if ($file) {
            $file->removeFile();
            $file->delete();
        }

        $lang->delete();

        return redirect()->back()->with('success', __('Deleted Successfully'));
    }

    public function import(Request $request)
    {
        $language = Language::where('iso_code', $request->import)->firstOrFail();
        $currentLang = Language::where('iso_code', $request->current)->firstOrFail();
        $contents = file_get_contents(resource_path() . "/lang/$language->iso_code.json");
        file_put_contents(resource_path() . "/lang/$currentLang->iso_code.json", $contents);

        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function updateLanguage(Request $request, $id)
    {
        $request->validate([
            'key' => 'required',
            'val' => 'required'
        ]);

        try {
            $language =  Language::findOrFail($id);
            $key = $request->key;
            $val = $request->val;
            $is_new = $request->is_new;
            $path = resource_path() . "/lang/$language->iso_code.json";
            $file_data = json_decode(file_get_contents($path), 1);

            if (!array_key_exists($key, $file_data)) {
                $file_data = array($key => $val) + $file_data;
            } else if ($is_new) {
                $response['msg'] = __("Already Exist");
                $response['status'] = 404;
                $response['type'] = $is_new;
                return response()->json($response);
            } else {
                $file_data[$key] = $val;
            }
            unlink($path);

            file_put_contents($path, json_encode($file_data));

            $response['msg'] = __("Translation Updated");
            $response['status'] = 200;
            $response['type'] = 0;
            return response()->json($response);
        } catch (\Exception $e) {
            $response['msg'] = __("Something went wrong!");
            $response['status'] = 404;
            $response['type'] = 0;
            return response()->json($response);
        }
    }
}
