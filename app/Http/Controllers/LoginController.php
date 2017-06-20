<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19.06.2017
 * Time: 23:27
 */

namespace  App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;

class LoginController extends Controller{

    public function showLoginForm(Request $request){
        return $this->template->render('auth.login',array('title'=>translate('autorize')));
    }

    public function verify(Request $request){

        if (empty($request->email) and empty($request->password)) exit('1');
        $user = UserModel::loginUser(htmlspecialchars($request->email,3));
        if (!count($user)){
            $error['text_message'] = translate('cannot_found_email');
            $error['email'] = 1;
            $userEnteredData['email'] = $request->email;
        }

        if (count($user)&&!password_verify($request->password,$user->password)){
            $error['text_message'] = translate('email_or_password_error');
            $error['email'] = 1;
            $error['password'] = 1;
            $userEnteredData['email'] = $request->email;
        }

        if (isset($error)and !empty($error))
            return $this->template->view('auth.login',array('title'=>translate('autorize'),'error'=>$error,'user'=>$userEnteredData));
        $_SESSION['user'] = $user->id;
        return redirect('/');

    }

}