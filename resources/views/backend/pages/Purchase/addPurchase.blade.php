@extends('backend.layouts.master')

@section('title')
  Add Purchase
@endsection

@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Purchase</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item active">Purchase</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       
        <!-- Main row -->
        <div class="row">
          <section class="col-lg-12 connectedSortable">
           
            <div class="card">
              <div class="card-header">
                <h3>
                    Add Purchase
                    <a class="btn btn-success btn-sm float-right" href="{{route('purchases.view')}}"><i class="fa fa-list"></i>&nbsp;Purchase List</a>
                </h3>
              </div>
              <div class="card-body">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Purchase DataTable</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                            <div class="form-row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Date</label>
                                    <input type="text" name="date" class="form-control form-control-sm datepicker" id="date" readonly value="{{old('date')}}" placeholder="YYYY-MM-DD">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Purchase No</label>
                                    <input type="text" name="purchase_no" class="form-control form-control-sm" id="purchase_no"  value="{{old('purchase_no')}}" placeholder="enter purchase number">
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Supplier Name</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control select2 form-control-sm" style="width: 100%;">
                                        <option value="" selected disabled>select supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Category Name</label>
                                    <select name="category_id" id="category_id" class="form-control select2 form-control-sm" style="width: 100%;">
                                        <option value="" selected disabled>select category</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Product Name</label>
                                    <select name="product_id" id="product_id" class="form-control select2 form-control-sm" style="width: 100%;">
                                        <option value="" selected disabled>select product</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-2" style="padding-top: 33px;">
                                    <a class="btn btn-success btn-sm text-white addeventmore"><i class="fa fa-plus-circle"></i>&nbsp;Add Item</a>
                                </div>
                            </div>
                    </div>

                    <div class="card-body">
                      <form action="{{route('purchases.store')}}" method="POST" id="">
                        @csrf
                        <table class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              {{-- <th scope="col">#</th> --}}
                              <th scope="col">Category</th>
                              <th scope="col" width="15%">Product Name</th>
                              <th scope="col" width="7%">Pcs/Kg</th>
                              <th scope="col" width="15%">Unit Price</th>
                              <th scope="col">Description</th>
                              <th scope="col" width="15%">Total Price</th>
                              <th scope="col" width="15%">Action</th>
                            </tr>
                          </thead>
                          <tbody id="addRow" class="addRow">
                            
                           
                          </tbody>

                          <tbody>
                            <tr>
                              <td colspan="5"></td>
                              <td>
                                <input type="text" name="estimated_amount" value="0" id="estimated_amount" class="form-control form-control-sm text-right estimated_amount" readonly style="background-color: rgb(127, 225, 255)">
                              </td>
                              <td></td>
                            </tr>
                           
                          </tbody>
                        </table>
                        <br>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary purchaseStoreBtn">Purchase Store</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.card-body -->
                  </div>
              </div>
            </div>
        </div>
      </div>
    </section>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    $(document).ready(function(){
      $('#supplier_id').on('change',function(){
        var supplier_id = $(this).val();
        var html = '<option value="" selected disabled>select category</option>';
        var url = '/get-category/'+supplier_id;

        axios.get(url)
        .then(function (response) {
          $.each(response.data,function(key,v){
             html += '<option value="'+v.category_id+'">'+v.category.name+'</option>';
           })
           $('#category_id').html(html);
        })
        .catch(function (error) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
          })
        })
      })
    })
  </script>

<script>
  $(document).ready(function(){
    $('#category_id').on('change',function(){
      var category_id = $(this).val();
      var html = '<option value="" selected disabled>select product</option>';
      var url = '/get-product/'+category_id;

      axios.get(url)
      .then(function (response) {
        $.each(response.data,function(key,v){
           html += '<option value="'+v.id+'">'+v.name+'</option>';
         })
         $('#product_id').html(html);
      })
      .catch(function (error) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!',
        })
      })
    })
  })
</script>

<script id="document-template" type="text/x-handlebars-template">
  <tr class="delete_add_more_item" id="delete_add_more_item">
    <input type="hidden" name="date[]" value="@{{date}}">
    <input type="hidden" name="purchase_no[]" value="@{{purchase_no}}">
    <input type="hidden" name="supplier_id[]" value="@{{supplier_id}}">
    
    <td>
       <input type="hidden" name="category_id[]" value="@{{category_id}}">
       @{{category_name}}
    </td>
    <td>
      <input type="hidden" name="product_id[]" value="@{{product_id}}">
      @{{product_name}}
   </td>
   <td>
     <input type="number" min="1" name="buying_qty[]" value="1" class="form-control form-control-sm text-right buying_qty">
   </td>
   <td>
    <input type="number" name="unit_price[]" class="form-control form-control-sm text-right unit_price">
  </td>
  <td>
    <input type="text" name="description[]" class="form-control form-control-sm  description">
  </td>
  <td>
    <input type="text" name="buying_price[]" value="0" class="form-control form-control-sm text-right buying_price" readonly>
  </td>
  <td><i class="btn btn-danger btn-sm fa fa-window-close removeeventmore"></i></td>
    
  </tr>

</script>

<script type="text/javascript">
   $(document).ready(function(){
     $(document).on('click','.addeventmore',function(){
        var date           = $('#date').val();
        var purchase_no    = $('#purchase_no').val();
        var supplier_id    = $('#supplier_id').val();
        var category_id    = $('#category_id').val();
        var category_name  = $('#category_id').find('option:selected').text();
        var product_id     = $('#product_id').val();
        var product_name   = $('#product_id').find('option:selected').text();
         
         if(date==''){
           $.notify('Date is required',{globalPosition:'top right',className:'error'})
           return false;
         }
         if(purchase_no==''){
           $.notify('Purchase no. is required',{globalPosition:'top right',className:'error'})
           return false;
         }
         if(supplier_id==''){
           $.notify('Supplier name is required',{globalPosition:'top right',className:'error'})
           return false;
         }
         if(category_id==''){
           $.notify('Category name is required',{globalPosition:'top right',className:'error'})
           return false;
         }
         if(product_id==''){
           $.notify('Product name is required',{globalPosition:'top right',className:'error'})
           return false;
         }

         var source = $('#document-template').html();
         var template = Handlebars.compile(source);

         var data = {
             date:date,
             purchase_no:purchase_no,
             supplier_id:supplier_id,
             category_id:category_id,
             product_id:product_id,
             category_name:category_name,
             product_name:product_name
         }
         var html = template(data);
         $('.addRow').append(html);
     })
     $(document).on('click','.removeeventmore',function(){
       $(this).closest('.delete_add_more_item').remove();
        totalAmountPrice();
     })

     $(document).on('keyup click','.unit_price,.buying_qty',function(){
       var unit_price = $(this).closest('tr').find('input.unit_price').val();
       var buying_qty = $(this).closest('tr').find('input.buying_qty').val();
       var total = (unit_price*buying_qty);
       $(this).closest('tr').find('input.buying_price').val(total);
       totalAmountPrice();
     })
     function totalAmountPrice(){
       var sum = 0;
       $('.buying_price').each(function(){
         var value = $(this).val();
         if(!isNaN(value) && value!=0){
           sum += parseFloat(value);
         }
       })
       $('.estimated_amount').val(sum);

     }

   })
</script>

   {{-- <script>
     $(document).ready(function(){
        $('#supplier_id').on('change',function(){
             var supplier_id = $(this).val();
             $.ajax({
                 url:'{{route('get-category')}}',
                type:'GET',
                 data:{supplier_id:supplier_id},
                 success:function(data){
                    var html = '<option value="">select category</option>';
                     $.each(data,function(key,v){
                         html += '<option value="'+v.category_id+'">'+v.category_id+'</option>';
                     })
                     $('#category_id').html(html);
                 }
            })
         })
    })
   </script> --}}

  <script>
    $('.datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format:'yyyy-mm-dd'
    });
</script>

@endsection