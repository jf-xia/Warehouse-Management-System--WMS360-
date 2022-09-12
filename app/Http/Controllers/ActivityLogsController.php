<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ActivityLog;
use App\Traits\SearchCatalogue;
use App\Setting;
use Auth;
use App\Pagination;
use Arr;
use App\WoocommerceAccount;
use App\EbayAccount;
use App\OnbuyAccount;
use App\amazon\AmazonAccountApplication;
use App\Http\Controllers\Channel\ChannelFactory;
use App\Http\Controllers\Channel\EChannel;
use Illuminate\Support\Facades\Session;
use App\Traits\CommonFunction;

class ActivityLogsController extends Controller
{
    use SearchCatalogue;
    use CommonFunction;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pagination(){
        $user_id = Auth::user()->id;
        $page_info = Pagination::where('user_id',$user_id)->first();
        return $page_info->per_page;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
        try{
            //Start page title and pagination setting
            $settingData = $this->paginationSetting('activitylog', 'activity_log_active_product');
            $setting = $settingData['setting'];
            $page_title = '';
            $pagination = $settingData['pagination'];
            //End page title and pagination setting

            $channels = array();
            $wooChannels = array();
            $onbuyChannels = array();
            $amazonChannels = array();
            $temp = array();
            $wooTemp = array();
            $onbuyTemp = array();
            $amazonTemp = array();

            if(Session::get('woocommerce') == 1){
            $wooChannel = WoocommerceAccount::get()->all();
                foreach ($wooChannel as $woo){
                    $wooTemp[$woo->id] = $woo->account_name;
                }
            }
            if(Session::get('onbuy') == 1){
                $onbuyChannel = OnbuyAccount::get()->all();
                foreach ($onbuyChannel as $onbuy){
                    $onbuyTemp[$onbuy->id] = $onbuy->account_name;
                }
            }
            if(Session::get('ebay') == 1){
                $ebayChannel = EbayAccount::get()->all();
                foreach ($ebayChannel as $ebay){
                    $temp[$ebay->id] = $ebay->account_name;
                }
            }
            if(Session::get('amazon') == 1){
                $amazonChannel = AmazonAccountApplication::with(['accountInfo','marketPlace'])->get();
                if(count($amazonChannel) > 0){
                    foreach($amazonChannel as $amazon){
                        $amazonTemp[$amazon->id] = $amazon->application_name.'('.$amazon->accountInfo->account_name.' '.$amazon->marketPlace->marketplace.')';
                    }
                }
            }
            $channels["ebay"] = $temp;
            $wooChannels["woocommerce"] = $wooTemp;
            $onbuyChannels["onbuy"] = $onbuyTemp;
            $amazonChannels["amazon"] = $amazonTemp;


            // dd($request);
            // exit();
            $allActivityLogs = ActivityLog::where(function($order){
                $this->activityLogChannelRestriction($order);
            });
            $channel_name = new ChannelFactory;
            $channel_name = $channel_name->getChannelArray();
            $s_channels = array();
            foreach($channel_name as $s_channel){
                $s_channels[] = $s_channel->getChannelName();
            }
            // echo '<pre>';
            // print_r($s_channels);
            // exit();
            $isSearch = $request->get('is_search') ? true : false;
            $allCondition = [];
            if($isSearch){
                $this->activityLogSearchCondition($allActivityLogs, $request);
                $allCondition = $this->activiyLogSearchParams($request, $allCondition);
                //dd($allCondition);
            }
            $allActivityLogs = $allActivityLogs->orderByDesc('id')->paginate($pagination);
            // start on page refresh function call
            if($request->has('is_clear_filter')){
                $allActivityLogs = $allActivityLogs;

                $view = view('activity-logs.search_activity_log_list',compact('allActivityLogs'))->render();
                return response()->json(['html' => $view]);
            }
            // end on page refresh function call

            $activityLogs_info = json_decode(json_encode($allActivityLogs));

            return view('activity-logs.activity_log_list',compact('allActivityLogs', 'activityLogs_info', 'allCondition', 'url', 'pagination','channels','s_channels','wooChannels','onbuyChannels','amazonChannels','setting'));

        }catch (\Exception $e){
            return redirect('exception')->with('exception',$e->getMessage());
        }

    }


     /*
      * Function : paginationSetting
      * Route Type : null
      * Parameters : null
      * Creator : Solaiman
      * Description : This function is used for pagination setting
      * Created Date : 1-12-2020
      */

      public function paginationSetting ($firstKey, $secondKey = NULL) {
        $setting_info = Setting::where('user_id',Auth::user()->id)->first();
        $data['setting'] = null;
        $data['pagination'] = 50;
        if(isset($setting_info)) {
            if($setting_info->setting_attribute != null){
                $data['setting'] = \Opis\Closure\unserialize($setting_info->setting_attribute);
                if(array_key_exists($firstKey,$data['setting'])){
                    if($secondKey != null) {
                        if (array_key_exists($secondKey, $data['setting'][$firstKey])) {
                            $data['pagination'] = $data['setting'][$firstKey][$secondKey]['pagination'] ?? 50;
                        } else {
                            $data['pagination'] = 50;
                        }
                    }else{
                        $data['pagination'] = $data['setting'][$firstKey]['pagination'] ?? 50;
                    }
                }else{
                    $data['pagination'] = 50;
                }
            }else{
                $data['setting'] = null;
                $data['pagination'] = 50;
            }

        }else{
            $data['setting'] = null;
            $data['pagination'] = 50;
        }

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
        try{
            $updateActivityLog = ActivityLog::find($id);
            $updateActivityLog->solve_status = $request->solve_status;
            $updateActivityLog->action_status = $request->solve_status;
            $updateActivityLog->save();
            return back()->with('success', 'Updated Successfully');
        }catch(\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
