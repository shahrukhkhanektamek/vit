<?php
namespace App\Http\Controllers\Payment;


use App\Helper\Helpers;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Custom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Helper\ImageManager;
use App\Models\MemberModel;
use App\Models\PaymentModel;
use App\Models\Package;
 
class PhonepeController extends Controller
{


    public function make_payment(Request $request)
    {
        $id = $request->id;
        $amount = 0;
        $redirectUrl = route('phonepe.payment-response').'?id='.$id;
        $transaction_id = 'MT'.rand ( 10000 , 99999 ).rand ( 10000 , 99999 ).rand ( 1000 , 9999 ).rand ( 10 , 99 );
        
        DB::table('transaction')->where("id",$id)->update(["transaction_id"=>$transaction_id,"payment_by"=>'phonepe',]);
        
        

        $orders = DB::table('transaction')->where("id",$id)->where("status",0)->first();
        if(!empty($orders))
        {
            $amount = $orders->tax_amount;
            $data['redirectUrl'] = $redirectUrl;
            $data['transaction_id'] = $transaction_id;
            $data['amount'] = $amount;
            $url = PaymentModel::phonepe_create_url($data);
            if(!empty($url))
            {
                return redirect($url);
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
        $orders = DB::table('orders')->where("id",$id)->where("status",0)->first();
         

        if(!empty($orders))
        {
            $insert_id = $orders->user_id;
            $transaction_id = $orders->transaction_id;

            $payment_status = PaymentModel::phonepe_payment_status($transaction_id);
            if($payment_status->success)
            {
                if($payment_status->code=='PAYMENT_SUCCESS')
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