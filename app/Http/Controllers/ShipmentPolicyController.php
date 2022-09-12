<?php

namespace App\Http\Controllers;


use App\EbaySites;
use App\ShipmentPolicy;
use App\EbayAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShipmentPolicyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = EbaySites::get()->all();
        $accounts = EbayAccount::get()->all();
        $results =  ShipmentPolicy::get();

        return view('ebay.shipment_policy.index',compact('results', 'accounts', 'sites'));
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

        return view('ebay.shipment_policy.create',compact('sites','accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = ShipmentPolicy::create($request->all());
        return redirect('shipment-policy')->with('success','successfully created');
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
        $result = ShipmentPolicy::find($id);
       return view('ebay.shipment_policy.edit',compact('result','sites','accounts'));
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
        $result = ShipmentPolicy::find($id);
        $result->update($request->all());
        return redirect('shipment-policy')->with('success','updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ShipmentPolicy::destroy($id);
        return redirect('shipment-policy')->with('success','deleted successfully');
    }
}
