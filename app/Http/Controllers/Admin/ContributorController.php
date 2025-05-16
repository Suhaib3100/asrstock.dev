<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendContributorStatusJob;
use App\Models\Customer;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContributorController extends Controller
{
    use ResponseTrait;

    public function index(Request $request, $status = null)
    {
        $contributors = Customer::where(function ($q) use ($request) {
            if ($request->search_string) {
                $q->where('email', 'like', "%{$request->search_string}%")
                    ->orWhere('contact_number', 'like', "%{$request->search_string}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$request->search_string}%"]);
            }
        })->orderBy('id', 'DESC');

        if ($status == null) {
            if (!Auth::user()->can('all_contributor')) {
                abort('403');
            }
            $data['pageTitle'] = __('All Contributor');
            $data['subNavAllContributorActiveClass'] = 'active';
            $data['showContributor'] = 'show';
            $contributors = $contributors->contributorApplyYes();

        } elseif ($status == CONTRIBUTOR_STATUS_PENDING) {
            if (!Auth::user()->can('pending_contributor')) {
                abort('403');
            }
            $data['pageTitle'] = __('Pending Contributor');
            $data['subNavPendingContributorActiveClass'] = 'active';
            $data['showContributor'] = 'show';
            $contributors = $contributors->contributorApplyYes()->where('contributor_status', CONTRIBUTOR_STATUS_PENDING)->latest();

        } elseif ($status == CONTRIBUTOR_STATUS_APPROVED) {
            if (!Auth::user()->can('approve_contributor')) {
                abort('403');
            }
            $data['pageTitle'] = __('Approved Contributor');
            $data['subNavApprovedContributorActiveClass'] = 'active';
            $data['showContributor'] = 'show';
            $contributors = $contributors->contributor()->contributorApplyYes()->where('contributor_status', CONTRIBUTOR_STATUS_APPROVED)->latest();

        } elseif ($status == CONTRIBUTOR_STATUS_HOLD) {
            if (!Auth::user()->can('hold_contributor')) {
                abort('403');
            }
            $data['pageTitle'] = __('Hold Contributor');
            $data['subNavHoldContributorActiveClass'] = 'active';
            $data['showContributor'] = 'show';
            $contributors = $contributors->contributorApplyYes()->where('contributor_status', CONTRIBUTOR_STATUS_HOLD)->latest();

        } elseif ($status == CONTRIBUTOR_STATUS_CANCELLED) {
            if (!Auth::user()->can('cancel_contributor')) {
                abort('403');
            }
            $data['pageTitle'] = __('Cancelled Contributor');
            $data['subNavCancelledContributorActiveClass'] = 'active';
            $data['showContributor'] = 'show';
            $contributors = $contributors->contributorApplyYes()->where('contributor_status', CONTRIBUTOR_STATUS_CANCELLED)->latest();
        }

        if ($request->ajax()) {
            return datatables($contributors)
                ->addIndexColumn()
                ->addColumn('image', function ($contributor) {
                    return '<div class="admin-dashboard-blog-list-img w-30 h-30 rounded-circle overflow-hidden">
                        <img src="' . $contributor->image . '" alt="img" class="w-100 h-100 object-fit-cover" />
                    </div>';
                })
                ->addColumn('status', function ($contributor) {
                    if ($contributor->contributor_status == CONTRIBUTOR_STATUS_PENDING) {
                        return '<span class="zBadge zBadge-pending">Pending</span>';
                    } elseif ($contributor->contributor_status == CONTRIBUTOR_STATUS_APPROVED) {
                        return '<span class="zBadge zBadge-approved">Approved</span>';
                    } elseif ($contributor->contributor_status == CONTRIBUTOR_STATUS_HOLD) {
                        return '<span class="zBadge zBadge-hold">Hold</span>';
                    } elseif ($contributor->contributor_status == CONTRIBUTOR_STATUS_CANCELLED) {
                        return '<span class="zBadge zBadge-cancel">Cancelled</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    return '<ul class="d-flex align-items-center cg-5 justify-content-end">
                        <li class="align-items-center d-flex gap-2">
                            <button onclick="getEditModal(\'' . route('admin.contributor.edit', $data->id) . '\', \'#edit-modal\')"
                                class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white"
                                data-bs-toggle="modal" data-bs-target="#edit-modal">
                                <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.8067 3.19354C12.0667 2.93354 12.0667 2.5002 11.8067 2.25354L10.2467 0.693535C10 0.433535 9.56667 0.433535 9.30667 0.693535L8.08 1.91354L10.58 4.41354M0 10.0002V12.5002H2.5L9.87333 5.1202L7.37333 2.6202L0 10.0002Z" fill="#5D697A"></path></svg>
                            </button>
                        </li>
                    </ul>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }
        $data['status'] = $status;
        return view('admin.contributor.index', $data);
    }

    public function edit($id)
    {
        $data['contributor'] = Customer::findOrFail($id);
        return view('admin.contributor.edit', $data);
    }

    public function statusUpdate(Request $request, $id)
    {
        if (env('APP_DEMO') == 'active') {
            $message = __('This is a demo version! You can get full access after purchasing the application.');
            return $this->error([], $message);
        }

        DB::beginTransaction();
        try {
            $data['contributor'] = Customer::find($id);
            if (!$data['contributor']) {
                $message = __('Contributor not found.');
                return $this->error([], $message);
            }

            if ($request->contributor_status == CONTRIBUTOR_STATUS_APPROVED) {
                $data['contributor']->role = CUSTOMER_ROLE_CONTRIBUTOR;
            }

            $data['contributor']->contributor_status = $request->contributor_status;
            $data['contributor']->save();

            if ($request->contributor_status == CONTRIBUTOR_STATUS_APPROVED) {
                $data['msg'] = 'Your contributor status has changed. Status has been approved.';
            } elseif ($request->contributor_status == CONTRIBUTOR_STATUS_HOLD) {
                $data['msg'] = 'Your contributor status has changed. Status has been hold.';
            } elseif ($request->contributor_status == CONTRIBUTOR_STATUS_CANCELLED) {
                $data['msg'] = 'Your contributor status has changed. Status has been cancelled.';
            } else {
                $data['msg'] = 'Your contributor status has changed. Status has been pending.';
            }

            try {
                if (getOption('app_mail_status')) {
                    SendContributorStatusJob::dispatch($data, $data['contributor']->email);
                }
            } catch (\Exception $e) {
                //
            }

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
