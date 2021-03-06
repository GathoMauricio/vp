
<?php
if (!function_exists('getFormatDate')) {
    function getFormatDate($date)
    {
        $diassemanaN = array(
            "Domingo", "Lunes", "Martes", "Miércoles",
            "Jueves", "Viernes", "Sábado"
        );
        $mesesN = array(
            1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        );
        return $diassemanaN[date_format(new \DateTime($date), 'N')] 
        .' '.date_format(new \DateTime($date), 'd'). 
        ' de '.
        $mesesN[date_format(new \DateTime($date), 'n')].
        ' del '.
        date_format(new \DateTime($date), 'Y')
        .' a las '.
        date_format(new \DateTime($date),'g:i A');
    }
}
if (!function_exists('parseBase64')) {
    function parseBase64($image)
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $imageData = file_get_contents($image, false, stream_context_create($arrContextOptions));
        $data64 = base64_encode($imageData);
        $data = 'data:image/' . $type . ';base64,' . $data64;
        return $data;
    }
}

if (!function_exists('current_user')) {
    function current_user()
    {
        return auth()->user();
    }
}

if (!function_exists('getRoles')) {
    function getRoles()
    {
        $roles = App\UserRol::where('user_id', Auth::user()->id)->get();
        $rol_admin = false;
        $rol_mesa = false;
        $rol_tec = false;
        foreach ($roles as $rol) {
            if ($rol->rol_id == 7) {
                $rol_admin = true;
            }
            if ($rol->rol_id == 6) {
                $rol_mesa = true;
            }
            if ($rol->rol_id < 6) {
                $rol_tec = true;
            }
        }
        return [
            'rol_admin' => $rol_admin,
            'rol_mesa' => $rol_mesa,
            'rol_tec' => $rol_tec
        ];
    }
}
if (!function_exists('sendFcm')) {
    function sendFcm($fcm_token, $title, $body, $service_id)
    {
        $data = json_encode([
            "to" => $fcm_token,
            "notification" => [
                "title" => $title,
                "body" => $body,
                "icon" => "ic_launcher",
                "sound" => "default"
            ],
            "data" => [
                'service_id' => $service_id
            ]
        ]);
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AAAAmbD0P8Q:APA91bE90ohQs-Rv5Eed17S97MwqeSegVZyv2Eecb5g5NVEPIa224VbO_GkhTL9vgP8uHDoYWdwKV_Hm3kE-zFvxH7ynGtByTHI8ZfdglFG_L28RMu7tXtEn44YXPBRJ6r8RP9pq48hU';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $server_key
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            return die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
}
