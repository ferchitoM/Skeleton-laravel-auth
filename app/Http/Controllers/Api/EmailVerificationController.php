<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller {

    public function verify(EmailVerificationRequest $request) {

        if ($request->user()->hasVerifiedEmail()) {
            return [
                'message' => 'El correo ya se encuentra verificado'
            ];
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return [
            'message' => 'El correo se verificó exitosamente'
        ];
    }

    public function resendEmail(Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return [
                'message' => 'El correo ya se encuentra verificado'
            ];
        }

        $request->user()->sendEmailVerificationNotification();

        return ['message' => 'Correo de verificación enviado'];
    }
}
