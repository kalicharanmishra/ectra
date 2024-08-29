<?php



use App\Models\Categories;





/*if (! function_exists('aws_url')) {

    function aws_url($path='')

    {

        return 'https://demo031122.s3.ap-northeast-1.amazonaws.com/'.$path;

    }

}*/



if (! function_exists('parentCat')) {

    function parentCat($name='')

    { 

         $list = Categories::where('name', $name)->with('parent_cat_data')->first()->toArray();

         return $list;

    }

}

function allCountriesCitisList($all)
{
    if($all == 0) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://countriesnow.space/api/v0.1/countries/',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    } else {
        $response = json_encode(['error'=>true, 'message' => 'please send correct parameter']);
    }
    return $response;
}

function generateRandomString($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;

}