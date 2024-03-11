<?php

namespace App\Http\Controllers;


use App\Models\consultation;
use App\Mail\EmailPayment;
use App\Models\payment;
use App\Models\payment_method;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return view('payment.index', ['payments' => $payments]);
    }

    public function create(Consultation $consultation)
    {
        $payment_methods = payment_method::where('isActive', true)->get();
        return view('payment.create', ['payment_methods' => $payment_methods, 'consultation' => $consultation]);
    }

    public function store(Request $request, Consultation $consultation)
    {
        $data = $request->validate([
            'consultation_id' => 'required',
            'payment_method_id' => 'required',
        ]);
        Payment::create($data);
        $consultation->update(['isPaid' => true]);
        return redirect(route('consultation.index'))->with('success', 'Payment Successfully!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect(route('payment.index'))->with('success', 'Payment Deleted Successfully');
    }

    public function otp(Request $req)
    {
        $targer = $req->input('target');
        $email = rand(100000, 999999);
        $dw = Mail::to($targer)->send(new EmailPayment($email));
        return response()->json([$dw, 'email' => $email]);
    }

    public function pembayaran(Request $request)
    {
        $booking = [
            'student_id' => $request->student_id,
            'counselor_id' => $request->counselor_id,
            'note' => '',
            'isPaid' => 0,
            'consultation_date' => $request->consultation_date,
            'duration' => $request->duration,
        ];

        $newdatakonsul = Consultation::create($booking);
        $datakonsul = DB::table('DataKonsultasi')->where('id', $newdatakonsul->id)->first();
        $referenceId = $datakonsul->id + $datakonsul->counselor_id + $datakonsul->student_id;

        $va = '0000001221723861';
        $secret = 'SANDBOXEF649FC8-F90F-4E29-9C47-B33167239B9A-20220326121000';
        $url = 'https://sandbox.ipaymu.com/api/v2/payment';

        $body = [
            'product' => ['Melakukan Konsultasi Dengan ' . $datakonsul->dokter_name . ' Pada Tanggal ' . $datakonsul->consultation_date . '. support by Herru we Heer You'],
            'qty' => [1],
            'price' => [$datakonsul->dokter_fare],
            'returnUrl' => url('/pembayaran/berhasil?id=' . $datakonsul->id),
            'cancelUrl' => url('/pembayaran/gagal?id=' . $datakonsul->id),
            'notifyUrl' => url('/pembayaran/notif?id=' . $datakonsul->id),
            'buyerName' => $datakonsul->student_name,
            'buyerEmail' => $datakonsul->student_email,
            'buyerPhone' => $datakonsul->student_no_telp,
            'expired' => 2,
        ];

        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper('POST') . ":$va:$requestBody:$secret";
        $signature = hash_hmac('sha256', $stringToSign, $secret);
        $timestamp = date('YmdHis');

        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            "va: $va",
            "signature: $signature",
            "timestamp: $timestamp"
        ];

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $jsonBody,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            dd($err);
        }

        $ret = json_decode($response);
        if ($ret->Status == 200) {
           return response()->json(['status' => 'success', 'url' => $ret->Data->Url]);
        }
    }

    public function berhasil(Request $request)
    {
        $id = $request->query('id');
        Consultation::where('id', $id)->update(['isPaid' => 1]);
        return response()->json(['status' => 'success', 'message' => 'Pembayaran berhasil.']);
    }

    public function gagal(Request $request)
    {
        $id = $request->query('id');
        Consultation::where('id', $id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Pembayaran gagal. Data konsultasi telah dihapus.']);
    }

    public function notif(Request $request)
    {
        dd($request->all());
    }
}
