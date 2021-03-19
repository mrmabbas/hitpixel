<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIpRequest;
use Illuminate\Support\Facades\Validator;
use App\IpAddress;
use Illuminate\Http\Request;

class IpAddressController extends Controller
{


    public function index(){
        $ips = IpAddress::paginate(5);
       // dd($ips);

        return view('home', ['ipAddress' => $ips]);
       
    }

    public function addIp(StoreIpRequest $request){

        $ip = $request['ip'];
   
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.hitpixel.io/test/whitelist',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"ip": "'.$ip.'"}
        ',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Cookie: __cfduid=d3504429888f3cf41dd7c831ccaf8fad01616157989; PHPSESSID=rvve4ft84j9obh5468grrc15se'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
       // echo $response;

       
        $response =  json_decode($response); 

        if ($response->status != 200) {
            //negative condition and return
            IpAddress::create([
                'ip' => $ip,
                'status' => 'Declined',
                'msg' => $response->data
           ]);

            $msg = $response->data;
            return back()->with('message', $msg);
        }
        if ($response->status == 200) {
            IpAddress::create([
                'ip' => $ip,
                'status' => 'Accepted',
                'msg' => $response->data
           ]);
           $ip_array = IpAddress::all();
           $msg = $response->data;
               return back()
               ->with(['message'=> $msg, 'ip_address'=> $ip_array ] );
        }
      
        


    }
}
