<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
class EmailBodyController extends Controller
{
    public static function sendotp($name,$mesg){
        $body = ' <tr>
            <td align="center" style="padding:0;">
                    <tr>
                        <td style="padding:36px 30px 42px 30px;">
                                <tr>
                                    <td style="padding:0 0 36px 0;color:#153643;">
                                        <p style="font-weight:bold;margin:30px 0 20px 0;font-family:Arial,sans-serif;">
                                             Hi '. $name .',
                                        <p
                                            style="margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
                                            '.$mesg.'
                                        </p>

                                        <p style="margin:20px 0 12px 0;font-size:14px;font-family:Arial,sans-serif;">
                                            Thank
                                            you, </p>
                                        <p style="margin:0 0 12px 0;font-size:14px;font-family:Arial,sans-serif;">
                                           DRS </p>
                                    </td>
                                </tr>
                        </td>
                    </tr>
            </td>
        </tr>';
        return $body;
    }
    public static function forgotpassword($id, $token)
    {
        $url = url('/reset-password/' . $id . '/' . $token);
        $body = ' <tr>
            <td align="center" style="padding:0;">
                    <tr>
                        <td style="padding:36px 30px 42px 30px;">
                                <tr>
                                    <td style="padding:0 0 36px 0;color:#153643;">
                                        <p style="font-weight:bold;margin:30px 0 20px 0;font-family:Arial,sans-serif;">
                                             Hi,
                                        <p
                                            style="margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
                                             You have requested a password reset link please click  <a href="' . $url . '" target="_blank">here</a> to reset your password.
                                        </p>

                                        <p style="margin:20px 0 12px 0;font-size:14px;font-family:Arial,sans-serif;">
                                            Thank
                                            you, </p>
                                        <p style="margin:0 0 12px 0;font-size:14px;font-family:Arial,sans-serif;">
                                           DRS </p>
                                    </td>
                                </tr>
                        </td>
                    </tr>
            </td>
        </tr>';
        return $body;
    }

}
