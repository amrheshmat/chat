<?php

namespace App\Http\Controllers\Messages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Message;
use App\User;
class InboxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $message = new Message();
       // $income_count= DB::table('messages')->select(DB::raw('count(*) as count'))->groupBy('message_from')->get();
        $income_messages =  DB::table('messages')->select('*',DB::raw('count(*) as count'))->where('message_to',Auth::User()->name)->groupBy('message_from')->get();
        return view('messages.inbox',compact('income_messages'));
    }
    public function sentmessage()
    {
        $message = new Message();
       $income_messages= DB::table('messages')->select('*',DB::raw('count(*) as count'))->where('reply_to_unkown',0)->where('message_to','!=',Auth::User()->name)->groupBy('message_to')->get();
        //$income_messages =  DB::table('messages')->select('*',DB::raw('count(*) as count'))->where('message_from',Auth::User()->name)->groupBy('message_to')->get();
        return view('messages.sent',compact('income_messages'));
    }
    public function sentview()
    {
        return view('messages.NewMessage');
    }
    public function allsentmessages(Request $request)
    {
        $message = new Message();
        $income_messages= DB::table('messages')->select('*')->where('message_from',Auth::User()->name)->where('message_to',$request->id)->get();
        return $income_messages;
    }
    public function allsentmessages2(Request $request)
    {
        $message = new Message();
        $income_messages= DB::table('messages')->select('*')->where('message_to',Auth::User()->name)->where('message_from',$request->id)->get();
        return $income_messages;
    }
    public function sent(Request $request)
    {
        $check =new User();
        $check_name = $check->where('name',$request->name)->first();
        $valid_name ;
        if(!empty($check_name)){
            $message = new Message();
            $message->message_from = Auth::User()->name;
            $message->message_to = $request->name;
            $message->message_content = $request->message_content;
            $message->save();
            $valid_name="message Sent Correctly";
        }else{
            $valid_name="Not Valid";
        }
        
        return view('messages.NewMessage',compact('valid_name'));
    }
    public function replymessage(Request $request)
    {
        $check =new User();
        $check_name = $check->where('name',$request->name)->first();
        $valid_name ;
        if(!empty($check_name)){
            $message = new Message();
            $message->message_from = Auth::User()->name;
            $message->message_to = $request->name;
            $message->message_content = $request->message_content;
            $message->reply_to_unkown = 1 ;
            $message->save();
            $valid_name="message Sent Correctly";
        }else{
            $valid_name="Not Valid";
        }
        
        return view('messages.NewMessage',compact('valid_name'));
    }
}
