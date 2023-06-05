<?php

namespace App\Helpers;

use App\Helpers\App\QontakUtil;

class QontakMessage
{

    public $authObject;
    public $token;

    public function __construct()
    {

    }

    public function auth()
    {

        $resArr = QontakUtil::getToken();

        $this->authObject = $resArr;

        $this->token = $resArr->access_token ?? '';
    }

    public function postTemplate($name, $body, $category = 'ALERT_UPDATE', $language = 'id'){

        $token = $this->token;

        $response = QontakUtil::postTemplate($name, $body, $token ,$category, $language);

        return $response->body();
    }

}
