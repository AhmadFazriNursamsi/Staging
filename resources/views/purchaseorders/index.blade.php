<?php use App\Http\Controllers\HelpersController as Helpers; 
$haveaccessadd = Helpers::checkaccess('purchaseorders', 'add');
$haveaccessdelete = Helpers::checkaccess('purchaseorders', 'delete');
?>
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hetf2"><i class="fa fa-plus"></i>
            {{ __('Purchase Orders') }} <?php if($haveaccessadd): ?> 
            <button type="button" id="btnAdd" class="btn btn-sm btn-success m-2" data-toggle="modal" data-target="#addUser">
                <i class="fa fa-plus me-2"></i>Create Purchase Orders   
            </button> <?php endif; ?>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- table --}}
                    <div class="table-responsive">
                        <table id="datastable" class="table text-start table-striped align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="No Purchase Order" name=""></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Jumlah Pre Order" name=""></td>
                                    <!-- <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Barang Bagus" name=""></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Barang Jelek" name=""></td> -->
                                    <!-- <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Catatan" name=""></td> -->
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Flag" name=""></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><input type="checkbox" class="checkall" name="checkall"></th>
                                    <th class="align-center">No Purchase Order</th>
                                    <th class="align-center">Jumlah</th>
                                    <th class="align-center">Delete</th>
                                    <th class="align-center">Catatan</th>
                                    <th class="align-center">Actions</th>
                                    <!-- <th class="align-center">Flag</th>
                                    <th class="align-center">Action</th> -->
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="align-center">No Purchase Order</th>
                                    <th class="align-center">Jumlah</th>
                                    <th class="align-center">Delete</th>
                                    <th class="align-center">Catatan</th>
                                    <th class="align-center">Actions</th>
                                    <!-- <th class="align-center">Flag</th>
                                    <th class="align-center">Action</th> -->
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    {{-- table --}}
                </div>
            </div>
        </div>
    </div>

    {{-- CREATE --}}
    @if ($haveaccessadd) 
    <div class="modal fade" style="background: rgba(0, 0, 0, 0.7);" id="viewad" tabindex="-1" role="dialog" aria-labelledby="viewTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex right-content-lg-start">
                    <h5 class="modal-title" id="ModalLongTitle"></h5>
                    <button type="button" class="close-modal btn btn-sm btn-danger close closeModalad" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <form id="smbtn" enctype="multipart/form-data"> 
                                @csrf
                                <input type="hidden" id="id" class="inpt-cst-add" name="id">
                                <div class="form-group">
                                    <label for="no_purchase_order" class="form-label">No Purchase Order *</label>
                                    <input type="text" class="form-control inpt-cst-add mb-2" name="no_purchase_order" id="no_purchase_order" placeholder="No Purchase Order" autocomplete="off">
                                </div>  

                                <div class="form-group">
                                    <label for="deskripsi_po" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi_po" class="form-control inpt-cst-add mb-2" id="deskripsi_po" cols="10" rows="6"></textarea>
                                </div>

                                <div class="input-group mb-2">
                                    <label for="" class="form-label">Cari Produk
                                        <small style="color:white; visibility: hidden;">
                                            {{-- *(P-01 : Produk Basah | P-02 : Produk Padat | P-03 : Produkaaaaaaaaaaaaaaa)* --}}
                                            *(P-01 : Produk Basah | P-02 : Produk Padat | P-03 : Produk CairaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaCairaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa)* 
                                        </small>
                                    </label>
                                    <input type="text" name="search" id="produkId" class="form-control produkId" placeholder="Cari Produk" autocomplete="off">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>

                                <div class="form-group">
                                    <div id="produk_list" class="produk_list"></div>
                                </div>
                                
                                {{-- <input type="hidden" name="user_group" id="user_group"> --}}
                                
                                <input type="hidden" name="user_group" id="user_group" class="user_group">

                                <div class="d-flex justify-content-end">
                                    <div class="control-group after-add-more">
                                        <div class="copy control-group"></div>
                                    </div>
                                </div><br>

                                {{-- tabel --}}
                                <table id="listProdukTable" class="table text-start table-striped align-middle table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="align-center">Nama Produk</th>
                                            <th>Qty</th>
                                            <!-- <th>Bagus</th>
                                            <th>Jelek</th>  -->
                                            <th>Action</th> 
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th class="align-center">Nama Produk</th>
                                            <th>Qty</th>
                                            <!-- <th>Bagus</th>
                                            <th>Jelek</th>  -->
                                            <th>Action</th> 
                                        </tr>
                                    </tfoot>
                                </table>
                                {{-- tabel --}}                               

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm closeModalad" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" id="addvbtn" data-attid="" class="btn btn-success btn-sm"></button>
                                    <button type="button" id="saveKarantina" class="btn btn-info">Save Karantina</button>
                                </div>
                            </form>
                            {{--  --}}
                        </div>               
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- CREATE --}}


    {{-- DETAIL --}}
    <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="viewTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                {{-- MODAL BODY --}}
                <div class="modal-body">
                    <ul class="nav nav-pills mb-10" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"  aria-selected="true">Modal Details Info</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            {{--  --}}
                            <table class="table table-striped" id="table_detail">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Produk Detail</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Barang Bagus</th>
                                        <th scope="col">Barang Jelek</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{--  --}}
                                </tbody>
                            </table>
                            {{--  --}}
                        </div>
                    </div>
                </div>
                {{-- MODAL BODY --}}

                {{-- y --}}
                <div class="modal-footer"> 
                    <button id="closeModal" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        Close                        
                    </button>
                    @if ($haveaccessadd)
                        <span id="editvbtn" data-attid="" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit Purchase Order</span>
                    @endif

                    @if ($haveaccessdelete)
                    <button onClick="deleteyesshow()" data-attid="" data-deleteval="1" id="deletevbtn" class="btn btn-danger btn-sm"></a>
                        <button onClick="undeleteyesshow()" data-attid="" data-deleteval="0" id="undeletevbtn" class="btn btn-success btn-sm"></a>                    
                    @endif
                </div>

            </div>
        </div>
    </div>
    {{-- DETAIL --}}

@section('script')

<script type="text/javascript">

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // FUNCTION UNTUK SEARCH
    var url = "{{ asset('/api/purchaseorders/getdata') }}";
    function searcAjax(a, skip = 0) {
        if ($(a).val().length > global_length_src || skip == 1) {
            var getparam = getAllClassAndVal("src_class_user"); // helpers
            $('#datastable').DataTable().ajax.url(url + "?" + getparam).load();
        }else{
            $('#datastable').DataTable().ajax.url(url).load();
        }
    }
    // FUNCTION UNTUK SEARCH

    // FUNCTION SECARA GLOBAL
    $(".closeModalad").click(function(){
        $("#viewad").modal('hide');
    });
    // FUNCTION SECARA GLOBAL
    
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // FUNCTION UNTUK MENAMPIKAN DATA DI DALAM TABLE 
    $(document).ready(function() {
        var table = $('#datastable').DataTable({
            ajax: url,
            createdRow: function(row, data, dataIndex, cells) {
                // console.log(data[0]);
                // console.log(data[1]);
                // console.log(data[2]);
                // console.log(data[3]);
                // console.log(data[4]);
                // console.log(data[5]);
                // console.log(data[6]);
                // console.log(data[7]); 
            

                if(data[7] == 1)
                $(row).addClass('warning');
                else
                $(row).removeClass('warning');
            },
            columnDefs: [
                // {
                //     'targets': 2,
                //     'searchable':false,
                //     'orderable':false,
                //     'className': 'dt-body-center',
                //     'render': function(data, type, full, meta) 
                //     {
                //         return '<tbody>' + full[2] + '</tbody>';
                //     }
                // },
                // {
                //     'targets': 3,
                //     'searchable':false,
                //     'orderable':false,
                //     'className': 'dt-body-center',
                //     'render': function(data, type, full, meta) 
                //     {
                //         return '<tbody>' + full[3] + '</tbody>';
                //     }
                // }, 
                // {
                //     'targets': 4,
                //     'searchable':false,
                //     'orderable':false,
                //     'className': 'dt-body-center',
                //     'render': function(data, type, full, meta) 
                //     {
                //         return '<tbody>' + full[4] + '</tbody>';
                //     }
                // },
                {
                    'targets': 3,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {                 
                        if(full[7] == 0)
                            return '<span class="btn btn-success btn-sm">Ready</span>';
                        else 
                            return '<span class="btn btn-danger btn-sm">Deleted</span>';
                    }
                },
                {
                    'targets': 4,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {    
                        // console.log(full);   
                        return '<span>'+ full[5] +' </span>';     
                        // if(full[7] == 0)
                        //     return '<span class="btn btn-success btn-sm">Ready</span>';
                        // else 
                        //     return '<span class="btn btn-danger btn-sm">Deleted</span>';
                    }
                },
                {
                    'targets': 5,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {
                        console.log(full);
                        if(full[7] == 0)
                        return '<span class="btn btn-success btn-sm" onclick="showdetail('+full[6]+')">details</span>'

                        else
                        return '<span class="btn btn-info btn-sm" onclick="showdetail('+full[6]+')">details</span>' 
                        
                    }
                },
            ],
            searching: false,
        });
    });
    // FUNCTION UNTUK MENAMPIKAN DATA DI DALAM TABLE 

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // UNTUK MEMBUKA MODAL ADD
    $("#btnAdd").click(function() 
    {
        clearInput("inpt-cst-add");

        $('#viewad').modal('show');
        $("#user_group").val("");

        $('#user_group').hide();
        $("#produkId").val("");

        $('.copy').html("");
        $('.produk_list').html("");
        $(".control-group after-add-more").html("");  

        $("#ModalLongTitle").html("Purchase Orders Tambah"); 
        $("#addvbtn").html('<i class="fa fa-plus"></i> Add Purchase Orders');
        
        var table3 = document.querySelector("#listProdukTable tbody");
        table3.innerHTML= "";

    });
    // UNTUK MEMBUKA MODAL ADD

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // FUNCTION UNTUK SUBMIT
    $("#smbtn").submit(function(e)
    {
        e.preventDefault();
        var id = $("#id").val();

        var url = "{{ asset('api/purchaseorders/insertdata') }}";

        if(id != '') 
            var url = "{{ asset('api/purchaseorders/updatedata') }}/" + id;
        
        var form = $("#smbtn");
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            dataType: 'JSON',
            enctype: 'multipart/form-data',
            success: function(response) 
            {
                data = response.data;

                if (data == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Save',
                        html:'Your data has been <b>Saved</b>'
                    });
                    $("#viewad").modal('hide'); // tutup modal sesudah create
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
                
                var url = "{{ asset('/api/purchaseorders/getdata') }}";
                $('#datastable').DataTable().ajax.url(url).load();
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log(textStatus, errorThrown);
            }
            
        });

    });

    $('#saveKarantina').on('click', function () { 
        var url = "{{ asset('api/purchaseorders/savekarantina') }}";

        // var url = "{{ asset('api/purchaseorders/updatedata') }}/" + id;
        var form = $("#smbtn");
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            dataType: 'JSON',
            enctype: 'multipart/form-data',
            success: function(response) 
            {
                data = response.data;

                if (data == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Save',
                        html:'Your data has been <b>Saved</b>'
                    });
                    $("#viewad").modal('hide'); // tutup modal sesudah create
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
                
                var url = "{{ asset('/api/purchaseorders/getdata') }}";
                $('#datastable').DataTable().ajax.url(url).load();
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log(textStatus, errorThrown);
            }
            
        });
        
     })
    // FUNCTION UNTUK SUBMIT

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // FITUR SEARCH
    $('#produkId').keyup(function() {
        var path = "{{ asset('/api/purchaseorders/search') }}"; // url untuk Request Search
        var query = $(this).val();  

        if(query != '')  
        {
            $.ajax({
                url: path,  
                method:"GET",  
                data:{query:query},  
                success:function(data) 
                {
                    htmls1 = '<select class="list-unstyled form-control form-group col-sm-8" id="id_user" name="selectproduct" onchange="onchangeTabel(this)">';
                    $.each(data, function (key, item) {
                        htmls1 += "<option value=\""+item.id+"\">"+item.nama+"</option>";  
                    });

                    htmls1 += '<option value="" selected>-- Select option --</option></select>';
                    $('#produk_list').html(htmls1);  

                } 
            });
        }

        if (query == '') {
            $('#produk_list').html('<select class="list-unstyled form-control"><option value="">-- Select option --</option></select>')  
        }
        else{
            $('#produk_list').html('<select class="list-unstyled form-control"><option value="">-- Select option --</option></select>')     
        }
    });
    // FITUR SEARCH

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    $(document).ready(function()
    {
        var table2 = $('#listProdukTable').DataTable({
            // ajax: url,
            columnDefs: [
                {
                    'targets': 3,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) {
                        return '<div class="form-group row"><div class="col-xs-2"> <input type="number" name="jumlah_produk[][]" id="jumlah_produk" class="form-group form-control jumlah_produk"></div></div>';
                    }
                },

                // {
                //     'targets': 4,
                //     'searchable': false,
                //     'orderable': false,
                //     'className': 'dt-body-center',
                //     'render': function(data, type, full, meta) {
                //         return '<div class="form-group row"><div class="col-xs-2"> <input type="number" name="barang_bagus[][]" id="barang_bagus" class="form-group form-control barang_bagus"></div></div>';
                //     }
                // },

                // {
                //     'targets': 5,
                //     'searchable': false,
                //     'orderable': false,
                //     'className': 'dt-body-center',
                //     'render': function(data, type, full, meta) {
                //         return '<div class="form-group row"><div class="col-xs-2"> <input type="number" name="barang_jelek[][]" id="barang_jelek" class="form-group form-control barang_jelek"></div></div>';

                //     }
                // },
            ],
            // searching: false,
        });
        
        $("#closeModal").click(function() {
            $("#view").modal('hide');
        });
    });
    // 

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // ONCHANGE TABEL
    function onchangeTabel(a) 
    {
        id = $(a).val();
        var hidden = $("#user_group").val();
        var tampung = hidden + ', ' + id;

        nama = $("#id_user option:selected").text();
        const pattern = new RegExp('(' + id + ')', 'gm');
        let m;
        if(m = pattern.exec(hidden) == null) 
        {
            $("#user_group").val(tampung);
        }
        
        var url = "{{ asset('/api/purchaseorders/getdataId') }}/"+id; // Table Create
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                var htmlinput = '<tr class="" id="row-'+response.data[0][6]+'">\
                    <td class="sorting_1">'+response.data[0][0]+'</td>\
                    <td>'+response.data[0][1]+'</td>\
                    <td class=" dt-body-center">\
                        <div class="form-group row">\
                            <div class="col-xs-2"><input type="number" value="0" name="jumlah_produk[\'id\']['+response.data[0][6]+']" id="jumlah_produk-'+response.data[0][6]+'" class="form-group form-control jumlah_produk"></div>\
                        </div>\
                    </td>\
                    <td class="  dt-body-center">\
                        <span class="btn btn-danger deletee btn-sm" onclick="kurangininput('+response.data[0][6]+')">\
                            <i class="fa-solid fa-trash-can"></i>\
                        </span>\
                    </td>\
                    </tr>';
                var table3 = document.querySelector("#listProdukTable tbody");

                const regex = new RegExp('(row-' + id + ')', 'gm');
                let m;

                if(regex.exec(table3.innerHTML) == null)
                    table3.innerHTML = table3.innerHTML + htmlinput;
                else {
                    Swal.fire({
                        icon: 'danger',
                        title: 'Warning',
                        html:'Data <b>Sudah ada</b>'
                    });
                }
            }
        });
    }
    // ONCHANGE TABEL

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // 
    function kurangininput(a) 
    { 
        var tampung = $("#user_group").val();
        tampung = tampung.replace(", "+a, "");
        $("#user_group").val(tampung);
        var rowid = '#row-'+a; // untuk hapus row 
        var table = $('#listProdukTable').DataTable();
        $("#row-"+a).remove();

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            html:'Data Berhasil <b>Dihapus</b>'
        });
    }
    // 

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    $(document).ready(function() {
        var tableRow = $('#listProdukTable').DataTable(); 

        $('#listProdukTable tbody').on('click', 'tr', function() {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                tableRow.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        $('.del').click(function () {
            tableRow.row('.selected').remove().draw(false);
        });
    });

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    function showdetail(idx) 
    {
        $('#addvbtn').attr('data-attid', idx);

        $('#view').modal('show');

        $('#deletevbtn').attr('data-attid', idx);
        $('#deletevbtn').html('<i class="fa fa-trash"></i>Delete Purchase Order');
        $('#undeletevbtn').hide();



        $('#undeletevbtn').attr('data-attid', idx);
        $('#undeletevbtn').html('<i class="fa fa-repeat"></i> Undelete Purchase Order');
        
        var table3 = document.querySelector("#table_detail tbody");
        table3.innerHTML= "";

        var url = "{{ asset('/api/purchaseorders/detail') }}/" + idx; // Table View Details

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                var htmlInputTable = "";
                
                data = response.data;
                $.each(data, function (item, key) {
                    htmlInputTable += '<tr class="" id="row-'+key[5]+'">\
                        <td class="sorting_1">'+key[0]+'</td>\
                        <td>'+key[1]+'</td>\
                        <td>'+key[2]+'</td>\
                        <td>'+key[3]+'</td>\
                        <td>'+key[4]+'</td>\
                    </tr>';
                    
                });
                table3.innerHTML = table3.innerHTML + htmlInputTable;

                if(data.flag_delete == 0)
                {
                    $("#deletevbtn").show();
                    $("#undeletevbtn").hide();
                    data = '<span id="activspan">-</span>';
                }

                if(data.flag_delete == 1)
                {
                    $("#deletevbtn").hide();
                    $("#undeletevbtn").show();
                    data = '<span id="activspan" style="color: #dc3545">deleted</span>';
                }
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log(textStatus, errorThrown);
            }
        });
    }

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    $("#editvbtn").click(function()
    {
        var idx = $("#addvbtn").attr("data-attid");       
        $("#ModalLongTitle").html("Purchase Orders Edit"); // title MODAL CREATE
        clearInput("inpt-cst-add"); 

        $('.produk_list').html("");
        $('#user_group').hide(); 
        $('.copy').html("");
        $("#produkId").val("");

        $("#addvbtn").html('<i class="fa fa-plus"></i> Edit Purchase Orders');
        $("#view").modal('hide');
        $('#viewad').modal('show');

        var table4 = document.querySelector("#listProdukTable tbody"); // listProdukTable adalah table untuk create dan edit
        table4.innerHTML = "";

        var url = "{{ asset('api/purchaseorders/detail') }}/"+idx;

        $.ajax({
            url: url,
            type: "GET",
            success: function(response)
            {             
                data = response.data;
                $("#id").val(data[0][5]);
                $("#no_purchase_order").val(data[0][6]);
                $("#deskripsi_po").val(data[0][7]);

                var tampungUser = inHtml= "";
                var htmlinput = "";

                $.each(data, function(key, item) {
                    htmlinput += 
                    '<tr class="" id="row-'+item[8]+'">\
                        <td class="sorting_1">'+item[0]+'</td>\
                        <td>'+item[1]+'</td>\
                        <td class=" dt-body-center">\
                            <div class="form-group row">\
                                <div class="col-xs-2"><input type="number" value="'+item[2]+'" name="jumlah_produk[\'id\']['+item[8]+']" id="jumlah_produk-'+item[8]+'" class="form-group form-control"></div>\
                            </div>\
                        </td>\
                        <td class="  dt-body-center">\
                            <div class="form-group row">\
                                <div class="col-xs-2"><input type="number" value="'+item[3]+'" name="barang_bagus[\'id\']['+item[8]+']" id="barang_bagus-'+item[8]+'" class="form-group form-control"></div>\
                            </div>\
                        </td>\
                        <td class="  dt-body-center">\
                            <div class="form-group row">\
                                <div class="col-xs-2"><input type="number" value="'+item[4]+'" name="barang_jelek[\'id\']['+item[8]+']" id="barang_jelek-'+item[8]+'" class="form-group form-control"></div>\
                            </div>\
                        </td>\
                        <td class="  dt-body-center">\
                            <span class="btn btn-danger deletee btn-sm" onclick="kurangininput('+item[8]+')">\
                                <i class="fa-solid fa-trash-can"></i>\
                            </span>\
                        </td>\
                    </tr>';

                    table4.innerHTML = htmlinput;
                    tampungUser = tampungUser + ", " + item[8];
                    $(".user_group").val(tampungUser);                    
                });
            }
        });
    });

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    //  FUNCTION delete yes show
    function deleteyesshow() {
        $('#deletevbtn').hide();
        var idx= $("#addvbtn").attr("data-attid");       
        // console.log(idx);     
        test = '@csrf';
        token = $(test).val();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) 
            {
                var url = "{{ asset('/api/purchaseorders/delete') }}/" + idx;
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        id : idx,
                        _token: token
                    },
                    success: function(response) 
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            html:'Your file has been <b>Deleted</b>'
                        });
                        var url = "{{ asset('/api/purchaseorders/getdata') }}";
                        // $("#view").modal('hide');

                        $('#datastable').DataTable().ajax.url(url).load();
                        $('#undeletevbtn').show();
                        $("#activspan").html('deleted');
                        $("#activspan").css('color', '#dc3545');
                    },
                    error: function(jqXHR, textStatus, errorThrown) 
                    {
                        alert('something wrong');
                        console.log(textStatus, errorThrown);
                    }
                    
                });
            } else {
                $('#deletevbtn').show();
                
            }
        });

    }
    // FUNCTION delete yes show

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // FUNCTION undelete yes show
    function undeleteyesshow()
    {
        $('#undeletevbtn').hide();
        var idx= $("#undeletevbtn").attr("data-attid");       
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
        }).then((result) => {
            if (result.isConfirmed) 
            {
                var url = "{{ asset('/api/purchaseorders/delete') }}/" + idx;
                // console.log(url);
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        id : idx,
                        _token: token,
                        undeleted : 1
                    },
                    success: function(response) 
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'Undeleted',
                            html:'Your file has been <b>Undeleted</b>'
                        });
                        var url = "{{ asset('/api/purchaseorders/getdata') }}";
                        // $("#view").modal('hide');

                        $('#datastable').DataTable().ajax.url(url).load();
                        $('#deletevbtn').show();
                        $("#activspan").html('-');
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
    // FUNCTION undelete yes show

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

</script>

@endsection 
</x-app-layout>
