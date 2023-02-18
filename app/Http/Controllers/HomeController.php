<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirect()
    {
        $usertype=Auth::user()->usertype;

        if($usertype=='1')
        {
            return view('admin.home');
        }
        else
        {
            $data = Product::paginate(3);

            $user = auth()->user();
            $count = cart::where('phone',$user->phone)->count();
                return view('user.home',compact('data','count'));
        }
    }
    
    public function index()
        {
            if(Auth::id())
            {
                return redirect('redirect');
            }
            else
            {

                $data = Product::paginate(3);
                return view('user.home',compact('data'));

            }
            
        }

        public function search(Request $request)
        {
            $search = $request->search;
            if($search==''){
                $data = Product::paginate(3);
                return view('user.home',compact('data'));


            }
            $data = Product::where('title','Like','%'.$search.'%')->get();

            return view('user.home',compact('data'));
        }

        public function addcart(Request $request , $id)
        {
            if(Auth::id())
            {

                $user= auth()->user();
                $product = Product::find($id);

                $cart=new cart;

                $cart->name=$user->name;
                $cart->phone=$user->phone;
                $cart->address=$user->address;
                $cart->product_title=$product->title;
                $cart->price = $product->price;
                $cart->quantity = $request->quantity;
                $cart->save();


                return redirect()->back()->with('message','product Added successfully');
            }
            else
            {
                return redirect('login');
            }
        }

        public function showcart()
        {
            $user = auth()->user();

            $cart= cart::where('phone',$user->phone)->get();
            $count = cart::where('phone',$user->phone)->count();
            return view('user.showcart',compact('count','cart'));
        }

        public function deletecart($id)
        {
            $data = cart::find($id);
            $data->delete();
            return redirect()->back()->with('message','Product Removed successfully');
        }

        public function confirmorder(Request $request)
        {

            $user=auth()->user();

            $name=$user->name;

            $phone=$user->phone;

            $address=$user->address;

            foreach($request->productname as $key=>$productname)
            {
                $order=new order;

                $order->product_name=$request->productname[$key];

                $order->price=$request->price[$key];

                $order->quantity=$request->quantity[$key];

                $order->name=$name;

                $order->phone=$phone;

                $order->address=$address;

                $order->status='not delivered';

                $order->save();


            }

            DB::table('carts')->where('phone',$phone)->delete();

            return redirect()->back()->with('message','Product Orderd successfully');

        

        }
    // public function detailproduct($id)
    // {
    //     $data = Product::find($id);
    //     return view('user.detailproduct',compact('data'));
    // }
}
