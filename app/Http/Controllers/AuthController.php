<?php

namespace App\Http\Controllers;

use App\Models\TemporalToken;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Retrieves a temporal token for the admin access
     * 
     * @param String $token
     * @return Route
     */
    public function temporalToken($token)
    {
        // Check if the token is valid
        $temporalToken = TemporalToken::where('token', $token)->first();

        if (!$temporalToken) {
            return redirect(config('app.canvolt') . '/iniciar-sesion')->with('error', 'El token no es valido de acceso.');
        }

        // Check if the token is expired
        if ($temporalToken->expires_at < now()) {
            return redirect(config('app.canvolt') . '/iniciar-sesion')->with('error', 'El token de acceso ha expirado.');

            // Delete the token and more expired tokens
            TemporalToken::where('expires_at', '<', now())->delete();
        }

        // Get the user
        $user = User::find($temporalToken->user_id);

        // Log the user in
        Auth::login($user);
        return redirect('/panel');
    }

    /**
     * Logs the user out
     * 
     * @return Route
     */
    public function logout()
    {
        Auth::logout();
        return redirect(config('app.canvolt') . '/iniciar-sesion');
    }
}
