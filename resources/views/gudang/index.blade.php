<?php use App\Http\Controllers\HelpersController as Helpers; 

$haveaccessadd = Helpers::checkaccess('warehouse', 'add');
$haveaccessdelete = Helpers::checkaccess('warehouse', 'delete');
$haveaccessedit = Helpers::checkaccess('warehouse', 'edit');
$haveaccessview = Helpers::checkaccess('warehouse', 'view');

?>
@section('title')
    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">


<style>
    .alll{
        height: 120px;
    }
    .btn-plus-alamat{
        border-radius: 32em;
    }
    .is-invalid {
        display: block;
    }   
    .alert-danger{
        line-height:0;
    }
    .modal-footer{
        justify-content: flex-start;
    }

    .flex-container {
  display: flex;
  flex-wrap: nowrap;
  background-color: DodgerBlue;
}

.flex-container > div {
  background-color: #f1f1f1;
  width: 100px;
  margin: 10px;
  text-align: center;
  line-height: 75px;
  font-size: 30px;
}


    </style>
<title>{{ $datas['title'] }}</title>
@endsection
<x-app-layout>
    {{-- <title>{{ $datas['title'] }}</title> --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hetf2"><i class="bi bi-person-workspace"> </i>
        {{ __('Warehouse') }}<?php if($haveaccessadd): ?>  <button class="btn btn-success btn-sm" id="btn_addcustomer"><i class="fa fa-plus"></i>Add Warehouse</button> <?php endif; ?>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   <div class="table-responsive">
                        <table id="gudangtable" class="table text-start table-striped align-middle table-bordered table-hover mb-0">
                            <thead>

                                <tr>
                                    <th><input type="checkbox" class="checkall" name="checkall"></th>
                                    <th class="align-center">Nama warehouse</th>
                         
                                    <th class="align-center">Address </th>
                                      <th class="align-center">Another Warehouse</th>
                            

                                    <th class="align-center">Active</th>
                                    <th class="align-center">Status delete</th>
                                    <th class="align-center">Action</th>
                                    
                                </tr>
                                
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="align-center">Nama warehouse</th>
                         
                                    <th class="align-center">Address </th>
                                      <th class="align-center">Another Warehouse</th>
                            

                                    <th class="align-center">Active</th>
                                    <th class="align-center">Status Delete</th>
                                    <th class="align-center">Action</th>
                                    
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Add modal -->
<div class="modal fade" id="addmodall" tabindex="-1" role="dialog" aria-labelledby="viewUserTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

        <div class="row">
            <div class="container">
                <div class="modal-header lg">
                    <div class="justify-content-lg-start">
                        <h4><i id="iconn" ></i><i class="icoon ms-2"><span id="icon"></span><span id="titleaddmodal" class="icoon titleaddmodal" class="ms-2"></span></i></h4>
         
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-body">
                <form id="formm">
                    <div class="mb-3">
                        <div class="col">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="form-label nama">Name Warehouse</label>
                                <input type="text" class="form-control nama " placeholder="Nama" name="nama" id="nama" aria-describedby="validationServer03Feedback">
                            </div> 
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="col">
                            <label for="alias_gudang" class="form-label alias_gudang">Another Warehouse</label>
                            <input type="alias_gudang" class="form-control alias_gudang" placeholder="Another Warehouse" name="alias_gudang" id="alias_gudang" aria-describedby="validationServer03Feedback" >
                            <input type="hidden" id="idAdd">
                        </div> 
                    </div>
                    <div class="mb-3">
                        <label for="alamat">Address</label>
                        <textarea class="form-control alll alamat" name="alamat" placeholder="Address" id="alamat"></textarea>
                    </div>
                    <div class="mt-3 col-3">
                        <select multiple name="user" required class="form-control user" id="id_user" onchange="Userchange(this)">
                            <option selected disabled hidden>-- Select Users --</option>
                            <?php foreach ($datas['user'] as $key => $post) :?>
                            <option id="userid" value="{{ $post->id }}">{{ $post->name }}</option>
                            <?php endforeach ;?>
                        </select>
                    </div>
                    <input type="hidden" name="user_group" id="user_group">
                    <div class="form-group">
                        <div class="d-flex justify-content-end">
                            <div class="after-add-more control-group"style="display: flex;flex-wrap: nowrap;">
                                <div class="copy control-group"><span id="changeuserselect" class="ms-2"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="col">
                            <label for="active" class="form-label active_class">Status Active</label>
                            <div class="form-check">
                                <input required class="form-check-input  active_class" type="radio" value="1" name="active" id="active" checked>
                                <label class="form-check-label active_class" for="active">Active</label>
                            </div>
                            <div class="form-check">
                                <input required class="form-check-input active_class" type="radio" value="0" name="active" id="active2">
                                <label class="form-check-label active_class" for="active2">Not Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content d-flex justify-content-end" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <dl class="row mb-0" id="datauser-1"></dl>
                        </div>
                        <div class="tab-pane fade btn-add-cencel" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button id="closeModalViewUser" type="button" class="btn closeModalViewUser btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button id="save" type="submit" class="btn btn-success btn-sm" data-dismiss="modal">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>
</div>

{{-- View Modal --}}
<div class="modal fade" id="viewCustomer" tabindex="-1" role="dialog" aria-labelledby="viewUserTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="row">
                <div class="container">
                    <div class="modal-header lg">
                        <div class="justify-content-lg-start">
                            <h4><i class="bi bi-clipboard2-minus"><span id="titledetailmodal"></span></i></h4>
                        </div>
                        <div class="d-flex justify-content-end"></div>   
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <dl class="row mb-0">
                            <dt class="col-sm-4 show_name">Warehouse Name</dt>
                            <dd class="col-sm-8 show_name">: <span name="name" id="show_name"></dd>
                            <dt class="alias_gudang col-sm-4">Another Warehouse </dt>
                            <dd class="alias_gudang col-sm-8">: <span name="email" id="alias_gudang_view"></dd>
                            <dt class="show_tlp col-sm-4">Address</dt>
                            <dd class="show_tlp col-sm-8">: <span name="no_tlp" id="show_alamat"></dd>
                            <dt class="show_status col-sm-4">User</dt>
                            <dd class="show_status col-sm-8">: <span id="userdetail"></span>
                            <dt class="show_status col-sm-4">Status</dt>
                            <dd class="show_status col-sm-8">: <span id="activedetail"></span>
                            <dt class="show_delete col-sm-4">Status Delete</dt>
                            <dd class="show_delete col-sm-4">: <span id="flagdelete"></span></dd>
                        </dl>                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnlistProduct" type="button" data-attid="" class="btn btn-primary btn-sm btn-block ml-1 justify-content-start" onclick="listShow()" data-dismiss="modal">LIST PRODUCT</button>
                <button id="closeModalViewmodal" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <?php if($haveaccessedit): ?> 
                    <button class="btn-success btn-sm" data-attid="" onclick="editshow()" id="editbtn"><i class="fa fa-edit"></i> Edit Gudang</button>
                <?php endif; ?>
                <?php if($haveaccessdelete): ?> 
                    <button onClick="deleteyesshow()" data-attid="" data-deleteval="1" id="deletevbtn" class="btn btn-danger btn-sm"></a>
                <?php endif; ?>
                    <button onClick="undeleteyesshow()" data-attid="" data-deleteval="0" id="undeletevbtn" class="btn btn-warning btn-sm"></button>
            </div>
        </div>
    </div>
</div>


{{-- List Modal --}}
<div class="modal fade" id="ListModal" tabindex="-1" role="dialog" aria-labelledby="viewUserTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="row">
                <div class="container">
                    <div class="modal-header lg">
                        <div class="justify-content-lg-start">
                            <h4><i class="bi bi-list-ul"></i><span id="titlelistmodal"></span></i></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="table-responsive">
                                    <table id="listgudangtable" class="table text-start table-striped align-middle table-bordered table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th class="align-center">Product</th>
                                                <th class="align-center">Stock</th> 
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th class="align-center">Product</th>
                                                <th class="align-center">Stock</th>
 
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="closeModallistmodal" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('script')
<script type="text/javascript">
    var url = "{{ asset('/api/gudang/getdata/') }}";
    function searcAjax(a, skip = 0){
        if($(a).val().length > global_length_src || skip == 1) {
            var getparam = getAllClassAndVal("src_class_user"); // helpers
            $('#gudangtable').DataTable().ajax.url(url+"?"+getparam).load();
        }
        else {
          $('#gudangtable').DataTable().ajax.url(url).load();
        }
    }

    $(document).ready(function(){
        var getndate = getNowdate(); // helpers
        $("#daterangepicker").val(getndate + ' - ' + getndate );
        $(".datepicker").val(getndate);
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            timePicker: false,
            locale: {
              format: "DD/MM/YYYY"
            }
        });

        $("#daterangepicker").daterangepicker({
            timePicker: false,
            locale: {
              format: "DD/MM/YYYY"
            }
        });

        var table = $('#gudangtable').DataTable({
            ajax: url,
            createdRow: function(row, data, dataIndex, cells) {
                if(data[5] == 1)
              $(row).addClass('warning');
              else
              $(row).removeClass('warning');
            },
            columnDefs: [
                 {
                   'targets': 6,
                   'searchable':false,
                   'orderable':false,
                   'className': 'dt-body-center',
                   'render': function (data, type, full, meta){
                       return '<span class="btn btn-info btn-sm" onclick="showdetail('+full[6]+')">details</span>';
                   }
                }, {
                   'targets': 0,
                   'searchable':false,
                   'orderable':false,
                   'className': 'dt-body-center',
                   'render': function (data, type, full, meta){
                       return '<input type="checkbox" class="ckc" name="checkid['+full[8]+']" value="' + $('<div/>').text(data).html() + '">';
                   }
                }, {
                   'targets': 4,
                   'className': 'dt-body-center',
                   'render': function (data, type, full, meta){
                       
                        if(full[4] != 0)
                        return '<span class="btn btn-success btn-sm">Active</span>';
                        else 
                        return '<span class="btn btn-secondary btn-sm">Not Active</span>';
                   }
                },
                {
                   'targets': 5,
                   'className': 'dt-body-center',
                   'render': function (data, type, full, meta){
                        if(full[5] == 0)
                        return '<span class="btn btn-primary btn-sm">ON</span>';
                        else 
                        return '<span class="btn btn-danger btn-sm">Deleted</span>';
                   }
                }
            ],
            searching: true,
        }); 

        $('.checkall').change(function(){
            var cells = table.cells().nodes();
            $( cells ).find('.ckc:checkbox').prop('checked', $(this).is(':checked'));
        });
    });



    ////////////////////////////// Add Modal
   $('#btn_addcustomer').on('click', function () {
       $("#iconn").html("<i class='bi bi-person-workspace'>  </i>");
    //    $("#titleaddmodal").html("Add Gudang");
        $("#addvbtn").hide();
        $("#deletevbtn").hide();
        $("#user_group").val("");
        $(".copy").hide();
        $(".copy").hide();
        $("#idAdd").val("");
        $("#undeletevbtn").hide();
        $(".nama").val("");
        $(".alias_gudang").val("");
        $(".alamat").val("");
        $(".icoon").html("Add Warehouse");
        $("#addmodall").modal('show');
        $(".after-add-more").hide();
        $(".after-add-more").val("");
        $('.copy').hide();
        
     })


    ///form submit
    $(document).ready(function(){
        $( "#formm" ).submit(function(e) {
            var id = $("#idAdd").val();
            idx = $('#editbtn').attr('data-attid');
            var url= "{{ asset('/gudang/store') }}" ;
            if(id != "")
            var url = "{{ asset('/gudang/update') }}/" + id ;

            e.preventDefault();
            var form = $('#formm');
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(),
                        success: function (response) {
                            data = response.data;
                            if(data == 'success') {
                                Swal.fire({
                                    title: 'Selamat!',
                                    text: "Data Berhasil Disimpan",
                                    icon: 'success'
                            
                                });
                                $("#name").val();
                                $("#email").val();
                                $("#no_tlp").val();

                                $(".provinsi").val();
                                $(".kabupaten").val();
                                $(".kecamatan").val();
                                $(".kelurahan").val();
                                $(".alamat").val();
                                
                                $(".provinsi").show("");
                                $(".kabupaten").show("");
                                $(".kecamatan").show("");
                                $(".kelurahan").show("");
                                $(".alamat").show("");

                                $(".email").show("");
                                $(".no_tlp").show("");
                                $(".active_class").show("");
                                $(".nama").show("");
                                $("#addmodall").modal('hide');
                                $("#formm")[0].reset();
                                reloaddata();
                                $('.alert-danger').hide();
                            }
                            else {
                                $.each(response.errors, function(key, value){
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: value,
                                        icon: 'error'
                                    });
                                });
                                
                            } 
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
            });  
        });

    function Userchange(a){
            id = $(a).val();
            $('.after-add-more').show();
            var hidden = $("#user_group").val();
            $('.copy').show("");
            $(".after-add-more").val("");
            var tampung = hidden + ', ' + id;
            nama = $( "#id_user option:selected" ).text();

            const pattern = new RegExp('(' + id + ')', 'gm');
            let m;
            if(m = pattern.exec(hidden) == null) {
                var html = $(".copy").html();
                $("#user_group").val(tampung);
                $('.copy').after(" <div class='alert alert-success alert-dismissible fade mx-1 show' role='alert'><b><strong>"+nama+"</strong></b><button type='button' class='btn-close col-1 lg' id='close-"+id+"' data-bs-dismiss='alert' aria-label='Close' onClick=\"kurangininput("+id+")\"></button>");
            }
    }
    function kurangininput(a) { 
        var tampung = $("#user_group").val();
        tampung = tampung.replace(", "+a, "");
        $("#user_group").val(tampung);
    }
    function showdetail(id) {
        var addurl = $('#addvbtn').attr('data-attrref')+'/'+id;
            $('#addvbtn').attr('href', addurl);
            $('#saveee').attr('data-attid', id);
   
        var addurl = $('#deletevbtn').attr('data-attid', id);
        var url = "{{ asset('/gudang/detail') }}/" + id;
        var form = $('#viewCustomer');
            $('#undeletevbtn').html("Undelete");
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        data = response.data;
                        if (data) {
                            $("#show_name").html(data.nama);
                            $("#alias_gudang_view").html(data.alias_gudang);
                            $("#show_alamat").html(data.alamat);
                            var tampungUser = "";
                            $.each(data.list_user_gudang, function(k, item){
                                tampungUser = tampungUser + item.nama + ", ";
                            });
                            $("#userdetail").html(tampungUser);                            
                            if (data.active == 0) {
                                $("#activedetail").html("<span class='btn btn-secondary btn-sm'><b>Not Active</b></span>");
                            } else {
                                $("#activedetail").html("<span class='btn btn-success btn-sm'><b>Active</b></span>");
                            }
                            if (data.flag_delete == 0) {
                                $("#flagdelete").html("<span class='btn btn-primary btn-sm'><b>ON</b></span>");
                            } else {
                                $("#flagdelete").html("<span class='btn btn-danger btn-sm'><b>Delete</b></span>");
                            }
                            if (data.flag_delete == 0){
                                $('#deletevbtn').show();
                                $('#undeletevbtn').hide();
                            }
                            if (data.flag_delete == 1){
                                $('#deletevbtn').hide();
                                $('#undeletevbtn').show();
                            }
                        }
                        $('#viewCustomer').modal('show');
                        $("#closemodaledit").modal('hide');
                    }
                }); 
                $('#deletevbtn').attr('data-attid', id);
                $("#idAdd").val(id);
                $('#btnlistProduct').attr('data-attid', id);
                $('#editbtn').attr('data-attid', id);
                $('#undeletevbtn').attr('data-attid', id);
                $('#deletevbtn').html('<i class="fa fa-trash"></i> Delete Warehouse');
                $("#titledetailmodal").html("Detail Warehouse")
    }
            $("#closeModalViewmodal").click(function() {
                $("#viewCustomer").modal('hide');
            });
            $("#closeModallistmodal").click(function() {
                $("#ListModal").modal('hide');
            });
            $(".closeModalViewUser").click(function() {
                $("#addmodall").modal('hide');
            });
    function editshow(){
        idx = $('#editbtn').attr('data-attid');
        id = $("#idAdd").val();
        $('.after-add-more').show();
        $("#iconn").html("<i class='bi bi-person-workspace'> </i>");
        $(".icoon").html("Edit Warehouse");
        
        $('.after-add-more').html("");
        $('.after-add-more').html('<div class="copy control-group"></div>');
        var url = "{{ asset('/gudang/edit') }}/" + idx;
            $.ajax({
                url: url,
                type: "GET",
                    success: function(response) {
                        data = response.data;
                        if(data) {
                            var tampungUser = inHtml= "";

                            $.each(data.list_user_gudang, function(k, item){
                                tampungUser = tampungUser + ", " + item.id_user;
                                $("#user_group").val(tampungUser);
                                inHtml += "<div class='alert alert-success alert-dismissible fade show' role='alert'><b><strong>"+item.nama+"</strong></b><button type='button' class='btn-close col-1 lg' id='close-"+k+"' data-bs-dismiss='alert' aria-label='Close' onClick=\"kurangininput("+item.id_user+")\"></button></div>";

                            }); // end looping

                            $('.copy').html(inHtml);
                        
                            $("#nama").val(data.nama);
                            $("#alias_gudang").val(data.alias_gudang);
                            $(".alamat").val(data.alamat);

                            if(data.active != 0){
                                $("#active").attr('checked', 'checked');
                            }
                            else {
                                $("#active2").attr('checked', 'checked');
                            }

                        } // endif

                        $('#addmodall').modal('show');
                        $('#viewCustomer').modal('hide');
                                
                } // end response
                    
            });
    }
    
 
    function deleteyesshow(){
        $('#deletevbtn').hide();
        idx = $('#deletevbtn').attr('data-attid');
        test = '@csrf';
        token = $(test).val();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ asset('/gudang/delete') }}/" + idx;
                $.ajax({
                    url: url,
                    type: "get",
                    data: {
                        id : idx,
                        _token: token
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            html:'Your file has been <b>Deleted</b>'
                        });
                        reloaddata();
                        $("#viewCustomer").modal("hide");
                        $("#activspan").html('deleted');
                        $("#activspan").css('color', '#dc3545');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('something wrong');
                        console.log(textStatus, errorThrown);
                    }
                });

            } else {
                $('#deletevbtn').show();
            }
        })
    }

    function undeleteyesshow(){
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
        }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ asset('/gudang/delete') }}/" + idx;
                    $.ajax({
                        url: url,
                        type: "get",
                        data: {
                            id : idx,
                            _token: token,
                            undeleted : 1
                        },
                        success: function (response) {
                            Swal.fire({
                            icon: 'success',
                            title: 'Undeleted',
                            html:'Your file has been <b>Undeleted</b>'
                            });
                            reloaddata();
                            $("#viewCustomer").modal("hide");
                            $("#activspan").html('-');
                            $("#activspan").css('color', '#198754');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });

                } else {
                $('#undeletevbtn').show();
                }
        })
    }
    function listShow() { 
        id = $('#btnlistProduct').attr('data-attid');
        $("#viewCustomer").modal("hide");
        $("#titlelistmodal").html(" List Product");
        $("#ListModal").modal("show");
        var url = "{{ asset('/api/listProduct/getdata') }}/" + id;
        $('#listgudangtable').DataTable().ajax.url(url).load();
    }
    function reloaddata() {
        $('#gudangtable').DataTable().ajax.url(url).load();
    }
</script>
@endsection    
</x-app-layout>



