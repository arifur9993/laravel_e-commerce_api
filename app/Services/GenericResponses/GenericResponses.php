<?php
/*=============================================
#   Author: Fahim Hossain <fahim>
#=============================================*/

namespace App\Services\GenericResponses;

class GenericResponses
{

  /*========================================================================================
# NOTES:
#   The List of HTTP Status Codes. While creating Generic Responses and
#   handling errors, use the Most Suitable HTTP Request
==========================================================================================
#   200 – OK – Eyerything is working
#   201 – OK – New resource has been created
#   204 – OK – The resource was successfully deleted
#   304 – Not Modified – The client can use cached data
#   400 – Bad Request – The request was invalid or cannot
#         be served. The exact error should be explained in the error payload.
#         E.g. „The JSON is not valid“
#   401 – Unauthorized – The request requires an user authentication
#   403 – Forbidden – The server understood the request, but is refusing it or
#         the access is not allowed.
#   404 – Not found – There is no resource behind the URI.
#   404 – Gone – Indicates that the resource at this end point is no longer available. Useful as a blanket response for old API version
#   415 – If incorrect content type was provided as part of the request
#   422 – Unprocessable Entity – Should be used if the server cannot
#         process the enitity, e.g. if an image cannot be formatted or
#         mandatory fields are missing in the payload.
#   429 – Too Many Requests
#   500 – Internal Server Error – API developers should avoid this error. If an error
#         occurs in the global catch blog, the stracktrace should be logged and not returned as response.
##############################################################################
#   Ref: http://blog.mwaysolutions.com/2014/06/05/10-best-practices-for-better-restful-api/
#   Ref: http://www.vinaysahni.com/best-practices-for-a-pragmatic-restful-api
##############################################################################
==========================================================================================*/

  /**
   * Validation Failed API Response
   *
   * 422 – Unprocessable Entity – Should be used if the server cannot process the enitity, e.g. if an image
   * cannot be formatted or mandatory fields are missing in the payload.
   *
   * @param void
   * @return json
   */
  public function inputValidationError()
  {
    return response()->json([
      'status_code' => 422,
      'message' => "Please check your input and try again"
    ]);
  }
  /**
   * Validation Failed API Response
   *
   * 422 – Unprocessable Entity – Should be used if the server cannot process the enitity, e.g. if an image
   * cannot be formatted or mandatory fields are missing in the payload.
   *
   * @param void
   * @return json
   */
  public function errorMsg($msg)
  {
    return response()->json([
      'status_code' => 422,
      'message' => $msg
    ]);
  }

  /**
   * Successfully Created
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function sucessFullyImport()
  {
    return response()->json([
      'status_code' => 200,
      'message' => "All Records Sucessfully Imported!"
    ]);
  }
  /**
   * Successfully Created
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function postSuccess()
  {
    return response()->json([
      'status_code' => 200,
      'message' => "All Records Saved!"
    ]);
  }

  /**
   * If Input it not correct or empty
   *
   * 401 - Input not valie
   *
   * @param void
   * @return json
   */
  public function checkInput()
  {
    return response()->json([
      'status_code' => 401,
      'message' => "Please check your input!"
    ]);
  }
  /**
   * No Records Found
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function cannotUpdate()
  {
    return response()->json([
      'status_code' => 422,
      'message' => "Cannot process for Update Request!"
    ]);
  }
  public function updateSuccess()
  {
    return response()->json([
      'status_code' => 200,
      'message' => "Successfully Updated!"
    ]);
  }
  /**
   * No Records Found
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function noPermission()
  {
    return response()->json([
      'status_code' => 422,
      'message' => "You Don't have peermission to access!"
    ]);
  }
  /**
   * No Records Found
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function noRecords()
  {
    return response()->json([
      'status_code' => 500,
      'message' => "No Records to Show!"
    ]);
  }
  /**
   * Could Not Import Data From BGCar
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function importError()
  {
    return response()->json([
      'status_code' => 422,
      'message' => "Could Not Import Data!"
    ]);
  }
  /**
   * Could Not Import Data From BGCar
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function allreadyImport()
  {
    return response()->json([
      'status_code' => 200,
      'message' => "Already Imported Data!"
    ]);
  }
  /**
   * retrun data with sucess code
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function returnData($results)
  {
    return response()->json([
      'status_code' => 200,
      'results' => $results
    ]);
  }
  /**
   * retrun data with Message
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function returnMessage($message)
  {
    return response()->json([
      'status_code' => 200,
      'results' => $message
    ]);
  }
  /**
   * No new Records to Import Data From BGCar
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function noNewRecord()
  {
    return response()->json([
      'status_code' => 200,
      'message' => "No New Record!"
    ]);
  }
  /**
   * No new Records to Import Data From BGCar
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function validationError($message)
  {
    return response()->json([
      'status_code' => 400,
      'message' => $message
    ]);
  }
  /**
   * Cannot Update
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function couldNotUpdate()
  {
    return response()->json([
      'status_code' => 422,
      'message' => "Nothing to update!"
    ]);
  }
  /**
   * Empty DB update can not perform need to run the import script
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function couldNotUpdateForImport()
  {
    return response()->json([
      'status_code' => 422,
      'message' => "Empty Database! Run the import Script!"
    ]);
  }
  /**
   * Empty DB update can not perform need to run the import script
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function addDepError()
  {
    return response()->json([
      'status_code' => 422,
      'message' => "No Trims Found!"
    ]);
  }
  /**
   * Permission Error
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function permissionError()
  {
    return response()->json([
      'status_code' => 422,
      'message' => "You Don't have permission to perform this action!"
    ]);
  }
  /**
   * Delete Sucess
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function deleteSuccess()
  {
    return response()->json([
      'status_code' => 200,
      'message' => "Deleted Sucessfully!"
    ]);
  }
  /**
   * Delete Sucess
   *
   * 200 – OK – Eyerything is working
   *
   * @param void
   * @return json
   */
  public function importSucess()
  {
    return response()->json([
      'status_code' => 200,
      'message' => "Import Data Sucessfully!"
    ]);
  }
}
