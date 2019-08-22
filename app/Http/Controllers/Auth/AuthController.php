<?php
    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Http\Request;
    
    class AuthController extends Controller {
        use ValidatesRequests;

        protected $request;

        public function __construct(Request $request){
            $this->request = $request;
        }
    
        public function login(){
            return view('login');
        }
        public function loginUser(){
            // validate users request
            $this->validate($this->request,[
                'email' => 'required|email|exists:users'
            ]);
            dd('email exists');
            // create users token after successful request validation
            // send login url link to users mail
        }
    
    }
?>