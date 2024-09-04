<?php
namespace app\Traits;



trait HttpResponsesTrait {

public function ReturnSuccessMessage($message='successs',$code=200){

return response() ->json([
'status'=>true,
'message'=>$message,
'code'=>$code
]);
}

public function ReturnFailMessage($message='successs',$code=500){

return response() ->json([
'status'=>false,
'message'=>$message,
'code'=>$code
]);
}
public function SuccessWithData($key,$value,$message='successs',$code=200){

return response() ->json([
'status'=>true,
'message'=>$message,
'code'=>$code,
$key=>$value
]);

}



public function hello(){
    return 'hello';
}



}

