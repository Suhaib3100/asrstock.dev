<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUsTopic;
use Illuminate\Http\Request;

class ContactUsTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['pageTitle'] = 'Contact Us Topic List';
        $data['showContactUs'] = 'show';
        $data['subNavContactUsTopicIndexActiveClass'] = 'active';
        $data['contactUsTopics'] = ContactUsTopic::all();
        return view('admin.contact.topics', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(env('APP_DEMO') == 'active'){
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }

        $request->validate([
            'name' => 'required|string|unique:contact_us_topics,name|max:255'
        ]);

        $item = new ContactUsTopic();
        $item->name = $request->name;
        $item->status =  $request->status ?? 1;
        $item->save();
        return redirect()->back()->with('success', __('Created Successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(env('APP_DEMO') == 'active'){
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:contact_us_topics,name,' . $id
        ]);

        $item = ContactUsTopic::find($id);
        $item->name = $request->name;
        $item->status =  $request->status ?? 1;
        $item->save();
        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(env('APP_DEMO') == 'active'){
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }

        ContactUsTopic::findOrFail($id)->delete();
        return redirect()->back()->with('success', __('Deleted Successfully'));
    }
}
