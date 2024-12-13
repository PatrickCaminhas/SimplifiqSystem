<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Rules\PasswordComplexity;


class SenhaResetController extends Controller
{
    //
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $user->update([
            'senha' => Hash::make($request->new_password), // Certifique-se de que `new_password` está no request
        ]);

        return back()->with('success', 'Senha resetada com sucesso');
    }


    public function requestForm()
    {
        return view('index.resetSenha');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker('funcionarios')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetForm($token)
    {
        return view('index.resetSenhaFormulario', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => [new PasswordComplexity(), 'required', 'confirmed', 'min:6'],
            'token' => 'required'
        ]);

        $status = Password::broker('funcionarios')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'senha' => Hash::make($password),
                ])->save();
            }
        );


        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }


}
