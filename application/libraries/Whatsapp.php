<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Whatsapp {

    protected $CI;
    protected $phone_id;
    protected $token;
    protected $version;
    protected $lang;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->config->load('whatsapp');

        $this->phone_id = $this->CI->config->item('wa_phone_id');
        $this->token    = $this->CI->config->item('wa_token');
        $this->version  = $this->CI->config->item('wa_version');
        $this->lang     = $this->CI->config->item('wa_language');
    }

    public function send_template($to, $template, $params = [])
    {
        $components = [];
        foreach ($params as $p) {
            $components[] = [
                "type" => "text",
                "text" => $p
            ];
        }

        $payload = [
            "messaging_product" => "whatsapp",
            "to" => $to,
            "type" => "template",
            "template" => [
                "name" => $template,
                "language" => ["code" => $this->lang],
                "components" => [
                    [
                        "type" => "body",
                        "parameters" => $components
                    ]
                ]
            ]
        ];

        $url = "https://graph.facebook.com/{$this->version}/{$this->phone_id}/messages";

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->token}",
                "Content-Type: application/json"
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
