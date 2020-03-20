<?php

namespace App\Http\Controllers\Frontend\Site;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class SubscriberController extends Controller
{
    function saveSubscribers(){
        $validator = Validator::make(request()->all(), ['email' => 'email| string |unique:subscribers,email']);
        if($validator->fails()){
            $message = $validator->errors();

            return response()->json(['message' => $message] ,422);
        }
        $subscriberSaved = Subscriber::create(['email' => request('email')]);
        return response()->json(['message' => __('email_has_been_subscribed') , 'subscriberSaved' =>$subscriberSaved] ,201);
    }
}
