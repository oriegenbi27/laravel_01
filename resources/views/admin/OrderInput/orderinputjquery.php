@section('js')

<script type="text/javascript">
$(function() {
    $.post(_base_url+"TelponCS",function(data){
        $("#transaksi-group-telepon").typeahead({ source:data.telepon });
    });
    SumberSelect();
    Provinsiall();
});

$(document).on("show.bs.modal","#modal-popup",function(){
    var e="";
    $('#datatable1').dataTable().fnClearTable();
    $('#datatable1').dataTable().fnDestroy();
    var e = $("#datatable1").DataTable({
        "processing": true,
		"serverSide": true,
        "ordering": true,

		"order": [[ 0, 'asc' ]],
        "ajax":{
        "url":_base_url+"Prodak-dtable",
        "type": "POST",
        },
        "columnDefs": [
            {
                "targets": [7],
                "visible": false
            }],
        "deferRender": true,
        "aLengthMenu": [[10, 50, 100],[ 10, 50, 100]],
        "responsive": true,

    });

    $('#datatable1 tbody').on('dblclick', 'tr', function () {

        let b=e.row((this) ).data();
        if(b !==undefined){
            let code=b[1];
                $("#inputserch").val(code);
                $("#modal-popup").modal("hide");
                detailtable();
        }
    } );

    // Paket
    var ePaket="";
    $('#Paket').dataTable().fnClearTable();
    $('#Paket').dataTable().fnDestroy();
    var ePaket = $("#Paket").DataTable({
        "processing": true,
		"serverSide": true,
        "ordering": true,

		"order": [[ 0, 'asc' ]],
        "ajax":{
        "url":_base_url+"Paket-dtable",
        "type": "POST",
        },
        "columnDefs": [
            {
                "targets": [7],
                "visible": false
            }],
        "deferRender": true,
        "aLengthMenu": [[10, 50, 100],[ 10, 50, 100]],
        "responsive": true,

    });

    $('#Paket tbody').on('dblclick', 'tr', function () {

        let b=ePaket.row((this) ).data();
        if(b !==undefined){
            let code=b[1];
                $("#inputserch").val(code);
                $("#modal-popup").modal("hide");
                detailtable();
        }
    } );
});

$(document).on("submit", "#form-order-input", function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Perhatian..!',
        text: "Apakah Anda Yakin Akan Simpan Data",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Simpan Data'
      }).then((result) => {
        if (result.value) {
          Hxr(this);
        }
      })


});

var itembarang=[];
function Cekitembarang(value,arr){
    var status = 'false';
    for(var i=0; i<arr.length; i++){
      var name = arr[i];
      if(name == value){
        status = 'true';
        break;
      }
    }

    return status;
  }

$(document).on("change","#namapengirim-group",function (e){
    let item=this.value.length;
    if(item >3){
        $.post(_base_url+"HistoryDropsiper",{
            id:this.value
        },function(result){
            $("#teleponpengirim-group").focus();
            $("#teleponpengirim-group").val(result);
        });
    }
});

$(document).on("change","#transaksi-group-telepon",function (e){
    let item=this.value.length;
    if(item >9){
        $.post(_base_url+"HistoryCS",{
            id:this.value
        },function(result){
            $("#transaksi-group-nama").focus();
            $("#transaksi-group-nama").val(result);
        });
    }
});

var berattotal=0;
$(document).on("keyup","#inputserch",function (e){
    detailtable();
});

function detailtable(){
    let result=Cekitembarang($('#inputserch').val(), itembarang);
    let _itembarang=$('#inputserch').val();
    let item=_itembarang.length;

    if(item >3 && result=="false"){
        itembarang.push(_itembarang);
        $.post(_base_url+"DataProdak",{
            id:_itembarang
        },function(e){
            $("#barangdetail").append(e);
            $("#panelexpedisi").css("display","block");
        });
    }
}
// function calcprice(e){ // by QTY

//     let price =$("#pr"+id).val(); ////.data('price');
//     let qty=$("#qty"+id).val();
//     $("#e"+e).val(price*qty);
// }

function calcustomecprice(e){
    let price=$("#"+e).data('price');
    let id=e.substring(3);
    let diskon =$("#dss"+id).val();
    diskon.replace(/[^,\d]/g, '').toString();


    let qty=$("#qty"+id).val();
    let Totalharga=0;

    if($("#cek"+id).is(':checked')){
        Totalharga=(price-diskon)*qty;
    }else{

        if(diskon >=100){

            diskon=Number(diskon);

            Totalharga=(price*qty)-diskon;
        }else{
            Totalharga=(price-(price*diskon/100))*qty;
        }

    }
    let bharga=Totalharga;
    Totalharga=formatRupiah(Totalharga.toString());
    $("#qty"+id).attr("data-etotal",bharga);
    $("#eqty"+id).val(Totalharga);
    $('#biayacos').html('');

    let berat=0;
    let harga=0;
    var formObjects = $("form :input");
        formObjects.each(
        function(){
            if($(this).attr("data-berat")!==undefined){
                berat +=Number($(this).attr("data-berat"))* Number(this.value);
                 harga +=Number($(this).attr("data-etotal"));

            }
        }
        );
        $("#total").val(formatRupiah(harga.toString()) );

}

function removetable(e){
    let code=$("#s"+e).attr("data-code");
    let index=itembarang.indexOf(code);
    if(index >-1){
        itembarang.splice(index,1)
    }
    $("#s"+e).remove();
    calcwight();

}

function Hxr(data){
    $("#loading").modal('show');
    $.ajax({
        type: 'POST',
        url: _base_url+"OrderStore",
        data: new FormData(data),
        processData: false,
        contentType: false,
        success: function(e) {

           if(e.errcode==200){
            Swal.fire('success',e.msg,'success').then((value) => {
                location.reload();
              });

            }else{

                if(e.errcode==401){
                    Swal.fire('Warning',e.msg,'warning').then((result) => {
                        if (result.value) {
                            location.reload();
                          }
                      });

                    }


                if(e.errcode==4400){ location.reload();}else{
                    Swal.fire('Warning',e.msg,'warning') ;}
                    $("#loading").modal("hide");
                }

        }
    });
}

$("#modal-input").on("hidden.bs.modal",function(){
    $("#form-order-input").trigger("reset");
});

function SumberSelect(){
    $.post(_base_url+"SumberOption",function(e){
        $('#sumber').html(e);
        $('#sumber').selectpicker('refresh');
        if(selectsumber !=undefined){
            $("#sumber").val(selectsumber);
            $("#sumber").change();
        }
    });

}
function Provinsiall(){
    $.post(_base_url+"Ongkirprovinsi",function(e){
        $('#provinsi').html(e);
        $('#provinsi').selectpicker('refresh');
        if(selectprovinsi !=undefined){
            $("#provinsi").val(selectprovinsi);
            $("#provinsi").change();
        }
    });
}

$(document).on("change","#provinsi",function (e){
    $('#kota').html('');

    $.post(_base_url+"Ongkirkota",{
        'provinsi':$("#provinsi").val()
        },function(e){
        $('#kota').html(e);
        $('#kota').selectpicker('refresh');

        if(selectkab !=undefined){
            $("#kota").val(selectkab);
            $("#kota").change();
        }
        $('#kecamatan').html('');
        $('#kecamatan').selectpicker('refresh');
    });

});

$(document).on("change","#kota",function (e){
    $('#kecamatan').html('');
    $.post(_base_url+"Ongkecamatan",{
        'kota':$("#kota").val(),
        },function(e){
        $('#kecamatan').html(e);
        $('#kecamatan').selectpicker('refresh');
        if(selectkec !=undefined){
            $("#kecamatan").val(selectkec);
            $("#kecamatan").change();
        }else{
            calcwight();
        }
    });

});

$(document).on("change","#kecamatan",function (e){
    if(selectkec ==undefined){
        $('#Expedisi').val('');
        $('#Expedisi').selectpicker('refresh');
    }
    calcwight();

});

$(document).on("click","#radioCustom1",function (e){
    if($("#provinsi").val()==""|| $("#kota").val()==""|| $("#kecamatan").val()==""){
            alert("Sory Anda belum pilih detail alamat provinsi ,kota , kecamtan dengan benar");
            $("#biayakirim").removeAttr("readonly");
            $("#radioCustom1").prop("checked", false);
            $(".dropsipcm").prop("checked", false);
            estop();
    }

    $('#tipekrim').html('');
    if(this.value==1){
        let brand ='<div class="row">';
            brand +='<div class="form-group col-sm-12">';
            brand +='<div class="form-level">';
            brand +='<label  class="label-material">Pilih Brand</label>';
            brand +='<select name="namakirim"  id="brandtipe" data-style="btn-default" required class="selectpicker" data-width="100%" data-live-search="true">';
            brand +='</select>';
            brand +='</div>';
            brand +='</div>';
            brand +='</div>';
        $.post(_base_url+"Brand-select",function(e){
            $('#tipekrim').html(brand);
            $('#brandtipe').html(e);
            $('#brandtipe').selectpicker('refresh');
            if(namapengirim !=""){
                $("#brandtipe").val(namapengirim);
                $("#brandtipe").change();
            }
        });


    }else{
        let dropsip='<div class="row"></div> <div class="form-group-material">';
            dropsip +='<input id="namapengirim-group" type="text" name="namakirim"  class="input-material">';
            dropsip +='<label for="namapengirim-group" class="label-material active">Nama Pengirim / Toko</label></div>';
            dropsip +='<div class="form-group-material">';
            dropsip +='<input id="teleponpengirim-group" type="text" name="teleponpengirim"  class="input-material">';
            dropsip +='<label for="teleponpengirim-group" class="label-material active">telpon Pengirim</label></div>';
            $('#tipekrim').html(dropsip);

            $.post(_base_url+"dropshipertoko",function(data){
                $("#namapengirim-group").typeahead({ source:data.dropsip});
            });
            if(namapengirim !=""){
                $('#namapengirim-group').val(namapengirim);
                $('#teleponpengirim-group').val(tlppengirim);
            }

    }
});

$(document).on("click","#berjenjang",function (e){
    let html="";
    if($("#provinsi").val()==""|| $("#kota").val()==""|| $("#kecamatan").val()==""){
            alert("Sory Anda belum pilih detail alamat provinsi ,kota , kecamtan dengan benar");
            $(this).prop( "checked", false );
            estop();
    }

    if ($(this).is(':checked')) {
        for(let i=1; i<13; i++){
            html +=' <div class="form-group row no-padding">';
            html +='              <label class="col-sm-3 form-control-label">Kirim '+i+'</label>';
            html +='              <div class="col-sm-9">';
            html +='                <input id="inputHorizontalSuccess" name="jenjang[]" type="text" placeholder="Set Tanggal Kirim" class="form-control form-control-success input-datepicker-autoclose">';
            html +='              </div>';
            html +='            </div>';
        }

            $(".panelberjenjang").html(html);
            $(".input-datepicker-autoclose").datepicker({autoclose:!0,format:"yyyy-mm-dd"});
            $(".panelberjenjang").css('display','block');

        }else{
            $(this).prop( "checked", false );
            $(".panelberjenjang").html(html);
            $(".panelberjenjang").css('display','none');
        }

});

function calcwight(){
$("#biayakirim").val('');
$("#grandtotal").val('');
let expedisi=$("#Expedisi").val();
let checkedotion="";
if($("#provinsi").val()==""|| $("#kota").val()==""|| $("#kecamatan").val()==""){
    alert("Sory Anda belum pilih detail alamat provinsi ,kota , kecamtan dengan benar");
    estop();
}

if(selectexpedisi !="" && expedisi ==selectexpedisi){
        expedisi=selectexpedisi;
        checkedotion=selectexpedisiChoice;
        $("#biayakirim").val(biayakirim);
        $("#grandtotal").val(grandtotal);
       // $("#loading").modal("hide");

}else{
    //$("#loading").modal("show");
}
    let berat=0;
    let harga=0;
    var formObjects = $("form :input");
        formObjects.each(
        function(){
            if($(this).attr("data-berat")!==undefined){
                berat +=Number($(this).attr("data-berat"))* Number(this.value);
                 harga +=Number($(this).attr("data-etotal"));

            }
        }
        );
        $("#total").val(formatRupiah(harga.toString()) );
        if(harga >=500000){
            $(".trpromo").css("display","contents");
        }
    $.post(_base_url+"OngkirCost",{
        'kota':$("#kecamatan").val(),
        'berat':berat,
        'expedisi':expedisi,
        'selected':checkedotion,
        },function(e){
            if(e=="manual"){
                $("#biayacos").html("");
                $("#biayakirim").removeAttr("readonly");
                $("#biayakirim").focus();
            }else{
                $('#biayacos').html(e);
                $("#biayakirim").attr('readonly', 'readonly');
            }
             $("#loading").modal("hide");
    });

}


$(document).on("keyup","#biayakirim",function (e){
    let biaya=this.value;
    let total=$("#total").val();
        total=total.replace(/[^,\d]/g, '').toString();
        biaya=biaya.replace(/[^,\d]/g, '').toString();
    let grandtotal=Number(total)+Number(biaya);

    $("#biayakirim").val(formatRupiah(biaya.toString()) );
    $("#grandtotal").val(formatRupiah(grandtotal.toString()) );
});

$(document).on("keyup","#promo",function (e){
    let grandtotal=$("#grandtotal").val();
        grandtotal=grandtotal.replace(/[^,\d]/g, '').toString();

    $.post(_base_url+"Transaksi/PromoDiskon",{
        'code':$("#promo").val()
        },function(e){
            if(e.err=="001"){
                alert(e.msg);
                $("#dispromo").val('');
            }else{
                $("#dispromo").val(e.nominal);
                let unominal=e.nominal.replace(/[^,\d]/g, '').toString();
                let grands=Number(grandtotal)-Number(unominal);
                    $("#grandtotal").val(grands.toString());

            }

    });

});

function sercivekirim(e){
let biaya=$("#"+e.id).data('price');
let total=$("#total").val();
let promovoucher=$("#dispromo").val();
    promovoucher=promovoucher.replace(/[^,\d]/g, '').toString();
    total=total.replace(/[^,\d]/g, '').toString();
let grandtotal=Number(total)+Number(biaya)-Number(promovoucher);

$("#biayakirim").val(formatRupiah(biaya.toString()) );
$("#grandtotal").val(formatRupiah(grandtotal.toString()) );

}


function formatRupiah(angka){
    if(Number(angka)<0){
        return;
    }
    let prefix="Rp.";
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp.' + rupiah : '');
}
function calcodeunik(e){
    let total=$("#total").val().replace(/[^,\d]/g, '');
    let biaya=$("#biayakirim").val().replace(/[^,\d]/g, '');
    let unik=$("#kodeunik").val();
    let promovoucher=$("#dispromo").val();
        promovoucher=promovoucher.replace(/[^,\d]/g, '');
    let grandtotal=0;
    if(e>0){
        unik=unik.replace(/[^,\d]/g, '');
        grandtotal=Number(total)+Number(biaya)+Number(unik)-Number(promovoucher);
        $("#kodeunik").val(unik);
    }else{
        $("#kodeunik").val("-"+unik);
        grandtotal=(Number(total)+Number(biaya))-Number(unik)-Number(promovoucher);
    }
    $("#grandtotal").val(formatRupiah(grandtotal.toString()));
}


// cadangan

var data = $('#datatable1').DataTable().row('.selected').data();
                data.forEach(function(index) {
                    if (index <= 1){
                        $('#modal-popup').modal('hide');

                        $('#tablelistproduk > tbody').append(

                            '<tr>' +
                            '<td>' + data[1] + '</td>' +
                            '<td>' + data[2] + '</td>' +
                            '<td>' + data[6] + '</td>' +
                            '<td ><input id="txt2"  value="0"   class="form-control" type="number"  name="qty[]"></td>' +
                            '<td ><input id="txt1" value="0"     class="form-control" type="number" name="discon[]"></td>' +
                            '<td ><input id="total" value="0"  class="form-control" type="text"  name="total[]"></td>' +
                            '<td></td>' +
                            '</tr>'


                        );
                    } else {
                        return false;
                    }

                });
</script>
@stop
