<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Food;
use App\Models\FoodImage;
use App\Models\User;
use App\Models\FoodItem;
use attach;
use auth;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{

    public function AddFood(Request $request)
    {
      $validator = \Validator::make($request->all(), [
        'category_id'=>'required',
        'food_name'=>'required',
        'food_description'=>'required',
        'base_price'=>'required'

      ]);

      if ($validator->fails()) {
        $responseArr['message'] = $validator->errors();;
        return response()->json($responseArr);
      }
      $user = User::find(auth::user()->id);
      $dataInseet = new Food;
      $dataInseet->user_id = $user->id;
      $dataInseet->category_id = $request->category_id;
      $dataInseet->food_name = $request->food_name;
      $dataInseet->food_description = $request->food_description;
      $dataInseet->base_price = $request->base_price;
      $dataInseet->promo_code = $request->promo_code;
      $dataInseet->promo_code_value = $request->promo_code_value;
      if ($dataInseet->save()) {
        /*Food Images Save*/
        if ($request->hasfile('food_image')) {
            $prio = 1;
            $productImg = [];
            $prodImg = new FoodImage();
            foreach ($request->file('food_image') as $key => $image) {
                $name = 'food_images' . $dataInseet->id . '-' . $prio . '-' . time() . '.' .$image->getClientOriginalExtension();
                Storage::disk('food_images')->put($name, file_get_contents($image->getRealPath()));
                if (!empty($dataInseet->id))
                 $productImg[] = ['food_id' => $dataInseet->id, 'food_image' => $name,'extension' => $image->getClientOriginalExtension()];
                else
                 $productImg[] = ['food_id' => null, 'food_image' => $name,'extension' => $image->getClientOriginalExtension()];
                $prio++;
            }
            FoodImage::insert($productImg);
        }
        $food_items = $request->items;
        if(isset($food_items) && !empty($food_items)){
            $food_itemsjson = json_decode($food_items);
            //echo "<pre>"; print_r($shopsjson); die("df");
            $_shops = [];
            $_shops['food_id']    =  $dataInseet->id;
            $t_shop = new FoodItem();
            foreach($food_itemsjson->items as $val){
                $_shops['title']    =  $val->title;
                $_shops['price']    =  $val->price;
                FoodItem::insert($_shops);
            }
            
        }
        return response()->json($data = ['status'=>true,'data'=>$dataInseet,'message'=>'Foods  Added Successfully.']);
      }else{
        response()->json($data = ['status'=>false,'data'=>[],'message'=>'please try again.']);
      }
    }

    public function EditFood(Request $request)
    {
      $validator = \Validator::make($request->all(), [
        'category_id'=>'required',
        'food_name'=>'required',
        'food_description'=>'required',
        'base_price'=>'required'
      ]);
      if ($validator->fails()) {
          $responseArr['message'] = $validator->errors();;
          $responseArr['token'] = '';
          return response()->json($responseArr);
      }
      $dataInseet = Food::find($request->id);
      $dataInseet->category_id = $request->category_id;
      $dataInseet->food_name = $request->food_name;
      $dataInseet->food_description = $request->food_description;
      $dataInseet->base_price = $request->base_price;
      $dataInseet->stock = $request->stock;
      $dataInseet->promo_code = $request->promo_code;
      $dataInseet->promo_code_value = $request->promo_code_value;
      if ($dataInseet->save()) {
        if ($request->hasfile('food_image')) {
            $prio = 1;
            $productImg = [];
            $prodImg = new FoodImage();
            foreach ($request->file('food_image') as $key => $image) {
                $name = 'food_images' . $dataInseet->id . '-' . $prio . '-' . time() . '.' .$image->getClientOriginalExtension();
                Storage::disk('food_images')->put($name, file_get_contents($image->getRealPath()));
                if (!empty($dataInseet->id))
                 $productImg[] = ['food_id' => $dataInseet->id, 'food_image' => $name,'extension' => $image->getClientOriginalExtension()];
                else
                 $productImg[] = ['food_id' => null, 'food_image' => $name,'extension' => $image->getClientOriginalExtension()];
                $prio++;
            }
            FoodImage::insert($productImg);
        }
        $food_items = $request->items;
        if(isset($food_items) && !empty($food_items)){
          FoodItem::where("food_id",$dataInseet->id)->delete();
          $food_itemsjson = json_decode($food_items);
          //echo "<pre>"; print_r($shopsjson); die("df");
          $_shops = [];
          $_shops['food_id']    =  $dataInseet->id;
          $t_shop = new FoodItem();
          foreach($food_itemsjson->items as $val){
              $_shops['title']    =  $val->title;
              $_shops['price']    =  $val->price;
              FoodItem::insert($_shops);
          }
          $data = [
              'status'=>true,
              'message'=>'Food Truck added Successfully.',
              'data'=> $dataInseet,
           ];
        }else{
           $data = [
              'status'=>false,
              'message'=>'please try agin.',
              'data'=> [],
           ];
        }
        return response()->json($data);
      }
    }

    public function FoodList(Request $request)
    {
        $cat_data = Food::where('user_id',Auth::user()->id)
                  ->select('category_id')
                  ->with('category')
                  ->groupBy('category_id')
                  ->get();
        //echo "<pre>"; print_r($cat_data); die; 
        $response = array();
        if(count($cat_data)>0){
          foreach ($cat_data as $key => $value) {
            $response[$key]['category_id'] = $value->category_id;
            $response[$key]['category_name'] = (@$value->category->title) ?: "";
            $data1 = Food::where('user_id',Auth::user()->id)
                      ->where('category_id',$value->category_id)
                      ->with('category','food_multiple_images','food_items')
                      ->orderBy('id','desc')->get();
            $response[$key]['products'] = $data1;
          }
          $data = ['status'=>true, 'message'=>'Food list','data'=> $response];
        }else{
          $data = ['status'=>false,'message'=>'Food not Found.','data'=> []]; 
        }
        return response()->json($data);
    }


    public function foodsearch($id) 
    {

      $foods = Food::where('category_id', 'Like', '%'.$id. '%')->get();
      if(count($foods)){
      return response()->json($foods, 200);
      } else {
      return response()->json(['status'=>false,
      "message" => "Record not found",
      'data'=>[],
      ], 404);
      }
    }

    public function delete(Request $request)
    {
        $CountryListing = Food::where('id',$request->id)->delete();
        if($CountryListing){
        return response()->json(['message'=>'Deleted Successfully.']);
        }
        else{
        return response()->json(['message'=>'Record Not Found.']);
        }
    }

}
