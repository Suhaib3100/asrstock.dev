<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Following;
use App\Models\Product;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    use ResponseTrait;

    public function index(Request $request, $status = null)
    {
        $customerData = Customer::where(function ($q) use ($request) {
            if ($request->search_string) {
                $q->where('email', 'like', "%{$request->search_string}%")
                    ->orWhere('contact_number', 'like', "%{$request->search_string}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$request->search_string}%"]);
            }
        })->orderBy('id','DESC');

        if ($status == null) {
            if (!Auth::user()->can('all_customer')) {
                abort('403');
            }
            $data['pageTitle'] = 'All Customer';
            $data['subNavAllCustomerActiveClass'] = 'active';
            $data['showCustomer'] = 'show';
        } elseif ($status == ACTIVE) {
            if (!Auth::user()->can('active_customer')) {
                abort('403');
            }
            $data['pageTitle'] = 'Active Customer';
            $data['subNavActiveCustomerActiveClass'] = 'active';
            $data['showCustomer'] = 'show';
            $customerData = $customerData->where('status',$status);
        } elseif ($status == PENDING) {
            if (!Auth::user()->can('pending_customer')) {
                abort('403');
            }
            $data['pageTitle'] = __('Pending Customer');
            $data['subNavPendingCustomerActiveClass'] = 'active';
            $data['showCustomer'] = 'show';
            $customerData = $customerData->where('status',$status);
        } elseif ($status == DISABLE) {
            if (!Auth::user()->can('disable_customer')) {
                abort('403');
            }
            $data['pageTitle'] = 'Disable Customer';
            $data['subNavDisableCustomerActiveClass'] = 'active';
            $data['showCustomer'] = 'show';
            $customerData = $customerData->where('status',$status);
        }

        if($request->ajax()){
            return datatables($customerData)
                ->editColumn('image', function ($data) {
                    return '<div class="admin-dashboard-blog-list-img w-30 h-30 rounded-circle overflow-hidden">
                        <a class="test-popup-link" href="' . $data->image . '">
                            <img src="' . $data->image . '" alt="img" class="w-100 h-100 object-fit-cover">
                        </a>
                    </div>';
                })
                ->editColumn('role', function ($data) {
                    return $data->role == CUSTOMER_ROLE_CUSTOMER ? 'Customer' : 'Customer & Contributor';
                })
                ->editColumn('wallet_balance', function ($data) {
                    return '<span class="text-end">' . showPrice($data->wallet_balance) . '</span>';
                })
                ->editColumn('earning_balance', function ($data) {
                    return '<span class="text-end">' . showPrice($data->earning_balance) . '</span>';
                })
                ->editColumn('status', function ($data) {
                    if($data->status == ACTIVE){
                        return '<span class="zBadge zBadge-active">Active</span>';
                    }elseif ($data->status == PENDING){
                        return '<span class="zBadge zBadge-pending">Pending</span>';
                    }elseif ($data->status == DISABLE){
                        return '<span class="zBadge zBadge-disabled">Disable</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    return '<ul class="d-flex align-items-center cg-5 justify-content-end">
                        <li class="align-items-center d-flex gap-2">
                            <button onclick="getEditModal(\'' . route('admin.customer.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.8067 3.19354C12.0667 2.93354 12.0667 2.5002 11.8067 2.25354L10.2467 0.693535C10 0.433535 9.56667 0.433535 9.30667 0.693535L8.08 1.91354L10.58 4.41354M0 10.0002V12.5002H2.5L9.87333 5.1202L7.37333 2.6202L0 10.0002Z" fill="#5D697A"></path></svg>
                            </button>
                            <button onclick="deleteItem(\'' . route('admin.customer.delete', $data->uuid) . '\', \'customer-datatable\')"
                                class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white"
                                title="Delete">
                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.76256 2.51256C6.09075 2.18437 6.53587 2 7 2C7.46413 2 7.90925 2.18437 8.23744 2.51256C8.4448 2.71993 8.59475 2.97397 8.67705 3.25H5.32295C5.40525 2.97397 5.5552 2.71993 5.76256 2.51256ZM3.78868 3.25C3.89405 2.57321 4.21153 1.94227 4.7019 1.4519C5.3114 0.84241 6.13805 0.5 7 0.5C7.86195 0.5 8.6886 0.84241 9.2981 1.4519C9.78847 1.94227 10.106 2.57321 10.2113 3.25H13C13.4142 3.25 13.75 3.58579 13.75 4C13.75 4.41422 13.4142 4.75 13 4.75H12V13C12 13.3978 11.842 13.7794 11.5607 14.0607C11.2794 14.342 10.8978 14.5 10.5 14.5H3.5C3.10217 14.5 2.72064 14.342 2.43934 14.0607C2.15804 13.7794 2 13.3978 2 13V4.75H1C0.585786 4.75 0.25 4.41422 0.25 4C0.25 3.58579 0.585786 3.25 1 3.25H3.78868ZM5 6.37646C5.34518 6.37646 5.625 6.65629 5.625 7.00146V11.003C5.625 11.3481 5.34518 11.628 5 11.628C4.65482 11.628 4.375 11.3481 4.375 11.003V7.00146C4.375 6.65629 4.65482 6.37646 5 6.37646ZM9.625 7.00146C9.625 6.65629 9.34518 6.37646 9 6.37646C8.65482 6.37646 8.375 6.65629 8.375 7.00146V11.003C8.375 11.3481 8.65482 11.628 9 11.628C9.34518 11.628 9.625 11.3481 9.625 11.003V7.00146Z" fill="#5D697A"></path></svg>
                            </button>
                        </li>
                    </ul>';
                })
                ->rawColumns(['image', 'wallet_balance', 'earning_balance', 'status', 'action'])
                ->make(true);
        }

        $data['status'] = $status;
        return view('admin.customer.index',$data);
    }

    public function delete($uuid)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::where('uuid', $uuid)->firstOrFail();
            Following::where('customer_id', Auth::id())->orWhere('following_customer_id', Auth::id())->delete();
            Product::where('customer_id', Auth::id())->delete();
            $customer->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function edit($id)
    {
        $data['customer'] = Customer::findOrFail($id);
        return view('admin.customer.edit', $data);
    }

    public function statusUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $customer = Customer::findOrfail($id);
            $customer->status = $request->status;
            $customer->save();

            DB::commit();
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

}
