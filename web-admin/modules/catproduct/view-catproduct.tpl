
<div class="page-header">
  <h3>PRODUCT CATEGORIES</h3>
</div>
<form name="frmpage" id="frmpage"  method="post" action="javascript:return false;" >
<div class="row">
<div class="col-md-12" align="right">    
  <button type="button" class="btn btn-success" title="Add - Klik untuk tambah data ini." onclick="tambahdata()" ><i class="fa fa-plus"></i></button>
  <button type="button" class="btn btn-warning" title="Edit - Centang salah satu data lalu klik tombol ini." ><i class="fa fa-pencil"></i></button>
  <button type="button" class="btn btn-danger" title="Hapus - Centang salah satu data lalu klik tombol ini." ><i class="fa fa-trash-o"></i></button>
</div>
</div>

  <div class="row">
    <div class="col-md-6">
      <select name="jumlahbaris" id="jumlahbaris" class="form-control input-100">
        <option value="25" selected="selected">25</option>
        <option value="50">50</option>
        <option value="150">150</option>
      </select>
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-4">
      <select name="pilihfilter" class="form-control" id="pilihfilter">
        <option value="" selected="selected">--Pilih Filter--</option>
        <option value="A.name">Nama kategori</option>
      </select>
        </div>
        <div class="col-md-8">
      <div class="input-group">
      <input name="cari" type="text" id="cari" class="form-control" placeholder="Pilih lalu ketik disini...">
      <span class="input-group-btn">
      	<button type="submit" class="btn btn-default" title="Search" onclick="izydata(1);return false"><i class="fa fa-search"></i></button>
        <button type="button" class="btn btn-info" title="Refresh" onclick="$('#pilihfilter').val('');$('#cari').val('');izydata(1);return false;" ><i class="fa fa-refresh"></i></button>
      </span>
      </div>
        </div>
      </div>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-bordered tabelview table-hover table-condensed" id="tabeldata">
      <thead id="head1">
        <tr>
          <th width="1"><input id="checkall-baris" type="checkbox" onchange="$('.check-baris').prop('checked', $(this).prop('checked'));"></th>
          <th>Category Name</th>
          <th>Subcategory of</th>
          <th style="width:100px;" >Action</th>
        </tr>
      </thead>
      <tbody id="barisnomor1">
      </tbody>
    </table>
  </div>
  <div class="row">
    <div class="col-md-6"><div class="form-control">Total : <span id="jumlahdata">0</span> records</div></div>
    <div class="col-md-6" align="right">
      <button class="btn btn-gebo" name="butfirst" id="butfirst">First</button>
      <button name="butprev" id="butprev" class="btn btn-gebo">Previous</button>
      Page
      <input type="text" name="halaman" id="halaman" class="input-100 form-control" value="1" />
      / <span class="jumlahhalaman">1</span>
      <button class="btn btn-gebo" name="butnext" id="butnext">Next</button>
      <button name="butlast" id="butlast" class="btn btn-gebo">Last</button>
    </div>
  </div>
</form>
<script type="text/javascript">
$(document).ready(function() {
	izydata(0);
	$("#butnext").click(function() {
		jumlahhalaman = parseInt($(".jumlahhalaman").text());
		tambahhalaman = parseInt($("#halaman").val()) + 1;
		$("#halaman").val(tambahhalaman);

		if (jumlahhalaman == tambahhalaman) {
			$("#butnext").attr("disabled", "disabled");
			$("#butlast").attr("disabled", "disabled");
			$("#butprev").removeAttr("disabled", "disabled");
			$("#butfirst").removeAttr("disabled", "disabled");
		} else {
			$("#butprev").removeAttr("disabled", "disabled");
			$("#butfirst").removeAttr("disabled", "disabled");
		}
		izydata(1);
		return false;
	});

	$("#butprev").click(function() {
		jumlahhalaman = parseInt($(".jumlahhalaman").text());
		kuranghalaman = parseInt($("#halaman").val()) - 1;
		$("#halaman").val(kuranghalaman);

		if (kuranghalaman == 1) {
			$("#butprev").attr("disabled", "disabled");
			$("#butfirst").attr("disabled", "disabled");
			$("#butnext").removeAttr("disabled", "disabled");
			$("#butlast").removeAttr("disabled", "disabled");
		} else {
			$("#butnext").removeAttr("disabled", "disabled");
			$("#butlast").removeAttr("disabled", "disabled");
		}
		izydata(1);
		return false;
	});

	$("#butfirst").click(function() {
		$("#halaman").val("1");
		$("#butfirst").attr("disabled", "disabled");
		$("#butprev").attr("disabled", "disabled");
		$("#butnext").removeAttr("disabled", "disabled");
		$("#butlast").removeAttr("disabled", "disabled");
		izydata(1);
		return false;
	});

	$("#butlast").click(function() {
		jumlahhalaman = parseInt($(".jumlahhalaman").text());
		$("#halaman").val(jumlahhalaman);
		$("#butnext").attr("disabled", "disabled");
		$("#butlast").attr("disabled", "disabled");
		$("#butfirst").removeAttr("disabled", "disabled");
		$("#butprev").removeAttr("disabled", "disabled");
		izydata(1);
		return false;
	});

	$("#jumlahbaris").change(function() {
		no = $("#jumlahbaris").val();
		izydata(0);
		return false;
	});

});

function izydata(id) {
	var myData = $('#frmpage').serialize();
	
	$.ajax({
		type : "POST",
		url : "{$baseurl}/catproduct/data",
		data : myData,
		datatype : "json",
		beforeSend : function(){
		  $("#loader").fadeIn("fast");
		},
		complete : function(){
		  $("#loader").fadeOut("fast");
		},
		success : function(r) {	
			

			var json = jQuery.parseJSON(r);

			// Heading -- no need heading

			// Data
			$("#tabeldata tbody").html("");
			no = 1;

			if (json.databody != null) {
				$.each(json.databody, function(m, item) {
					var action = '';
					action += ' <a title="Edit" href="javascript:editdata('+item.id+')" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a> ';
					action += ' <a title="Hapus" href="javascript:hapusdata('+item.id+')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a> ';

					var tr1 = '<tr id="baris_'+item.id+'">';
					var field = "";
					field += '<td><input id="check-baris_'+item.id+'" class="check-baris" type="checkbox" value="'+item.id+'"></td>';
					
					field += '<td>'+item.name+'</td>';
					field += '<td>'+item.parentname+'</td>';
					field += '<td style="text-align:right;">'+action+'</td>';
					var tr2 = "</tr>";

					$("#tabeldata tbody").append(tr1 + field + tr2);
					no++;
				});
			}

			if (json.databody == "") {
				$("#tabeldata tbody").append('<tr><td colspan="4" style="text-align:center;">No available data.</td></tr>');
			}

			// Pagination
			$(".jumlahhalaman").html(json.datasetting.jumlahhalaman);
			$("#jumlahdata").html(json.datasetting.jumlahdata);
			if (parseInt(json.datasetting.jumlahhalaman) <= 1 || parseInt(json.datasetting.jumlahhalaman) == parseInt($("#halaman").val())) {
				$("#butnext").attr("disabled", "disabled");
				$("#butlast").attr("disabled", "disabled");
			} else {
				$("#butnext").removeAttr("disabled");
				$("#butlast").removeAttr("disabled");
			}
			if (parseInt($("#halaman").val()) == 1) {
				$("#butprev").attr("disabled", "disabled");
				$("#butfirst").attr("disabled", "disabled");
			} else {
				$("#butprev").removeAttr("disabled");
				$("#butfirst").removeAttr("disabled");
			}
		}
	});
}


function hapusdata(id) {
	var konfirm = confirm('Yakin hapus data ini?');
	if(!konfirm) return;
	$.ajax({
	  type : 'POST',
	  url : '{$baseurl}/catproduct/query-delete',
	  data : {
	    'id' : id
	  },
	  beforeSend : function(){
	    $('#loader').show();
	  },
	  complete : function(){
	    $('#loader').hide();
	  },
	  error : function(response){
	    toastr["error"](response.statusText);
	  },
	  success: function(response){
	    var result = $.trim(response);
		if(response == 'berhasil'){
		  toastr["success"]("Berhasil di hapus.");
		  $('#baris_'+id).slideUp();
		  izydata(1);
		}else{
		  toastr["error"](response);
		}
	  }
	});
}

function tambahdata() {
	ajaxpage('{$baseurl}/catproduct/add', 'Add Category Product');
}

function editdata(id) {
	ajaxpage('{$baseurl}/catproduct/edit/'+id, 'Edit Category Product');
}

</script> 
