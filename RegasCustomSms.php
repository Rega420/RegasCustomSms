<?php
if (isset($_GET['phn']) && isset($_GET['msg'])) {
    $phn = $_GET['phn'];
    $msg = $_GET['msg'];

    if (strlen($phn) !== 11) {
        echo 'Invalid Mobile Number';
    } else {
        $api_url = 'http://202.51.182.198:8181/nbp/sms/code';

        $data = array(
            'receiver' => $phn,
            'text' => $msg,
            'title' => 'Register Account'
        );

        $ch = curl_init($api_url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if ($response === false) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            $response_data = json_decode($response, true);

            if (isset($response_data['status']) && $response_data['status'] == 'success') {
                echo 'Failed to send SMS ';
            } else {
                echo 'SMS sent successfully '  . $response_data['message'];
            }
        }

        curl_close($ch);
    }
}
?>