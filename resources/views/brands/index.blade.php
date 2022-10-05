<?php use App\Http\Controllers\HelpersController as Helpers; 
$haveaccessadd = Helpers::checkaccess('brands', 'add');
$haveaccessdelete = Helpers::checkaccess('brands', 'delete');
?>

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hetf2"><i class="fa fa-plus"></i>
            {{ __('Brand') }} <?php if($haveaccessadd): ?> 
            <button type="button" id="btnAdd" class="btn btn-sm btn-success m-2" data-toggle="modal" data-target="#addUser">
                <i class="fa fa-plus me-2"></i>Create Brand   
            </button> <?php endif; ?>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="table-responsive">
                        {{-- table --}}
                        <table id="datastable" class="table text-start table-striped align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="Nama Brand" name="brand_name"></td>
                                    <td>
                                        <select name="active" class="form-control input-sm src_class_user" onchange="searcAjax(this, 1)">
                                            <option value="">-- Status Active --</option>
                                            <option value="1">Active</option>
                                            <option value="0">Not Active</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><input type="checkbox" class="checkall" name="checkall"></th>
                                    <th class="align-center">Nama Brand</th>
                                    <th class="align-center">Active</th>
                                    <th class="align-center">Flag</th>
                                    <th class="align-center">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="align-center">Nama Brand</th>
                                    <th class="align-center">Active</th>
                                    <th class="align-center">Flag</th>
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

    <!-- TAMPIL DATA MODAL CREATE -->
    @if ($haveaccessadd) 
    <div class="modal fade" style="background: rgba(0, 0, 0, 0.7);" id="viewad" tabindex="-1" role="dialog" aria-labelledby="viewTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLongTitle"></h5>
                    <button type="button" class="close-modal btn btn-sm btn-danger close closeModalad" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- MODAL BODY --}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="smbtn" enctype="multipart/form-data"> 
                                @csrf
                                {{--  --}}
                                <div class="form-group">
                                    <input type="hidden" id="id" class="inpt-cst-add" name="id">
                                    <label for="brand_name" class="form-label">Nama Brand*</label>
                                    <input type="text" class="form-control inpt-cst-add mb-2" name="brand_name" id="brand_name" placeholder="Nama Brand">
                                </div>

                                <div class="form-group">
                                    <label for="active" class="form-label">Status</label>
                                    <select name="active" class="form-control inpt-cst-add  mb-2" id="active">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Not Active</option>
                                    </select>
                                </div>

                                <div class="form-group" style="float: right; text-align: right; right: 0; width: 2000px;">
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
    <!-- TAMPIL DATA MODAL CREATE -->

    {{-- TAMPIL DATA MODAL VIEW --}}
    <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="viewTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                {{-- MODAL BODY --}}
                <div class="modal-body">
                    <ul class="nav nav-pills mb-10" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Details Info</button><br>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            {{--  --}}
                            <table class="table table-striped" id="table_detail">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Brand</th>
                                        {{-- <th scope="col">Active</th> --}}
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
                        <span id="editvbtn" data-attid="" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit Brand</span>
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


@section('script')
<script type="text/javascript">
    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    // FUNCTION UNTUK SEARCH
    var url = "{{ asset('/api/brands/getdata') }}";
    // console.log(url);
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
    // FUNCTION UNTUK SEARCH

    // FUNCTION SECARA GLOBAL
    $(".closeModalad").click(function(){
        $("#viewad").modal('hide');
    });
    // FUNCTION SECARA GLOBAL

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    // FUNCTION UNTUK MENAMPIKAN DATA DI DALAM TABLE 
    $(document).ready(function()
    {
        var table = $('#datastable').DataTable({
            ajax: url,
            createdRow: function(row, data, dataIndex, cells) {
                // console.log(data);
                if(data[4] == 1)
                $(row).addClass('warning');
                else
                $(row).removeClass('warning');
                // console.log(row); // tabel row
                // console.log(data[0]); // sting kosong
                // console.log(data[1]); // Nama Brand
                // console.log(data[2]); // ID
                // console.log(data[3]); // Active
                // console.log(data[4]); // FLAG DELETE
            },
            columnDefs: [
                {
                    'targets': 0,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {
                        return '<input type="checkbox" class="ckc" name="checkid['+full[2]+']" value="' + $('<div/>').text(data).html() + '">';       
                    }
                },
                {
                    'targets': 2,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {                        
                        if(full[3] == 0)
                            return '<span class="btn btn-danger btn-sm">Non Active</span>';
                        else 
                            return '<span class="btn btn-success btn-sm">Active</span>';
                    }
                },
                {
                    'targets': 3,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {                        
                        if(full[4] == 0)
                            return '<span class="btn btn-success btn-sm">Ready</span>';
                        else 
                            return '<span class="btn btn-danger btn-sm">Deleted</span>';
                    }
                },
                {
                    'targets': 4,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) 
                    {
                        return '<span class="btn btn-info btn-sm" onclick="showdetail('+full[2]+')">details</span>';             
                    }
                },
            ],
            searching: false,
        });
        $("#closeModal").click(function(){
            $("#view").modal('hide');
        });

        $('.checkall').change(function(){
            var cells = table.cells().nodes();
            $( cells ).find('.ckc:checkbox').prop('checked', $(this).is(':checked'));
        });
    });
    // // FUNCTION UNTUK MENAMPIKAN DATA DI DALAM TABLE 

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    // UNTUK MEMBUKA MODAL ADD
    $("#btnAdd").click(function(){
        clearInput("inpt-cst-add");
        $('#active').val(1).change(); //
        $('#viewad').modal('show'); 
        $("#ModalLongTitle").html("Brand Tambah"); // title MODAL CREATE
        $("#addvbtn").html('<i class="fa fa-plus"></i> Add Brand');
    });
    // UNTUK MEMBUKA MODAL ADD

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // FUNCTION UNTUK SUBMIT
    $("#smbtn").submit(function(e)
    {
        e.preventDefault();
        var id = $("#id").val();
        var brand_name = $("#brand_name").val();
        var active = $("#active").val();

        var url = "{{ asset('api/brands/insertdata') }}";
        if(id != '') 
            var url = "{{ asset('api/brands/updatedata') }}/" + id;

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
                var url = "{{ asset('/api/brands/getdata') }}";
                $('#datastable').DataTable().ajax.url(url).load();
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log(textStatus, errorThrown);
            }
            
        });

    });
    // FUNCTION UNTUK SUBMIT

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // FUNCTION UNTUK MODAL DETAILS
    function showdetail(idx) 
    {
        $('#addvbtn').attr('data-attid', idx);
        $('#view').modal('show'); // tampil modal details
        
        $('#deletevbtn').attr('data-attid', idx);
        $('#deletevbtn').html('<i class="fa fa-trash"></i>Delete Brand');

        $('#undeletevbtn').attr('data-attid', idx);
        $('#undeletevbtn').html('<i class="fa fa-repeat"></i> Undelete Brand');

        var table3 = document.querySelector("#table_detail tbody");
        table3.innerHTML= "";

        var url = "{{ asset('/api/brands/getdatabyid') }}/" + idx; // Table View Details

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) 
            {
                // console.log(response);
                data = response.data; // success
                var htmlInputTable = "";
                var i = 1;
                
                htmlInputTable += 
                '<tr class="" id="row-'+i+'">\
                    <td class="sorting_1">'+i+'</td>\
                    <td>'+data.brand_name+'</td>\
                </tr>';
    
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

                if(data.active == 0)
                {
                    data = '<span style="color: #dc3545">non active</span>';
                }

                if(data.active == 1)
                {
                    data = '<span style="color: #198754">active</span>';
                }
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log(textStatus, errorThrown);
            }
        });
    }
    // FUNCTION UNTUK MODAL DETAILS

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // FUNCTION KETIKA CLICK BTN EDIT
    $("#editvbtn").click(function()
    {        
        var idx= $("#addvbtn").attr("data-attid");       
        $("#ModalLongTitle").html("Edit Brand");
        clearInput("inpt-cst-add"); // pak heri

        $("#addvbtn").html('<i class="fa fa-edit"></i> Edit Brand');
        $("#view").modal('hide');
        $('#viewad').modal('show');

        var url = "{{ asset('/api/brands/getdatabyid') }}/" + idx; // Table View Details
        // console.log(url);

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) 
            {
                data = response.data; // success
                $("#id").val(data.id);
                $("#brand_name").val(data.brand_name);
                $("#active").val(data.active);
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log(textStatus, errorThrown);
            }
            
        });
    });
    // FUNCTION KETIKA CLICK BTN EDIT

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
                var url = "{{ asset('/api/brands/delete') }}/" + idx;
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
                        var url = "{{ asset('/api/brands/getdata') }}";
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
                var url = "{{ asset('/api/brands/delete') }}/" + idx;
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
                        var url = "{{ asset('/api/brands/getdata') }}";
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
