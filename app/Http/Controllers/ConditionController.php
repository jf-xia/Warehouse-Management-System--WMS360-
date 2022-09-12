<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Condition;
use Auth;

class ConditionController extends Controller
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
        $all_conditions = Condition::orderByDesc('id')->get();
        $content = view('condition.condition_list',compact('all_conditions'));
        return view('master',compact('content'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $content = view('condition.create_condition');
        return view('master',compact('content'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'condition_name' => 'required',
        ]);
        try {
            $result = Condition::create([
                'condition_name' => $request->condition_name,
                'user_id' => Auth::id()
            ]);
            return redirect('condition')->with('success','Condition added successfully');
        }catch (\Exception $exception){
            return redirect('condition/create')->with('error','Something went wrong');
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
        try {
            $single_condition = Condition::find($id);
            $content = view('condition.edit_condition',compact('single_condition'));
            return view('master',compact('content'));
        }catch (\Exception $exception){
            return redirect('condition')->with('error','Something went wrong');
        }
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
        $validation = $request->validate([
            'condition_name' => 'required',
        ]);
        try {
            $condition_result = Condition::find($id);
            $condition_result->update([
                'condition_name' => $request->condition_name
            ]);
            return redirect('condition')->with('success','Condition updated successfully');
        }catch (\Exception $exception){
            return redirect('condition')->with('error','Something went wrong');
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
        try {
            Condition::destroy($id);
            return redirect('condition')->with('condition_deleted_successfully','Condition deleted successfully');
        }catch (\Exception $exception){
            return redirect('condition')->with('error','Something went wrong');
        }
    }

    public function makeDefaultCondition(Request $request){
        try {
            $default_condition = Condition::where('default_select',1)->update([
                'default_select' => 0
            ]);
//            $default_condition->update([
//                'default_select' => null
//            ]);
            $new_default = Condition::find($request->condition_id);
            $new_default->default_select = 1;
            $new_default->save();
            return redirect('condition')->with('success','Default selection done!');
        }catch (\Exception $exception){
            return redirect('condition')->with('error','Something went wrong');
        }
    }
}
