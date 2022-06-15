<?php

namespace App\Http\Controllers;

use App\Models\RequestForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;

class AppController extends Controller
{
    public function getAuthUser(Request $request)
    {
        $requestToken=substr($request->server('HTTP_AUTHORIZATION'),7);
        $token = PersonalAccessToken::findToken($requestToken);
        return $token->tokenable;
    }

    public function uploadFile(Request $request)
    {

        $request->validate([
            'file'  => 'required',
            'type'  => 'required',
        ]);

        $file=$request->file;
        $type=$request->type;

        //upload new picture and update database
        $explodedFile=explode(',',$file);
        //$decodedFile=base64_decode($explodedFile[1]);


        //develop name
        $ext=$this->getExtension($explodedFile);

        switch ($type){
            case 'VEHICLE':
                $filename="files/vehicles/".$type."-".uniqid().".".$ext;
                break;
            case 'QUOTE':
                $filename="files/quotes/".$type."-".uniqid().".".$ext;
                break;
            case 'RECEIPT':
                $filename="files/receipts/".$type."-".uniqid().".".$ext;
                break;
            default:
                $filename="files/other/".$type."-".uniqid().".".$ext;
        }

        if($type=='PHOTO'){
            if($ext=='jpg' || $ext=='png'){
                try{
                    Storage::disk('public_uploads')->put(
                        $filename,file_get_contents($file)
                    );
                }catch (\RuntimeException $e){
                    return response()->json([
                        'message' => "Failed to upload",
                    ],501);
                }
            }else {
                return response()->json([
                    'message' => "Invalid extension",
                ],415);
            }
        } else{
            if($ext=='jpg' || $ext=='png' || $ext=='pdf'){
                try{
                    Storage::disk('public_uploads')->put(
                        $filename,file_get_contents($file)
                    );
                }catch (\RuntimeException $e){
                    return response()->json([
                        'message' => "Failed to upload",
                    ],501);
                }
            }else {
                return response()->json([
                    'message' => "Invalid extension",
                ],415);
            }
        }

        return response()->json([
            'file'      =>  $filename
        ]);
    }

    private function getExtension($explodedImage)
    {
        $imageExtensionDecode=explode('/',$explodedImage[0]);
        $imageExtension=explode(';',$imageExtensionDecode[1]);
        $lowercaseExt=strtolower($imageExtension[0]);
        if($lowercaseExt=='jpeg')
            return 'jpg';
        else
            return $lowercaseExt;
    }

    public function generateUniqueCode()
    {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 8;

        do{
            //initialise code to an empty string
            $code='';

            //generate a code according to the length
            while (strlen($code) < $codeLength) {
                $position = rand(0, $charactersNumber - 1);
                $character = $characters[$position];
                $code .= $character;
            }

        //If the code exists generate another one
        }while(RequestForm::where('code',$code)->exists());

        //return unique code
        return $code;
    }

}
