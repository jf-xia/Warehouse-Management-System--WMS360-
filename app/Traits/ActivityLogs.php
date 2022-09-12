<?php
namespace App\Traits;

use App\ActivityLog;

trait ActivityLogs {

    // public function saveActivityLog($actionUrl,$actionName,$accountName,
    // $accountId,$requestData,$responseData,
    // $actionBy,$lastQuantity,$updatedQuantity,
    // $actionDate,$actionStatus){
    //     try{
    //         $insertInfo = ActivityLog::create([
    //             'action_url' => $actionUrl,
    //             'action_name' => $actionName,
    //             'account_name' => $accountName,
    //             'account_id' => $accountId,
    //             'request_data' => $requestData,
    //             'response_data' => $responseData,
    //             'action_by' => $actionBy,
    //             'last_quantity' => $lastQuantity,
    //             'updated_quantity' => $updatedQuantity,
    //             'action_date' => $actionDate,
    //             'action_status' => $actionStatus
    //         ]);
    //         return $insertInfo;
    //     }catch(\Exception $exception){
    //         return 'error';
    //     }
    // }
    public function saveActivityLog($logData){
        try{
            $insertLog = ActivityLog::create($logData);
            return $insertLog;
        }catch(\Exception $exception){
            return 'error';
        }
    }

    public function paramToArray($actionUrl,$actionName,$accountName,
    $accountId,$sku,$requestData,$responseData,
    $actionBy,$lastQuantity,$updatedQuantity,
    $actionDate,$solveStatus,$actionStatus){
        $data['action_url'] = $actionUrl;
        $data['action_name'] = $actionName;
        $data['account_name'] = $accountName;
        $data['account_id'] = $accountId;
        $data['sku'] = $sku;
        $data['request_data'] = json_encode($requestData);
        $data['response_data'] = ($responseData != null) ? (is_array($responseData) ? json_encode($responseData) : $responseData) : null;
        $data['action_by'] = $actionBy;
        $data['last_quantity'] = $lastQuantity;
        $data['updated_quantity'] = $updatedQuantity;
        $data['action_date'] = $actionDate;
        $data['solve_status'] = $solveStatus;
        $data['action_status'] = $actionStatus;

        $insertInfo = $this->saveActivityLog($data);
        return $insertInfo;
    }

    public function modifyExistingArr($arr,$newValue){
        foreach($newValue as $key => $val){
            $arr[$key] = $val;
        }
        return $arr;
    }

    public function updateResponse($id,$response,$solveStatus,$actionStatus){
        $updateLog = ActivityLog::where('id',$id)->update([
            'response_data' => is_array($response) ? json_encode($response) : $response,
            'solve_status' => $solveStatus,
            'action_status' => $actionStatus
        ]);
        return $updateLog;
    }


}
