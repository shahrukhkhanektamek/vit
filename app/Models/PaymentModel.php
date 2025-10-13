<?php
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use Razorpay\Api\Api;


require_once APPPATH.'Libraries/razorpay-php/Razorpay.php'; // Razorpay SDK ka entry file


class PaymentModel extends Model
{
    protected $table = 'about_logo';
    protected $useTimestamps = true;
    protected $createdField = 'add_date_time';
    protected $updatedField = 'update_date_time';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /*phonepe start*/

        public function phonepe_create_url($data)
        {
            $db = db_connect();
            $payment_setting = $db->table('payment_setting')->where('name', 'PhonePe')->get()->getRow();

            if (!$payment_setting) {
                return '';
            }

            $key_data = json_decode($payment_setting->data);
            $key = $key_data->key ?? '';
            $salt = $key_data->salt ?? '';

            $order_amount = $data['amount'];
            $transaction_id = $data['transaction_id'];
            $redirectUrl = $data['redirectUrl'];

            $payload = [
                'merchantId' => $key,
                'merchantTransactionId' => $transaction_id,
                'order_id' => $transaction_id,
                'merchantUserId' => 'MUID123',
                'amount' => $order_amount * 100,
                'redirectUrl' => $redirectUrl,
                'redirectMode' => 'POST',
                'callbackUrl' => $redirectUrl,
                'mobileNumber' => '',
                'paymentInstrument' => [
                    'type' => 'PAY_PAGE',
                ],
            ];

            $encoded = base64_encode(json_encode($payload));
            $saltKey = $salt;
            $saltIndex = 1;

            $stringToHash = $encoded . '/pg/v1/pay' . $saltKey;
            $sha256 = hash('sha256', $stringToHash);
            $finalXHeader = $sha256 . '###' . $saltIndex;

            $client = \Config\Services::curlrequest();
            $response = $client->post('https://api.phonepe.com/apis/hermes/pg/v1/pay', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-VERIFY' => $finalXHeader
                ],
                'json' => [
                    'request' => $encoded
                ]
            ]);

            $responseBody = json_decode($response->getBody());

            if (!empty($responseBody) && $responseBody->success === true) {
                return $responseBody->data->instrumentResponse->redirectInfo->url ?? '';
            }

            return '';
        }

        public function phonepe_payment_status($transaction_id)
        {
            $db = db_connect();
            $payment_setting = $db->table('payment_setting')->where('name', 'PhonePe')->get()->getRow();

            if (!$payment_setting) {
                return null;
            }

            $key_data = json_decode($payment_setting->data);
            $key = $key_data->key ?? '';
            $salt = $key_data->salt ?? '';

            $saltKey = $salt;
            $saltIndex = 1;

            $stringToHash = "/pg/v1/status/" . $key . "/" . $transaction_id . $saltKey;
            $sha256 = hash('sha256', $stringToHash);
            $finalXHeader = $sha256 . '###' . $saltIndex;

            $client = \Config\Services::curlrequest();
            $response = $client->get("https://api.phonepe.com/apis/hermes/pg/v1/status/{$key}/{$transaction_id}", [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-VERIFY' => $finalXHeader,
                    'X-MERCHANT-ID' => $key
                ]
            ]);

            return json_decode($response->getBody());
        }

    /*phonepe end*/




    /*payumoney start*/

        public function payu_create_checksum($data)
        {
            $db = db_connect();
            $payment_setting = $db->table("payment_setting")->where('name', 'Payumoney')->get()->getRow();
            if (!$payment_setting) return '';

            $key_data = json_decode($payment_setting->data);
            $MERCHANT_KEY = $key_data->key ?? '';
            $SALT = $key_data->salt ?? '';
            $orders = $data['orders'];

            $db->table('transaction')->where('id', $orders->id)->update(['product_name' => 'Consultation Fees']);

            $orders = $db->table('transaction')->where('id', $orders->id)->where('status', 0)->get()->getRow();
            if (!$orders) return '';

            $txnid = $data['transaction_id'];
            $amount = $data['amount'];
            $productinfo = $orders->product_name;
            $firstname = explode(" ", $orders->name)[0] ?? '';
            $email = $orders->email;
            $phone = $orders->phone;
            $success_url = $data['redirectUrl'];
            $failed_url = $data['redirectFUrl'];
            $cancelled_url = $data['redirectCUrl'];

            $udf1 = $udf2 = $udf5 = '';
            $hash_string = $MERCHANT_KEY . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' . $firstname . '|' . $email . '|' . $udf1 . '|' . $udf2 . '|||' . $udf5 . '||||||' . $SALT;
            $hash = hash('sha512', $hash_string);

            $html = '
            <form action="https://secure.payu.in/_payment" id="payment_form_submit" method="post">
                <input type="hidden" name="key" value="' . $MERCHANT_KEY . '" />
                <input type="hidden" name="txnid" value="' . $txnid . '" />
                <input type="hidden" name="amount" value="' . $amount . '" />
                <input type="hidden" name="productinfo" value="' . $productinfo . '" />
                <input type="hidden" name="firstname" value="' . $firstname . '" />
                <input type="hidden" name="email" value="' . $email . '" />
                <input type="hidden" name="phone" value="' . $phone . '" />
                <input type="hidden" name="surl" value="' . $success_url . '" />
                <input type="hidden" name="furl" value="' . $failed_url . '" />
                <input type="hidden" name="curl" value="' . $cancelled_url . '" />
                <input type="hidden" name="hash" value="' . $hash . '" />
                <input type="hidden" name="udf1" value="' . $udf1 . '" />
                <input type="hidden" name="udf2" value="' . $udf2 . '" />
                <input type="hidden" name="udf5" value="' . $udf5 . '" />
                <input type="hidden" name="Lastname" value="" />
                <input type="hidden" name="Zipcode" value="" />
                <input type="hidden" name="address1" value="" />
                <input type="hidden" name="address2" value="" />
                <input type="hidden" name="city" value="" />
                <input type="hidden" name="state" value="" />
                <input type="hidden" name="country" value="" />
                <input type="hidden" name="Pg" value="Pay" />
            </form>
            <script type="text/javascript">
                document.getElementById("payment_form_submit").submit();
            </script>';

            return $html;
        }

        public function payu_payment_status($transaction_id)
        {
            $db = db_connect();
            $payment_setting = $db->table("payment_setting")->where('name', 'Payumoney')->get()->getRow();
            if (!$payment_setting) return null;

            $key_data = json_decode($payment_setting->data);
            $key = $key_data->key ?? '';
            $salt = $key_data->salt ?? '';

            $hash_string = $key . '|verify_payment|' . $transaction_id . '|' . $salt;
            $hash = hash('sha512', $hash_string);

            $client = \Config\Services::curlrequest();
            $response = $client->post('https://info.payu.in/merchant/postservice?form=2', [
                'form_params' => [
                    'key' => $key,
                    'command' => 'verify_payment',
                    'hash' => $hash,
                    'var1' => $transaction_id
                ]
            ]);

            return json_decode($response->getBody());
        }

    /*payumoney end*/




    /*Razorpay start*/

        public function razorpay_create_checksum($data)
        {        

            $orders = $data['orders'];            
            $detail = json_decode($orders->detail)[0];
            

            $payment_setting = $this->db->table('payment_setting')->where('payment_by', $orders->payment_by)->get()->getRow();
            $key_data = json_decode($payment_setting->data);
            $key = $key_data->key;
            $salt = $key_data->salt;
            $amount = $data['amount'];
            $productinfo = $detail->name;
            $api = new Api($key, $salt);
            $razorpayOrder = $api->order->create(array(
                'receipt'         => rand(),
                'amount'          => $amount * 100, // 2000 rupees in paise
                'currency'        => 'INR',
                'payment_capture' => 1 // auto capture
            ));
            $amount = $razorpayOrder['amount'];
            $razorpayOrderId = $razorpayOrder['id'];
            $dataData = array(
                  "key" => $key,
                  "amount" => $amount,
                  "name" => env('APP_NAME'),
                  "description" => env('APP_NAME'),
                  "image" => '',
                  "prefill" => array(
                    "name"  => $orders->user_name,
                    "email"  => $orders->user_email,
                    "contact" => $orders->user_phone,
                  ),
                  "notes"  => array(
                    "address"  => "Hello World",
                    "merchant_order_id" => rand(),
                  ),
                  "theme"  => array(
                    "color"  => "#F37254"
                  ),
                  "order_id" => $razorpayOrderId,
                );
                $View = '
                    <button id="rzp-button1" style="display:none;">Pay with Razorpay</button>
                    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
                    <form name="razorpayform" action="'.$data['redirectUrl'].'" method="POST">
                        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                        <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
                    </form>
                    <script>
                    var options = '.json_encode($dataData).';
                    options.handler = function (response){
                        document.getElementById("razorpay_payment_id").value = response.razorpay_payment_id;
                        document.getElementById("razorpay_signature").value = response.razorpay_signature;
                        document.razorpayform.submit();
                    };
                    options.theme.image_padding = false;
                    options.modal = {
                        ondismiss: function() {
                            console.log("This code runs when the popup is closed");
                        },
                        escape: true,
                        backdropclose: false
                    };
                    var rzp = new Razorpay(options);
                    $(document).ready(function(){
                      $("#rzp-button1").click();
                       rzp.open();
                        e.preventDefault();
                    });
                    </script>
                ';
                return ["transaction_id"=>$razorpayOrderId,"html"=>$View,];

        }        
        public function razorpay_payment_status($transaction_id)
        {
            $payment_setting = $this->db->table('payment_setting')->where('payment_by', 'razorpay')->get()->getRow();

            $key_data = json_decode($payment_setting->data);
            $api_key = $key_data->key;
            $api_secret = $key_data->salt;
            
            $orders = $this->db->table('transaction')->where("transaction_id",$transaction_id)->where("status",0)->get()->getRow();
            if(!empty($orders))
            {
                $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/payments/" . $transaction_id);
                curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/orders/" . $transaction_id);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERPWD, $api_key . ":" . $api_secret);
                $response = curl_exec($ch);
                curl_close($ch);
                $payment_details = json_decode($response, true);
                return $payment_details;
            }
            return [];
        }

    /*Razorpay end*/





    
}
