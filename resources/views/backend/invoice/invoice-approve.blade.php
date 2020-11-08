@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Invoice</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-md-12 ">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3>Invoice No #{{$invoice->invoice_no}} ({{date('d-m-Y',strtotime($invoice->date))}})
                  <a class="btn btn-success float-right btn-sm" href="{{route('invoice.pending.list')}}"><i class="fa fa-list"></i>Pending Invoice List</a>
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                @php 
                $payment = App\Model\Payment::where('invoice_id',$invoice->id)->first();
                @endphp
               <table width="100%">
                 <tbody>
                   <tr>
                     <td width="15%"><p><strong>Customer Info</strong></p></td>
                     <td width="25%"><p><strong>Name :</strong> {{$payment['customer']['name']}}</p></td>
                     <td width="25%"><p><strong>Mobile No : </strong> {{$payment['customer']['mobile_no']}}</p></td>
                     <td width="35%"><p><strong>Address : </strong> {{$payment['customer']['address']}}</p></td>
                   </tr>
                   <tr>
                     <td width="15%"></td>
                     <td width="85%" colspan="3"><p><strong>Description : </strong> {{$invoice->description}}</p></td>
                   </tr>
                 </tbody>
               </table>
               <table border="1" width="100%">
                 <thead>
                   <tr>
                     <th>SL.</th>
                     <th>Category</th>
                     <th>Product Name</th>
                     <th class="text-center" style="background: #ddd; padding: 1px;">Current Stock</th>
                     <th>Quantity</th>
                     <th>Unit Price</th>
                     <th>Total Price</th>
                   </tr>
                 </thead>
                 <tbody>
                   <tr>
                     <td>1</td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                   </tr>
                 </tbody>
               </table>
               <table>
                 <tbody>
                   
                 </tbody>
               </table>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection