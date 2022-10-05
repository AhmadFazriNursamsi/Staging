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
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="No Purchase Order" name="no_purchase_order"></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Nama Produk" name="products_id"></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Catatan" name="deskripsi_po"></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Jumlah" name="jumlah_produk"></td>
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
                                    <th class="align-center">No Purchase Order</th>
                                    <th class="align-center">Nama Produk</th>
                                    <th class="align-center">Catatan</th>
                                    <th class="align-center">Jumlah</th>
                                    <th class="align-center">Active</th>
                                    <th class="align-center">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="align-center">No Purchase Order</th>
                                    <th class="align-center">Nama Produk</th>
                                    <th class="align-center">Catatan</th>
                                    <th class="align-center">Jumlah</th>
                                    <th class="align-center">Active</th>
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

    <!-- MODAL CREATE -->
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
                {{-- MODAL BODY --}}
                <div class="modal-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <form id="smbtn" enctype="multipart/form-data"> 
                                {{--  --}}
                                <div class="form-group">
                                    {{-- <input type="hidden" id="id" class="inpt-cst-add" name="id"> --}}
                                    <label for="no_purchase_order" class="form-label">No Purchase Order *</label>
                                    <input type="text" class="form-control inpt-cst-add mb-2" name="no_purchase_order" id="no_purchase_order" aria-describedby="" placeholder="No Purchase Order" aria-describedby="basic-addon1">
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

                                {{-- <div class="form-group"> --}}
                                    <table id="listProdukTable" class="table text-start table-striped align-middle table-bordered table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th class="align-center">Thumbnails</th>
                                            <th class="align-center">Nama</th>
                                            <th class="align-center">Satuan</th>
                                            {{-- <th class="align-center">Kategori</th>
                                            <th class="align-center">Brand</th>
                                            <th class="align-center">Supplier</th> --}}
                                            {{-- <th>Qty</th>
                                            <th>Bagus</th>
                                            <th>Jelek</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="align-center">Thumbnails</th>
                                            <th class="align-center">Nama</th>
                                            <th class="align-center">Satuan</th>
                                            {{-- <th class="align-center">Kategori</th>
                                            <th class="align-center">Brand</th>
                                            <th class="align-center">Supplier</th> --}}
                                            {{-- <th>Qty</th>
                                            <th>Bagus</th>
                                            <th>Jelek</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>                               
                            {{-- </div> --}}

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm closeModalad" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" id="addvbtn" data-attid="" class="btn btn-success btn-sm"></button>
                                </div>
                                {{--  --}}                                
                            </form>
                        </div>
                    </div>
                </div>
                {{-- MODAL BODY --}}
            </div>
        </div>
    </div>
    @endif
    <!-- MODAL CREATE -->
    
@section('script')

<script type="text/javascript">
    
    // FUNCTION SECARA GLOBAL
    $(".closeModalad").click(function() 
    {
    $("#viewad").modal('hide');
    });
    // FUNCTION SECARA GLOBAL
    

    // // DATA TABLE UNTUK HALAMAN DEPAN
    var url = "{{ asset('/api/purchaseorders/getdata') }}";
    function searcAjax(a, skip = 0) {
        if ($(a).val().length > global_length_src || skip == 1) {
            var getparam = getAllClassAndVal("src_class_user"); // helpers
            $('#datastable').DataTable().ajax.url(url + "?" + getparam).load();
        }else{
            $('#datastable').DataTable().ajax.url(url).load();
        }
    }
    // // DATA TABLE UNTUK HALAMAN DEPAN

    // // TAMPIL PADA HALAMAN TABLE DEPAN
    $(document).ready(function() {
        var table = $('#datastable').DataTable({
            // ajax: url,
            columnDefs: [
                {
                    'targets': 2,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) {
                        return '<span class="btn btn-info btn-sm" onclick="showdetail(' + full[2] + ')">details</span>';
                    }
                }, 
            ],
            searching: false,
        });
    
        $("#closeModal").click(function() {
            $("#view").modal('hide');
        });
    });
    // // TAMPIL PADA HALAMAN TABLE


    // // UNTUK MEMBUKA MODAL ADD
    $("#btnAdd").click(function() 
    {
        clearInput("inpt-cst-add");
        $('#viewad').modal('show');
        $('#showProduk').show();
    
        // tambahan
        $("#produkId").val("");
        $('#produk_list').html("");
        $('#user_group').hide();
        $('.copy').html("");
        $(".control-group after-add-more").html("");
        // tambahan
    
        $("#ModalLongTitle").html("Purchase Orders Tambah"); // title MODAL CREATE
        $("#addvbtn").html('<i class="fa fa-plus"></i> Add Purchase Orders');
    });
    // // UNTUK MEMBUKA MODAL ADD

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
                    htmls1 = '<select class="list-unstyled form-control form-group col-sm-8" id="id_user" name="selectProduk" onchange="table(this)">';
                        // console.log(htmls1);

                    htmls1 += '<option value="" selected>-- Select option --</option>';

                    $.each(data, function (key, item) {
                        htmls1 += '<option id="optcust-'+item.id+'" data-attid="'+item.id+'" data-attname="'+item.nama+'" value="'+item.id+'" data-attthum="'+item.image+'" data-attsat="'+item.satuan+'">'+item.nama+'</option>';


                    });

                    htmls1 += '</select>';
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
    
    // // FORM SUBMIT

    // // FORM SUBMIT


    function produkChange(a) 
    {
        id = $(a).val();
        var hidden = $("#user_group").val();
        var tampung = hidden + ', ' + id;
        nama = $( "#id_user option:selected" ).text();
        const pattern = new RegExp('(' + id + ')', 'gm');
        let m;



        if(m = pattern.exec(hidden) == null)
        {
            var html = $(".copy").html();
            $("#user_group").val(tampung);

            $('.copy').after("<div class='alert alert-success alert-dismissible fade show' role='alert'><b><span class='mx-2 btn btn-info' onclick='showdetail()'><i class='bi bi-eye-fill'></i></span><strong>"+nama+"</strong></b><button type='button' class='btn-close col-1 lg' id='close-"+id+"' data-bs-dismiss='alert' aria-label='Close' onClick=\"kurangininput("+id+")\"></button></div>");
        }
    }

    var untukUrl = '[]';

    function table(a) 
    {
        id = $(a).val();
        
        var dataThumbnail = $("#optcust-"+id).attr("data-attthum");  
        var dataSatuan = $("#optcust-"+id).attr("data-attsat");  
        var dataNama = $("#optcust-"+id).attr("data-attname");  

        var thumbnails = "{{ asset('/images/uploads/Thumbnail-') }}"+'/'+dataThumbnail;
        thumbnails = '<img src="' + thumbnails + '" width="500" height="500">';


        untukUrl = '{"data":[["","'+thumbnails+'","'+dataNama+'","'+dataSatuan+'","'+id+'"]],"status":"200"}';

        console.log(untukUrl);
        // var hidden = $("#user_group").val();
        // var tampung = hidden + ', ' + id;
        // nama = $("#id_user option:selected").text();
        // const pattern = new RegExp('(' + id + ')', 'gm');
        // let m;
        // if(m = pattern.exec(hidden) == null) 
        // {
        //     $("#user_group").val(tampung);
        // }
        
        $('#listProduKTable').DataTable().ajax.url(untukUrl).load();
    }



    $(document).ready(function() 
    {
        // Untuk DataTable Produk saaat Create
        var table = $('#listProdukTable').DataTable({
            // searching: false,
        });
    
        $("#closeModal").click(function() {
            $("#view").modal('hide');
        });
    });


    
    function kurangininput(a) 
    { 
        var tampung = $("#user_group").val();
        tampung = tampung.replace(", "+a, "");
        $("#user_group").val(tampung);
    }

    // function reloaddata() {
    //     var url = "{{ asset('/api/purchaseorders/getdata') }}";
    //     $('#datastable').DataTable().ajax.url(url).load();
    // }


</script>
@endsection 


</x-app-layout>