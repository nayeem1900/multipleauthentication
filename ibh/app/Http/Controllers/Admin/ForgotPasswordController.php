<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use App\Admin;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    public function __construct()
    {
        $this->middleware('guest:admin');
    }
    public function showLinkRequestForm()
    {
        return view('admin.passwords.email');
    }



    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);


        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request,$response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    public function broker()
    {
        return Password::broker('admins');
    }




}
