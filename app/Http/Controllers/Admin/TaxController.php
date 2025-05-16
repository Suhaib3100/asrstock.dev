<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function index()
    {
        $data['pageTitle'] = 'Manage Tax';
        $data['navSettingsActiveClass'] = 'active';
        $data['subTaxActiveClass'] = 'active';
        $data['taxes'] = Tax::get();
        return view('admin.setting.general.tax', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'percentage' => 'required|numeric|gt:0|lte:100',
            'status' => 'required'
        ]);

        $source = new Tax();
        $source->name = $request->name;
        $source->percentage = $request->percentage;
        $source->status = $request->status;
        $source->save();

        return redirect()->back()->with('success', __('Created Successfully'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'percentage' => 'required|numeric|gt:0|lte:100',
            'status' => 'required'
        ]);
        $source = Tax::find($id);
        $source->name = $request->name;
        $source->percentage = $request->percentage;
        $source->status = $request->status;
        $source->save();

        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function delete($id)
    {
        Tax::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted Successfully'));
    }
}
