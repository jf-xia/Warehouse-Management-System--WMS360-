<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Category;
use App\Client;
use App\Invoice;
use App\Order;
use App\ProductDraft;
use App\ProductOrder;
use App\ProductVariation;
use App\ReturnOrder;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use function foo\func;
use App\Channel;
use App\Traits\CommonFunction;

class DashboardController extends Controller
{
    use CommonFunction;
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
     * Function : Index
     * Route : dashboard
     * Creator : Kazol
     * Modifier : Kazol,Solaiman
     * Description : This function is used for displaying all the information of dashboard content
     * Created Date: unknown
     * Modified Date : 11-11-2020, 17-11-2021
     */
    public function index()
    {
        //dd(Session::get('onbuy'));
        $data['top_product'] = $this->topProductData('all');

        $commitHash = trim(exec('git describe --tags --abbrev=0'));
        $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
        $commitDate->setTimezone(new \DateTimeZone('Europe/London'));
        $appVersion = sprintf('%s (%s)', $commitHash, $commitDate->format('d-m-Y'));
        Session::put('appVersion',$appVersion);

        $clientShelfUse = Client::first()->shelf_use;
        Session::put('shelf_use',$clientShelfUse);
        $total_product_info = ProductVariation::select('product_variation.id AS p_id','product_variation.cost_price','product_shelfs.quantity')
            ->join('product_shelfs','product_variation.id','=','product_shelfs.variation_id')
            ->where([['product_variation.cost_price','!=',null],['product_variation.deleted_at','=',null]])
            ->where('product_shelfs.quantity','!=',0)
            ->get();
        $data['total_cost_price'] = 0;
        if(count($total_product_info) > 0) {
            foreach ($total_product_info as $info) {
                $data['total_cost_price'] += ($info->cost_price * $info->quantity);
            }
        }

        $data['total_order'] = Order::where(function($order){
            $this->channel_restriction_order_session($order);
        })->get()->count();
        $data['total_product'] = ProductVariation::get()->count();
        $data['total_invoice'] = Invoice::get()->count();
        $data['total_catalogue'] = ProductDraft::get()->count();

        $data['last_week_total_order'] = Order::where(function($order){
            $this->channel_restriction_order_session($order);
        })->whereDate('date_created', '>', Carbon::now()->subDays(7))->count();
        $data['last_week_total_product'] = ProductVariation::whereDate('created_at', '>', Carbon::now()->subDays(7))->count();
        $data['last_week_total_invoice'] = Invoice::whereDate('created_at', '>', Carbon::now()->subDays(7))->count();
        $data['last_week_total_catalogue'] = ProductDraft::whereDate('created_at', '>', Carbon::now()->subDays(7))->count();

        $data['last_month_total_order'] = Order::where(function($order){
            $this->channel_restriction_order_session($order);
        })->whereDate('date_created', '>', Carbon::now()->subDays(30))->count();
        $data['last_month_total_product'] = ProductVariation::whereDate('created_at', '>', Carbon::now()->subDays(30))->count();
        $data['last_month_total_invoice'] = Invoice::whereDate('created_at', '>', Carbon::now()->subDays(30))->count();
        $data['last_month_total_catalogue'] = ProductDraft::whereDate('created_at', '>', Carbon::now()->subDays(30))->count();

        $data['today_order'] = Order::where(function($order){
            $this->channel_restriction_order_session($order);
        })->whereDate('date_created', '=', Carbon::now())->count();
        $data['today_product'] = ProductVariation::whereDate('created_at', '=', Carbon::now())->count();
        $data['today_invoice'] = Invoice::whereDate('created_at', '=', Carbon::now())->count();
        $data['today_catalogue'] = ProductDraft::whereDate('created_at', '=', Carbon::now())->count();

        // $data['top_product'] = ProductOrder::with(['variation_info' => function ($query) {
        //     $query->select('id','product_draft_id','image','sale_price','cost_price','attribute')->with(['product_draft' => function($query){
        //         $query->select('id','name')->with('single_image_info:id,draft_product_id,image_url');
        //     }]);
        // }])->select('variation_id',DB::raw('COUNT(variation_id) as total_order'),DB::raw('sum(price) as total_sale'))
        //     ->groupBy('variation_id')
        //     ->orderBy('total_order','desc')
        //     ->paginate(20);
        $data['top_country'] = Order::select('customer_country',DB::raw('COUNT(customer_country) as total_country'))
            ->where('customer_country','!=', '')
            ->where(function($order){
                $this->channel_restriction_order_session($order);
            })
            ->groupBy('customer_country')
            ->orderBy('total_country','desc')
            ->paginate(20);
        $data['top_channel'] = Order::select('created_via',DB::raw('COUNT(created_via) as total_channel'))
            ->where(function($order){
                $this->channel_restriction_order_session($order);
            })
            ->groupBy('created_via')
            ->orderBy('total_channel','desc')
            ->paginate(20);
        $country_arr = [];
        if(count($data['top_country']) > 0) {
            foreach ($data['top_country'] as $country) {
                $country_arr[] = [
                    'id' => $country->customer_country,
                    'name' => $country->customer_country,
                    'value' => $country->total_country,
                    'color' => '#7266ba'
                ];
            }
        }

        $data['country_map'] = json_encode($country_arr);
        $data ['total_sell'] = Order::where(function($order){
            $this->channel_restriction_order_session($order);
        })->doesntHave('returnOrder')->where('status','!=','cancelled')->sum('total_price');
        $data ['last_month_sell'] = Order::where(function($order){
            $this->channel_restriction_order_session($order);
        })->doesntHave('returnOrder')->where('status','!=','cancelled')->whereDate('date_created',' >' , Carbon::now()->subDays(30))->sum('total_price');
        $data ['last_week_sell'] = Order::where(function($order){
            $this->channel_restriction_order_session($order);
        })->doesntHave('returnOrder')->where('status','!=','cancelled')->whereDate('date_created', '>', Carbon::now()->subDays(7))->sum('total_price');
        $data ['today_sell'] = Order::where(function($order){
            $this->channel_restriction_order_session($order);
        })->doesntHave('returnOrder')->where('status','!=','cancelled')->whereDate('date_created', '=', Carbon::now())->sum('total_price');

        $data ['complete_order_sell'] = Order::where(function($order){
            $this->channel_restriction_order_session($order);
        })->doesntHave('returnOrder')->where(['status' =>'completed'])->sum('total_price');
        $data ['processing_order_sell'] = Order::where(function($order){
            $this->channel_restriction_order_session($order);
        })->doesntHave('returnOrder')->where(['status' =>'processing'])->sum('total_price');
        $data ['onhold_order_sell'] = Order::where(function($order){
            $this->channel_restriction_order_session($order);
        })->doesntHave('returnOrder')->where(['status' =>'on-hold'])->sum('total_price');
        $data ['return_order'] = ReturnOrder::count();
        $data ['ebay_total_sell'] = $this->checkChannelActiveBySessionValue('ebay') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'ebay'])->sum('total_price'),2) : 0.00;
        $data ['amazon_total_sell'] = $this->checkChannelActiveBySessionValue('amazon') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'amazon'])->sum('total_price'),2) : 0.00;
        $data ['tbo_total_sell'] = $this->checkChannelActiveBySessionValue('woocommerce') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'checkout'])->sum('total_price'),2) : 0.00;
        $data ['manual_total_sell'] = round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'rest-api'])->sum('total_price'),2);
        $data ['onbuy_total_sell'] = $this->checkChannelActiveBySessionValue('onbuy') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'onbuy'])->sum('total_price'),2) : 0.00;
        $data ['shopify_total_sell'] = $this->checkChannelActiveBySessionValue('shopify') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'shopify'])->sum('total_price'),2) : 0.00;

        $data['group_channel'] = Order::where(function($order){
            $this->channel_restriction_order_session($order);
        })->doesntHave('returnOrder')->where('status','!=','cancelled')->select('created_via',DB::raw('sum(total_price) as total_price'))
            ->groupBy('created_via')->orderBy('total_price','desc')->get();
        $channel_arr = [];
        if(count($data['group_channel']) > 0) {
            foreach ($data['group_channel'] as $channel) {
                $channel_arr[] = [
                    'ChannelFactory' => ($channel->created_via == 'ebay' || $channel->created_via == 'Ebay') ? 'eBay' : (($channel->created_via == 'checkout') ? 'Website' : (($channel->created_via == 'rest-api') ? 'E Pos' : (($channel->created_via == 'amazon') ? 'Amazon' : (($channel->created_via == 'onbuy') ? 'OnBuy' : $channel->created_via)))),
                    'salesPrice' => $channel->total_price
                ];
            }
        }
        $data['order_channel'] = json_encode($channel_arr);
        $data['group_sale'] = Order::where(function($order){
            $this->channel_restriction_order_session($order);
        })->doesntHave('returnOrder')->where('status','!=','cancelled')->select(DB::raw("DATE_FORMAT(date_created,'%Y-%m-%d') as date "),DB::raw('sum(total_price) as total_price'))
//            ->where('date_created', '>=', DB::raw('DATE(NOW()) - INTERVAL 30 DAY'))
            ->whereDate('date_created','>=',Carbon::today()->subDays(30))
            ->where('deleted_at','=',null)
            ->where('status','!=','cancelled')
            ->groupBy('date')->orderBy('date','desc')
            ->get();
        $bar_chart_data = [];
        if(count($data['group_sale']) > 0) {
            foreach ($data['group_sale'] as $sale) {
                $bar_chart_data[] = [
                    'Sales' => explode('-', $sale->date)[2],
                    'price' => round($sale->total_price)
                ];
            }
        }
        $data['bar_chart_sale'] = json_encode($bar_chart_data);
        $total_channel_sale = $data ['ebay_total_sell'] +$data ['amazon_total_sell'] +$data ['tbo_total_sell'] +$data ['manual_total_sell'] +
            $data ['onbuy_total_sell'] + $data ['shopify_total_sell'];
        if($total_channel_sale) {
            $data['ebay'] = ($data ['ebay_total_sell'] * 100) / $total_channel_sale;
            $data['amazon'] = ($data ['amazon_total_sell'] * 100) / $total_channel_sale;
            $data['tbo'] = ($data ['tbo_total_sell'] * 100) / $total_channel_sale;
            $data['onbuy'] = ($data ['onbuy_total_sell'] * 100) / $total_channel_sale;
            $data['manual'] = ($data ['manual_total_sell'] * 100) / $total_channel_sale;
            $data['shopify'] = ($data ['shopify_total_sell'] * 100) / $total_channel_sale;
        }else{
            $data['ebay'] = 0;
            $data['amazon'] = 0;
            $data['tbo'] = 0;
            $data['onbuy'] = 0;
            $data['manual'] = 0;
            $data['shopify'] = 0;
        }

        $data['top_category'] = Category::select('categories.id AS c_id','categories.category_name',
            DB::raw('COUNT(product_orders.variation_id) as total_product'))
            ->join('product_draft_category','categories.id','=','product_draft_category.category_id')
            ->join('product_drafts','product_draft_category.product_draft_id','=','product_drafts.id')
            ->join('product_variation','product_drafts.id','=','product_variation.product_draft_id')
            ->join('product_orders','product_variation.id','=','product_orders.variation_id')
            ->groupBy('categories.id')
            ->groupBy('categories.category_name')
            ->orderBy('total_product','desc')
            ->limit(20)
            ->get();
        $category_arr = [];
        if(count($data['top_category']) > 0) {
            foreach ($data['top_category'] as $category) {
                $category_arr[] = [
                    'category' => $category->category_name,
                    'totalCategory' => $category->total_product
                ];
            }
        }
        $data['product_category'] = json_encode($category_arr);
        $data['total_user'] = User::count();

        $currentDate = date('Y-m-d H:i:s');
        $userExpireLastDate = Client::whereBetween('expire_date', [Carbon::now(), Carbon::now()->addDays(3)])->first();
        $userExpireDate = Client::where('expire_date', '<' , $currentDate)->first();

        $content = view('dashboard.dashboard',compact('data','userExpireDate','userExpireLastDate','currentDate'));
        return view('master',compact('content'));
    }

    public function channelSale(){
        $ebay = $this->checkChannelActiveBySessionValue('ebay') ? Order::where(['created_via' =>'ebay'])->sum('total_price') : 0.00;
        $amazon = $this->checkChannelActiveBySessionValue('amazon') ? Order::where(['created_via' =>'amazon'])->sum('total_price') : 0.00;
        $tbo = $this->checkChannelActiveBySessionValue('woocommerce') ? Order::where(['created_via' =>'checkout'])->sum('total_price') : 0.00;
        $manual = Order::where(['created_via' =>'rest-api'])->sum('total_price');
        return response()->json(['ebay' => $ebay,'amazon' =>$amazon,'tbo' => $tbo,'manual' =>$manual]);
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
    /*
     * Function : salesByDate
     * Route : sales-by-date
     * Creator : Kazol
     * Modifier :
     * Description : This function is used for displaying all the sales information of top eight card using ajax in the dashboard
     * Created Date: unknown
     * Modified Date :
     */
    public function getBetweenTwoDateSale($dateQuery,$request) {
        if($request->end_date){
            //$date->whereBetween('date_created', [date($request->start_date), date($request->end_date)]);
            $dateQuery->whereDate('date_created', '>=', $request->start_date)->whereDate('date_created', '<=', $request->end_date);
        }else{
            $dateQuery->whereDate('date_created', $request->start_date);
        }
    }
    public function salesByDate(Request $request){
        if($request->day == 'all'){
            $data ['total_sell'] = round(Order::where(function($order){
                $this->channel_restriction_order_session($order);
            })->doesntHave('returnOrder')->where('status','!=','cancelled')->sum('total_price'),2);
            $data ['ebay_total_sell'] = $this->checkChannelActiveBySessionValue('ebay') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'ebay'])->sum('total_price'),2) : 0.00;
            $data ['amazon_total_sell'] = $this->checkChannelActiveBySessionValue('amazon') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'amazon'])->sum('total_price'),2) : 0.00;
            $data ['tbo_total_sell'] = $this->checkChannelActiveBySessionValue('woocommerce') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'checkout'])->sum('total_price'),2) : 0.00;
            $data ['manual_total_sell'] = round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'rest-api'])->sum('total_price'),2);
            $data ['onbuy_total_sell'] = $this->checkChannelActiveBySessionValue('onbuy') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'onbuy'])->sum('total_price'),2) : 0.00;
            // $data ['shopify_total_sell'] = $this->checkChannelActiveBySessionValue('shopify') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'shopify'])->sum('total_price'),2) : 0.00;
            $data ['complete_order_sell'] = round(Order::where(function($order){
                $this->channel_restriction_order_session($order);
            })->doesntHave('returnOrder')->where(['status' =>'completed'])->sum('total_price'),2);
            $data ['processing_order_sell'] = round(Order::where(function($order){
                $this->channel_restriction_order_session($order);
            })->where(['status' =>'processing'])->sum('total_price'),2);
        }elseif($request->day == 'custom'){
            $data ['total_sell'] = round(Order::where(function($order){
                $this->channel_restriction_order_session($order);
            })->doesntHave('returnOrder')->where('status','!=','cancelled')->where(function($date) use ($request){
                $this->getBetweenTwoDateSale($date,$request);
            })->sum('total_price'),2);
            $data ['ebay_total_sell'] = $this->checkChannelActiveBySessionValue('ebay') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'ebay'])->where(function($date) use ($request){
                $this->getBetweenTwoDateSale($date,$request);
            })->sum('total_price'),2) : 0.00;
            $data ['amazon_total_sell'] = $this->checkChannelActiveBySessionValue('amazon') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'amazon'])->where(function($date) use ($request){
                $this->getBetweenTwoDateSale($date,$request);
            })->sum('total_price'),2) : 0.00;
            $data ['tbo_total_sell'] = $this->checkChannelActiveBySessionValue('woocommerce') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'checkout'])->where(function($date) use ($request){
                $this->getBetweenTwoDateSale($date,$request);
            })->sum('total_price'),2) : 0.00;
            $data ['manual_total_sell'] = round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'rest-api'])->where(function($date) use ($request){
                $this->getBetweenTwoDateSale($date,$request);
            })->sum('total_price'),2);
            $data ['onbuy_total_sell'] = $this->checkChannelActiveBySessionValue('onbuy') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'onbuy'])->where(function($date) use ($request){
                $this->getBetweenTwoDateSale($date,$request);
            })->sum('total_price'),2) : 0.00;
            $data ['complete_order_sell'] = round(Order::where(function($order){
                $this->channel_restriction_order_session($order);
            })->doesntHave('returnOrder')->where(['status' =>'completed'])->where(function($date) use ($request){
                $this->getBetweenTwoDateSale($date,$request);
            })->sum('total_price'),2);
            $data ['processing_order_sell'] = round(Order::where(function($order){
                $this->channel_restriction_order_session($order);
            })->where(['status' =>'processing'])->where(function($date) use ($request){
                $this->getBetweenTwoDateSale($date,$request);
            })->sum('total_price'),2);
        }
        else{
            if($request->day == '-1'){
                $search_day = 1;
                $operator = '=';
            }else{
                $search_day = $request->day;
                $operator = '>';
            }
            $data ['total_sell'] = round(Order::where(function($order){
                $this->channel_restriction_order_session($order);
            })->doesntHave('returnOrder')->where('status','!=','cancelled')->whereDate('date_created', $operator, Carbon::now()->subDays($search_day))->sum('total_price'),2);
            $data ['ebay_total_sell'] = $this->checkChannelActiveBySessionValue('ebay') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'ebay'])->whereDate('date_created', $operator, Carbon::now()->subDays($search_day))->sum('total_price'),2) : 0.00;
            $data ['amazon_total_sell'] = $this->checkChannelActiveBySessionValue('amazon') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'amazon'])->whereDate('date_created', $operator, Carbon::now()->subDays($search_day))->sum('total_price'),2) : 0.00;
            $data ['tbo_total_sell'] = $this->checkChannelActiveBySessionValue('woocommerce') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'checkout'])->whereDate('date_created', $operator, Carbon::now()->subDays($search_day))->sum('total_price'),2) : 0.00;
            $data ['manual_total_sell'] = round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'rest-api'])->whereDate('date_created', $operator, Carbon::now()->subDays($search_day))->sum('total_price'),2);
            $data ['shopify_total_sell'] = $this->checkChannelActiveBySessionValue('shopify') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'shopify'])->whereDate('date_created', $operator, Carbon::now()->subDays($search_day))->sum('total_price'),2) : 0.00;
            $data ['onbuy_total_sell'] = $this->checkChannelActiveBySessionValue('onbuy') ? round(Order::doesntHave('returnOrder')->where('status','!=','cancelled')->where(['created_via' =>'onbuy'])->whereDate('date_created', $operator, Carbon::now()->subDays($search_day))->sum('total_price'),2) : 0.00;
            $data ['complete_order_sell'] = round(Order::where(function($order){
                $this->channel_restriction_order_session($order);
            })->doesntHave('returnOrder')->where(['status' =>'completed'])->whereDate('date_created', $operator, Carbon::now()->subDays($search_day))->sum('total_price'),2);
            $data ['processing_order_sell'] = round(Order::where(function($order){
                $this->channel_restriction_order_session($order);
            })->where(['status' =>'processing'])->whereDate('date_created', $operator, Carbon::now()->subDays($search_day))->sum('total_price'),2);
        }
        return response()->json($data);
    }
    /*
     * Function : salesByChannel
     * Route : sales-by-channel
     * Creator : Kazol
     * Modifier :
     * Description : This function is used for displaying sales information using ajax of pie chart
     * Created Date: unknown
     * Modified Date :
     */
    public function salesByChannel(Request $request){
        $search_day = $request->day;
        $channel_arr = [];
        if($request->day == 'all'){
            $data['group_channel'] = Order::where(function($order){
                $this->channel_restriction_order_session($order);
            })->select('created_via',DB::raw('sum(total_price) as total_price'))
                ->groupBy('created_via')->orderBy('total_price','desc')->get();
            if(count($data['group_channel']) > 0) {
                foreach ($data['group_channel'] as $channel) {
                    $channel_arr[] = [
                        'ChannelFactory' => ($channel->created_via == 'ebay' || $channel->created_via == 'Ebay') ? 'eBay' : (($channel->created_via == 'checkout') ? 'Website' : (($channel->created_via == 'rest-api') ? 'E Pos' : (($channel->created_via == 'amazon') ? 'Amazon' : (($channel->created_via == 'onbuy') ? 'OnBuy' : $channel->created_via)))),
                        'salesPrice' => $channel->total_price
                    ];
                }
            }
        }else{
            $data['group_channel'] = Order::where(function($order){
                $this->channel_restriction_order_session($order);
            })->select('created_via',DB::raw('sum(total_price) as total_price'))
                ->whereDate('date_created', '>', Carbon::now()->subDays($search_day))
                ->groupBy('created_via')->orderBy('total_price','desc')->get();
            if(count($data['group_channel']) > 0) {
                foreach ($data['group_channel'] as $channel) {
                    $channel_arr[] = [
                        'ChannelFactory' => ($channel->created_via == 'ebay' || $channel->created_via == 'Ebay') ? 'eBay' : (($channel->created_via == 'checkout') ? 'Website' : (($channel->created_via == 'rest-api') ? 'E Pos' : (($channel->created_via == 'amazon') ? 'Amazon' : (($channel->created_via == 'onbuy') ? 'OnBuy' : $channel->created_via)))),
                        'salesPrice' => $channel->total_price
                    ];
                }
            }
        }
        return response()->json($channel_arr);
    }
    /*
     * Function : topOrderedCountry
     * Route : top-ordered-country
     * Creator : Kazol
     * Modifier :
     * Description : This function is used for displaying top 20 ordered country using ajax with map in the dashboard
     * Created Date: unknown
     * Modified Date :
     */
    public function topOrderedCountry(Request $request){
        $search_day = $request->day;
        $country_arr = [];
        if($request->day == 'all'){
            $data['top_country'] = Order::where(function($order){
                $this->channel_restriction_order_session($order);
            })->select('customer_country',DB::raw('COUNT(customer_country) as total_country'))
                ->where('customer_country','!=', '')
                ->groupBy('customer_country')
                ->orderBy('total_country','desc')
                ->paginate(20);
            if(count($data['top_country']) > 0) {
                foreach ($data['top_country'] as $country) {
                    $country_arr[] = [
                        'id' => $country->customer_country,
                        'name' => $country->customer_country,
                        'value' => $country->total_country,
                        'color' => '#7266ba'
                    ];
                }
            }
        }else{
            $data['top_country'] = Order::where(function($order){
                $this->channel_restriction_order_session($order);
            })->select('customer_country',DB::raw('COUNT(customer_country) as total_country'))
                ->where('customer_country','!=', '')
                ->whereDate('date_created', '>', Carbon::now()->subDays($search_day))
                ->groupBy('customer_country')
                ->orderBy('total_country','desc')
                ->paginate(20);
            if(count($data['top_country']) > 0) {
                foreach ($data['top_country'] as $country) {
                    $country_arr[] = [
                        'id' => $country->customer_country,
                        'name' => $country->customer_country,
                        'value' => $country->total_country,
                        'color' => '#7266ba'
                    ];
                }
            }
        }

        return response()->json(['map_country' => $country_arr, 'ordered_country' => $data['top_country']]);
    }
    /*
     * Function : topOrderedProduct
     * Route : top-ordered-product
     * Creator : Kazol
     * Modifier :
     * Description : This function is used for displaying top 20 ordered product using ajax in the dashboard
     * Created Date: unknown
     * Modified Date :
     */
    public function topOrderedProduct(Request $request){
        $search_day = $request->day;
        if($search_day == 'all'){
            $data['top_product'] = $this->topProductData('all');
        }else{
            $data['top_product'] = $this->topProductData($search_day);
        }
        if(count($data['top_product']) > 0){
            $page_view = view('dashboard.top_product',compact('data'));
            echo $page_view;
        }else{
            return response()->json('no-data');
        }
    }
    /*
     * Function : topOrderedCategory
     * Route : top-ordered-category
     * Creator : Kazol
     * Modifier :
     * Description : This function is used for displaying top 20 ordered category using ajax in the dashboard
     * Created Date: unknown
     * Modified Date :
     */
    public function topOrderedCategory(Request $request){
        $search_day = $request->day;
        if($search_day == 'all'){
            $data['top_category'] = Category::select('categories.id AS c_id','categories.category_name',
                DB::raw('COUNT(product_orders.variation_id) as total_product'))
                ->join('product_draft_category','categories.id','=','product_draft_category.category_id')
                ->join('product_drafts','product_draft_category.product_draft_id','=','product_drafts.id')
                ->join('product_variation','product_drafts.id','=','product_variation.product_draft_id')
                ->join('product_orders','product_variation.id','=','product_orders.variation_id')
                ->groupBy('categories.id')
                ->groupBy('categories.category_name')
                ->orderBy('total_product','desc')
                ->limit(20)
                ->get();
        }else{
            $data['top_category'] = Category::select('categories.id AS c_id','categories.category_name',
                DB::raw('COUNT(product_orders.variation_id) as total_product'))
                ->join('product_draft_category','categories.id','=','product_draft_category.category_id')
                ->join('product_drafts','product_draft_category.product_draft_id','=','product_drafts.id')
                ->join('product_variation','product_drafts.id','=','product_variation.product_draft_id')
                ->join('product_orders','product_variation.id','=','product_orders.variation_id')
                ->join('orders','product_orders.order_id','=','orders.id')
                ->whereDate('orders.date_created', '>', Carbon::now()->subDays($search_day))
                ->groupBy('categories.id')
                ->groupBy('categories.category_name')
                ->orderBy('total_product','desc')
                ->limit(20)
                ->get();
        }
        $category_arr = [];
        if(count($data['top_category']) > 0) {
            foreach ($data['top_category'] as $category) {
                $category_arr[] = [
                    'category' => $category->category_name,
                    'totalCategory' => $category->total_product
                ];
            }
        }


        return response()->json($category_arr);
    }

    public function topProductData($filterType = null){
        $topProduct = ProductOrder::whereHas('order',function($order) use ($filterType){
            $order->where('status','!=','cancelled');
            $this->channel_restriction_order_session($order);
            if($filterType != 'all'){
                $order->whereDate('date_created', '>', Carbon::now()->subDays($filterType));
            }
        })->doesnthave('returnOrder')
        ->leftjoin('product_variation','product_orders.variation_id','=','product_variation.id')
        ->leftjoin('product_drafts','product_variation.product_draft_id','=','product_drafts.id')
        ->where([['product_variation.deleted_at',null],['product_drafts.deleted_at',null]])
        ->groupBy('product_variation.product_draft_id')
        ->select('product_variation.product_draft_id',DB::raw('sum(product_variation.cost_price * product_orders.quantity) as total_cost_price'),DB::raw('sum(product_orders.price) as total_order_price'),DB::raw('sum(product_orders.quantity) as total_order'))
        ->orderBy('total_order','DESC')
        ->paginate(20);
        $topProductData = [];
        if(($topProduct != null) && count($topProduct) > 0){
            foreach($topProduct as $product){
                $catalogueInfo = ProductDraft::with('product_catalogue_image')->find($product->product_draft_id);
                if($catalogueInfo){
                    $topProductData[] = [
                        'catalogue_title' => $catalogueInfo->name ?? null,
                        'catalogue_image' => $catalogueInfo->product_catalogue_image->image_url ?? null,
                        'total_cost_price' => $product->total_cost_price ?? 0,
                        'total_order_price' => $product->total_order_price ?? 0,
                        'total_order_product' => $product->total_order ?? 0
                    ];
                }
            }
        }
        return $topProductData;
    }


}
