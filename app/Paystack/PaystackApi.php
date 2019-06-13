<?php

namespace App\Paystack;


use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Response;

class PaystackApi
{
    private $client;

    protected $endpoints = [
        'bank_list' => '/bank',
        'create_recipient' => '/transferrecipient',
        'update_recipient' => '/transferrecipient/%s',
        'resolve_account' => '/bank/resolve?account_number=%s&bank_code=%s',
        'transfer'=>'/transfer',
        'finalize_transfer'=>'/transfer/finalize_transfer',
        'enable_otp'=>'/transfer/enable_otp',
        'disable_otp'=>'/transfer/disable_otp',
        'finalize_disable_otp'=>'/transfer/disable_otp_finalize',
    ];

    protected $base_uri = 'https://api.paystack.co';

    public $errorCodes = [
        200 => 'Transaction successful',
        201 => 'Success',
        400 => 'An error occured and the request was not fulfiled',
        404 => 'Request could not be fulfilled as the request resource does not exist.',
        422 => '',
        500 => 'Internal server error. Seek technical assistance.',
        501 => 'Internal server error. Seek technical assistance.',
        502 => 'Internal server error. Seek technical assistance.',
        503 => 'Internal server error. Seek technical assistance.',
        504 => 'Internal server error. Seek technical assistance.',
    ];

    private $headers;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client(['base_uri'=>$this->base_uri]);

        $this->headers = [
            'Cache-Control'=>'no-cache',
            'Content-type' => 'application/json',
            'Authorization'=>' Bearer '.env('PAYSTACK_SK')
        ];
    }

    /**
     * Get list of banks and bank codes from paystack
     * @return array
     */
    public function getBankList()
    {
        $options = [
            'headers' => $this->headers
        ];

        try {

            $request = $this->client->get($this->endpoints['bank_list'], $options);
            $response = json_decode($request->getBody()->getContents(), true);

            return $response;

        } catch (RequestException $exception) {

            return $this->StatusCodeHandling($exception);

        }

    }

    /**
     * Resolve account number
     * @return array
     */
    public function resolveAccount($account_number, $bank_code)
    {
        $options = [
            'headers' => $this->headers
        ];

        try {

            $request = $this->client->get(sprintf($this->endpoints['resolve_account'],$account_number,$bank_code), $options);
            $response = json_decode($request->getBody()->getContents(), true);

            return $response;

        } catch (RequestException $exception) {

            return $this->StatusCodeHandling($exception);

        }

    }

    public function createRecipient(array $data)
    {
        $options = [
            'headers' => $this->headers,
            'body'    => json_encode($data)
        ];

        try {

            $request = $this->client->post($this->endpoints['create_recipient'], $options);
            $response = json_decode($request->getBody()->getContents(), true);
            return $response;

        } catch (RequestException $exception) {
            return $this->StatusCodeHandling($exception);
        }
    }

    public function updateRecipient($recipient_code, array $data) {
        $options = [
            'headers' => $this->headers,
            'body'    => json_encode($data)
        ];

        try {

            $request = $this->client->put(sprintf($this->endpoints['update_recipient'],$recipient_code), $options);
            $response = json_decode($request->getBody()->getContents(), true);
            return $response;

        } catch (RequestException $exception) {
            return $this->StatusCodeHandling($exception);
        }
    }

    public function deleteRecipient($recipient_code, array $data=[]) {
        $options = [
            'headers' => $this->headers,
            'body'    => json_encode($data)
        ];

        try {

            $request = $this->client->delete(sprintf($this->endpoints['update_recipient'],$recipient_code), $options);
            $response = json_decode($request->getBody()->getContents(), true);
            return $response;

        } catch (RequestException $exception) {
            return $this->StatusCodeHandling($exception);
        }
    }




    public function makeSingeTransfer(array $data)
    {
        $options = [
            'headers' => $this->headers,
            'body'    => json_encode($data)
        ];

        try {
            $request = $this->client->post($this->endpoints['transfer'], $options);
            $response = json_decode($request->getBody()->getContents(), true);

            $response['code'] = $request->getStatusCode();

            return $response;

        } catch (RequestException $exception) {
            return $this->StatusCodeHandling($exception);
        }
    }

    public function sendTransferOTP(array $data) {
        $options = [
            'headers' => $this->headers,
            'body' => json_encode($data)
        ];

        try {

            $request = $this->client->post($this->endpoints['finalize_transfer'], $options);
            $response = json_decode($request->getBody()->getContents(), true);
            return $response;

        } catch (RequestException $exception) {
            return $this->StatusCodeHandling($exception);
        }

    }


    public function enableOtp() {
        $options = [
            'headers' => $this->headers,
        ];

        try {
            $request = $this->client->post($this->endpoints['enable_otp'], $options);
            $response = json_decode($request->getBody()->getContents(), true);
            return $response;
        } catch (RequestException $exception) {
            return $this->StatusCodeHandling($exception);
        }
    }


    public function disableOtp() {
        $options = [
            'headers' => $this->headers,
        ];

        try {
            $request = $this->client->post($this->endpoints['disable_otp'], $options);
            $response = json_decode($request->getBody()->getContents(), true);
            return $response;
        } catch (RequestException $exception) {
            return $this->StatusCodeHandling($exception);
        }
    }

    public function finalizeDisableOtp(array $data) {
        $options = [
            'headers' => $this->headers,
            'body' => json_encode($data)
        ];

        try {
            $request = $this->client->post($this->endpoints['finalize_disable_otp'], $options);
            $response = json_decode($request->getBody()->getContents(), true);
            return $response;
        } catch (RequestException $exception) {
            return $this->StatusCodeHandling($exception);
        }
    }



    private function StatusCodeHandling(RequestException $exception)
    {
        $code = $exception->getResponse() ? $exception->getResponse()->getStatusCode() : 0;

        $response = [
            'status'=>false,
            'code'=>$code,
            'response'=> $exception->getResponse() ? json_decode($exception->getResponse()->getBody(true)->getContents(), true) : null
        ];

        if ($exception->getResponse()) {
            $exception->getResponse()->getBody()->rewind();
            $body = json_decode($exception->getResponse()->getBody()->getContents(), true);

            $response['message'] = array_key_exists('message', $body) ? $body['message'] : $this->errorCodes[$code];
        } else {
            $response['message'] = 'Connection failed. Check your connection and try again.';
        }

        return $response;
    }
}