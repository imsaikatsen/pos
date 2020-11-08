@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
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
                <h3>Edit Product
                  <a class="btn btn-success float-right btn-sm" href="{{route('products.view')}}"><i class="fa fa-list"></i>Product List</a>
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
               
                   <form method="post" action="{{route('products.update',$editData->id)}}" id="myForm" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="supplier_name">Supplier Name</label>
                      <select name="supplier_id" class="form-control">
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                          <option value="{{$supplier->id}}" {{('$editData >supplier_id==$supplier_id')?"selected":''}}>{{$supplier->name}}</option>
                        @endforeach    
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="unit_id">Unit Name</label>
                      <select name="unit_id" class="form-control">
                        <option value="">Select Unit</option>
                        @foreach($units as $unit)
                          <option value="{{$unit->id}}"{{('$editData >unit_id==$unit_id')?"selected":''}}>{{$unit->name}} </option>
                        @endforeach    
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="category_id">Category Name</label>
                      <select name="category_id" class="form-control">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                          <option value="{{$category->id}}"{{('$editData >category_id==$category_id')?"selected":''}}>{{$category->name}} </option>
                        @endforeach    
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="name">Product Name</label>
                      <input type="text" name="name" value="{{$editData->name}}" class="form-control">
                    </div>

                   <div class="form-group col-md-12" >
                      <input type="submit" value="Update" class="btn btn-primary">
                  </div>   
                </div>        
               </form>
                
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
<script>
$(function () {

  $('#myForm').validate({
    rules: {
        
      supplier_id: {
        required: true,   
      },

      unit_id: {
        required: true,
      },

       category_id: {
        required: true,
      },  

       name: {
        required: true,
      },
      
    },

    messages: {

      supplier_id: {
        required: "Please enter your Supplier name",
      },

       unit_id: {
        required: "Please Enter Your unit",
      },
      
      category_id: {
        required: "Please Enter Your category name",
      },

      name: {
        required: "Please enter a product name",
      },

      
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>
@endsection