<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function index()
    {
        $data['pageTitle'] = 'Manage Source';
        $data['navSettingsActiveClass'] = 'active';
        $data['subSourceActiveClass'] = "active";
        $data['sources'] = Source::all();
        return view('admin.setting.general.source', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required'
        ]);

        $source = new Source();
        $source->name = $request->name;
        $source->status = $request->status;
        $source->save();

        return redirect()->back()->with('success', __('Created Successfully'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required'
        ]);
        $source = Source::find($id);
        $source->name = $request->name;
        $source->status = $request->status;
        $source->save();

        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function delete($id)
    {
        Source::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted Successfully'));
    }
}
