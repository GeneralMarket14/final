<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Conversation;
use App\Http\Resources\V2\ConversationCollection;
use App\Http\Resources\V2\MessageCollection;
use App\Mail\ConversationMailManager;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;
use Carbon\Carbon;

use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Factory;

class ChatController extends Controller
{


    
  protected $firestore;

    public function __construct()
    {
        $serviceAccountPath = config_path('firebase.json');
        $factory = (new Factory)->withServiceAccount($serviceAccountPath);
        $this->firestore = $factory->createFirestore();
    }
    
    
    public function conversations()
    {
        $conversations = Conversation::where('sender_id', auth()->user()->id)->latest('id')->paginate(10);
        return new ConversationCollection($conversations);
    }

    public function messages($id)
    {
        $messages = Message::where('conversation_id', $id)->latest('id')->paginate(10);
        return new MessageCollection($messages);
    }

   // app/Http/Controllers/MessageController.php



    public function insert_message(Request $request)
    {
        $user_id = auth()->user()->id;
        $reciever_id = $request->receiver_id;

        $checkMessage = Message::where(function($query) use ($user_id, $reciever_id) {
            $query->where('user_id', $user_id)
                  ->where('reciever_id', $reciever_id);
        })->orWhere(function($query) use ($user_id, $reciever_id) {
            $query->where('user_id', $reciever_id)
                  ->where('reciever_id', $user_id);
        })->exists();

        if($checkMessage) {
            $conversation_id = Message::where(function($query) use ($user_id, $reciever_id) {
                $query->where('user_id', $user_id)
                      ->where('reciever_id', $reciever_id);
            })->orWhere(function($query) use ($user_id, $reciever_id) {
                $query->where('user_id', $reciever_id)
                      ->where('reciever_id', $user_id);
            })->first()->conversation_id;

            $message = new Message;
            $message->conversation_id = $conversation_id;
            $message->user_id = $user_id;
            $message->temp_id = $request->temp_id;
            $message->reciever_id = $request->receiver_id;
            $message->message = $request->message;
            $message->save();

            $messages = Message::where('id', $message->id)->paginate(1);
            // $this->sendFirebaseNotification($request->receiver_id, $request->message);







            $database = $this->firestore->database();
        $collection = $database->collection('messages');
        $document = $collection->newDocument();

      $data = [
        'sender_id' => uid(auth()->user()->id)->uid,
            'sender_actual_id'=>auth()->user()->id,
            'receiver_id' => uid($request->receiver_id)->uid,
            'receiver_actual_id'=>$request->receiver_id,
            'message' => $request->message,
            'timestamp' => Carbon::now(),
            'sender_name'=> strtoupper( uid(auth()->user()->id)->merchant_type) == 'EXPLORER' ?  uid(auth()->user()->id)->firstName.' '.uid(auth()->user()->id)->surName : uid(auth()->user()->id)->cacname,
            'receiver_name'=> strtoupper( uid($request->receiver_id)->merchant_type) == 'EXPLORER' ?  uid($request->receiver_id)->firstName.' '.uid($request->receiver_id)->surName : uid($request->receiver_id)->cacname,
            'avatar'=> uid(auth()->user()->id)->avatar
            // Add other parameters as needed
        ];

        $document->set($data);
        
            return new MessageCollection($messages);
        } else {
            $conversation = new Conversation;
            $conversation->sender_id = $user_id;
            $conversation->receiver_id = $request->receiver_id;
            $conversation->save();
            $conversation_id = $conversation->id;

            $message = new Message;
            $message->conversation_id = $conversation_id;
            $message->user_id = $user_id;
            $message->temp_id = $request->temp_id;
            $message->reciever_id = $request->receiver_id;
            $message->message = $request->message;
            $message->save();

            $messages = Message::where('id', $message->id)->paginate(1);
            
            

            
                  $database = $this->firestore->database();
        $collection = $database->collection('messages');
        $document = $collection->newDocument();

        $data = [
        'sender_id' => uid(auth()->user()->id)->uid,
            'sender_actual_id'=>auth()->user()->id,
            'receiver_id' => uid($request->receiver_id)->uid,
            'receiver_actual_id'=>$request->receiver_id,
            'message' => $request->message,
            'timestamp' => Carbon::now(),
            'sender_name'=> strtoupper( uid(auth()->user()->id)->merchant_type) == 'EXPLORER' ?  uid(auth()->user()->id)->firstName.' '.uid(auth()->user()->id)->surName : uid(auth()->user()->id)->cacname,
            'receiver_name'=> strtoupper( uid($request->receiver_id)->merchant_type) == 'EXPLORER' ?  uid($request->receiver_id)->firstName.' '.uid($request->receiver_id)->surName : uid($request->receiver_id)->cacname,
            'avatar'=> uid(auth()->user()->id)->avatar
            // Add other parameters as needed
        ];

        $document->set($data);
            return new MessageCollection($messages);
        }
    }

  public function fcmprofile($id){
      $user = User::where('id',$id)->first();
      if(strtoupper($user->merchant_type) == 'Explorer'){
          return $user->firstName.' '.$user->surName;
      }else{
            return $user->cacname;
      }
      
  }

  



    public function get_new_messages(Request $request)
    {
        $limit = $request->limit;
        $last_message_id = $request->last_message_id;
        $id = auth()->user()->id;
        $messages = Message::where(function ($query) use ($id) {
        $query->where('reciever_id', $id)
              ->orWhere('user_id', $id);
    })
    ->when($last_message_id, function ($query) use ($last_message_id) {
        return $query->where('id', '>', $last_message_id);
    })
    ->latest('id')
    ->when(isset($limit), function ($query) use ($limit) {
        return $query->limit($limit);
    })
    ->get();
        return new MessageCollection($messages);
    }

    public function create_conversation(Request $request)
    {
        $seller_user = User::findOrFail($request->recieverId);
        $user = User::find(auth()->user()->id);
        $conversation = new Conversation;
        $conversation->sender_id = $user->id;
        $conversation->receiver_id = $request->recieverId;
        $conversation->title = $request->title;

        if ($conversation->save()) {
            $message = new Message;
            $message->conversation_id = $conversation->id;
            $message->user_id = $user->id;
            $message->message = $request->message;

            if ($message->save()) {
                $this->send_message_to_seller($conversation, $message, $seller_user, $user);
            }
        }

        return response()->json(['result' => true, 'conversation_id' => $conversation->id,
            'shop_name' => $conversation->receiver->user_type == 'admin' ? 'In House Product' : $conversation->receiver->shop->name,
            'shop_logo' => $conversation->receiver->user_type == 'admin' ? uploaded_asset(get_setting('header_logo'))  : uploaded_asset($conversation->receiver->shop->logo),
            'title'=> $conversation->title,
            'message' => translate("Conversation created"),]);
    }

    public function send_message_to_seller($conversation, $message, $seller_user, $user)
    {
        $array['view'] = 'emails.conversation';
        $array['subject'] = translate('Sender').':- '. $user->name;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['content'] = translate('Hi! You recieved a message from ') . $user->name . '.';
        $array['sender'] = $user->name;

        if ($seller_user->type == 'admin') {
            $array['link'] = route('conversations.admin_show', encrypt($conversation->id));
        } else {
            $array['link'] = route('conversations.show', encrypt($conversation->id));
        }

        $array['details'] = $message->message;

        try {
            Mail::to($conversation->receiver->email)->queue(new ConversationMailManager($array));
        } catch (\Exception $e) {
            //dd($e->getMessage());
        }

    }
}
