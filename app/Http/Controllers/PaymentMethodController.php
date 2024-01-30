<?php

namespace App\Http\Controllers;

use App\Models\payment_method;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index(){
        $payment_methods = payment_method::all();
        return view('payment_method.index', ['payment_methods' => $payment_methods]);
        
    }

    public function create(){
        return view('payment_method.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'payment_method_name' => 'required',
            'service_charge' => 'required',
        ]);
        $data['isActive']=true;
        $newPaymentMethod = payment_method::create($data);
        return redirect((route(('payment_method.index'))))->with('success', 'Payment Method Added Successfully !');;
    }


    public function edit(payment_method $payment_method){
        return view('payment_method.edit', ['payment_method' => $payment_method]);
    }

    public function update(payment_method $payment_method, Request $request){
        $data = $request->validate([
            'payment_method_name' => 'required',
            'service_charge' => 'required',
            'isActive' => 'required'
        ]);

        $payment_method->update(($data));
        return redirect(route('payment_method.index'))->with('success', 'Payment Method Updated Successfully');
    }

    public function destroy(payment_method $payment_method){
        $payment_method->delete();
        return redirect(route('payment_method.index'))->with('success', 'Payment Method Deleted Successfully');
    }
}
