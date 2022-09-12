<?php

namespace App\Http\Controllers;

use App\EbaySites;
use App\PaymentPolicy;
use App\EbayAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentPolicyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $sites = EbaySites::get()->all();
        $accounts = EbayAccount::get()->all();
        $results = PaymentPolicy::get()->all();

        return view('ebay.payment_policy.index',compact('results', 'accounts', 'sites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sites = EbaySites::get()->all();
        $accounts = EbayAccount::get()->all();

        return view('ebay.payment_policy.create',compact('sites','accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result =  PaymentPolicy::create($request->all());

        return redirect('payment-policy')->with('success','successfully created');
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
        $sites = EbaySites::get()->all();
        $accounts = EbayAccount::get()->all();
        $result = PaymentPolicy::find($id);
        return view('ebay.payment_policy.edit',compact('sites','accounts','result'));
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
        $result = PaymentPolicy::find($id);

        $result->update($request->all());

        return redirect('payment-policy')->with('success', 'successfully edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PaymentPolicy::destroy($id);

        return redirect('payment-policy')->with('success','successfully deleted');
    }
}
