<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Services;
/**
 * Description of SMSsender
 *
 * @author stefano.scarsella3punto6.com
 */
class SMSsender 
{
            
    private const MESSAGE_HIGH_QUALITY = 'GP';
    private const MESSAGE_MEDIUM_QUALITY = 'TI';
    private const MESSAGE_LOW_QUALITY = 'SI';
    
    protected $BASEURL;
    protected $USER;
    protected $PASSWORD;
    
    public function __construct() {
        $this->USER = env('SMS_USER');
        $this->PASSWORD = env('SMS_PASS');
        $this->BASEURL = env('SMS_URL');
        
    }

    public function Send($msg, $phone, $brand) {
        $otp = $this->randomOTP();
        $subBrand = substr($brand, 0, 11);
        if($auth = $this->login($this->USER, $this->PASSWORD)) {
            $smsSent = $this->sendSMS($auth, array(
                "message" => $brand." - ".$msg.$otp,
                "message_type" => self::MESSAGE_HIGH_QUALITY,
                "returnCredits" => true,
                "recipient" => array($phone),
                "sender" => $subBrand
            ));

            if ($smsSent && $smsSent->result == "OK") {
                return $otp;
            }
        }
        return false;
    }
    
    public function VerifyOTP($otp, $dbToken) {
        if($dbToken->otp == $otp) {
            return true;
        }
        return false;
    }

    private function login($username, $password) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->BASEURL .
                    'login?username=' . $username .
                    '&password=' . $password);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        if ($info['http_code'] != 200) {
            return false;
        }

        return explode(";", $response);
    }

    private function sendSMS($auth, $sendSMS) {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->BASEURL . 'sms');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-type: application/json',
            'user_key: ' . $auth[0],
            'Session_key: ' . $auth[1]
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sendSMS));
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] != 201) {
            return false;
        }

        return json_decode($response);
    }

    private function randomOTP() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1; 
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); 
    }
    
}
