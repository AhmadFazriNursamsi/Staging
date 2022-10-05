<?php use App\Http\Controllers\HelpersController as Helpers; 
$haveaccessadd = Helpers::checkaccess('purchaseorders', 'add');
$haveaccessdelete = Helpers::checkaccess('purchaseorders', 'delete');
?>
@section('css')

@endsection



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
                                <div class="form-group">
                                    <input type="hidden" id="id" class="inpt-cst-add" name="id">
                                    <label for="no_purchase_order" class="form-label">No Purchase Order *</label>
                                    <input type="text" class="form-control inpt-cst-add mb-2" name="no_purchase_order" id="no_purchase_order" aria-describedby="" placeholder="No Purchase Order" aria-describedby="basic-addon1">
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
                                    <input type="text" name="nama" id="produkId" class="form-control produkId" placeholder="Cari Produk" autocomplete="off">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>

                                <div class="form-group">
                                    <div id="produk_list"></div>
                                </div>

                                <div class="form-group">
                                    <input type="hidden" name="user_group" id="user_group">
                                    <div class="d-flex justify-content-end">
                                        <div class="control-group after-add-more">
                                            <div class="copy control-group"></div>
                                        </div>
                                    </div><br>
                                </div>

                                {{-- tabel --}}
                                <table id="listProdukTable" class="table text-start table-striped align-middle table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="align-center">Nama Produk</th>
                                            <th>Qty</th>
                                            <th>Bagus</th>
                                            <th>Jelek</th> 
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th class="align-center">Nama Produk</th>
                                            <th>Qty</th>
                                            <th>Bagus</th>
                                            <th>Jelek</th> 
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

    $(".closeModalad").click(function() 
    {
    $("#viewad").modal('hide');
    });
    // FUNCTION SECARA GLOBAL

    // 
    $(document).ready(function() {
        var table = $('#datastable').DataTable({
            ajax: url,
            columnDefs: [
                {
                    'targets': 6,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {
                        // console.log(full[6]);
                        return '<span class="btn btn-info btn-sm" onclick="showdetail('+full[6]+')">details</span>';             
                    }
                },
            ],
            searching: false,
        });
    
        $("#closeModal").click(function() {
            $("#view").modal('hide');
        });
    });
    // 
    
    
    // var table2 = $('#listProdukTable').DataTable({
    //     columnDefs: [
    //         {
    //             'targets': 4,
    //             'searchable': false,
    //             'orderable': false,
    //             'className': 'dt-body-center',
    //             'render': function(data, type, full, meta) {
    //                 console.log(full[7]);
    //                 return '<div class="form-group row"><div class="col-xs-2"> <input type="number" name="jumlah_produk" id="jumlah_produk" class="form-group form-control jumlah_produk"></div></div>';                    
    //             }
    //         },

    //         {
    //             'targets': 5,
    //             'searchable': false,
    //             'orderable': false,
    //             'className': 'dt-body-center',
    //             'render': function(data, type, full, meta) {
    //                 // console.log(full[8]);
    //                 return '<input type="number" class="form-group" name="barang_bagus" id="barang_bagus">';
    //             }
    //         },

    //         {
    //             'targets': 6,
    //             'searchable': false,
    //             'orderable': false,
    //             'className': 'dt-body-center',
    //             'render': function(data, type, full, meta) {
    //                 // console.log(full[9]);
    //                 return '<input type="number" class="form-group" name="barang_jelek" id="barang_jelek">';
    //             }
    //         },
    //     ],
    //     searching: false,

    // });

    // Buka Modal btnAdd
    $("#btnAdd").click(function() 
    {
        clearInput("inpt-cst-add");
        $('#viewad').modal('show');
        $('#showProduk').show();
    
        // tambahan
        $("#produkid").val("");
        $('#produk_list').html("");
        $('#user_group').hide();
        $('.copy').html("");
        $(".odd").html("");

        $(".control-group after-add-more").html("");
        // tambahan
    
        $("#ModalLongTitle").html("Purchase Orders Tambah"); // title MODAL CREATE
        $("#addvbtn").html('<i class="fa fa-plus"></i> Add Purchase Orders');
    });
    // Buka Modal btnAdd


    // FUNCTIONAL SEARCH
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
    // FUNCTIONAL SEARCH

    function onchangeTabel(a) 
    {
        id = $(a).val();
        var hidden = $("#user_group").val();
        var tampung = hidden + ' , ' + id;
        // console.log(tampung);

        nama = $("#id_user option:selected").text();
        const pattern = new RegExp('(' + id + ')', 'gm');
        let m;
        if(m = pattern.exec(hidden) == null) 
        {
            $("#user_group").val(tampung);
        }
        var url = "{{ asset('/api/purchaseorders/getdataId') }}/"+id;

        // $('#listProdukTable').DataTable().ajax.url(url).load();

        $.ajax({
            url:url,
            type:"GET",
            success: function(response) {
                // console.log(response.data[0][7]); // ID
                // console.log(response.data[0][6]); // Nama Produk
                // console.log(response.data[0][3]); // QTY
                // console.log(response.data[0][4]); // Barang Bagus
                // console.log(response.data[0][5]); // Barang Jelek

                var htmlInput = '<tr class="" id="row-'+response.data[0][7]+' ">\
                    <td class="sorting_1">'+response.data[0][0]+'</td>\
                    <td>'+response.data[0][6]+'</td>\
                    <td>'+response.data[0][3]+'</td>\
                    <td>'+response.data[0][4]+'</td>\
                    <td>'+response.data[0][5]+'</td>\
                    <td class="  dt-body-center">\
                        <div class="form-group row">\
                            <div class="col-xs-2"><input type="number" name="jumlah_produk[\'id\']['+response.data[0][3]+']" id="jumlah_produk-'+response.data[0][3]+'" class="form-group form-control jumlah_produk"></div>\
                            <div class="col-xs-2"><input type="number" name="barang_bagus[\'id\']['+response.data[0][4]+']" id="barang_bagus-'+response.data[0][4]+'" class="form-group form-control barang_bagus"></div>\
                            <div class="col-xs-2"><input type="number" name="barang_jelek[\'id\']['+response.data[0][5]+']" id="barang_jelek-'+response.data[0][5]+'" class="form-group form-control barang_jelek"></div>\
                        </div>\
                    </td>\
                    <td class="  dt-body-center"><span class="btn btn-danger deletee btn-sm" onclick="kurangininput('+response.data[0][7]+')"><i class="bi bi-trash-fill"></i></span></td>\
                    </tr>';

                    var table3 = document.querySelector("#listProdukTable tbody");
                    if(table3.innerHTML == '<tr class="odd"></tr>') {
                        table3.innerHTML = '';
                    }

                    const regex = new RegExp('(row- ' +id + ')', 'gm');
                    let m;

                    if(regex.exec(table3.innerHTML) == null)
                        table3.innerHTML = table3.innerHTML + htmlInput;
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


    
    // Untuk DataTable Produk saaat Create
    // var tableModalProduk = $('#listProdukTable').DataTable({
    //     // ajax: url,
    //     columnDefs: [
    //         {
    //             'targets': 4,
    //             'searchable': false,
    //             'orderable': false,
    //             'className': 'dt-body-center',
    //             'render': function(data, type, full, meta) {
    //                 console.log(full[7]);
    //                 return '<input type="number" class="form-group" name="jumlah_produk" id="jumlah_produk">';
    //             }
    //         },

    //         {
    //             'targets': 5,
    //             'searchable': false,
    //             'orderable': false,
    //             'className': 'dt-body-center',
    //             'render': function(data, type, full, meta) {
    //                 // console.log(full[8]);
    //                 return '<input type="number" class="form-group" name="barang_bagus" id="barang_bagus">';
    //             }
    //         },

    //         {
    //             'targets': 6,
    //             'searchable': false,
    //             'orderable': false,
    //             'className': 'dt-body-center',
    //             'render': function(data, type, full, meta) {
    //                 // console.log(full[9]);
    //                 return '<input type="number" class="form-group" name="barang_jelek" id="barang_jelek">';
    //             }
    //         },
    //     ],
    //     // searching: false,
    // });

    // $("#closeModal").click(function() {
    //     $("#view").modal('hide');
    // });
    


    function kurangininput(a) 
    { 
        var tampung = $("#user_group").val();
        // console.log(tampung);
        tampung = tampung.replace(" , " +a, "");
        $("#user_group").val(tampung);
        var table = $('#listProdukTable').DataTable();
        $('#listProdukTable tbody').on('click', 'deletee', function() 
        {
            table
            .row($(this).parrents('tr'))
            .remove()
            .draw();
        });
        
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            html:'Data Berhasil <b>Dihapus</b>'
        });
    }

    // FORM SUBMIT
    $("#smbtn").submit(function(e)
    {
        e.preventDefault();
        test = '@csrf';
        token = $(test).val();

        var id = $("#id").val();
        var no_purchase_order = $("#no_purchase_order").val();
        var products_id = $("#products_id").val();
        var deskripsi_po = $("#deskripsi_po").val();
        var jumlah_produk = $("#jumlah_produk").val();
        var barang_bagus = $("#barang_bagus").val();
        var barang_jelek = $("#barang_jelek").val();

        var url = "{{ asset('api/purchaseorders/insertdata') }}";
        if(id != '')
            var url = "{{ asset('api/purchaseorders/updatedata') }}/"+id;

        let formData = new FormData();
        formData.append('id', id);
        formData.append('no_purchase_order', no_purchase_order);
        formData.append('products_id', products_id);
        formData.append('deskripsi_po', deskripsi_po);
        formData.append('jumlah_produk', jumlah_produk);
        formData.append('barang_bagus', barang_bagus);
        formData.append('barang_jelek', barang_jelek);
        formData.append('created_at', created_at);
        formData.append('updated_at', updated_at);
        formData.append('updated_by', updated_by);
        formData.append('created_by', created_by);
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
                        // console.log(response.errors);
                        Swal.fire({
                            title: 'Gagal',
                            text: value,
                            icon: 'error'
                        });
                        
                    }); 
                }

                var url = "{{ asset('/api/purchaseorders/getdata') }}";
                $('#listProdukTable').DataTable().ajax.url(url).load();
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log(textStatus, errorThrown);
            }
        });
    });
    // FORM SUBMIT



</script>








@endsection 
</x-app-layout>