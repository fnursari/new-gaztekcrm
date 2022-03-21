$(document).ready(function() {
	$('div.datepicker').datepicker({
		format: 'yyyy-mm-dd',
		language: 'tr'
	});

	$('#ziyaret_firma_ad').select2({
		placeholder: 'Seçiniz'
	});

	$('.phone-number').inputmask({ alias: "phone", "clearIncomplete": true });
	$('.price').inputmask({ 'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': true, 'suffix': ' TL' });

	$(document).on('change','#satis_tipi,#makina_fiyati,#kompresor_fiyati,#fan_fiyati,#ups_fiyati,#kurutucu_fiyati',function() {
		$("#kdv_orani").val($("#satis_tipi").find('option:selected').attr('data-kdv'));
		var makina_fiyati	 = fiyatTemizle($("#makina_fiyati").val());
		console.log(makina_fiyati);
		var kompresor_fiyati = fiyatTemizle($("#kompresor_fiyati").val());
		var fan_fiyati 		 = fiyatTemizle($("#fan_fiyati").val());
		var ups_fiyati 		 = fiyatTemizle($("#ups_fiyati").val());
		var kurutucu_fiyati  = fiyatTemizle($("#kurutucu_fiyati").val());
		var kdv_orani  		 = parseFloat($("#kdv_orani").val());
		var kdvsiz_toplam 	 = 0;
		var kdv 	 		 = 0;
		var genel_toplam 	 = 0;
		if(kdv_orani!="") {
			kdvsiz_toplam = makina_fiyati + kompresor_fiyati + fan_fiyati + ups_fiyati + kurutucu_fiyati; 
			kdv = parseFloat(kdvsiz_toplam * kdv_orani/100);
			genel_toplam = parseFloat(kdvsiz_toplam + kdv);
			$("#kdv").val(kdv);
			$("#genel_toplam").val(genel_toplam);
			$("#pesinat").val(genel_toplam/2);
		}
	})

	$(document).on('change','#vade,#vade_baslangic',function() {
		if($('#vade').val()!="") {
			var d = new Date();
			d.setDate(d.getDate() + parseFloat($('#vade').val()));
			$("#vade_tarihi").val(d.toISOString().slice(0, 10));
		}
		if($('#vade').val()!="" && $('#vade_baslangic').val()!="") {
			var d1 = new Date(d.toISOString().slice(0, 10));
			d1.setDate(d1.getDate() + parseFloat($('#vade_baslangic').val()));
			$("#vade_baslangic_tarihi").val(d1.toISOString().slice(0, 10));
		}
	})

	
	function fiyatTemizle(fiyat) {
		fiyat=fiyat.replace(" TL", "");
		fiyat=fiyat.replace(",", "");
		return noNaN(parseFloat(fiyat));
	}

	function noNaN(n) { 
		return isNaN( n ) ? 0 : n; 
	}


});



//$(":input").inputmask();




function showEdit(editableObj) {
	$(editableObj).css("background","#FFF");
} 

function saveToDatabase(editableObj,column,id,table,table_id_name) {
	$(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
	$.ajax({
		url: "saveedit.php",
		type: "POST",
		data:'column='+column+'&editval='+editableObj.value+'&id='+id+'&table='+table+'&table_id_name='+table_id_name,
		success: function(data){
			$(editableObj).css("background","#FDFDFD");
		}        
	});
}

CKEDITOR.plugins.add("imageuploader",{
	init:function(editor){
		editor.config.filebrowserBrowseUrl='assets/ckeditor/plugins/imageuploader/imgbrowser.php';
	}
});


function editformatla(textboxid, str)
{
	if (str && str.length >= 1)
    {       
    	console.log(str);
      str=trkaraktercevir(str);
		  var firstChar = str.charAt(0);
      var remainingStr = str.slice(1).toLowerCase();
      //str = firstChar.toUpperCase() + remainingStr;
	  str = str.toUpperCase();
	}
	document.getElementById(textboxid).value = (str);
}





function trkaraktercevir(text)
{
	var duzenlenmis =text
	.replace(/Ç/g,"C")
	.replace(/ç/g,"c")
	.replace(/Ð/g,"G")
	.replace(/ð/g,"g")
	.replace(/Ý/g,"I")
	.replace(/ý/g,"i")
	.replace(/Ö/g,"O")
	.replace(/ö/g,"o")
	.replace(/Þ/g,"S")
	.replace(/þ/g,"s")
	.replace(/Ü/g,"U")
	.replace(/ü/g,"u");
	return duzenlenmis;
}  
function capitalize(text) {
    return text.replace(/\b\w/g , function(m){ return m.toUpperCase(); } );
}




function confirmDel() {
	var agree=confirm("Bu kaydı silmek istediğinizden emin misiniz?");
	if (agree) {
		return true ; }
		else {
			return false ;}
		}

		$(".ad").change(function(){
			var id = $(this).attr("id");
			var val = $(this).val();
			document.getElementById("ad_"+id).value = val;

		});        

		$('.edit_lang').on('click', function() {
			var id = $(this).data('id');

			$('#edit_lang_' + id).show();
			$('#view_lang_' + id).hide();
		});

		$('.close_edit').on('click', function() {
			var id = $(this).data('id');
			console.log(id);
			$('#edit_lang_' + id).hide();
			$('#view_lang_' + id).show();
		});

		$('#hesap_ekle').on('click', function() {
			var name = $('#hesap_name').val();
			var url = $('#hesap_url').val();
			console.log(name);
			console.log(url);
			if (name!="" && url!="") {
				$.ajax({
					url: "hesap_ekle_islem.php",
					type: "POST",
					data:'hesap_name='+name+'&hesap_url='+url,
					success: function(data){
						console.log("oldu");
						window.location = 'admin.php?cmd=config_guncelle&result=eklendi'; 
					}        
				});
			}

		});
		$('.hesap_guncelle').on('click', function() {
			var id = $(this).data('id');
			var name = $('#account_name_' + id).val();
			var url = $('#account_url_' + id).val();
			console.log(name);
			console.log(url);
			console.log(id);
			if (name!="" && id!="") {
				$.ajax({
					url: "hesap_guncelle_islem.php?&hesap_id="+id,
					type: "POST",
					data:'account_name='+name+'&account_url='+url,
					success: function(data){
						window.location = 'admin.php?cmd=config_guncelle&result=guncellendi'; 
					}        
				});
			}

		});

		$('.edit_address').on('click', function() {
			var id = $(this).data('id');

			$('#edit_address_' + id).show();
			$('#view_address_' + id).hide();
		});

		$('.close_edit_add').on('click', function() {
			var id = $(this).data('id');
			console.log(id);
			$('#edit_address_' + id).hide();
			$('#view_address_' + id).show();
		});


		function AddressAdd(editableObj,lang) {
			var name = $('#adres_name_' + lang).val();
			var url = $('#adres_content_' + lang).val();
			if (name!="" && url!="") {
				$.ajax({
					url: "adres_ekle_islem.php",
					type: "POST",
					data:'adres_name='+name+'&adres_content='+url+'&lang='+lang,
					success: function(data){
						window.location = 'admin.php?cmd=config_guncelle&result=eklendi'; 
					}        
				});
			}
		}
		function AddressUpdate(editableObj,lang,id) {
			var name = $('#address_name_' + lang+'_'+ id).val();
			var url = $('#address_content_' + lang+'_'+ id).val();
			if (name!="" && id!="") {
				$.ajax({
					url: "adres_guncelle_islem.php?&adres_id="+id,
					type: "POST",
					data:'address_name='+name+'&address_content='+url,
					success: function(data){
						window.location = 'admin.php?cmd=config_guncelle&result=guncellendi'; 
					}        
				});
			}
		}


		$('.state_lang').on('click', function() {
			var clicked = $(this);

			var id = $(this).data('id');
			var state = $(this).attr('id');

			if (state == 0) { state = 1; }
			else { state = 0 }
				$.ajax({
					url: "dil_durum.php",
					type: "POST",
					data:'state='+state+'&id='+id,
					success: function(data){
						if (data == "true") {

							clicked.attr('id', state);
							clicked.removeClass('green-meadow');
							clicked.removeClass('red');

							if (state == 1){
								clicked.addClass('green-meadow');
								clicked.html("Aktif");
							} else {
								clicked.addClass('red');
								clicked.html("Pasif");
							}
						}
					}            
				});
		});

