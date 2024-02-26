<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function store(Request $request) {
        //moze neka validacija odje

        $authorizationHeader = $request->header('Authorization');

        $token = false;

        //isti kod ide i za symphony da uzmes token
        if ($authorizationHeader && preg_match('/Bearer\s+(.+)/i', $authorizationHeader, $matches)) {
            if(isset($matches[1])) {
                $token = $matches[1];
            }
        }

        // $first_name = $request->first_name;
        // $last_name = $request->last_name;
        // $email = $request->email;
        // $country = $request->country;
        // $personal_type = $request->personal_type;
        // $interested_in_payroll = $request->interested_in_payroll;
        // $wants_to_be_emailed = $request->wants_to_be_emailed;
        // $phone_number = $request->phone_number;

        $client_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;

        $partner_source = false;
        if($token) {
            $decoded_jwt = $this->decodeJWT($token); //ovde bi trebalo da dobijes array sa svim informacijama

            $payload = $decoded_jwt['payload']; //proveri sadrzaj ovog array-a, trebalo bi da ima info odakle je request

            $partner_source = isset($payload['source']) ? $payload['source'] : false; // npr
        }

        // logic to store data
        // $store_model = new StoreModel();
        // $store_model->first_name = $first_name;
        // $store_model->last_name = $last_name;
        // $store_model->email = $email;
        // $store_model->country = $country;
        // $store_model->personal_type = $personal_type;
        // $store_model->interested_in_payroll = $interested_in_payroll;
        // $store_model->wants_to_be_emailed = $wants_to_be_emailed;
        // $store_model->phone_number = $phone_number;
        // $store_model->save();


        // response
    }

    private function decodeJWT($jwt_token) {
        $token_parts = explode('.', $jwt_token);

        if (count($token_parts) !== 3) {
            return false; // Invalid token format
        }

        $header = base64_decode($token_parts[0]);
        $payload = base64_decode($token_parts[1]);
        $signature = base64_decode($token_parts[2]);

        $data = [
            'header' => json_decode($header, true),
            'payload' => json_decode($payload, true),
            'signature' => $signature
        ];

        return $data;
    }
}
