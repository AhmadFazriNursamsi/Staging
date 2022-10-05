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
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Barang Bagus" name=""></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Barang Jelek" name=""></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Catatan" name=""></td>

                                    <td></td>
                                </tr>
                                <tr>
                                    <th><input type="checkbox" class="checkall" name="checkall"></th>
                                    <th class="align-center">No Purchase Order</th>
                                    <th class="align-center">Jumlah</th>
                                    <th class="align-center">Barang Bagus</th>
                                    <th class="align-center">Barang Jelek</th>
                                    <th class="align-center">Catatan</th>
                                    <th class="align-center">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="align-center">No Purchase Order</th>
                                    <th class="align-center">Jumlah</th>
                                    <th class="align-center">Barang Bagus</th>
                                    <th class="align-center">Barang Jelek</th>
                                    <th class="align-center">Catatan</th>
                                    <th class="align-center">Action</th>
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
                                <div class="form-group">
                                    <input type="hidden" id="id" class="inpt-cst-add" name="id" data-attid="">
                                    <label for="no_purchase_order" class="form-label">No Purchase Order *</label>
                                    <input type="text" class="form-control inpt-cst-add mb-2" name="no_purchase_order" id="no_purchase_order" placeholder="No Purchase Order" autocomplete="off">
                                </div>  

                                <div class="form-group">
                                    <label for="deskripsi_po" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi_po" class="form-control inpt-cst-add mb-2" id="deskripsi_po" cols="10" rows="6"></textarea>
                                </div>

                                <div class="input-group mb-2">
                                    <label for="products_id" class="form-label">Cari Produk
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
                                
                                <input type="hidden" name="user_group" id="user_group">
                                
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
                                            <th>Bagus</th>
                                            <th>Jelek</th> 
                                            <th>Action</th> 
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th class="align-center">Nama Produk</th>
                                            <th>Qty</th>
                                            <th>Bagus</th>
                                            <th>Jelek</th> 
                                            <th>Action</th> 
                                        </tr>
                                    </tfoot>
                                </table>
                                {{-- tabel --}}                               

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm closeModalad" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" id="addvbtn" data-attid="" class="btn btn-success btn-sm"></button>
                                </div>
                            </form>
                            {{--  --}}
                        </div>               
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- CREATE --}}


    {{-- DETAIL --}}
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
                            <table class="table table-striped" id="table_detail">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Produk</th>
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

                <div class="modal-footer">
                    <button id="closeModal" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        Close                        
                    </button>
                    @if ($haveaccessadd) :
                        {{--  --}}
                        <span id="editvbtn" data-attid="" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Modal Edit Pre Order</span>
                        {{--  --}}

                    @endif

                    @if ($haveaccessdelete) :
                        {{-- <button onClick="deleteyesshow()" data-attid="" data-deleteval="1" id="deletevbtn" class="btn btn-danger btn-sm"></a>
                        <button onClick="undeleteyesshow()" data-attid="" data-deleteval="0" id="undeletevbtn" class="btn btn-success btn-sm"></a> --}}
                    @endif
                </div>

            </div>
        </div>
    </div>
    {{-- DETAIL --}}

@section('script')

<script type="text/javascript">

    // FUNCTION SECARA GLOBAL
    var url = "{{ asset('/api/purchaseorders/getdata') }}";
    function searcAjax(a, skip = 0) {
        if ($(a).val().length > global_length_src || skip == 1) {
            var getparam = getAllClassAndVal("src_class_user"); // helpers
            $('#datastable').DataTable().ajax.url(url + "?" + getparam).load();
        }else{
            $('#datastable').DataTable().ajax.url(url).load();
        }
    }

    // -----------------------------------------------------------------------------------------------------

    $(document).ready(function() {
        var table = $('#datastable').DataTable({
            ajax: url,
            columnDefs: [
                {
                    'targets': 2,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {
                        return '<tbody>' + full[2] + '</tbody>';
                    }
                },
                {
                    'targets': 3,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {
                        return '<tbody>' + full[3] + '</tbody>';
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
                    'targets': 6,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {
                        return '<span class="btn btn-info btn-sm" onclick="showdetail('+full[6]+')">details</span>';             
                    }
                },
            ],
            searching: false,
        });
    });

    // -----------------------------------------------------------------------------------------------------

    // Buka Modal btnAdd
    $("#btnAdd").click(function() 
    {
        clearInput("inpt-cst-add");
        $('#viewad').modal('show');
    
        // tambahan
        $("#produkId").val("");
        $('.produk_list').html("");
        $('#user_group').hide();
        $('.copy').html("");
        // $("#user_group").val(""); // tambahan 14 Juli
        // $("#id").val(""); // tambahan 14 Juli


        $(".control-group after-add-more").html("");
        // tambahan
    
        $("#ModalLongTitle").html("Purchase Orders Tambah"); // title MODAL CREATE
        $("#addvbtn").html('<i class="fa fa-plus"></i> Add Purchase Orders');
        
    });

    // -----------------------------------------------------------------------------------------------------

    // FUNCTIONAL GLOBAL
    $(".closeModalad").click(function() // tutup modal Add
    {
        $("#viewad").modal('hide');
    });

    
    // FUNCTIONAL GLOBAL

    // -----------------------------------------------------------------------------------------------------

    // FORM SUBMIT
    $("#smbtn").submit(function(e)
    {
        e.preventDefault();
        var id = $("#id").val(); // success
        var url = "{{ asset('api/purchaseorders/insertdata') }}";
        if(id != '') // versi produk
            var url = "{{ asset('api/purchaseorders/updatedata') }}/" + id;
            console.log(url);

        var form = $('#smbtn');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            dataType: 'JSON',
            enctype: 'multipart/form-data',
            success: function(response) 
            {
                data = response.data;
                console.log(data);

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
                $('#user_group').show();
                $('.copy').html("");
                $(".after-add-more").html("");

                var url = "{{ asset('/api/purchaseorders/getdata') }}";
                $('#datastable').DataTable().ajax.url(url).load();
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log(textStatus, errorThrown);
            }
        });
    });
    // FORM SUBMIT

    // -----------------------------------------------------------------------------------------------------

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

            {
                'targets': 4,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function(data, type, full, meta) {
                    return '<div class="form-group row"><div class="col-xs-2"> <input type="number" name="barang_bagus[][]" id="barang_bagus" class="form-group form-control barang_bagus"></div></div>';
                }
            },

            {
                'targets': 5,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function(data, type, full, meta) {
                    return '<div class="form-group row"><div class="col-xs-2"> <input type="number" name="barang_jelek[][]" id="barang_jelek" class="form-group form-control barang_jelek"></div></div>';

                }
            },
        ],
            // searching: false,
        });
        
        $("#closeModal").click(function() {
            $("#view").modal('hide');
        });
    });
    // 

    // -----------------------------------------------------------------------------------------------------

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
                        
                        // console.log(htmls1);

                    $.each(data, function (key, item) {
                        // console.log(key,item.id);
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

    // -----------------------------------------------------------------------------------------------------

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
                    // console.log(response.data[0][0]); // NO RANDOM
                // console.log(response.data[0][1]); // NAMA PRODUK
                // console.log(response.data[0][2]); // Satuan
                // console.log(response.data[0][3]); // QTY
                // console.log(response.data[0][4]); // Barang Bagus
                // console.log(response.data[0][5]); // Barang Jelek
                // console.log(response.data[0][6]); // ID

                var htmlinput = '<tr class="" id="row-'+response.data[0][6]+'">\
                    <td class="sorting_1">'+response.data[0][0]+'</td>\
                    <td>'+response.data[0][1]+'</td>\
                    <td class=" dt-body-center">\
                        <div class="form-group row">\
                            <div class="col-xs-2"><input type="number" name="jumlah_produk[\'id\']['+response.data[0][6]+']" id="jumlah_produk-'+response.data[0][6]+'" class="form-group form-control jumlah_produk"></div>\
                        </div>\
                    </td>\
                    <td class="  dt-body-center">\
                        <div class="form-group row">\
                            <div class="col-xs-2"><input type="number" name="barang_bagus[\'id\']['+response.data[0][6]+']" id="barang_bagus-'+response.data[0][6]+'" class="form-group form-control barang_bagus"></div>\
                        </div>\
                    </td>\
                    <td class="  dt-body-center">\
                        <div class="form-group row">\
                            <div class="col-xs-2"><input type="number" name="barang_jelek[\'id\']['+response.data[0][6]+']" id="barang_jelek-'+response.data[0][6]+'" class="form-group form-control barang_jelek"></div>\
                        </div>\
                    </td>\
                    <td class="  dt-body-center">\
                        <span class="btn btn-danger deletee btn-sm" onclick="kurangininput('+response.data[0][6]+')">\
                            <i class="fa-solid fa-trash-can"></i>\
                        </span>\
                    </td>\
                    </tr>';
                    
                    
                    
                // console.log(htmlinput);

                var table3 = document.querySelector("#listProdukTable tbody");
                // console.log(table3);

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

    // -----------------------------------------------------------------------------------------------------

    // 
    $(document).ready(function() {
        var tableRow = $('#listProdukTable').DataTable(); 
        // console.log(tableRow);

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
    // 

    // -----------------------------------------------------------------------------------------------------

    // 
    function kurangininput(a) 
    { 
        var tampung = $("#user_group").val();
        // console.log(tampung);
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

    // -----------------------------------------------------------------------------------------------------

    function showdetail(idx) 
    {
        // $('#deletevbtn').html('<i class="fa fa-trash"></i>Delete Pre Order');
        // $('#undeletevbtn').html('<i class="fa fa-repeat"></i>Undelete Pre Order');
        
        $('#deletevbtn').attr('data-attid', idx);
        $('#undeletevbtn').attr('data-attid', idx);
        $('#addvbtn').attr('data-attid', idx);

        // $('#addvbtn').attr('data-attid', idx);
        // $('#view').modal('show'); // tampil modal details
        var table3 = document.querySelector("#table_detail tbody");
        table3.innerHTML= "";


        var url = "{{ asset('/api/purchaseorders/detail') }}/" + idx; // Table View Details
        // console.log(url); // success 
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                var tampung = "";
                // var tampung2 = "";
                var htmlInputTable = "";
                
                // console.log(data); // array
                data = response.data;
                $.each(data, function (item, key) {
                    // console.log(key[0]); // nama produk
                    // console.log(key[1]); // satuan
                    // console.log(key[2]); // Jumlah produk
                    // console.log(key[3]); // Barang Bagus
                    // console.log(key[4]); // Barang Jelek
                    // console.log(key.item);

                    // htmlInputTable = untuk table details
                    htmlInputTable += '<tr class="" id="row-'+key.id+'">\
                        <td class="sorting_1">'+key[0]+'</td>\
                        <td>'+key[1]+'</td>\
                        <td>'+key[2]+'</td>\
                        <td>'+key[3]+'</td>\
                        <td>'+key[4]+'</td>\
                    </tr>';
                    // console.log(htmlInputTable); // success

                    
                });
                table3.innerHTML = table3.innerHTML + htmlInputTable;
                $('#view').modal('show');
            }
        });
        $('#id').attr('data-id', idx);
    }

    // -----------------------------------------------------------------------------------------------------

    $("#editvbtn").click(function()
    {
        idx = $('#id').attr('data-id');
        // console.log(idx);
        $('.produk_list').html("");
        $('#user_group').hide();
        $('.copy').html("");
        $("#produkId").val("");
        clearInput("inpt-cst-add"); // pak heri

        $("#ModalLongTitle").html("Purchase Orders Edit"); // title MODAL CREATE
        $("#addvbtn").html('<i class="fa fa-plus"></i> Edit Purchase Orders');
        $("#view").modal('hide');
        $('#viewad').modal('show');

        var table4 = document.querySelector("#listProdukTable tbody"); // listProdukTable adalah table untuk create dan edit
        table4.innerHTML = "";

        var url = "{{ asset('api/purchaseorders/detail') }}/"+idx;
        // var url = "{{ asset('api/purchaseorders/edit') }}/"+idx;

        // console.log(url);

        $.ajax({
            url: url,
            type: "GET",
            success: function(response)
            {             
                // $("#deskripsi_po").html(response[0].nama_paket)
                data = response.data;
            
                $("#id").val(data[0][5]);
                $("#no_purchase_order").val(data[0][6]);
                $("#deskripsi_po").val(data[0][7]);
                // $("#jumlah_produk").val(data[0][2]);
                // $("#barang_bagus").val(data[0][3]);
                // $("#barang_jelek").val(data[0][4]);

                var tampungUser = inHtml= "";
                var htmlinput = "";

                $.each(data, function(key, item) {

                    // console.log(item);
                    // console.log(item[0]); // Number
                    // console.log(item[1]); // Nama Produk
                    // console.log(item[2]); // Jumlah produk
                    // console.log(item[3]); // Barang Bagus
                    // console.log(item[4]); // Barang Jelek
                    // console.log(item[5]); // ID
                    // console.log(item[6]); // No Purchase Order
                    // console.log(item[7]); // Deskripsi Pre Order


                    htmlinput += '<tr class="" id="row-'+item[5]+'">\
                    <td class="sorting_1">'+item[0]+'</td>\
                    <td>'+item[1]+'</td>\
                    <td class=" dt-body-center">\
                        <div class="form-group row">\
                            <div class="col-xs-2"><input type="number" value="'+item[2]+'" name="jumlah_produk[\'id\']['+item[5]+']" id="jumlah_produk-'+item[5]+'" class="form-group form-control"></div>\
                        </div>\
                    </td>\
                    <td class="  dt-body-center">\
                        <div class="form-group row">\
                            <div class="col-xs-2"><input type="number" value="'+item[3]+'" name="barang_bagus[\'id\']['+item[5]+']" id="barang_bagus-'+item[5]+'" class="form-group form-control"></div>\
                        </div>\
                    </td>\
                    <td class="  dt-body-center">\
                        <div class="form-group row">\
                            <div class="col-xs-2"><input type="number" value="'+item[4]+'" name="barang_jelek[\'id\']['+item[5]+']" id="barang_jelek-'+item[5]+'" class="form-group form-control"></div>\
                        </div>\
                    </td>\
                    <td class="  dt-body-center">\
                        <span class="btn btn-danger deletee btn-sm" onclick="kurangininput('+item[5]+')">\
                            <i class="fa-solid fa-trash-can"></i>\
                        </span>\
                    </td>\
                    </tr>';

                    

                });
                // console.log(htmlinput);
                table4.innerHTML = htmlinput;


            }

        });


    });


</script>

@endsection 
</x-app-layout>