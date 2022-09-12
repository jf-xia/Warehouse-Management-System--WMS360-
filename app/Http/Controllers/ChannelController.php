<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Channel;
use App\Mapping;
use Illuminate\Support\Carbon;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allChannel = Channel::all();
        $content = view('channel.all_channel',compact('allChannel'));
        return view('master',compact('content'));
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
        $existChannel = Channel::where('id','!=',$id)->where('channel',$request->channel)->first();
        if(!$existChannel){
            $updateChannel = Channel::find($id)->update(['channel' => $request->channel]);
            return response()->json(['type' => 'success', 'msg' => 'Channel Updated Successfully']);
        }else{
            return response()->json(['type' => 'error', 'msg' => 'Channel Aready Exists']);
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

    public function channelMapField(Request $request){
        $mappedFields = Mapping::select('id','channel_id','attribute_term_id','mapping_field')->with(['attributeTerms' => function($term){
            $term->select('id','item_attribute_id','item_attribute_term','item_attribute_term_slug','is_active')->with('itemAttribute:id,item_attribute');
        }])->where('channel_id',$request->channel_id)->get();
        return response()->json($mappedFields);
    }

    public function changeChannelStatue(Request $request){
        $imageUrl = null;
        if (isset($request->logo) && !isset($request->is_logo_remove)) {
            $image = $request->logo;
            $name = $request->channel_id . '-' . str_replace([' ', ':', '%'], '-', Carbon::now()->toDateTimeString()) . '-';
            $name .= str_replace(' ', '-', $image->getClientOriginalName());
            $image->move('uploads/all-channel/', $name);
            $imageUrl = 'uploads/all-channel/' . $name;
        }
        if(isset($request->is_logo_remove)) {
            $imageUrl = null;
        }
        $updateValue = $request->currentStatus == 1 ? 0 : 1;
        $updateInfo = Channel::find($request->channel_id);
        $updateInfo->is_active = $request->status;
        if($imageUrl != null || isset($request->is_logo_remove) ){
            $updateInfo->logo = $imageUrl;
        }
        $updateInfo->save();
        return back()->with('success','Channel Updated Successfully');
        //return response()->json(['type' => 'success','msg' => 'Connection has changed successfully']);
    }

}
