<?php
declare(strict_types=1);
namespace Patreon;

use Patreon\Exceptions\CurlException;
use SensitiveParameter;

/**
 * Class OAuth
 * @package Patreon
 */
class OAuth
{
    private string $client_id;
    private string $client_secret;

    /**
     * OAuth constructor.
     *
     */
    public function __construct(#[SensitiveParameter]string $client_id, #[SensitiveParameter] string $client_secret)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    /**
     * @param string $code
     * @param string $redirect_uri
     * @return array
     * @throws CurlException
     */
    public function get_tokens(string $code, string $redirect_uri): array
    {
        return $this->__update_token([
            "grant_type" => "authorization_code",
            "code" => $code,
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret,
            "redirect_uri" => $redirect_uri
        ]);
    }

    /**
     * @param string $refresh_token
     * @return array
     * @throws CurlException
     */
    public function refresh_token(#[SensitiveParameter]string $refresh_token): array
    {
        return $this->__update_token([
            "grant_type" => "refresh_token",
            "refresh_token" => $refresh_token,
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret
        ]);
    }

    /**
     * @param array $params
     * @return array
     * @throws CurlException
     */
    private function __update_token(array $params): array
    {
        $api_endpoint = "https://api.patreon.com/oauth2/token";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Patreon-PHP, version 1.0.2, platform ".php_uname('s').'-'.php_uname('r'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

        // Strict TLS verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        if (!defined('CURLOPT_SSL_VERIFYPEER')) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        }

        $response = curl_exec($ch);
        if (!is_string($response)) {
            throw new CurlException('No response returned from Patreon server');
        }

        return (array) json_decode($response, true);
    }
}
