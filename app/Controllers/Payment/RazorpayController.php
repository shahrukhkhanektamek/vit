<?php
namespace App\Http\Controllers\Payment;


use App\Helper\Helpers;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Custom;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentModel;



 
class RazorpayController extends Controller
{


    public function make_payment(Request $request)
    {
        $id = $request->id;
        $amount = 0;
        $redirectUrl = route('razorpay.payment-response').'?id='.$id;
        $orders = DB::table('transaction')->where("id",$id)->where("status",0)->first();
        if(!empty($orders))
        {
            $amount = $orders->tax_amount;
            $data['redirectUrl'] = $redirectUrl;
            $data['redirectFUrl'] = $redirectUrl;
            $data['redirectCUrl'] = $redirectUrl;
            $data['amount'] = $amount;
            $data['orders'] = $orders;
            $html = PaymentModel::razorpay_create_checksum($data);
            if(!empty($html))
            {
                DB::table('transaction')->where("id",$id)->update(["transaction_id"=>$html['transaction_id'],"payment_by"=>'razorpay',]);
                echo $html['html'];
            }
            else
            {
                return redirect('payment-block');
            }
        }
        else
        {
            return redirect('payment-block');
        }
    }

    
   
    public function payment_response(Request $request)
    {
        $id = $request->id;
        $transaction_id = $_POST['razorpay_payment_id'];
        // $signature = $_POST['razorpay_signature'];
        DB::table('transaction')->where("id",$id)->update(["transaction_id"=>$transaction_id,]);
        $orders = DB::table('transaction')->where("id",$id)->where("status",0)->first();

        if(!empty($orders))
        {
            $website_id = $orders->website_id;
            $website = DB::table('website')->where('id',$website_id)->first();
            $domain = $website->domain;

            $transaction_id = $orders->transaction_id;
            $payment_status = PaymentModel::razorpay_payment_status($transaction_id);
            if(!empty($payment_status['status']))
            {
                if($payment_status['status']=='paid' || $payment_status['status']=='captured')
                {
                    Custom::update_transaction($orders->id);
                    $url = $orders->base_url.'payment-success';
                    // return redirect($url);
                }
                else
                {
                    $url = $orders->base_url.'payment-faild';
                    // return redirect($url);
                }
            }
            else
            {
                $url = $orders->base_url.'payment-faild';
                // return redirect($url);
            }
        }
        else
        {
            $url = $orders->base_url.'payment-block';
            // return redirect($url);
        }
    }

 

    


}