<?php

namespace App\Http\Controllers;

use App\EbaySites;
use App\ReturnPolicy;
use App\EbayAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReturnPolicyController extends Controller
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

        $results =  ReturnPolicy::get();

        return view('ebay.return_policy.index',compact('results', 'accounts', 'sites'));
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

        return view('ebay.return_policy.create',compact('sites','accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = ReturnPolicy::create($request->all());
        return redirect('return-policy')->with('success','created successfully');
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
        $result = ReturnPolicy::find($id);
        $sites = EbaySites::get()->all();
        $accounts = EbayAccount::get()->all();

        return view('ebay.return_policy.edit',compact('result','sites','accounts'));
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
        //return $request;
        $result = ReturnPolicy::find($id);

        $result->update($request->all());
        return redirect('return-policy')->with('success','successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ReturnPolicy::destroy($id);
        return redirect('return-policy')->with('success','successfully deleted');
    }
}
