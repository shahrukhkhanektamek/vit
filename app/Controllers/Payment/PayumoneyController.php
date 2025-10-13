<?php
namespace App\Http\Controllers\Payment;


use App\Helper\Helpers;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Models\PaymentModel;
use App\Models\Custom;

 
class PayumoneyController extends Controller
{


    public function make_payment(Request $request)
    {
        $id = $request->id;
        $amount = 0;
        $redirectUrl = route('payumoney.payment-response').'?id='.$id;
        $transaction_id = 'MT'.rand ( 10000 , 99999 ).rand ( 10000 , 99999 ).rand ( 1000 , 9999 ).rand ( 10 , 99 );

        DB::table('transaction')->where("id",$id)->update(["transaction_id"=>$transaction_id,"payment_by"=>'payumoney',]);
        // return redirect(route('payumoney.payment-response-testing').'?id='.Crypt::encryptString($id));
        
        $orders = DB::table('transaction')->where("id",$id)->where("status",0)->first();
        if(!empty($orders))
        {

            $amount = $orders->tax_amount;
            // $amount = 1;
            $data['redirectUrl'] = $redirectUrl;
            $data['redirectFUrl'] = $redirectUrl;
            $data['redirectCUrl'] = $redirectUrl;
            $data['transaction_id'] = $transaction_id;
            $data['amount'] = $amount;
            $data['orders'] = $orders;
            $html = PaymentModel::payu_create_checksum($data);
            $data['html'] = $html;

            if(!empty($html))
            {
                echo $html;
                // return view('payment/payumoney/index',compact('data'));
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
        $orders = DB::table('transaction')->where("id",$id)->where("status",0)->first();
        if(!empty($orders))
        {
            $transaction_id = $orders->transaction_id;
            $payment_status = PaymentModel::payu_payment_status($transaction_id);        
            if(!empty($payment_status->status) && !empty($payment_status->transaction_details->$transaction_id))
            {
                if(!empty($payment_status->transaction_details) && $payment_status->transaction_details->$transaction_id->status=='success')
                {
                    Custom::update_transaction($orders->id);
                    $url = $orders->base_url.'payment-success';
                    return redirect($url);
                }
                else
                {
                    $url = $orders->base_url.'payment-faild';
                    return redirect($url);
                }
            }
            else
            {
                $url = $orders->base_url.'payment-faild';
                return redirect($url);
            }
        }
        else
        {
            $url = $orders->base_url.'payment-block';
            return redirect($url);
        }
    }
   
    


}