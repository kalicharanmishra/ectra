<?php



namespace App\Http\Controllers\Auth;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller

{

    /*

    |--------------------------------------------------------------------------

    | Register Controller

    |--------------------------------------------------------------------------

    |

    | This controller handles the registration of new users as well as their

    | validation and creation. By default this controller uses a trait to

    | provide this functionality without requiring any additional code.

    |

    */



    use RegistersUsers;



    /**

     * Where to redirect users after registration.

     *

     * @var string

     */

    protected $redirectTo = RouteServiceProvider::HOME;



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('guest');

    }



    /**

     * Get a validator for an incoming registration request.

     *

     * @param  array  $data

     * @return \Illuminate\Contracts\Validation\Validator

     */

    protected function validator(array $data)

    {

        return Validator::make($data, [

            'name' => ['required', 'string', 'max:255'],

            'email' => ['string', 'email', 'max:255', 'unique:users'],

            'password' => ['required', 'string', 'min:8', 'confirmed', 'required_with:password_confirmed'],
            'phone' => ['required|unique:users,phone|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'],
            'gender'=> ['required'],
            'address' => ['required'],

        ],
        [
            'name' => 'This is a mandatory field, please fill this up.'
        ]);

    }



    /**

     * Create a new user instance after a valid registration.

     *

     * @param  array  $data

     * @return \App\Models\User

     */

    protected function create(Request $request)

    {
        $data = $request->all();
            /*$user = User::create(['name' => $data['name'],
                'dob' => $data['dob'],
                'email' => $data['email'],
                'phone' => $data['number'],
                'gender' => $data['gender'],
                'location' => $data['address'],
                'password' => Hash::make($data['password'])
            ]);*/
        $user = User::where('email', $data['email'])->first();
        if($user && !empty($user) && $data['user_type'] == 'user')
        {
            $user->assignRole('user');
            $credentials = $request->only('email', 'password');
            Auth::attempt($credentials);
            $request->session()->regenerate();
            return redirect()->route('admin.v1.dashboard')->withSuccess('You have successfully registered & logged in!');
        } else {
            $user->assignRole('tutor');
            $credentials = $request->only('email', 'password');
            Auth::attempt($credentials);
            $request->session()->regenerate();
            return redirect()->route('tutor.profession')->with('success', 'You have successfully registered & please fill the profession form.');
        }
         
        
         // return $user;
        // return redirect()->route('success');

    }

}

