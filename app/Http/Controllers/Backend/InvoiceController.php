<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Supplier;
use App\Model\Unit;
use App\Model\Category;
use App\Model\Invoice;
use App\Model\InvoiceDetail;
use App\Model\Payment;
use App\Model\PaymentDetail;
use App\Model\Purchase;
use App\Model\Customer;
use DB;
use Auth;


class InvoiceController extends Controller
{
    public function view(){

   		$allData = Invoice::orderBy('date','desc')->orderBy('id','desc')->where('status','1')->get();
   		return view('backend.invoice.view-invoice',compact('allData'));
   }

   public function add(){

   		$data['categories'] = Category::all();
   		$invoice_data = Invoice::orderBy('id','desc')->first();
   		if ($invoice_data == null) {
   			$firstReg = '0';
   			$data['invoice_no'] = $firstReg+1;
   		}else{
   			$invoice_data = Invoice::orderBy('id','desc')->first()->invoice_no;
   			$data['invoice_no'] = $invoice_data+1;
   		}
   		$data['customers'] = Customer::all();
   		return view('backend.invoice.add-invoice',$data);
   }

   public function store(Request $request){
      if ($request->category_id == null ) {
      	return redirect()->back()->with('error','Sorry! you did not select any product');
      }else{
      	if ($request->paid_amount>$request->estimate_ammount) {
      		return redirect()->back()->with('error','Your paid amount is over than total amount');
      	}else{
      		$invoice = new Invoice();
      		$invoice->invoice_no = $request->invoice_no;
      		$invoice->date = date('Y-m-d',strtotime($request->date));
      		$invoice->description = $request->description;
      		$invoice->status = '0';
      		$invoice->created_by = Auth::user()->id;
      		DB::transaction(function() use($request,$invoice) {
      			if ($invoice->save()) {
      				$count_category = count($request->category_id);
      				for ($i=0; $i <$count_category; $i++) { 
      					$invoice_details = new InvoiceDetail();
      					$invoice_details->date = date('Y-m-d',strtotime($request->date));
      					$invoice_details->invoice_id = $invoice->id;
      					$invoice_details->category_id = $request->category_id[$i];
      					$invoice_details->product_id = $request->product_id[$i];
      					$invoice_details->selling_qty = $request->selling_qty[$i];
      					$invoice_details->unit_price = $request->unit_price[$i];
      					$invoice_details->selling_price = $request->selling_price[$i];
      					$invoice_details->status = '1';
      					$invoice_details->save();
      				}
      				if ($request->customer_id == '0') {
      					$customer = new Customer();
      					$customer->name = $request->name;
      					$customer->mobile_no = $request->mobile_no;
      					$customer->address = $request->address;
      					$customer->save();
      					$customer_id = $customer->id;
      				}else{
      					$customer_id = $request->customer_id;
      				}
      				$payment = New Payment();
      				$payment_details = new PaymentDetail();
      				$payment->invoice_id = $invoice->id;
      				$payment->customer_id = $customer_id;
      				$payment->paid_status = $request->paid_status;
      				$payment->discount_amount = $request->discount_amount;
      				$payment->total_amount = $request->estimate_ammount;
      				if ($request->paid_status == 'full_paid') {
      					$payment->paid_amount = $request->estimate_ammount;
      					$payment->due_amount = '0';
      					$payment_details->current_paid_amount = $request->estimate_ammount;
      				}elseif ($request->paid_status == 'full_due') {
      					$payment->paid_amount = '0';
      					$payment->due_amount = $request->estimate_ammount;
      					$payment_details->current_paid_amount = '0';
      				}elseif ($request->paid_status == 'partial_paid') {
      					$payment->paid_amount = $request->paid_amount;
      					$payment->due_amount = $request->estimate_ammount-$request->paid_amount;
      					$payment_details->current_paid_amount = $request->paid_amount;
      				}
      				$payment->save();
      				$payment_details->invoice_id = $invoice->id;
      				$payment_details->date = date('Y-m-d',strtotime($request->date));
      				$payment_details->save();
      			}
      		});
      	}
      }

      return redirect()->route('invoice.pending.list')->with('success','Data Saved Successfully');
   }
   
    public function delete($id){
        $invoice = Invoice::find($id); 
        $invoice->delete();
        InvoiceDetail::where('invoice_id',$invoice->id)->delete();
        Payment::where('invoice_id',$invoice->id)->delete();
        PaymentDetail::where('invoice_id',$invoice->id)->delete();
        return redirect()->route('invoice.pending.list')->with('success','Data Deleted successfully');
    }

    public function pendingList(){
      	$allData = Invoice::orderBy('date','desc')->orderBy('id','desc')->where('status','0')->get();
   		return view('backend.invoice.pending-invoice-list',compact('allData'));
    }

    public function approve($id){
      $invoice = Invoice::find($id);
      return view('backend.invoice.invoice-approve',compact('invoice'));
    }
}