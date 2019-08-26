<?php
    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Http\Request;
    use App\User;
    use App\Token;
    use Auth;

    class AuthController extends Controller {
        use ValidatesRequests;

        protected $request;

        public function __construct(Request $request,Token $token){
            $this->request = $request;
            $this->token = $token;
        }

        public function login(){
            return view('login');
        }
        public function loginUser(){
            // validate users request
            $this->validate($this->request,[
                'email' => 'required|email|exists:users'
            ]);
            // get Users details through their mail field
            $user = User::verifyUserEmail($this->request->email);
            // create users token after successful request validation
            $this->token = Token::generateToken($user);
            // send login url link to users mail
            $url = url("/auth/token",$this->token->token);
            Mail::raw(
              "<a href='{$url}'>{$url}</a>",function($message){
                $message->to($this->token->user->email)->subject('My first logged Mail');
              }
            );
        }
        public function authenticate(Token $token)
        {
          Auth::login($token->user);

          $token->delete();
          return redirect('dashboard');
        }

        public function logout()
        {
          Auth::logout();
          return redirect('login');
        }

    }
?>
