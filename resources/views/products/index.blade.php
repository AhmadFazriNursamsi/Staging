<?php use App\Http\Controllers\HelpersController as Helpers; 
$haveaccessadd = Helpers::checkaccess('products', 'add');
$haveaccessdelete = Helpers::checkaccess('products', 'delete');
?>

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hetf2"><i class="fa fa-plus"></i>
            {{ __('Products') }} <?php if($haveaccessadd): ?> 
            <button type="button" id="btnAdd" class="btn btn-sm btn-success m-2" data-toggle="modal" data-target="#addUser">
                <i class="fa fa-plus me-2"></i>Create Products
            </button> <?php endif; ?>
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="table-responsive">
                        <table id="datastable" class="table text-start table-striped align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Nama" name="nama"></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Barcode" name="barcode"></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Satuan" name="satuan"></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Slug" name="slug"></td>
                                    <td>
                                        <select name="active" class="form-control input-sm src_class_user" onchange="searcAjax(this, 1)">
                                            <option value="">-- Status Active --</option>
                                            <option value="1">Active</option>
                                            <option value="0">Not Active</option>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><input type="checkbox" class="checkall" name="checkall"></th>
                                    <th class="align-center">Thumbnail</th>
                                    <th class="align-center">Nama</th>
                                    <th class="align-center">Barcode</th>
                                    <th class="align-center">Satuan</th>
                                    <th class="align-center">Slug</th>
                                    <th class="align-center">Active</th>
                                    <th class="align-center">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="align-center">Thumbnail</th>
                                    <th class="align-center">Nama</th>
                                    <th class="align-center">Barcode</th>
                                    <th class="align-center">Satuan</th>
                                    <th class="align-center">Slug</th>
                                    <th class="align-center">Active</th>
                                    <th class="align-center">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TAMPIL DATA MODAL VIEW --}}
    <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="viewTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                {{-- MODAL BODY --}}
                <div class="modal-body">
                    <ul class="nav nav-pills mb-10" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Modal Details Info</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            {{--  --}}
                            <dl class="row mb-0" id="datauser-1"></dl>
                            {{--  --}}
                        </div>
                    </div>
                </div>
                {{-- MODAL BODY --}}

                <div class="modal-footer">
                    <button id="closeModal" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        Close                        
                    </button>
                    @if ($haveaccessadd) :
                        <span id="editvbtn" data-attid="" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Modal Edit Product</span>
                    @endif

                    @if ($haveaccessdelete) :
                        <button onClick="deleteyesshow()" data-attid="" data-deleteval="1" id="deletevbtn" class="btn btn-danger btn-sm"></a>
                        <button onClick="undeleteyesshow()" data-attid="" data-deleteval="0" id="undeletevbtn" class="btn btn-success btn-sm"></a>
                    @endif
                </div>

            </div>
        </div>
    </div>
    {{-- TAMPIL DATA MODAL VIEW --}}


    <!-- TAMPIL DATA MODAL CREATE -->
    @if ($haveaccessadd) :
    <div class="modal fade" style="background: rgba(0, 0, 0, 0.7);" id="viewad" tabindex="-1" role="dialog" aria-labelledby="viewTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLongTitle"></h5>
                    <button type="button" class="close-modal btn btn-sm btn-danger close closeModalad" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="smbtn" enctype="multipart/form-data"> 

                                <div class="form-group">
                                    <input type="hidden" id="id" class="inpt-cst-add" name="id">
                                    <label for="nama" class="form-label">Nama *</label>
                                    <input type="text" class="form-control inpt-cst-add mb-2" name="nama" id="nama" aria-describedby="" placeholder="nama" aria-describedby="basic-addon1" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="kode_products" class="form-label">Kode Produk 
                                        <small style="color:red">
                                            *(P-01 : Produk Basah | P-02 : Produk Padat | P-03 : Produk Cair)* 
                                        </small>
                                    </label>
                                    <input type="text" class="form-control inpt-cst-add mb-2" name="kode_products" id="kode_products" aria-describedby="" placeholder="Kode Produk" aria-describedby="basic-addon1" autocomplete="off">
                                </div>                                

                                {{-- <div class="form-group">
                                    <label for="satuan_id">Satuan</label>
                                    <select class="form-control inpt-cst-add mb-2" name="satuan_id" id="satuan_id">
                                        <option value="0" selected>Pilih Satuan</option>
                                        @php
                                            foreach ($satuans as $key => $value):
                                        @endphp
                                            <option value="{{ $key }}">{{ $value->satuan_name }}</option> 
                                        @endforeach 
                                    </select>
                                </div>  --}}

                                <div class="form-group">
                                    <label for="satuan_id">Satuan</label>
                                    <select class="form-control inpt-cst-add mb-2" id="satuan_id">
                                        {{-- <option id="selected" value="0"> -- Pilih Satuan -- </option> --}}
                                        <option id="selected_satuan" value="0"></option>
                                        @foreach ($satuans as $satuan)
                                            @if (old('satuan_id') == $satuan->id )
                                                <option value="{{ $satuan->id }}" selected>
                                                    {{ $satuan->satuan_name }}
                                                </option> 
                                            @else
                                                <option value="{{ $satuan->id }}">
                                                    {{ $satuan->satuan_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="">Kategori</label>
                                    <select class="form-control inpt-cst-add mb-2" name="category_id" id="category_id">
                                        <option id="selected_kategori" value="0"></option>
                                        @foreach ($categories as $category)
                                            @if (old('category_id') == $category->id )
                                                <option value="{{ $category->id }}" selected>
                                                    {{ $category->category_name }}
                                                </option> 
                                            @else
                                                <option value="{{ $category->id }}">
                                                    {{ $category->category_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Brand</label>
                                    <select class="form-control inpt-cst-add mb-2" name="brand_id" id="brand_id">
                                        <option id="selected_brand" value="0"></option>
                                        @foreach ($brands as $brand)
                                            @if (old('brand_id') == $brand->id )
                                                <option value="{{ $brand->id }}" selected>
                                                    {{ $brand->brand_name }}
                                                </option> 
                                            @else
                                                <option value="{{ $brand->id }}">
                                                    {{ $brand->brand_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Supplier</label>
                                    <select class="form-control inpt-cst-add mb-2" name="supplier_id" id="supplier_id">
                                        <option id="selected_supplier" value="0"></option>
                                        @foreach ($suppliers as $supplier)
                                            @if (old('supplier_id') == $supplier->id )
                                                <option value="{{ $supplier->id }}" selected>
                                                    {{ $supplier->supplier_name }}
                                                </option> 
                                            @else
                                                <option value="{{ $supplier->id }}">
                                                    {{ $supplier->supplier_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="deskripsi" class="form-label">Deksripsi</label>
                                    <textarea name="deskripsi" class="form-control inpt-cst-add mb-2" id="deskripsi" cols="10" rows="6"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="spesifikasi" class="form-label">Spesifikasi</label>
                                    <textarea name="spesifikasi" class="form-control inpt-cst-add mb-2" id="spesifikasi" cols="10" rows="6"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="image" class="form-label">Images</label>
                                    <input type="file" class="form-control inpt-cst-add mb-2" name="image" id="image">
                                </div>

                                <div class="form-group">
                                    <label for="active" class="form-label">Status</label>
                                    <select name="active" class="form-control inpt-cst-add  mb-2" id="active">
                                        {{-- <option value="">-- Status Active --</option> --}}
                                        <option value="1" selected>Active</option>
                                        <option value="0">Not Active</option>
                                    </select>
                                </div>
                                
                                <div class="form-group" style="float: right; text-align: right; right: 0; width: 185px;">
                                    <button type="button" class="btn btn-secondary btn-sm closeModalad" data-dismiss="modal">Close</button>&nbsp;
                                    <button type="submit" id="addvbtn" data-attid="" class="btn btn-success btn-sm"></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- TAMPIL DATA MODAL CREATE -->

    {{-- TAMPIL DATA MODAL viewImage --}}
    <div class="modal fade" id="viewImage" tabindex="-1" role="dialog" aria-labelledby="viewTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                {{-- MODAL BODY --}}
                <div class="modal-body">
                    <ul class="nav nav-pills mb-10" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Main Info</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            {{--  --}}
                            <dl class="row mb-0" id="dataIMAGE"></dl>
                            {{--  --}}
                        </div>
                    </div>
                </div>
                {{-- MODAL BODY --}}

                <div class="modal-footer">
                    <button id="closeModal" type="button" class="btn btn-secondary btn-sm closeModalViewImage" data-dismiss="modal">
                        Close                        
                    </button>
                </div>

            </div>
        </div>
    </div>
    {{-- TAMPIL DATA MODAL viewImage --}}

{{-- asli --}}
<div id="showqrcode" style="display: none; position: absolute; z-index: 9999; top: 10%; right: 40%; background: #fff; padding: 15px; border-radius: 5px; border: 1px solid #DDD; box-shadow: 1px 1px 1px #ddd;">
    <div id="showqrcode_inner"></div>
    <br>
    <span id="closeshowqrcode" class="btn btn-sm btn-danger">Hide Qrcode</span> || <span id="printqrcode" data-idqrcode="" target="_blank" class="btn btn-sm btn-success">Print Qrcode</span>
</div>
{{-- asli --}}


@section('script')
<script type="text/javascript">
    
    var url = "{{ asset('/api/products/getdata') }}";
    function searcAjax(a, skip = 0){
        if($(a).val().length > global_length_src || skip == 1) 
        {
            var getparam = getAllClassAndVal("src_class_user"); // helpers
            $('#datastable').DataTable().ajax.url(url+"?"+getparam).load();
        }
        else {
            $('#datastable').DataTable().ajax.url(url).load();
        } 
    }
    // 
    // FUNCTION 
    $("#btnAdd").click(function(){
        clearInput("inpt-cst-add");
        $('#active').val(1).change(); //
        $('#satuan_id').val(0).change(); //
        $('#category_id').val(0).change(); //
        $('#brand_id').val(0).change(); //
        $('#supplier_id').val(0).change(); //

        $('#selected_satuan').empty().append('<option selected value=0>-- Pilih Satuan --</option>');
        $('#selected_kategori').empty().append('<option selected value=0>-- Pilih Kategori --</option>');
        $('#selected_brand').empty().append('<option selected value=0>-- Pilih Brand --</option>');
        $('#selected_supplier').empty().append('<option selected value=0>-- Pilih Supplier --</option>');

        $('#viewad').modal('show');
        // $('#showGudang').modal('show');
        $("#nama").removeAttr('readonly');
        $("#kode_products").removeAttr('readonly');

        $("#ModalLongTitle").html("Modal Title Product Tambah"); // title MODAL CREATE
        $("#addvbtn").html('<i class="fa fa-plus"></i> Add Product');
    });
    // 
    $("#smbtn").submit(function(e)
    {
        e.preventDefault();
        test = '@csrf';

        token = $(test).val();
        var id = $("#id").val();
        var nama = $("#nama").val();
        var barcode = $("#barcode").val();
        var satuan_id = $("#satuan_id").val();
        var slug = $("#slug").val();
        var active = $("#active").val();
        var deskripsi = $("#deskripsi").val();
        var image = $("#image")[0].files[0];
        var spesifikasi = $("#spesifikasi").val();
        var supplier_id = $("#supplier_id").val();
        var brand_id = $("#brand_id").val();
        var category_id = $("#category_id").val();
        var kode_products = $("#kode_products").val();

        var url = "{{ asset('api/products/insertdata') }}";
        if(id != '')
            var url = "{{ asset('api/products/updatedata') }}/"+id;

        const file = $('#image').prop('files')[0];

        let formData = new FormData();
        formData.append('file', file);
        formData.append('id', id);
        formData.append('nama', nama);
        formData.append('barcode', barcode);
        formData.append('satuan_id', satuan_id);
        formData.append('slug', slug);
        formData.append('active', active);
        formData.append('deskripsi', deskripsi);
        formData.append('image', image);
        formData.append('spesifikasi', spesifikasi);
        formData.append('supplier_id', supplier_id);
        formData.append('brand_id', brand_id);
        formData.append('category_id', category_id);
        formData.append('kode_products', kode_products);
        formData.append('created_at', kode_products);
        formData.append('updated_at', kode_products);
        formData.append('updated_by', kode_products);
        formData.append('created_by', kode_products);

        formData.append('_token', token);

        $.ajax({
            url: url,
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            enctype: 'multipart/form-data',
            success: function(response) 
            {               
                data = response.data;
                // console.log(data);
                if (data == 'success') 
                {
                    Swal.fire({
                        icon: 'success',
                        title: 'Save',
                        html:'Your data has been <b>Saved</b>'
                    });
                    $("#viewad").modal('hide');
                    
                } 
                else {
                    $.each(response.errors, function(key, value) {
                        Swal.fire({
                            title: 'Gagal',
                            text: value,
                            icon: 'error'
                        });
                    }); 
                }
                var url = "{{ asset('/api/products/getdata') }}";
                $('#datastable').DataTable().ajax.url(url).load();
                $("#showqrcode").hide();
            }, 
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log(textStatus, errorThrown);
            }
        });
    });
    // 

    // 
    $("#editvbtn").click(function()
    {
        idx = $('#deletevbtn').attr('data-attid');
        $("#addvbtn").html('<i class="fa fa-edit"></i> Edit Products');
        $("#ModalLongTitle").html("Edit Products t");

        $("#view").modal('hide');
        clearInput("inpt-cst-add");
        $("#nama").prop("readonly", true);
        $("#kode_products").prop("readonly", true);
        
        $('#selected_satuan').empty().append('<option selected value=0>Default</option>');
        $('#selected_kategori').empty().append('<option selected value=0>Default</option>');
        $('#selected_brand').empty().append('<option selected value=0>Default</option>');
        $('#selected_supplier').empty().append('<option selected value=0>Default</option>');

        var url = "{{ asset('/api/products/getdatabyid/') }}"+'/'+idx;
        test = '@csrf';
        token = $(test).val();    
        $.ajax({
            url: url,
            type: "GET",
            data: {
                id : idx,
                _token: token,
            },
            success: function (response) 
            {
                // tag html #id  set value pakai val
                $("#id").val(response.data[0].id);
                $("#nama").val(response.data[0].nama);
                $("#barcode").val(response.data[0].barcode);
                $("#kode_products").val(response.data[0].kode_products);
                $("#category_id").val(response.data[0].category_id);
                $("#supplier_id").val(response.data[0].supplier_id);
                $("#brand_id").val(response.data[0].brand_id);
                $("#satuan_id").val(response.data[0].satuan_id);
                $("#slug").val(response.data[0].slug);
                $("#barcode").val(response.data[0].barcode);
                $("#active").val(response.data[0].active);
                $("#spesifikasi").val(response.data[0].spesifikasi);
                $("#deskripsi").val(response.data[0].deskripsi);
                $('#viewad').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log(textStatus, errorThrown);
            }
        });
    });
    
    $(".closeModalad").click(function(){
        $("#viewad").modal('hide');
    });

    // closeModalViewImage
    $(".closeModalViewImage").click(function(){
        $("#viewImage").modal('hide');
    });
    
    $('#printqrcode').click(function(){
        alert('print qrcode not ready');
    });

    function imagePreviewNih(image)
    {
        var thumbnails = "{{ asset('/images/uploads/') }}"+'/'+image;
        $('#viewImage').modal('show');  
        var dhtml = '<img src="' + thumbnails + '" width="500" height="500">';
        $("#dataIMAGE").html(dhtml);        
    }

    function showqrcode(){
        $("#showqrcode").show();
    }


    $("#closeshowqrcode").click(function(){
        $("#showqrcode").hide();
    });

    $(document).ready(function()
    {
        var table = $('#datastable').DataTable({
            ajax: url,
            columnDefs: [
                {
                    'targets': 1,
                    'name' : 'image',
                    'data' : 'image',
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {
                        return '<img src=\'{{ asset("/images/uploads/Thumbnail-") }}' + full[1] + '\' width=\"100\" height=\"100\" alt=\"Thumbnails\" onclick="imagePreviewNih(\''+full[1]+'\')" class="imagePreviewNih">'; // hampir berhasil                        
                    }
                },
                {
                    'targets': 4,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {
                        return '<tbody>' + full[4] + '</tbody>';
                    }
                },
                {
                    'targets': 7,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {
                        return '<span class="btn btn-info btn-sm" onclick="showdetail('+full[7]+')">details</span>';
                    }
                },
                // datas = [0, 1, 2, 3, 4, 5, 6]
                // '', $value->image, $value->nama, $value->barcode, $value->satuan, $value->slug, $value->active, $value->id
                {
                    'targets': 6,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    'render': function (data, type, full, meta) 
                    {
                        if(full[6] == 1)
                            return '<span class="btn btn-success btn-sm">Active</span>';
                        else 
                            return '<span class="btn btn-warning btn-sm">Non Active</span>';
                    }
                },
                {
                    'targets': 0,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {
                        return '<input type="checkbox"  class="ckc" name="checkid['+full[7]+']" value="' + $('<div/>').text(data).html() + '">';               
                    }
                },
            ],
            searching: false,
        });
        
        $("#closeModal").click(function(){
            $("#view").modal('hide');
        });
    });
    // 
    
    
    // 
    function showdetail(idx) 
    {
        $('#deletevbtn').html('<i class="fa fa-trash"></i>Modal Delete Product');
        $('#undeletevbtn').html('<i class="fa fa-repeat"></i>Modal Undelete Product');
        
        $('#deletevbtn').attr('data-attid', idx);
        $('#undeletevbtn').attr('data-attid', idx);
        
        $('#addvbtn').attr('data-attid', idx);
        // $("#showqrcode").hide();  
        $('#showqrcode').hide();

        
        $('#view').modal('show'); // tampil modal details
        test = '@csrf';
        token = $(test).val();
        
        var url = "{{ asset('/api/products/getdatabyid/') }}"+'/'+idx;    
        // dd("test");
        $.ajax({
            url: url,
            type: "get",
            data: 
            {
                id : idx,
                _token: token
            },
            success: function (response) 
            {
                // console.log(response);
                var dhtml = '';
                if(response.data.flag_delete == 0)
                {
                    $('#deletevbtn').show();
                    $('#undeletevbtn').hide();
                }
                if(response.data[0].flag_delete == 1)
                {
                    $('#deletevbtn').hide();
                    $('#undeletevbtn').show();
                }
                // console.log(response.data[0]);

                $.each(response.data[0], function(i, item) {                    
                    // if(i != 'id' && i != 'supplier_id' && i != 'category_id' && i != 'brand_id' && i != 'createdby' && i != 'updatedby' && i != 'gudang_id' ) {

                    if(i != 'id' && i != 'supplier_id' && i != 'satuan_id' && i != 'category_id' && i != 'brand_id' && i != 'createdby' && i != 'updatedby') {
                        if(i == 'flag_delete' && item == 0) 
                            item = '<span id="activspan" style="color: #198754">Active</span>';
                        
                        if(i == 'flag_delete' && item == 1) 
                            item = '<span id="activspan" style="color: #dc3545">Deleted</span>';
                        
                        if(i == 'active' && item == 1) 
                            item = '<span id="activspan" style="color: #198754">Active</span>';
                        
                        if(i == 'active' && item == 0) 
                            item = '<span id="activspan" style="color: #dc3545">Non Active</span>';
                                                
                        if(i == 'satuans' ) 
                            item = response.data[0].satuans[0].satuan_name;
                            // console.log(response.data[0].satuans[0].satuan_name);

                        if(i == 'categories' ) 
                            item = response.data[0].categories[0].category_name;

                        if(i == 'suppliers' ) 
                            item = response.data[0].suppliers[0].supplier_name;
                        
                        if(i == 'brands' ) 
                            item = response.data[0].brands[0].brand_name;
                        
                        if(i == 'updated_by' ) 
                            item = response.data[0].updatedby.name;
                        
                        if(i == 'created_by' ) 
                            item = response.data[0].createdby.name;

                        if(i == 'url_qr_code' ) {
                            $("#printqrcode").attr('idqrcode', '');
                            $("#printqrcode").attr('idqrcode', item);
                            return true;
                        }

                        if(i == 'qr_code') {
                            dhtml += '<dt class="col-sm-4">'+i+'</dt>';                            
                            $("#showqrcode_inner").html('');
                            dhtml += '<dt class="col-sm-8"><span class="btn btn-sm btn-info" onclick="showqrcode()">Show Qrcode</span></dt>';
                            $("#showqrcode_inner").html(item);      
                            $('#showqrcode').hide();

                        } else {
                            dhtml += '<dt class="col-sm-4">'+i+'</dt>';
                            dhtml += '<dt class="col-sm-8">'+item+'</dt>';
                            $('#showqrcode').hide();


                        }
                        
                    } 
                });
                $("#datauser-1").html(dhtml);
                $('#showqrcode').hide();

            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log(textStatus, errorThrown);
            }
        });
        
        
    }

    

    // 
    function deleteyesshow(){
        // $('#deletevbtn').hide();
        $('#view').modal('hide');
        idx = $('#deletevbtn').attr('data-attid');
        test = '@csrf';
        token = $(test).val();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            input: 'textarea',
            inputAttributes: {
                id: "notedelete",
            },
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) 
            {
                var valuenotedelete = $("textarea#notedelete").val();
                var url = "{{ asset('/api/products/delete') }}/" + idx;
                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        id : idx,
                        _token: token,
                        alasan_delete: valuenotedelete
                    },
                    success: function (response) 
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            html:'Your file has been <b>Deleted</b>'
                        });
                        var url = "{{ asset('/api/products/getdata') }}";
                        $('#datastable').DataTable().ajax.url(url).load();
                        $('#undeletevbtn').show();
                        $("#activspan").html('Deleted');
                        $("#activspan").css('color', '#dc3545');
                    },
                    error: function(jqXHR, textStatus, errorThrown) 
                    {
                        alert('something wrong');
                        console.log(textStatus, errorThrown);
                    }
                });
            } else {
                $('#view').modal('show');
            }
        });
    }
    // 
    // 
    function undeleteyesshow()
    {
        $('#undeletevbtn').hide();
        idx = $('#undeletevbtn').attr('data-attid');
        test = '@csrf';
        token = $(test).val();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, undelete it!'
        }).then((result) => 
        {
            if (result.isConfirmed) 
            {
                var url = "{{ asset('/api/products/delete') }}/" + idx;
                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        id : idx,
                        _token: token,
                        undeleted : 1
                    },
                    success: function (response) 
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'Undeleted',
                            html:'Your file has been <b>Undeleted</b>'
                        });
                        var url = "{{ asset('/api/products/getdata') }}";
                        $('#datastable').DataTable().ajax.url(url).load();
                        $('#deletevbtn').show();
                        $("#activspan").html('Active');
                        $("#activspan").css('color', '#198754');
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        console.log(textStatus, errorThrown);
                    }
                });
    
            } else {
                $('#undeletevbtn').show();
            }
        });
    }
</script>
@endsection 
</x-app-layout>
