<?php

namespace App\Http\Controllers;

use App\Models\consultation;
use App\Models\payment;
use App\Models\payment_method;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(){
        $payments = payment::all();
        return view('payment.index', ['payments' => $payments]);
        
    }
    
    public function create(consultation $consultation){
        $payment_methods = payment_method::where('isActive', true)->get();
        return view('payment.create', ['payment_methods' => $payment_methods], ['consultation' => $consultation]);
    }
    
    public function store(Request $request, consultation $consultation){
        $data = $request->validate([
            'consultation_id' => 'required',
            'payment_method_id' => 'required',
        ]);
        $newPayment = payment::create($data);
        $consultation->update(['isPaid' => true]);
        return redirect((route(('consultation.index'))))->with('success', 'Payment Successfully !');;
    }


    // public function edit(payment $payment){
    //     return view('payment.edit', ['payment' => $payment]);
    // }

    // public function update(payment $payment, Request $request){
    //     $data = $request->validate([
    //         'consultation_id' => 'required',
    //         'payment_method_id' => 'required',
    //     ]);

    //     $payment->update(($data));
    //     return redirect(route('payment.index'))->with('success', 'Payment Updated Successfully');
    // }

    public function destroy(payment $payment){
        $payment->delete();
        return redirect(route('payment.index'))->with('success', 'Payment Deleted Successfully');
    }
}
