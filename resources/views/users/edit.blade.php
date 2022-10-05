<?php use App\Http\Controllers\HelpersController as Helpers; 

$haveaccessadd = Helpers::checkaccess('users', 'add');
$haveaccessdelete = Helpers::checkaccess('users', 'delete');

?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hetf2"><i class="fa fa-users"></i>
            {{ __('Users') }} Edit <a href="{{URL::to('/users')}}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Back to User</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  @include('users._form', $datas)
                </div>
            </div>
        </div>
    </div>



@section('script')
<script type="text/javascript">
   
  $(document).ready(function (){
    check_access_Edit();
    edit();
  })

  function check_access_Edit(){
    idx = '{{$id}}';
    test = '@csrf';
    token = $(test).val();
    var url = "{{ asset('/api/usersaccess') }}/" + idx;
    $.ajax({
        url: url,
        type: "get",
        data: {
            id : idx,
            _token: token
        },
        success: function (response) {
          $.each(response.data, function(i, item) {
            if(item.val_access == 1)
              $("#"+item.name_access+'-'+item.key_access).attr('checked', true);
            else 
              $("#"+item.name_access+'-'+item.key_access).attr('checked', false);
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('something wrong');
            console.log(textStatus, errorThrown);
        }
    });
  }
  function edit() { 
    idx = '{{$id}}';
    test = '@csrf';
    var table3 = document.querySelector("#table_add tbody");
    table3.innerHTML= "";
		var url = "{{ asset('/api/edit') }}/" + idx;

			$.ajax({
				url: url,
				type: "GET",
					success: function(response) {
            data = response.data
            if(data){
              var tampungUser = inHtml= "";
                $.each(data, function(k, item,){
                  
                  var htmlinput = '<tr class="" id="row-'+item[2]+'">\
                      <td></td>\
                      <td>'+item[1]+'</td>\
                      <td class="dt-body-center"><span class="btn btn-danger deletee btn-sm" onclick="kurangininputedit('+item[2]+')"><i class="bi bi-trash-fill"></i></span></td>\
                      </tr>';
                      table3.innerHTML = table3.innerHTML + htmlinput;
                      tampungUser = tampungUser + ", " + item[2];
                      $("#table_group").val(tampungUser)
                })

            }
					}});
        }
  function kurangininputedit(a) { 
		var tampung = $("#table_group").val();
		tampung = tampung.replace(", "+a, "");
		$("#table_group").val(tampung);
		var rowid = '#row-'+a;
		$("#row-"+a).remove();
		Swal.fire({
				icon: 'success',
				title: 'Berhasil',
				html:'Data Berhasil <b>Dihapus</b>'
			});
	}
</script>

@endsection    
</x-app-layout>


