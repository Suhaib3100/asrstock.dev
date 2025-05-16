<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GatewayRequest;
use App\Models\Bank;
use App\Models\Gateway;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GatewayController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Gateway');
        $data['navGatewaySettingsActiveClass'] = 'active';
        $data['navSettingsActiveClass'] = 'active';
        $data['gateways'] = Gateway::all();

        return view('admin.setting.gateway.index', $data);
    }

    public function edit($id)
    {
        $data['pageTitle'] = __('Edit Gateway');
        $data['gateway'] = Gateway::findOrFail($id);
        $data['gatewaySettings'] = json_decode(gatewaySettings(), true)[$data['gateway']->gateway_slug] ?? [];
        $data['gatewayBanks'] = Bank::all();
        return view('admin.setting.gateway.edit', $data);
    }

    public function store(GatewayRequest $request)
    {
        DB::beginTransaction();
        try {
            $gateway = Gateway::findOrFail($request->id);
            if ($gateway->gateway_slug == 'bank') {
                $bankIds = [];
                foreach ($request->bank['name'] as $i => $name) {
                    $bank = Bank::updateOrCreate(
                        ['id' => $request->bank['id'][$i] ?? null],
                        ['gateway_id' => $gateway->id, 'name' => $name, 'details' => $request->bank['details'][$i], 'status' => ACTIVE]
                    );
                    $bankIds[] = $bank->id;
                }
                Bank::whereNotIn('id', $bankIds)->delete();
                $gateway->gateway_currency = $request->gateway_currency;
                $gateway->conversion_rate = $request->conversion_rate;
                $gateway->wallet_gateway_status = $request->wallet_gateway_status;
            } else {
                if ($gateway->gateway_slug == 'wallet') {
                    $request->conversion_rate = 1;
                    $request->gateway_currency = getCurrencyCode();
                }
                $gateway->gateway_name = $request->gateway_name;
                $gateway->gateway_currency = $request->gateway_currency;
                $gateway->mode = $request->mode == GATEWAY_MODE_LIVE ? GATEWAY_MODE_LIVE : GATEWAY_MODE_SANDBOX;
                $gateway->url = $request->url;
                $gateway->key = $request->key;
                $gateway->secret = $request->secret;
                $gateway->gateway_type = 2;
                $gateway->conversion_rate = $request->conversion_rate;
                $gateway->wallet_gateway_status = $request->wallet_gateway_status;
            }
            $gateway->status = $request->status;

            $gateway->save();

            DB::commit();
            $message = $request->id ? __(UPDATED_SUCCESSFULLY) : __(CREATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }


    public function syncs()
    {
        syncMissingGateway();
        return redirect()->back()->with('success', 'Gateways synced successfully!');
    }
}
