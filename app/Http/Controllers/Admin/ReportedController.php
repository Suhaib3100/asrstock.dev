<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportedCategory;
use App\Models\ReportedMember;
use App\Models\ReportedProduct;
use Illuminate\Http\Request;

class ReportedController extends Controller
{
    public function memberReportedIndex()
    {
        $data['pageTitle'] = 'Members Reported';
        $data['navMemberReportedActiveClass'] = 'active';
        $data['showReported'] = 'show';
        $data['memberReports'] = ReportedMember::latest()->get();
        return view('admin.reported.member-reported')->with($data);
    }

    public function memberReportedDelete($id)
    {
        ReportedMember::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    public function productReportedIndex()
    {
        $data['pageTitle'] = 'Products Reported';
        $data['navProductReportedActiveClass'] = 'active';
        $data['showReported'] = 'show';
        $data['productReports'] = ReportedProduct::latest()->get();
        return view('admin.reported.product-reported')->with($data);
    }

    public function productReportedDelete($id)
    {
        ReportedProduct::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    public function reportedCategoryIndex(Request $request)
    {
        $data['pageTitle'] = 'Reported Category';
        $data['navReportedCategoryActiveClass'] = 'active';
        $data['showReported'] = 'show';
        $data['reportedCategories'] = ReportedCategory::latest()->get();
        return view('admin.reported.category-list')->with($data);
    }

    public function reportedCategoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:reported_categories,name'
        ]);

        $category = new ReportedCategory();
        $category->name = $request->name;
        $category->status = $request->status ?? 1;
        $category->save();
        return redirect()->back()->with('success', 'Created Successfully');
    }

    public function reportedCategoryUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:reported_categories,name,'.$id
        ]);

        $category = ReportedCategory::findOrfail($id);
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function reportedCategoryDelete($id)
    {
        ReportedCategory::findOrfail($id)->delete();
        return redirect()->back()->with('success', 'Deleted Successfully');
    }
}
