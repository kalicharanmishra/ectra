<?php

namespace App\Http\Controllers\Api;

use App\Mail\EmailOtpMail;
use App\Mail\ForgotPasswordMail;
use App\Mail\RegisterMail;
use App\Models\User;
use App\Models\UserOtp;
use App\Models\TruckImage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\TruckShop;
use App\Models\TruckManagment;
use App\Models\Event;
use App\Models\Food;
use App\Models\Favorite;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Rating;
use App\Models\SiteSetting;
use URL;
use Illuminate\Support\Facades\Storage;

class CustomerController extends ApiController
{

    public function GetProfile(Request $request)
    {
        $user   = User::find(Auth::user()->id);
        $Favorite   = Favorite::where('user_id', $user->id)
            ->with('truck_details')
            ->get();
        $orders   = Order::where('user_id', $user->id)
            ->with('vendor_details', 'order_items.food')
            ->orderBy('id', 'desc')
            ->take(3)->get();
        $response = array();
        $response['user'] = $user;
        $response['favorite'] = $Favorite;
        $response['orders'] = $orders;
        $this->status  = true;
        $this->data    = $response;
        $this->message = 'Vendor lists.';

        return $this->jsonView();
    }

    public function VendorList(Request $request)
    {
        $response = array();
        $SiteSetting   = SiteSetting::where('slug', 'nearby_radius')->first();
        $user   = User::where('status', 'active')
            ->where('role', '2')
            ->orderBy('id', 'DESC')
            ->pluck('id')
            ->toArray();
        //echo "<pre>"; print_r($user); die;
        $distance = ($SiteSetting->value * 1.60934);
        if (isset($request->latitude) && !empty($request->latitude)) {
            $TruckManagment  = TruckManagment::with('vendor_details')
                ->with('truck_multiple_images')
                ->select('truck_managment.*', DB::raw("6371 * acos(cos(radians(" . $request->latitude . "))
                * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $request->longitude . "))
                + sin(radians(" . $request->latitude . ")) * sin(radians(latitude))) AS distance"))
                ->having('distance', '<', $distance)
                ->get();
        } else {
            $TruckManagment   = TruckManagment::with('vendor_details')
                ->with('truck_multiple_images')
                ->whereIn('user_id', $user)
                ->get();
        }
        $this->status  = true;
        $this->data    = $TruckManagment;
        $this->message = 'Vendor lists.';

        return $this->jsonView();
    }

    public function VendorView(Request $request)
    {
        $rule = [
            'truck_id' => 'required',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $user   = User::find(Auth::user()->id);
            $data = TruckManagment::where('id', $request->truck_id)
                ->with('vendor_details', 'truck_multiple_images', 'truck_shops')
                ->first();
            if ($data) {
                $cat_data = Food::where('user_id', $data->user_id)
                    ->select('category_id')
                    ->with('category')
                    ->groupBy('category_id')
                    ->get();
                $data->vendor_menu = $cat_data;
                $data = ['status' => true, 'message' => 'Truck Details', 'data' => $data];
            } else {
                $data = ['status' => false, 'message' => 'Trucks not Found.', 'data' => []];
            }
            return response()->json($data);
        }
        return $this->jsonView();
    }

    public function VendorManuList(Request $request)
    {
        $cat_data = Food::where('user_id', $request->vendor_id)
            ->select('category_id')
            ->with('category')
            ->groupBy('category_id')
            ->get();
        $response = array();
        if (count($cat_data) > 0) {
            foreach ($cat_data as $key => $value) {
                $response[$key]['category_id'] = $value->category_id;
                $response[$key]['category_name'] = (@$value->category->title) ?: "";
                $data1 = Food::where('user_id', $request->vendor_id)
                    ->where('category_id', $value->category_id)
                    ->with('category', 'food_multiple_images', 'food_items')
                    ->orderBy('id', 'desc')->get();
                $response[$key]['products'] = $data1;
            }
            $data = ['status' => true, 'message' => 'Food list', 'data' => $response];
        } else {
            $data = ['status' => false, 'message' => 'Food not Found.', 'data' => []];
        }
        return response()->json($data);
    }


    public function ProductDetails(Request $request)
    {
        $cat_data = Food::where('id', $request->id)
            ->with('category', 'food_multiple_images', 'food_items',)
            ->first();
        if ($cat_data) {
            $data = ['status' => true, 'message' => 'Food Details', 'data' => $cat_data];
        } else {
            $data = ['status' => false, 'message' => 'Food not Found.', 'data' => []];
        }
        return response()->json($data);
    }

    public function FavoriteItem(Request $request)
    {
        $rule = [
            'truck_id' => 'required',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $user   = User::find(Auth::user()->id);
            $tableFov = Favorite::where('truck_id', $request->truck_id)
                ->where('user_id', $user->id)
                ->first();
            if (!empty($tableFov)) {
                $tableFov = Favorite::where('id', $tableFov->id)->delete();
                $data = ['status' => true, 'message' => 'Unfavorite successfully.', 'data' => []];
            } else {
                $cat = new Favorite();
                $cat->user_id = Auth::user()->id;
                $cat->truck_id = $request->truck_id;
                $cat->save();
                $data = ['status' => true, 'message' => 'Favorite successfully.', 'data' => []];
            }
            return response()->json($data);
        }
        return $this->jsonView();
    }

    public function FavoriteList(Request $request)
    {
        $user   = User::find(Auth::user()->id);
        // $Favorite   = Favorite::where('user_id', $user->id)
        //     ->with('truck_details')
        //     ->with('truck_images')
        //     ->get();
        $response = [];
        $favorites = Favorite::where('user_id', $user->id)->get();

        foreach ($favorites as $fav) {
            $truck_detail = TruckManagment::where('id', $fav->truck_id)->first();
            $truck_images = TruckImage::where('truck_managment_id', $fav->truck_id)->get();
            $food_items = Food::where('user_id', $truck_detail->user_id)->get();
            $response[] = [
                'id' => $fav->id,
                'user_id' => $fav->user_id,
                'truck_id' => $fav->truck_id,
                'created_at' => $fav->created_at,
                'updated_at' => $fav->updated_at,
                'truck_details' => $truck_detail,
                'truck_images' => $truck_images,
                'food_items' => $food_items
            ];
        }

        // $response['favorite'] = $favorite;
        // $response['truck_detail'] = $truck_detail;
        // $response['truck_images'] = $truck_images;
        // $response['food_items'] = $food_items;
        // $this->status  = true;
        // $this->data    = $response;
        // $this->message = 'Favorite lists.';
        // return $this->jsonView();

        $res = [
            'status' => true,
            'data' => $response,
            'message' => 'Favorite lists.'
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($res);
        die;
    }

    public function AddToCart(Request $request)
    {
        $rule = [
            'vendor_id' => 'required',
            'food_id' => 'required',
            'quantity' => 'required',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $user   = User::find(Auth::user()->id);
            $tablecart = Cart::where('user_id', $user->id)
                ->where('vendor_id', '!=', $request->vendor_id)
                ->where('order_id', NULL)
                ->first();
            if (!empty($tablecart)) {
                $data = ['status' => false, 'message' => 'Please purchase the product already added in your cart!', 'data' => []];
            } else {
                $foodcart = Cart::where('user_id', $user->id)
                    ->where('food_id', $request->food_id)
                    ->first();
                if (!empty($foodcart)) {
                    $update['food_items']    = $request->food_items;
                    $update['quantity']      = $foodcart->quantity + $request->quantity;
                    $foodcart->update($update);
                    $data = ['status' => true, 'message' => 'Product add to cart successfully!', 'data' => []];
                } else {
                    $cat = new Cart();
                    $cat->user_id       = Auth::user()->id;
                    $cat->vendor_id     = $request->vendor_id;
                    $cat->food_id       = $request->food_id;
                    $cat->food_items    = $request->food_items;
                    $cat->quantity      = $request->quantity;
                    $cat->save();
                    $data = ['status' => true, 'message' => 'Product add to cart successfully!', 'data' => []];
                }
            }
            return response()->json($data);
        }
        return $this->jsonView();
    }

    public function UpdateCart(Request $request)
    {
        $rule = [
            'cart_id' => 'required',
            'quantity' => 'required',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $user   = User::find(Auth::user()->id);
            $foodcart = Cart::where('user_id', $user->id)
                ->where('id', $request->cart_id)
                ->first();
            if (!empty($foodcart)) {
                $update['food_items']    = $request->food_items;
                $update['quantity']      = $request->quantity;
                $foodcart->update($update);
                $data = ['status' => true, 'message' => 'Cart product update successfully!', 'data' => []];
            } else {
                $data = ['status' => false, 'message' => 'Product not update!', 'data' => []];
            }
            return response()->json($data);
        }
        return $this->jsonView();
    }

    public function GetCart(Request $request)
    {
        $user   = User::find(Auth::user()->id);
        $tablecart = Cart::where('user_id', $user->id)
            ->where('order_id', NULL)
            ->with('food', 'food_images')
            ->get();

        $data = [
            'status' => false,
            'message' => 'Cart list!',
            'data' => $tablecart
        ];

        return response()->json($data);
    }

    public function DeleteCart(Request $request)
    {
        $rule = [
            'cart_id' => 'required'
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $user   = User::find(Auth::user()->id);
            $foodcart = Cart::where('user_id', $user->id)
                ->where('id', $request->cart_id)
                ->delete();
            $data = ['status' => true, 'message' => 'Cart product delete successfully!', 'data' => []];
            return response()->json($data);
        }
        return $this->jsonView();
    }

    public function PurchaseOrder(Request $request)
    {
        $rule = [
            'vendor_id' => 'required',
            // 'food_id' => 'required',
            // 'quantity' => 'required',
            'price' => 'required',
            'total_amount' => 'required',
            'payment_type' => 'required',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $user   = User::find(Auth::user()->id);
            $foods = $request->foods;
            $food_json = json_decode($foods);
            //echo "<pre>"; print_r($food_json); die;
            $order = new Order();
            $order->user_id       = Auth::user()->id;
            $order->vendor_id     = $request->vendor_id;
            $order->promo_code    = $request->promo_code;
            $order->promo_code_discount       = $request->promo_code_discount;
            $order->price           = $request->price;
            $order->fee             = $request->fee;
            $order->total_amount    = $request->total_amount;
            $order->info            = $request->info;
            $order->payment_type    = $request->payment_type;
            $order->payment_id      = $request->payment_id;
            $order->save();

            $_ques = [];
            $_ques['order_id']    =  $order->id;
            foreach ($food_json->foods as $val) {
                $_ques['food_id']    =  $val->food_id;
                $_ques['food_items'] =  $val->food_items;
                $_ques['quantity']   =  $val->quantity;
                OrderItem::insert($_ques);
            }
            if (isset($request->cart_ids) && !empty($request->cart_ids)) {
                $cardIds = explode(",", $request->cart_ids);
                foreach ($cardIds as $c_Id) {
                    $foodcart = Cart::where('user_id', $user->id)
                        ->where('id', $c_Id)
                        ->first();
                    $update['order_id']    = $order->id;
                    $foodcart->update($update);
                }
            }
            $data = ['status' => true, 'message' => 'Order successfully!', 'data' => []];
            return response()->json($data);
        }
        return $this->jsonView();
    }

    public function MyBookings(Request $request)
    {
        $user   = User::find(Auth::user()->id);
        $events = Event::where('user_id', $user->id)
            ->get();
        $response = [];
        foreach ($events as $event) {
            $truck_detail = TruckManagment::where('user_id', $event->vendor_id)->first();
            $truck_images = TruckImage::where('truck_managment_id', $truck_detail->id)->get();
            $event_data = [
                'event' => $event,
                'truck_detail' => $truck_detail,
                'truck_images' => $truck_images,
            ];
            $response['events'][] = $event_data;
        }
        $res = [
            'status' => true,
            'data' => $response,
            'message' => "Customer event list."
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($res);
        exit;
    }

    public function SendReview(Request $request)
    {
        $rule = [
            'order_id' => 'required',
            'vendor_id' => 'required',
            'rating' => 'required'
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $user   = User::find(Auth::user()->id);

            $rating = new Rating();
            $rating->user_id     = Auth::user()->id;
            $rating->vendor_id   = $request->vendor_id;
            $rating->rating      = $request->rating;
            $rating->review      = $request->review;
            $rating->order_id    = $request->order_id;
            $rating->save();
            //--Update vendor avrage rating in user table --//
            $vendor   = User::find($request->vendor_id);
            $allrating = Rating::select([
                DB::raw('AVG(ratings.rating) as ratings_average')
            ])->first();
            //echo "<pre>"; print_r($allrating); die;
            $update['rating']    = $allrating->ratings_average;
            $vendor->update($update);

            $data = ['status' => true, 'message' => 'Review send successfully!', 'data' => []];
            return response()->json($data);
        }
        return $this->jsonView();
    }
}
