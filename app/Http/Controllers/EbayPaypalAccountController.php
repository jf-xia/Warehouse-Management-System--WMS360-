<?php

namespace App\Http\Controllers;

use App\EbayAccount;
use App\EbayPaypalAccount;
use App\EbaySites;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EbayPaypalAccountController extends Controller
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
        $accounts = EbayAccount::get()->all();
        $sites = EbaySites::get()->all();

        $results = EbayPaypalAccount::get()->all();

        return view('ebay.paypal.index',compact('results', 'accounts', 'sites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = EbayAccount::get()->all();
        $sites = EbaySites::get()->all();

        return view('ebay.paypal.create',compact('accounts','sites'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = EbayPaypalAccount::create($request->all());

        return redirect('ebay-paypal')->with('success','created successfully');
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
        $result = EbayPaypalAccount::find($id);
        $accounts = EbayAccount::get()->all();
        $sites = EbaySites::get()->all();

        return view('ebay.paypal.edit',compact('accounts','sites','result'));
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
        $result = EbayPaypalAccount::find($id);

        $result->update($request->all());

        return redirect('ebay-paypal')->with('success','successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EbayPaypalAccount::destroy($id);

        return redirect('ebay-paypal')->with('success','successfully deleted');
    }
}
