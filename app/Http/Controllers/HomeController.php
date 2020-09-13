<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Auth;
use App\Cart;
use App\Order;
use App\OrderProduct;

class HomeController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $auth = [
            'auth' => [
                'ck_2682b35c4d9a8b6b6effac126ac552e0bfb315a0',
                'cs_cab8c9a729dfb49c50ce801a9ea41b577c00ad71',
            ],
        ];
        $client = new Client();
        $response = $client->get('https://mangomart-autocount.myboostorder.com/wp-json/wc/v1/products', $auth);

        $total_products = intval($response->getHeader('X-WP-Total')[0]);
        $total_pages = intval($response->getHeader('X-WP-TotalPages')[0]);
        $result = json_decode($response->getBody()->getContents(),true); //first page

        for($i=2; $i<=$total_pages; $i++)
        {
            $response = $client->get('https://mangomart-autocount.myboostorder.com/wp-json/wc/v1/products?page='.$i, $auth);
            $result = array_merge($result, json_decode($response->getBody()->getContents(),true));   //merge all pages
        }

        for($i=$total_products-1; $i>=0; $i--)
        {
            if($result[$i]['catalog_visibility'] == 'hidden')
            {
                array_splice($result, $i, 1);   //delete those with catelogue visibility = false
                $total_products--;
            }
        }

        return view('home')->with(compact('total_products','result'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        
        if(!Cart::select()->where('user_id', Auth::id())->where('product_id', $request->product_id)->exists()) {
            $cart = new Cart;
            $cart->user_id = Auth::id();
            $cart->product_id = $request->product_id;
            $cart->product_name = $request->product_name;
            
            $cart->save();  //create new cart product under this user id

            return response()->json(['success'=>true]);
        }
        else {
            return response()->json(['success'=>false]);
        }
    }

    public function cart()
    {
        $cart_products = Auth::user()->carts;
        
        return view('cart')->with(compact('cart_products'));
    }

    public function delete(Request $request)
    {
        $cart_products = Cart::where('user_id', Auth::id())->where('product_id',$request->product_id)->delete();
        
        return response()->json(['success' => true]);
    }

    public function order(Request $request)
    {
        $order = new Order;
        $order->user_id = Auth::id();

        $order->save(); //create new order under user

        for($i=0; $i<count($request->product_id); $i++)
        {
            $order_product = new OrderProduct;
            $order_product->order_id = $order->id;
            $order_product->product_id = $request->product_id[$i];
            $order_product->product_name = $request->product_name[$i];
            $order_product->product_quantity = $request->product_quantity[$i];

            $order_product->save(); //save each order product with order as foreign key
        }

        Auth::user()->carts->each->delete();    //collection must be accessed using each or for loop

        return redirect()->route('orders')->with('success','Order '.$order->id.' created successfully!');
    }

    public function orders()
    {
        $orders = Auth::user()->orders;
        $pending_count = $orders->where('status', 0)->count();

        return view('orders')->with(compact('orders', 'pending_count'));
    }

    public function showOrder($id)
    {
        $order = Order::find($id);

        if(is_null($order) || $order->user_id != Auth::id())
        {
            return redirect()->route('orders')->with('error', 'You cannot view Order ' . $id);
        }

        $updated = $order->notification;    //get notification set true or not
        $order->notification = false;   //set it to false
        $order->save();

        $order_products = $order->orderProducts;

        return view('showOrder')->with(compact('order', 'order_products', 'updated'));
    }

    public function notification()
    {
        if (Auth::check() && Auth::user()->name === "User")
        {
            //Auth::user()->orders->where('notification', 1)->first(); returns a collection, not an object! Must foreach loop to get element, unlike an object
            $notification = Order::where('user_id', Auth::id())->where('notification', 1)->first();
            
            if(!is_null($notification))
            {
                //add "updated" icon beside orders in User Nav bar
                return "<a class='nav-link' href='" . route('orders') . "/" . $notification->id . "'>Orders <span class='badge badge-secondary'>Updated!</span></a>";
            }
            else
            {
                return null;
            }
        }
    }

    public function adminHome()
    {
        $orders = Order::all();
        $pending_count = $orders->where('status', 0)->count();  //get total pending orders count which is status = 0

        return view('adminHome')->with(compact('orders', 'pending_count'));
    }

    public function adminShowOrder($id)
    {
        $order = Order::find($id);
        $order_products = $order->orderProducts;

        return view('adminShowOrder')->with(compact('order', 'order_products'));
    }

    public function adminChangeStatus(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = $request->status;  //0 is pending; 1 is accepted; 2 is rejected
        $order->notification = true;    //activate notification for user
        $order->save();

        return response()->json(['success' => true]);
    }
}
