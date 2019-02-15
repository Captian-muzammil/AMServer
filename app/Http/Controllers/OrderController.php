<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Libs\Platform\Storage\Order\OrderRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;

class OrderController extends Controller
{
    public $order;

    public function __construct(OrderRepository $tag)
    {
        $this->order = $tag;
    }

    public function totalOrder(){
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
            $orders = $this->order->listing($limit, $active, $fields, $filters, $sort, $with,$page);
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
            $orders = $this->order->listing($limit, $active, $fields, $filters, $sort, $with,$page);
            /* Get Match Event List */

            foreach ($orders as $order) {
                $returnData[] = $this->order->node($order);
            }


            return response()->json(['message' => 'success', 'data' => $returnData],200);
        } catch (Exception $e) {
            return response()->json(['code' => 500, 'message' => Lang::get('apiStatusCodes.oops')], 500);
        }
    }

}