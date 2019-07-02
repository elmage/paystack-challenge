<?php

namespace App\Paystack;


use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Response;

class PaystackApi
{
    private $client;

    protected $endpoints = [
        'bank_list' => '/bank',
        'create_recipient' => '/transferrecipient',
        'update_recipient' => '/transferrecipient/%s',
        'resolve_account' => '/bank/resolve?account_number=%s&bank_code=%s',
        'transfer' => '/transfer',
        'finalize_transfer' => '/transfer/finalize_transfer',
        'resend_otp' => '/transfer/resend_otp',
        'enable_otp' => '/transfer/enable_otp',
        'disable_otp' => '/transfer/disable_otp',
        'finalize_disable_otp' => '/transfer/disable_otp_finalize',
        'verify_transaction' => '/transaction/verify/%s',
        'charge_card' => '/transaction/charge_authorization',
        'balance' => '/balance'
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
        $this->client = new GuzzleClient(['base_uri' => $this->base_uri]);

        $this->headers = [
            'Cache-Control'=>'no-cache',
            'Content-type' => 'application/json',
            'Authorization'=>' Bearer '.config('paystack.secret_key')
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

            return $this->statusCodeHandling($exception);

        }

    }

    /**
     * Resolve account number
     * @param $account_number
     * @param $bank_code
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

            return $this->statusCodeHandling($exception);

        }

    }

    /**
     * Create a transfer recipient
     * @param array $data
     * @return array|mixed
     */
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
            return $this->statusCodeHandling($exception);
        }
    }

    /**
     * Update a transfer recipient
     * @param $recipient_code
     * @param array $data
     * @return array|mixed
     */
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
            return $this->statusCodeHandling($exception);
        }
    }

    /**
     * Delete a transfer recipient
     * @param $recipient_code
     * @param array $data
     * @return array|mixed
     */
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
            return $this->statusCodeHandling($exception);
        }
    }

    /**
     * Send a single transfer request
     * @param array $data
     * @return array|mixed
     */
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
            return $this->statusCodeHandling($exception);
        }
    }

    /**
     * Finalize transaction with OTP request
     * @param array $data
     * @return array|mixed
     */
    public function sendTransferOTP(array $data)
    {
        $options = [
            'headers' => $this->headers,
            'body' => json_encode($data)
        ];

        try {

            $request = $this->client->post($this->endpoints['finalize_transfer'], $options);
            $response = json_decode($request->getBody()->getContents(), true);
            return $response;

        } catch (RequestException $exception) {
            return $this->statusCodeHandling($exception);
        }

    }

    public function resendTransferOtp(array $data)
    {
        $options = [
            'headers' => $this->headers,
            'body' => json_encode($data)
        ];

        try {

            $request = $this->client->post($this->endpoints['resend_otp'], $options);
            $response = json_decode($request->getBody()->getContents(), true);
            return $response;

        } catch (RequestException $exception) {
            return $this->statusCodeHandling($exception);
        }
    }

    /**
     * Enable transfer confirmation - OTP
     * @return array|mixed
     */
    public function enableOtp() {
        $options = [
            'headers' => $this->headers,
        ];

        try {
            $request = $this->client->post($this->endpoints['enable_otp'], $options);
            $response = json_decode($request->getBody()->getContents(), true);
            return $response;
        } catch (RequestException $exception) {
            return $this->statusCodeHandling($exception);
        }
    }

    /**
     * Disable transfer confirmation - OTP
     * @return array|mixed
     */
    public function disableOtp() {
        $options = [
            'headers' => $this->headers,
        ];

        try {
            $request = $this->client->post($this->endpoints['disable_otp'], $options);
            $response = json_decode($request->getBody()->getContents(), true);
            return $response;
        } catch (RequestException $exception) {
            return $this->statusCodeHandling($exception);
        }
    }

    /**
     * Confirm disable OTP
     * @param array $data
     * @return array|mixed
     */
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
            return $this->statusCodeHandling($exception);
        }
    }

    /**
     * Verify a transaction
     * @param $ref
     * @return array|mixed
     */
    public function verifyTransaction($ref) {
        $options = [
            'headers' => $this->headers
        ];

        try {
            $request = $this->client->get(sprintf($this->endpoints['verify_transaction'],$ref), $options);
            $response = json_decode($request->getBody()->getContents());
            return $response;
        } catch (RequestException $exception) {
            return $this->statusCodeHandling($exception);
        }
    }

    /**
     * Charge card with auth code
     * @param array $data
     * @return array|mixed
     */
    public function chargeCard(array $data)
    {
        $options = [
            'headers' => $this->headers,
            'body' => json_encode($data)
        ];

        try {
            $request = $this->client->post($this->endpoints['charge_card'], $options);
            $response = json_decode($request->getBody()->getContents(), true);
            return $response;
        } catch (RequestException $exception) {
            return $this->statusCodeHandling($exception);
        }
    }


    public function getBalance()
    {
        $options = [
            'headers' => $this->headers
        ];

        try {
            $request = $this->client->get($this->endpoints['balance'], $options);
            $response = json_decode($request->getBody()->getContents(), true);
            return $response;
        } catch (RequestException $exception) {
            return $this->statusCodeHandling($exception);
        }
    }


    /**
     * Handle API Exception
     * @param RequestException $exception
     * @return array
     */
    private function statusCodeHandling(RequestException $exception)
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