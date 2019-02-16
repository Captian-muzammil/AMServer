<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Libs\Platform\Storage\Outlet\OutletRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;

class OutletController extends Controller
{
    public $outlet;

    public function __construct(OutletRepository $outlet)
    {
        $this->outlet = $outlet;
    }

    public function totalOutlet(){
        /* Default Variables */
        $fields = []; // list of fields to be fetched (products collection)
        $filters = [];
        $limit = Input::has('limit') ? (int) Input::get('limit') : 25; // number of entries
        $active = true;
        $with = [];
        $returnData = null;
        $sort = ['id'];
        /* Default Variables */

        /* Set Page */
        $page = 1;
        if (Input::has('page')) {
            $page = Input::get('page');
        }
        /* Set Page */


        try {
            /* Get Match Event List */
            $orders = $this->outlet->listing($limit, $active, $fields, $filters, $sort, $with,$page);
            /* Get Match Event List */

            return response()->json(['message' => '', 'data' => count($orders)],200);
        } catch (Exception $e) {
            return response()->json(['code' => 500, 'message' => Lang::get('apiStatusCodes.oops')], 500);
        }
    }

    public function index() {
        /* Default Variables */
        $fields = []; // list of fields to be fetched (products collection)
        $filters = [];
        $limit = Input::has('limit') ? (int) Input::get('limit') : 25; // number of entries
        $active = true;
        $with = [];
        $returnData = null;
        $sort = ['id'];
        /* Default Variables */

        /* Set Page */
        $page = 1;
        if (Input::has('page')) {
            $page = Input::get('page');
        }
        /* Set Page */


        try {
            /* Get Match Event List */
            $outlets = $this->outlet->listing($limit, $active, $fields, $filters, $sort, $with,$page);
            /* Get Match Event List */

            foreach ($outlets as $outlet) {
                $returnData[] = $this->outlet->node($outlet);
            }


            return response()->json(['message' => 'success', 'data' => $returnData],200);
        } catch (Exception $e) {
            return response()->json(['code' => 500, 'message' => Lang::get('apiStatusCodes.oops')], 500);
        }
    }

    public function notification()
    {
        $token = 'etG19b5aZ8w:APA91bFYiQ5DcsgdMQhn3aCpC34275ItxuyOh58S3bsu31FODJZXtdjE6OIKM1cO6BrOT2i4KlVcnbslC7VBta1B5OpRPGhTGMx8yxctJcAQ70LRuG5FkAQAxk0eVMJxuhBTRsdHpy5h';
        $title = 'New order arrived';
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';


        $notification = [
            'title' => $title,
            'sound' => true,

        ];

        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to' => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData

        ];

        $headers = [
            'Authorization: key=AIzaSyAWKtzi6Yp9LWvL0R3RquCx2lgqJZeo7js',
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
        try {


            return response()->json(['message' => '', 'data' => $result],200);
        } catch (Exception $e) {
            return response()->json(['code' => 500, 'message' => Lang::get('apiStatusCodes.oops')], 500);
        }
    }

}