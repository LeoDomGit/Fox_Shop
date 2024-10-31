<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{

    public function initiatePayment(Request $request)
    {
        $vnp_TmnCode = env('VNPAY_TMN_CODE');
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        $vnp_Url = env('VNPAY_URL');
        $vnp_ReturnUrl = 'http://127.0.0.1:8000/api/vnpayreturn';

        $vnp_BankCode = $request->input('bank_code');
        $vnp_OrderId = time();
        $vnp_OrderInfo = "Thanh toán đơn hàng";
        $vnp_Amount = $request->input('total_amount') * 100;
        $vnp_CreateDate = date('YmdHis');
        $vnp_IpAddr = request()->ip();

        $data = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_OrderId" => $vnp_OrderId,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_IpAddr" => $vnp_IpAddr,
        ];
        if ($vnp_BankCode) {
            $data['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($data);
        $queryString = http_build_query($data);
        $vnp_SecureHash = hash('sha256', $vnp_HashSecret . '&' . $queryString);
        $data['vnp_SecureHash'] = $vnp_SecureHash;
        $vnp_Url .= '?' . http_build_query($data);
        return response()->json(['url' => $vnp_Url]);
    }
public function vnpayReturn(Request $request)
    {
        $vnp_ResponseCode = $request->query('vnp_ResponseCode');
        $vnp_TxnRef = $request->query('vnp_TxnRef');
        $vnp_Amount = $request->query('vnp_Amount');
        $vnp_OrderInfo = $request->query('vnp_OrderInfo');
        $vnp_TransactionNo = $request->query('vnp_TransactionNo');
        $vnp_BankCode = $request->query('vnp_BankCode');

        if ($vnp_ResponseCode == '00') {
            return redirect()->route('success.page')->with('message', 'Thanh toán thành công!');
        } else {
            return redirect()->route('error.page')->with('message', 'Thanh toán thất bại!');
        }
    }
public function handlePaymentSuccess(Request $request)
{

    $userId = Auth::id();
    $orderId = $request->input('order_id');
    $money = $request->input('money');
    $note = $request->input('note');
    $responseCode = $request->input('response_code');
    $codeVnpay = $request->input('code_vnpay');
    $codeBank = $request->input('code_bank');
    PaymentManagement::create([
        'user_id' => $userId,
        'order_id' => $orderId,
        'money' => $money,
        'note' => $note,
        'response_code' => $responseCode,
        'code_vnpay' => $codeVnpay,
        'code_bank' => $codeBank,
        'date_bank' => now(),
    ]);

    return response()->json(['message' => 'Payment recorded successfully'], 200);
}

}
