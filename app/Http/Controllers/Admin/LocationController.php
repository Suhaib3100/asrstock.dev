<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    public function countryIndex()
    {
        $data['pageTitle'] = 'Country Setting';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subCountryActiveClass'] = 'active';
        $data['countries'] = Country::all();

        return view('admin.setting.location.country', $data);
    }

    public function countryStore(Request $request)
    {
        $request->validate([
            'short_name' => 'required',
            'country_name' => 'required|unique:countries,country_name',
            'phonecode' => 'required',
            'continent' => 'required',
        ]);

        $country = new Country();
        $country->short_name = $request->short_name;
        $country->country_name = $request->country_name;
        $country->flag = Str::slug($request->short_name);
        $country->slug = Str::slug($request->name);
        $country->phonecode = $request->phonecode;
        $country->continent = $request->continent;
        $country->save();

        return redirect()->back()->with('success', __('Created Successfully'));
    }

    public function countryEdit($id)
    {
        $data['pageTitle'] = 'Country Setting';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subCountryActiveClass'] = 'active';
        $data['country'] = Country::findOrFail($id);

        return view('admin.setting.location.country-edit', $data);
    }

    public function countryUpdate(Request $request, $id)
    {
        $request->validate([
            'short_name' => 'required',
            'country_name' => 'required|unique:countries,country_name,' . $id,
            'phonecode' => 'required',
            'continent' => 'required',
        ]);

        $country = Country::findOrfail($id);
        $country->short_name = $request->short_name;
        $country->country_name = $request->country_name;
        $country->flag = Str::slug($request->short_name);
        $country->slug = Str::slug($request->name);
        $country->phonecode = $request->phonecode;
        $country->continent = $request->continent;
        $country->save();

        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function countryDelete($id)
    {
        $item = Country::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', __('Deleted Successfully'));
    }


    public function stateIndex()
    {
        $data['pageTitle'] = 'State Setting';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subStateActiveClass'] = 'active';
        $data['countries'] = Country::all();
        $data['states'] = State::all();

        return view('admin.setting.location.state', $data);
    }

    public function stateStore(Request $request)
    {
        $request->validate([
            'country_id' => 'required',
            'name' => 'required',
        ]);

        $country = new State();
        $country->country_id = $request->country_id;
        $country->name = $request->name;
        $country->save();

        return redirect()->back()->with('success', __('Created Successfully'));
    }

    public function stateEdit($id)
    {
        $data['pageTitle'] = 'State Setting';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subStateActiveClass'] = 'active';
        $data['countries'] = Country::all();
        $data['state'] = State::findOrFail($id);

        return view('admin.setting.location.state-edit', $data);
    }

    public function stateUpdate(Request $request, $id)
    {
        $request->validate([
            'country_id' => 'required',
            'name' => 'required',
        ]);

        $country = State::findOrfail($id);
        $country->country_id = $request->country_id;
        $country->name = $request->name;
        $country->save();

        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function stateDelete($id)
    {
        $item = State::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', __('Deleted Successfully'));
    }

    public function cityIndex()
    {
        $data['pageTitle'] = 'City Setting';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subCityActiveClass'] = 'active';
        $data['countries'] = Country::all();
        $data['states'] = State::all();
        $data['cities'] = City::all();

        return view('admin.setting.location.city', $data);
    }

    public function cityStore(Request $request)
    {
        $request->validate([
            'state_id' => 'required',
            'name' => 'required',
        ]);

        $country = new City();
        $country->state_id = $request->state_id;
        $country->name = $request->name;
        $country->save();

        return redirect()->back()->with('success', __('Created Successfully'));
    }

    public function cityEdit($id)
    {
        $data['pageTitle'] = 'State Setting';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subCityActiveClass'] = 'active';
        $data['states'] = State::all();
        $data['city'] = city::findOrFail($id);

        return view('admin.setting.location.city-edit', $data);
    }

    public function cityUpdate(Request $request, $id)
    {
        $request->validate([
            'state_id' => 'required',
            'name' => 'required',
        ]);

        $country = City::findOrfail($id);
        $country->state_id = $request->state_id;
        $country->name = $request->name;
        $country->save();

        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function cityDelete($id)
    {
        $item = City::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', __('Deleted Successfully'));
    }



}
