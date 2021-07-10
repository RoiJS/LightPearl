$(document).ready(function(){
	
	$('body').delegate('.whole-sale-price-multiple','change',function(){
		id = $(this).attr('idwspm');
		
		var percentage = $.trim($('#frm-update-item' + id + ' .whole-sale-price-increase-multiple').val());
		var wholeSalePrice = $.trim($(this).val());
		
		if(wholeSalePrice != 0){
			if(parseFloat($(this).val()) > 0){
				if(percentage != 0){
					percentage = percentage / 100;
					value = parseFloat(((percentage * parseFloat(wholeSalePrice)) + parseFloat(wholeSalePrice))).toFixed(2);	
				}else{
					value = parseFloat($(this).val().replace(",","")).toFixed(2);
				}
			}else{
				$(this).val('0.00');
				value = '0.00';
			}	
		}else{
			value = '0.00';
		}
		
		console.log(percentage);
		console.log(wholeSalePrice);
		console.log(value);
		
		$('#suggested-retail-price-hidden' + id).html(value);	
		$('#suggested-retail-price' + id).val(value);
		
	});
	
	$('body').delegate('.whole-sale-price-multiple','keyup',function(){
		id = $(this).attr('idwspm');
		
		var percentage = $.trim($('#frm-update-item' + id + ' .whole-sale-price-increase-multiple').val());
		var wholeSalePrice = $.trim($(this).val());
		
		if(wholeSalePrice != 0){
			if(parseFloat($(this).val()) > 0){
				if(percentage != 0){
					percentage = percentage / 100;
					value = parseFloat(((percentage * parseFloat(wholeSalePrice)) + parseFloat(wholeSalePrice))).toFixed(2);	
				}else{
					value = parseFloat($(this).val().replace(",","")).toFixed(2);
				}
			}else{
				$(this).val('0.00');
				value = '0.00';
			}	
		}else{
			value = '0.00';
		}
		
		console.log(percentage);
		console.log(wholeSalePrice);
		console.log(value);
		
		$('#suggested-retail-price-hidden' + id).html(value);	
		$('#suggested-retail-price' + id).val(value);
		
	});
	
	$('body').delegate('.whole-sale-price-increase-multiple','change',function(){
		id = $(this).attr('idwspim');
		percentage = $(this).val();
		wholeSalePrice = $('#whole-sale-price-multiple' + id).val().replace(",","");
		
		if($.trim(wholeSalePrice) != 0){
			if (parseFloat(wholeSalePrice) > 0){
				
				wholeSalePrice = parseFloat(wholeSalePrice);
				
				if($.trim(percentage) != 0){
					if(parseFloat(percentage) > 0){
						percentage = parseFloat(percentage) / 100;
					}else{
						percentage = 0;
					}
				}else{
					percentage = 0;
				}
			}else{
				percentage = 0;
				wholeSalePrice = 0;
				$(this).val('0');
			}
			
		}else{
			percentage = 0;
			wholeSalePrice = 0;
			$(this).val('0');
		}

		suggestedRetailPrice = parseFloat(((percentage * wholeSalePrice) + wholeSalePrice)).toFixed(2);
		$('#suggested-retail-price-hidden' + id).html(suggestedRetailPrice);
		$('#suggested-retail-price' + id).val(suggestedRetailPrice);	
	})
	
	$('body').delegate('.whole-sale-price-increase-multiple','keyup',function(){
		id = $(this).attr('idwspim');
		percentage = $(this).val();
		wholeSalePrice = $('#whole-sale-price-multiple' + id).val().replace(",","");
		
		if($.trim(wholeSalePrice) != 0){
			if (parseFloat(wholeSalePrice) > 0){
				
				wholeSalePrice = parseFloat(wholeSalePrice);
				
				if($.trim(percentage) != 0){
					if(parseFloat(percentage) > 0){
						percentage = parseFloat(percentage) / 100;
					}else{
						percentage = 0;
					}
				}else{
					percentage = 0;
				}
			}else{
				percentage = 0;
				wholeSalePrice = 0;
				$(this).val('0');
			}
			
		}else{
			percentage = 0;
			wholeSalePrice = 0;
			$(this).val('0');
		}

		suggestedRetailPrice = parseFloat(((percentage * wholeSalePrice) + wholeSalePrice)).toFixed(2);
		$('#suggested-retail-price-hidden' + id).html(suggestedRetailPrice);
		$('#suggested-retail-price' + id).val(suggestedRetailPrice);	
	})
	
	$('body').delegate('.btn-save-all-edit-items','click',function(){
		saveUpdateAllSelectedItems();
		location = '?pg=admin&vw=supplies&dir=72275625c8d96d9062889b056513dbc69c029f59&main=item_list';
	});
	
	
	function saveUpdateAllSelectedItems(){
		getItemsID = ajax({getItemsID : 1},true);
		var itemsInfo = jQuery.parseJSON(getItemsID);
		
		for(i = 0 ; i < itemsInfo.length; i++){
			id = itemsInfo[i];
			code = $('#frm-update-item' + id + ' .code').val();
			stocks = $('#frm-update-item' + id + ' .stocks').val(); 
			area_position = $('#frm-update-item' + id + ' .area').val(); 
			supplier = $('#frm-update-item' + id + ' .supplier').val(); 
			description = $('#frm-update-item' + id + ' .description').val(); 
			wholeSalePrice = $('#frm-update-item' + id + ' .whole-sale-price-multiple').val(); 
			wholeSalePriceIncrease = $('#frm-update-item' + id + ' .whole-sale-price-increase-multiple').val();
			srp = $('#frm-update-item' + id + ' .suggested-retail-price').val();
			category = $('#frm-update-item' + id + ' .select-category').val();
			unit = $('#frm-update-item' + id + ' .select-unit').val();
			
			updateMultipleItems = ajax({updateMultipleItems : 1, id : id, code : code , stocks : stocks, area : area_position, supplier : supplier,  description : description , wholeSalePrice : wholeSalePrice , wholeSalePriceIncrease : wholeSalePriceIncrease, srp : srp, category : category, unit : unit , supplier : supplier},true);
		}
	}
	
	
})