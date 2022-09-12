<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
    public function getClient(){
        $client_data = Client::get()->first();
        $data = \Opis\Closure\unserialize($client_data->ebay_auth_data) ;
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
        try {
            $clientInfo = Client::first();
            if($clientInfo) {
                if ($request->hasFile('logo_url')) {
                    $file = $request->logo_url;
                    $name = time() . '-' . str_replace([' ',':'],'-',$file->getClientOriginalName());
                    $file->move('uploads/app-logo', $name);
                    $logoUrl = asset('uploads/app-logo/'.$name);
                    $updateInfo = Client::where('id', $clientInfo->id)->update(['logo_url' => $logoUrl]);
                    return back()->with('success', 'Logo updated successfully');
                } else {
                    return back()->with('error', 'Image not found. Please try again');
                }
            }else{
                return redirect('error','No information is found, Please contact with your service provider');
            }

        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
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
            $ClientUpdate = Client::find($id);
            // dd($request);
            // exit();
            $ClientUpdate->address_line_1 = $request->address_line_1;
            $ClientUpdate->address_line_2 = $request->address_line_2;
            $ClientUpdate->address_line_3 = $request->address_line_3;
            $ClientUpdate->country = $request->country;
            $ClientUpdate->city = $request->city;
            $ClientUpdate->post_code = $request->post_code;
            $ClientUpdate->phone_no = $request->phone_no;
            $ClientUpdate->reg_no = $request->reg_no;
            $ClientUpdate->email = $request->email;
            $ClientUpdate->vat = $request->vat;
            $ClientUpdate->save();
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
