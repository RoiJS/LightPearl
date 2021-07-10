$(document).ready(function(){
	
	var tblnameForAllItems = "tbl_items";
	var sortOrderForAllItems = "ASC";
	var textDataForAllItems = "";
	var allItemsSelected = [];
	var boxUpdateItemForAllItems = "";
	var boxAddItemForAllItems = "";
	
	var itemsSelectionOptionsForAllItems = 0;
	var itemsSelectionOptionsForAllItemsPerCustomer = 0;
	
	// ============================ Functions for All Items ==================================
	
	showComponents('pagination','.displayAllItems',tblnameForAllItems,"",sortOrderForAllItems,0,textDataForAllItems);
	refreshTotalCapital();

	$(".frm-search-for-all-item").on("submit",function(e){
		e.preventDefault();
		textDataForAllItems = $.trim($(".frm-search-for-all-item .txt-all-items-search-engine").val());
		
		if(textDataForAllItems != 0){
			$(".radio-view-items-with-crucial-stocks").prop("checked",false);
			$(".radio-view-all-items").prop("checked",true);
			showComponents('pagination','.displayAllItems',tblnameForAllItems,"",sortOrderForAllItems,0,textDataForAllItems);
			viewNoOfItemsSearched();
			$('html, body').animate({scrollTop : 300},700);
			
			$(".option-deselect-all-items").addClass("disabled");
			$(".option-select-all-items").removeClass("disabled");
			$(".btn-update-items").addClass("disabled");
			$(".btn-remove-items").addClass("disabled");
			allItemsSelected = [];
			viewNoOfSelectedItems();
		}
	});
	
	$(".btn-refresh-all-items").on("click",function(){
		textDataForAllItems = "";
		allItemsSelected = [];
		$(".option-deselect-all-items").addClass("disabled");
		$(".option-select-all-items").removeClass("disabled");
		$(".btn-update-items").addClass("disabled");
		$(".btn-remove-items").addClass("disabled");
		$(".frm-search-for-all-item .txt-all-items-search-engine").val("");
		$(".radio-view-items-with-crucial-stocks").prop("checked",false);
		$(".radio-view-all-items").prop("checked",true);
		showComponents('pagination','.displayAllItems',tblnameForAllItems,"",sortOrderForAllItems,0,textDataForAllItems);
		viewNoOfSelectedItems();
		viewNoOfItemsSearched();
	});
	
	$(".radio-view-all-items").on("click",function(){
		allItemsSelected = [];
		$(".option-deselect-all-items").addClass("disabled");
		$(".option-select-all-items").removeClass("disabled");
		$(".btn-update-items").addClass("disabled");
		$(".btn-remove-items").addClass("disabled");
		$(".radio-view-items-with-crucial-stocks").prop("checked",false);
		showComponents('pagination','.displayAllItems',tblnameForAllItems,"",sortOrderForAllItems,0,textDataForAllItems);
	});
	
	$(".radio-view-items-with-crucial-stocks").on("click",function(){
		allItemsSelected = [];
		$(".option-deselect-all-items").addClass("disabled");
		$(".option-select-all-items").removeClass("disabled");
		$(".btn-update-items").addClass("disabled");
		$(".btn-remove-items").addClass("disabled");
		$(".radio-view-all-items").prop("checked",false);
		showComponents('pagination','.displayAllItems',tblnameForAllItems,"",sortOrderForAllItems,1,textDataForAllItems);
	});
	
	$("body").delegate(".menu-select-single-item","click",function(){
		itemsSelectionOptionsForAllItems = 0;
		$(".option-select-single-item").addClass("disabled");
		$(".option-select-several-items").removeClass("disabled");
	});
	
	$("body").delegate(".menu-select-several-items","click",function(){
		itemsSelectionOptionsForAllItems = 1;
		$(".option-select-single-item").removeClass("disabled");
		$(".option-select-several-items").addClass("disabled");
	});
	
	$("body").delegate(".all-items","click",function(){
		id = $(this).attr("idai");
		
		if(itemsSelectionOptionsForAllItems == 0){
			
			if($.inArray(id, allItemsSelected) != -1){
				allItemsSelected = [];
				$(".all-items").removeClass("success");	
				viewNoOfSelectedItems();
			}else{
				allItemsSelected = [];
				allItemsSelected.push(id);
				$(".all-items").removeClass("success");
				$("#all-items" + allItemsSelected[0]).addClass("success");
				viewNoOfSelectedItems();
			}
		}else{
			
			if($.inArray(id, allItemsSelected) != -1){
				position = allItemsSelected.indexOf(id);
				allItemsSelected.splice(position,1);
				$("#all-items"+id).removeClass("success");
				viewNoOfSelectedItems();
			}else{
				allItemsSelected.push(id);
				$("#all-items"+id).addClass("success");
				viewNoOfSelectedItems();
			}	
		}
		
		if(allItemsSelected.length > 0){
			$(".btn-update-items").removeClass("disabled");
			$(".btn-remove-items").removeClass("disabled");
			
			$(".option-deselect-all-items").removeClass("disabled");
			
			if($(".all-items").length == allItemsSelected.length){
				$(".option-select-all-items").addClass("disabled");
			}else{
				$(".option-select-all-items").removeClass("disabled");
			}
		}else{
			$(".btn-update-items").addClass("disabled");
			$(".btn-remove-items").addClass("disabled");
			
			$(".option-deselect-all-items").addClass("disabled");
		}
	});
	
	$(".btn-update-items").on("click",function(){
		if(!$(this).attr("class").match(/disabled/i)){
			if(allItemsSelected.length == 1){
				id = allItemsSelected[0];
				itemUpdateInfo = ajax({itemUpdateInfo : 1, id : id},true);
				requestInfo = itemUpdateInfo.split('==');
				boxUpdateItemForAllItems = modalForm(requestInfo[0],requestInfo[1]);
			}else{
				updateAllSelectedItems(allItemsSelected, "updateItemsForAllItems")
			}	
		}
	});
	
	$("body").delegate(".close-update-item-form-for-all-items","click",function(){
		boxUpdateItemForAllItems.modal("hide");
		boxUpdateItemForAllItems = "";
	});
	
	$('body').delegate('.whole-sale-price','change',function(){
		
		var percentage = $.trim($('.whole-sale-price-increase').val());
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
		
		$('.suggested-retail-price-hidden').html(value);	
		$('.suggested-retail-price').val(value);
		
	});
	
	$('body').delegate('.whole-sale-price','keyup',function(){
		
		var percentage = $.trim($('.whole-sale-price-increase').val());
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
		
		$('.suggested-retail-price-hidden').html(value);	
		$('.suggested-retail-price').val(value);
		
	});
	
	$('body').delegate('.whole-sale-price-increase','change',function(){
		percentage = $(this).val();
		wholeSalePrice = $('.whole-sale-price').val();
		
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
		$('.suggested-retail-price-hidden').html(suggestedRetailPrice);
		$('.suggested-retail-price').val(suggestedRetailPrice);	
	})
	
	$('body').delegate('.whole-sale-price-increase','keyup',function(){
		percentage = $(this).val();
		wholeSalePrice = $('.whole-sale-price').val();
		
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
		$('.suggested-retail-price-hidden').html(suggestedRetailPrice);
		$('.suggested-retail-price').val(suggestedRetailPrice);	
	})
	
	$('body').delegate('.frm-update-item','submit',function(e){
		e.preventDefault();
		formdata = new FormData($(this)[0]);
		formdata.append('updateItem',1);
		formdata.append('id',$(this).attr('idfui'));
		
		if(changeVerification()){
			if(validateItemInputs()){
				bootbox.confirm({
					title : "Update item details",
					message : messageBody("question", "Are you sure to update details of the selected item?"),	
					callback : function(result){
						if(result){
							updateItem = ajax(formdata,true,true,'','post');
							boxUpdateItemForAllItems.modal("hide");
							boxUpdateItemForAllItems = "";
							updateSelectedItem();
							refreshTotalCapital();
							$(".menu-deselect-all-items").click();
						}
					}
				});
			}else{
				$('.displayVerificationRespondent span').html("Please fill up all required fields..");
				$('.displayVerificationRespondent').show()
			}	
		}
	})
	
	$(".btn-remove-items").on("click",function(){
		if(!$(this).attr("class").match(/disabled/i)){
			
			itemsCannotRemove = getItemsCannotBeRemoved(allItemsSelected);
			
			if(itemsCannotRemove.length == 0){
				var dialog = bootbox.confirm({
					title : "Remove item details",
					message : messageBody("error", "Removing item details cannot be retrieve again. Do you still want to remove selected item?"),	
					callback : function(result){
						if(result){
							removeItemsSelectedForAllItems = ajax({removeItemsSelected : 1, itemsId : allItemsSelected},true);		
							removeItemFromTheList();
							refreshTotalCapital();	
							$(".menu-deselect-all-items").click();
						}
					}
				});
			}else{
				if(allItemsSelected.length == 1 && itemsCannotRemove.length == 1){
					bootbox.alert({
						title : "Restricted items",
						message : messageBody("warning", "Selected item could not be removed because it exists in transactions list.")
					});
				}else{
					
					if(allItemsSelected.length == itemsCannotRemove.length){
						bootbox.alert({
							title : "Restricted items",
							message : messageBody("warning", "All items you've selected could not be removed because they all exist in the transaction list.")
						});
					}else{
						
						itemDescription = "";
						
						/*for(i = 0; i < itemsCannotRemove.length; i++){
							id = itemsCannotRemove[i];
							
							if(i == itemsCannotRemove.length-1){
								connector = "";
							}else{
								if(i != itemsCannotRemove.length - 2){
									connector = ", ";
								}else{
									connector = " and ";
								}
							}
							
							itemDescription += $("#all-items" + id + " td:nth-of-type(2)").html() + connector;
						}*/
						
						if(itemsCannotRemove.length == 1){
							if(allItemsSelected.length == 2){
								message = "One of the selected item could not be removed because it exists in the transaction list. This item is " + itemDescription + ". Would you still like to remove the other selected item?";
							}else{
								message = "One of the selected item could not be removed because it exists in the transaction list. This item is " + itemDescription + ". Would you still like to remove the other selected items?";
							}
						}else{
							message = "Some of the selected items could not be removed because they exist in the transaction list. Would you still like to remove the other selected items?";
						}
						
						bootbox.confirm({
							title : "Remove item details",
							message : messageBody("question", message),	
							callback : function(result){
								if(result){
									removeItemsSelectedForAllItems = ajax({removeItemsSelected : 1, itemsId : allItemsSelected},true);		
									location.reload();
								}
							}
						});
					}
				}
			}
		}
	});
	
	$(".menu-select-all-items").on("click",function(){
		if($(".all-items").length > 0){
			$(".all-items").each(function(){
				id = $(this).attr("idai");
				if($.inArray(id,allItemsSelected) == -1){
					allItemsSelected.push(id);
				}
			})
			$(".all-items").addClass("success");
			$(".btn-remove-items").removeClass("disabled");
			$(".btn-update-items").removeClass("disabled");
			$(".option-deselect-all-items").removeClass("disabled");
			$(".option-select-all-items").addClass("disabled");	
			
			viewNoOfSelectedItems();
		}else{
			viewNoOfSelectedItems();
		}
	})
	
	$(".menu-deselect-all-items").click(function(e){
		allItemsSelected = [];
		$(".all-items").removeClass("success");
		$(".btn-update-items").addClass("disabled");
		$(".btn-remove-items").addClass("disabled");
		$(".option-deselect-all-items").addClass("disabled");
		$(".option-select-all-items").removeClass("disabled");
		viewNoOfSelectedItems();
	});
	
	$(".menu-sort-item-a-to-z").on("click",function(){
		sortOrderForAllItems = "ASC";
		$(".option-sort-item-a-to-z").addClass("disabled");
		$(".option-sort-item-z-to-a").removeClass("disabled");
		showComponents('pagination','.displayAllItems',tblnameForAllItems,"",sortOrderForAllItems,0,textDataForAllItems);
		
		if(allItemsSelected.length > 0){
			$(".all-items").each(function(){
				id = $(this).attr("idai");
				if($.inArray(id,allItemsSelected)!= -1){
					$("#all-items" + id).addClass("success");
				}
			});
		}
	});
	
	$(".menu-sort-item-z-to-a").on("click",function(){
		sortOrderForAllItems = "DESC";
		$(".option-sort-item-z-to-a").addClass("disabled");
		$(".option-sort-item-a-to-z").removeClass("disabled");
		showComponents('pagination','.displayAllItems',tblnameForAllItems,"",sortOrderForAllItems,0,textDataForAllItems);
		
		if(allItemsSelected.length > 0){
			$(".all-items").each(function(){
				id = $(this).attr("idai");
				if($.inArray(id,allItemsSelected) != -1){
					$("#all-items" + id).addClass("success");
				}
			});
		}
	});
	
	$(".btn-add-items").on("click",function(){
		itemForm = ajax({itemForm : 1},true);
		boxAddItemForAllItems = modalForm('Add item form',itemForm);
	});
	
	$('body').delegate('.close-add-item-form','click',function(){
		boxAddItemForAllItems.modal('hide');
		boxAddItemForAllItems = "";
	});
	
	$('body').delegate('.frm-add-new-item','submit',function(e){
		e.preventDefault();
		formdata = new FormData($(this)[0]);
		formdata.append('saveNewItem',1);
		
		if(validateItemInputs() == true){
			$('.displayVerificationRespondent').hide()
			bootbox.confirm({
				title : "Save new item",
				message : messageBody("question", "Are you sure to save new item details?"),	
				callback : function(result){
					if(result){
						saveNewItem = ajax(formdata,true,true,'Saving new item.','post');
						$(".close-add-item-form").click();
						addNewItemInTheList();
						refreshTotalCapital();
						$(".menu-deselect-all-items").click();

					}
				}
			});
		}else{
			$('.displayVerificationRespondent span').html("Please fill up all required fields..");
			$('.displayVerificationRespondent').show()
		}
	})
	
	$('body').delegate('.file-upload','change',function(){
		file = $(this).val();
		
		if(file != ''){
			formdata = new FormData();
			formdata.append('fileDetails',1);
			formdata.append('file',this.files[0]);
			
			getFileDetails = ajax(formdata,true,'','','post');
			fileDetails = jQuery.parseJSON(getFileDetails);
			$('.display-file-info').show();
			$('.file-name').html(fileDetails[0]);
			$('.file-size').html(fileDetails[1]);
			$('.total-rows').html(fileDetails[2]);
		}else{
			$('.display-file-info').hide();
			$(this).val('');
		}
	});
	
	$(".btn-export-items").on("click",function(){
		
		bootbox.confirm({
			title : "Export item list",
			message : messageBody("question", "Are you sure to export item list?"),	
			callback : function(result){
				if(result){
					e = ajax({exportItemList : 1},true);
					bootbox.alert({
						title : "Exported items",
						message : messageBody("info", "Items has been successfully exported. File has been saved at: " + e), 
						callback : function(){
							location.reload();
						}
					});		
				}
			}
		});
	});
	
	var tblnameForItemsPerCustomer = "tbl_itempricepercustomer";
	var sortOrderForAllItemsPerCustomer = "ASC";
	var textDataForAllItemsPerCustomer = "";
	var customerName = "";
	var itemsPerCustomerSelected = [];
	var boxAddItemsPerCustomer = "";
	var boxUpdateItemsPerCustomer = "";
	
	var tblnameForAllItemsPerCustomerSearch = "tbl_items"
	var sortOrderForAllItemsPerCustomerSearch = "ASC";
	var textDataForAllItemsPerCustomerSearch = "";
	var itemsPerCustomerSelectedSearch = [];
	var itemsPerCustomerOfficialSelected = [];
	var hasAlreadyInitialContent = false;
	
	var itemsPerCustomerOfficialSelectedSelected = [];
	
	removeItemsNotAlreadyExistsInItemsPerCustomer();
	
	//=============================== Functions for Items Per Customer ===================
	
	$(".select-customer").on("submit",function(e){
		e.preventDefault();
		
		customerName = $(".customer-name").val();
		
		if(customerName != ""){
			$(".select-existing-customer").hide();
			$(".display-selected-customer").show();
			customerInfo = ajax({getCustomerInfo : 1, customer_id : customerName},true);
			customerInfo = jQuery.parseJSON(customerInfo);
			name = customerInfo[0].substr(0,30);
			name += customerInfo[0].length > 30 ? '&hellip;' : '';
			$(".selected-customer-name").html(name);
			$(".total-number-of-items").html(customerInfo[1]);
			$(".customer-name-selected").val(customerInfo[0]);
			$(".customer-id-selected").val(customerName);
			$(".btn-add-items-per-customer").removeClass("disabled");
			
			$(".dropdown-toggle-items-per-customer").removeClass("disabled");
			$(".option-deselect-all-items-per-customer").addClass("disabled");
			$(".option-select-all-items-per-customers").removeClass("disabled");
			$(".option-sort-items-per-customer-z-to-a").removeClass("disabled");
			$(".option-sort-items-per-customer-a-to-z").addClass("disabled");
			
			$(".search-option-items-per-customer").show();
			$(".frm-search-item-per-customer .txt-all-items-search-engine").val("");
			
			showComponents('pagination','.displayItemsPerCsutomer',tblnameForItemsPerCustomer, "",sortOrderForAllItemsPerCustomer, customerName, textDataForAllItemsPerCustomer);	
			
			$('html, body').animate({scrollTop : 300},700);
		}
	});
	
	$(".btn-select-other-customer").on("click",function(){
		itemsPerCustomerSelected = [];
		$(".select-existing-customer").show();
		$(".display-selected-customer").hide();
		$(".displayItemsPerCsutomer").html("");
		$(".btn-add-items-per-customer").addClass("disabled");
		$(".btn-update-items-per-customer").addClass("disabled");
		$(".btn-remove-items-per-customer").addClass("disabled");
		$(".dropdown-toggle-items-per-customer").addClass("disabled");
		$(".option-deselect-all-items-per-customer").addClass("disabled");
		$(".option-select-all-items-per-customers").removeClass("disabled");
		$(".option-sort-items-per-customer-z-to-a").removeClass("disabled");
		$(".option-sort-items-per-customer-a-to-z").addClass("disabled");
		$(".search-option-items-per-customer").hide();
	});
	
	$("body").delegate(".menu-select-single-item-per-customer","click",function(){
		itemsSelectionOptionsForAllItemsPerCustomer = 0;
		$(".option-select-single-item-per-customer").addClass("disabled");
		$(".option-select-several-items-per-customer").removeClass("disabled");
	});
	
	$("body").delegate(".menu-select-several-items-per-customer","click",function(){
		itemsSelectionOptionsForAllItemsPerCustomer = 1;
		$(".option-select-single-item-per-customer").removeClass("disabled");
		$(".option-select-several-items-per-customer").addClass("disabled");
	});
	
	$("body").delegate(".all-items-per-customer","click",function(){
		id = $(this).attr("idaipc");
		
		if(itemsSelectionOptionsForAllItemsPerCustomer == 0){
			
			if($.inArray(id, itemsPerCustomerSelected) != -1){
				itemsPerCustomerSelected = [];
				$(".all-items-per-customer").removeClass("success");	
			}else{
				itemsPerCustomerSelected = [];
				itemsPerCustomerSelected.push(id);
				$(".all-items-per-customer").removeClass("success");
				$("#all-items-per-customer" + itemsPerCustomerSelected[0]).addClass("success");
			}
		}else{
			
			if($.inArray(id, itemsPerCustomerSelected) != -1){
				position = itemsPerCustomerSelected.indexOf(id);
				itemsPerCustomerSelected.splice(position,1);
				$("#all-items-per-customer"+id).removeClass("success");
			}else{
				itemsPerCustomerSelected.push(id);
				$("#all-items-per-customer"+id).addClass("success");
			}	
		}

		if(itemsPerCustomerSelected.length > 0){
			$(".btn-update-items-per-customer").removeClass("disabled");
			$(".btn-remove-items-per-customer").removeClass("disabled");
			
			$(".option-deselect-all-items-per-customer").removeClass("disabled");
			
			if($(".all-items-per-customer").length == itemsPerCustomerSelected.length){
				$(".option-select-all-items-per-customers").addClass("disabled");
			}else{
				$(".option-select-all-items-per-customers").removeClass("disabled");
			}
		}else{
			$(".btn-update-items-per-customer").addClass("disabled");
			$(".btn-remove-items-per-customer").addClass("disabled");
			
			$(".option-deselect-all-items-per-customer").addClass("disabled");
		}
	});
	
	$("body").delegate(".menu-select-all-items-per-customer","click",function(e){
		
		if($(".all-items-per-customer").length > 0){
			$(".all-items-per-customer").each(function(){
				id = $(this).attr("idaipc");
				if($.inArray(id,itemsPerCustomerSelected) == -1){
					itemsPerCustomerSelected.push(id);
				}
			})
			$(".all-items-per-customer").addClass("success");
			$(".btn-update-items-per-customer").removeClass("disabled");
			$(".btn-remove-items-per-customer").removeClass("disabled");
			$(".option-deselect-all-items-per-customer").removeClass("disabled");
			$(".option-select-all-items-per-customers").addClass("disabled");	
		}
	});
	
	$("body").delegate(".menu-deselect-all-items-per-customer","click",function(e){
		itemsPerCustomerSelected = [];
		$(".all-items-per-customer").removeClass("success");
		$(".btn-update-items-per-customer").addClass("disabled");
		$(".btn-remove-items-per-customer").addClass("disabled");
		$(".option-deselect-all-items-per-customer").addClass("disabled");
		$(".option-select-all-items-per-customers").removeClass("disabled");
	})
	
	$("body").delegate(".menu-sort-items-per-customer-a-to-z","click",function(){
		sortOrderForAllItemsPerCustomer = "ASC";
		$(".option-sort-items-per-customer-z-to-a").removeClass("disabled");
		$(".option-sort-items-per-customer-a-to-z").addClass("disabled");
		
		showComponents('pagination','.displayItemsPerCsutomer',tblnameForItemsPerCustomer, "",sortOrderForAllItemsPerCustomer, customerName, textDataForAllItemsPerCustomer);	
		
		if(itemsPerCustomerSelected.length > 0){
			$(".all-items-per-customer").each(function(){
				id = $(this).attr("idaipcs");
				if($.inArray(id,itemsPerCustomerSelected) != -1){
					$("#all-items-per-customer" + id).addClass("success");
				}
			});
		}
	});
	
	$("body").delegate(".menu-sort-items-per-customer-z-to-a","click",function(){
		sortOrderForAllItemsPerCustomer = "DESC";
		$(".option-sort-items-per-customer-z-to-a").addClass("disabled");
		$(".option-sort-items-per-customer-a-to-z").removeClass("disabled");
		showComponents('pagination','.displayItemsPerCsutomer',tblnameForItemsPerCustomer, "",sortOrderForAllItemsPerCustomer, customerName, textDataForAllItemsPerCustomer);	
		
		if(itemsPerCustomerSelected.length > 0){
			$(".all-items-per-customer").each(function(){
				id = $(this).attr("idaipc");
				if($.inArray(id,itemsPerCustomerSelected) != -1){
					$("#all-items-per-customer" + id).addClass("success");
				}
			});
		}
	});
	
	$(".btn-add-items-per-customer").on("click",function(){
		if(!$(this).attr("class").match(/disabled/i)){
			getBoxAddItemsPerCustomer = ajax({boxAddItemsPerCustomer : 1},true);
			itemsPerCustomerSelectedSearch = [];
			itemsPerCustomerOfficialSelected = [];
			textDataForAllItems = "";
			sortOrderForAllItems = "ASC";
			boxAddItemsPerCustomer = modalForm("Select Items",getBoxAddItemsPerCustomer);
			showComponents('pagination','.displayAllItemsPerCustomerSearched',tblnameForAllItemsPerCustomerSearch,"",sortOrderForAllItemsPerCustomerSearch,2,textDataForAllItemsPerCustomerSearch);	
		}
	});
	
	$("body").delegate(".close-add-item-form-per-customer","click",function(){
		object = itemsPerCustomerOfficialSelected.length > 0 ? "item" : "items";
		if(itemsPerCustomerOfficialSelected.length > 0){
			bootbox.confirm({
				title : "Cancel selection of items",
				message : messageBody("warning", "Are you sure to cancel selection of " + object + "?"),	
				callback : function(result){
					if(result){
						boxAddItemsPerCustomer.modal("hide");
						boxAddItemsPerCustomer = "";
					}
				}
			});
		}else{
			boxAddItemsPerCustomer.modal("hide");
			boxAddItemsPerCustomer = "";
		}
	});

	$("body").delegate(".frm-search-for-all-items-per-customer-search","submit",function(e){
		e.preventDefault();
		textDataForAllItemsPerCustomerSearch = $.trim($(".txt-search-item").val());
		
		if(textDataForAllItemsPerCustomerSearch != 0){
			showComponents('pagination','.displayAllItemsPerCustomerSearched',tblnameForAllItemsPerCustomerSearch,"",sortOrderForAllItemsPerCustomerSearch,2,textDataForAllItemsPerCustomerSearch);
			
			itemsPerCustomerSelectedSearch = [];
			$(".btn-remove-selected-items").addClass("disabled");
			$(".btn-update-selected-items").addClass("disabled");
			$(".btn-add-selected-items").addClass("disabled");
			$(".option-select-all-items-per-customers-search").removeClass("disabled");
			$(".option-deselect-all-items-per-customer-search").addClass("disabled");
			$(".option-sort-items-per-customer-a-to-z-search").addClass("disabled");
			$(".option-sort-items-per-customer-z-to-a-search").removeClass("disabled");
			
		}
	});
	
	$("body").delegate(".btn-refresh-all-items-per-customer-search","click",function(){
		textDataForAllItemsPerCustomerSearch = "";
		$(".txt-search-item").val("")
		showComponents('pagination','.displayAllItemsPerCustomerSearched',tblnameForAllItemsPerCustomerSearch,"",sortOrderForAllItemsPerCustomerSearch,2,textDataForAllItemsPerCustomerSearch);
		
		itemsPerCustomerSelectedSearch = [];
		$(".btn-remove-selected-items").addClass("disabled");
		$(".btn-update-selected-items").addClass("disabled");
		$(".option-select-all-items-per-customers-search").removeClass("disabled");
		$(".option-deselect-all-items-per-customer-search").addClass("disabled");
		$(".option-sort-items-per-customer-a-to-z-search").addClass("disabled");
		$(".option-sort-items-per-customer-z-to-a-search").removeClass("disabled");
		
	});
	
	$("body").delegate(".all-items-per-customer-search","click",function(){
		id = $(this).attr("idaipcs");
		
		if($.inArray(id,itemsPerCustomerSelectedSearch) != -1){
			index = itemsPerCustomerSelectedSearch.indexOf(id);
			itemsPerCustomerSelectedSearch.splice(index,1);
			
			$("#all-items-per-customer-search"+id).removeClass("success");
		}else{
			if(!verifiIfExistsInTheOfficialItemList(id)){
				if($.inArray(id, itemsPerCustomerOfficialSelected) != -1){
					bootbox.alert({
						title : "Items exist",
						message : messageBody("warning", "Selected item is already on the list.")
					});
				}else{
					itemsPerCustomerSelectedSearch.push(id);
					$("#all-items-per-customer-search"+id).addClass("success");	
				}	
			}else{
				bootbox.alert({
					title : "Items exist",
					message : messageBody("warning", "Selected item already exist in customer's official item list.")
				});
			}
		}
		
		if(itemsPerCustomerSelectedSearch.length > 0){
			$(".btn-add-selected-items").removeClass("disabled");
			
			$(".option-deselect-all-items-per-customer-search").removeClass("disabled");
			
			if($(".all-items").length == itemsPerCustomerSelectedSearch.length){
				$(".option-select-all-items-per-customers-search").addClass("disabled");
			}else{
				$(".option-select-all-items-per-customers-search").removeClass("disabled");
			}
		}else{
			$(".btn-add-selected-items").addClass("disabled");
			
			$(".option-deselect-all-items-per-customer-search").addClass("disabled");
		}
		
	});
	
	$("body").delegate(".menu-select-all-items-per-customer-search","click",function(e){
		
		if($(".all-items-per-customer-search").length > 0){
			$(".all-items-per-customer-search").each(function(){
				id = $(this).attr("idaipcs");
				if($.inArray(id,itemsPerCustomerSelectedSearch) == -1){
					itemsPerCustomerSelectedSearch.push(id);
				}
			})
			$(".all-items-per-customer-search").addClass("success");
			$(".btn-add-selected-items").removeClass("disabled");
			$(".option-deselect-all-items-per-customer-search").removeClass("disabled");
			$(".option-select-all-items-per-customers-search").addClass("disabled");	
		}
	});
	
	$("body").delegate(".menu-deselect-all-items-per-customer-search","click",function(e){
		itemsPerCustomerSelectedSearch = [];
		$(".all-items-per-customer-search").removeClass("success");
		$(".btn-add-selected-items").addClass("disabled");
		$(".option-deselect-all-items-per-customer-search").addClass("disabled");
		$(".option-select-all-items-per-customers-search").removeClass("disabled");
	})
	
	$("body").delegate(".menu-sort-items-per-customer-a-to-z-search","click",function(){
		sortOrderForAllItemsPerCustomerSearch = "ASC";
		$(".option-sort-items-per-customer-z-to-a-search").removeClass("disabled");
		$(".option-sort-items-per-customer-a-to-z-search").addClass("disabled");
		showComponents('pagination','.displayAllItemsPerCustomerSearched',tblnameForAllItemsPerCustomerSearch,"",sortOrderForAllItemsPerCustomerSearch,2,textDataForAllItemsPerCustomerSearch);
		
		if(itemsPerCustomerSelectedSearch.length > 0){
			$(".all-items-per-customer-search").each(function(){
				id = $(this).attr("idaipcs");
				if($.inArray(id,itemsPerCustomerSelectedSearch) != -1){
					$("#all-items-per-customer-search" + id).addClass("success");
				}
			});
		}
	});
	
	$("body").delegate(".menu-sort-items-per-customer-z-to-a-search","click",function(){
		sortOrderForAllItemsPerCustomerSearch = "DESC";
		$(".option-sort-items-per-customer-z-to-a-search").addClass("disabled");
		$(".option-sort-items-per-customer-a-to-z-search").removeClass("disabled");
		showComponents('pagination','.displayAllItemsPerCustomerSearched',tblnameForAllItemsPerCustomerSearch,"",sortOrderForAllItemsPerCustomerSearch,2,textDataForAllItemsPerCustomerSearch);
		
		if(itemsPerCustomerSelectedSearch.length > 0){
			$(".all-items-per-customer-search").each(function(){
				id = $(this).attr("idaipcs");
				if($.inArray(id,itemsPerCustomerSelectedSearch) != -1){
					$("#all-items-per-customer-search" + id).addClass("success");
				}
			});
		}
	});
	
	
	$("body").delegate(".btn-update-items-per-customer","click",function(){
		
		supermaincontainer = $("<div>").attr({"class" : "row"});
		supercontainer = $("<div>").attr({"class" : "span6"});
		
		maincontainer = $("<div>").attr({"class" : "row"});
		container = $("<div>").attr({"class" : "span6"});
		
		smaincontainer = $("<div>").attr({"class" : "row"});
		scontainer = $("<div>").attr({"class" : "span6"});
		
		hr = $("<hr>");
		box = $("<div>").attr({"class" : "box mainform"});
		boxContent = $("<div>").attr({"class" : "box-content"});
		
		divRow = $("<div>").attr({"class" : "row"});
		divSpan = $("<div>").attr({"class" : "span6"});
		
		updateTable = $("<table>").attr({"class" : "table table-hover table-striped"}).css({"width" : "100%"});
		
		for(i in itemsPerCustomerSelected){
			
			tr = $("<tr>").attr({"class" : "update-items-per-customer", "id" : "update-items-per-customer" + itemsPerCustomerSelected[i], "iduipc" : itemsPerCustomerSelected[i]});
			
			td1 = $("<td>").css({"width" : "70%"}).html($("#all-items-per-customer" + itemsPerCustomerSelected[i] + " td:nth-of-type(3)").html());
			
			inputPrice = $("<input />").attr({"class" : "item-price", "type" : "number", "min" : 0, "step" : 0.01}).val($("#all-items-per-customer" + itemsPerCustomerSelected[i] + " td:nth-of-type(4)").html()).css({"width" : "90%"});
			
			td2 = $("<td>").css({"width" : "30%"}).append(inputPrice);
			
			container.append(updateTable.append(tr.append(td1, td2)));
			
		}
		
		
		closeButton = $("<button>").attr({"class" : "btn btn-warning btn-close-update-form-items-per-customer"}).css({"float" : "right"}).html("Close");
		
		saveButton = $("<button>").attr({"class" : "btn btn-primary btn-save-update-form-items-per-customer"}).css({"float" : "right", "margin-right" : "10px"}).html("Save");
	
		smaincontainer.append(scontainer.append(closeButton, saveButton));
		maincontainer.append(container);
		
		supermaincontainer.append(supercontainer.append(maincontainer, hr, smaincontainer));
		boxUpdateItemsPerCustomer = modalForm("Update item price",supermaincontainer);
	});
	
	$("body").delegate(".btn-close-update-form-items-per-customer","click",function(){
		boxUpdateItemsPerCustomer.modal("hide");
		boxUpdateItemsPerCustomer = "";
	});
	
	$("body").delegate(".btn-save-update-form-items-per-customer","click",function(){
		bootbox.confirm({
			title : "Update item price",
			message : messageBody("question", "Are you sure to update item price?"),	
			callback : function(result){
				if(result){
					itemsInfo = [];
					$(".update-items-per-customer").each(function(){
						id = $(this).attr("iduipc");
						price = $("#update-items-per-customer" + id + " input.item-price").val();
						itemsInfo.push([id,price]);
					});
					
					updateItemPrice = ajax({updateItemPrice : 1, itemsInfo : itemsInfo, customerId : $(".customer-id-selected").val()},true);
					
					itemsPerCustomerSelected = [];
					$(".option-deselect-all-items-per-customer").addClass("disabled");
					$(".option-select-all-items-per-customers").removeClass("disabled");
					$(".option-sort-items-per-customer-z-to-a").removeClass("disabled");
					$(".option-sort-items-per-customer-a-to-z").addClass("disabled");
					$(".btn-update-items-per-customer").addClass("disabled");
					$(".btn-remove-items-per-customer").addClass("disabled");
				
					showComponents('pagination','.displayItemsPerCsutomer',tblnameForItemsPerCustomer, "",sortOrderForAllItemsPerCustomer, customerName, textDataForAllItemsPerCustomer);
					boxUpdateItemsPerCustomer.modal("hide");
				}
			}
		});
	});
	
	$(".frm-search-item-per-customer").on("submit",function(e){
		e.preventDefault();
		textDataForAllItemsPerCustomer = $.trim($(".txt-items-per-customer-search-engine", this).val());
		
		if(textDataForAllItemsPerCustomer != 0){
			itemsPerCustomerSelected = [];
			$(".option-deselect-all-items-per-customer").addClass("disabled");
			$(".option-select-all-items-per-customers").removeClass("disabled");
			$(".option-sort-items-per-customer-z-to-a").removeClass("disabled");
			$(".option-sort-items-per-customer-a-to-z").addClass("disabled");
			$(".btn-update-items-per-customer").addClass("disabled");
			$(".btn-remove-items-per-customer").addClass("disabled");
			showComponents('pagination','.displayItemsPerCsutomer',tblnameForItemsPerCustomer, "",sortOrderForAllItemsPerCustomer, customerName, textDataForAllItemsPerCustomer);
		}
	});
	
	$("body").delegate(".btn-refresh-items-per-customer","click",function(){
		textDataForAllItemsPerCustomer = "";
		$(".frm-search-item-per-customer .txt-items-per-customer-search-engine").val("");
		
		showComponents('pagination','.displayItemsPerCsutomer',tblnameForItemsPerCustomer, "",sortOrderForAllItemsPerCustomer, customerName, textDataForAllItemsPerCustomer);
	});
	
	$("body").delegate(".btn-remove-items-per-customer","click",function(){
		bootbox.confirm({
			title : "Remove item details",
			message : messageBody("error", "Removing item details cannot be retrieve again. Do you still want to remove selected item?"),	
			callback : function(result){
				if(result){
					removeSelectedItems = ajax({removeSelectedItems : 1, itemsId : itemsPerCustomerSelected, customerId : $(".customer-id-selected").val()},true);
					
					itemsPerCustomerSelected = [];
					$(".option-deselect-all-items-per-customer").addClass("disabled");
					$(".option-select-all-items-per-customers").removeClass("disabled");
					$(".option-sort-items-per-customer-z-to-a").removeClass("disabled");
					$(".option-sort-items-per-customer-a-to-z").addClass("disabled");
					$(".btn-update-items-per-customer").addClass("disabled");
					$(".btn-remove-items-per-customer").addClass("disabled");
				
					showComponents('pagination','.displayItemsPerCsutomer',tblnameForItemsPerCustomer, "",sortOrderForAllItemsPerCustomer, customerName, textDataForAllItemsPerCustomer);
					
					updateNoOfItemsPerCustomerStatus();		
				}
			}
		});
	});
	
	$("body").delegate(".btn-add-selected-items","click",function(){
		if(!$(this).attr("class").match(/disabled/i)){
			
			itemsPerCustomerOfficialSelected = itemsPerCustomerOfficialSelected.concat(itemsPerCustomerSelectedSearch);
			
			itemsPerCustomerSelectedSearch = [];
			$(".btn-add-selected-items").addClass("disabled");
			$(".all-items-per-customer-search").removeClass("success");
			displayNumberOfSeletedItems();
			
			count = itemsPerCustomerOfficialSelected.length;
			if(count != 0){
				if(!hasAlreadyInitialContent){
					td = "";
					for(i in itemsPerCustomerOfficialSelected){
						td += "<tr class='official-selected-items-per-customer' id='official-selected-items-per-customer" + itemsPerCustomerOfficialSelected[i] + "' idosipc='" + itemsPerCustomerOfficialSelected[i] + "'>" +
									"<td>" +  $("tr#all-items-per-customer-search" + itemsPerCustomerOfficialSelected[i] + " td:nth-of-type(2)").html() + "</td>" + 
									"<td>" + 
										"<input type='text' value='" + $("tr#all-items-per-customer-search" + itemsPerCustomerOfficialSelected[i] + " td:nth-of-type(3)").html() + "' class='span2 items-per-customer-new-item-price' />" + "</td>" +
							   "</tr>";
					}
					
					$(".displayItemsSelected").html(td);
					hasAlreadyInitialContent = true;
				}else{
					for(i in itemsPerCustomerOfficialSelected){
						
						if($("#official-selected-items-per-customer" + itemsPerCustomerOfficialSelected[i]).length == 0){
							
							td = "<tr class='official-selected-items-per-customer' id='official-selected-items-per-customer" + itemsPerCustomerOfficialSelected[i] + "' idosipc='" + itemsPerCustomerOfficialSelected[i] + "'>" +
									"<td>" +  $("tr#all-items-per-customer-search" + itemsPerCustomerOfficialSelected[i] + " td:nth-of-type(2)").html() + "</td>" + 
									"<td>" + 
										"<input type='text' value='" + $("tr#all-items-per-customer-search" + itemsPerCustomerOfficialSelected[i] + " td:nth-of-type(3)").html() + "' class='span2 items-per-customer-new-item-price' />" + "</td>" +
							   "</tr>";
							   
							$(".displayItemsSelected").append(td);
						}
					}
				}
				
			}
		}
	});
	
	$("body").delegate(".official-selected-items-per-customer","click",function(){
		id = $(this).attr("idosipc");
		
		if($.inArray(id,itemsPerCustomerOfficialSelectedSelected) != -1){
			index = itemsPerCustomerOfficialSelectedSelected.indexOf(id);
			itemsPerCustomerOfficialSelectedSelected.splice(index,1);
			
			$("#official-selected-items-per-customer"+id).removeClass("success");
		}else{
			itemsPerCustomerOfficialSelectedSelected.push(id);
			$("#official-selected-items-per-customer"+id).addClass("success");	
		}
		
		if(itemsPerCustomerOfficialSelectedSelected.length > 0){
			$(".btn-remove-selected-items").removeClass("disabled");
		}else{
			$(".btn-remove-selected-items").addClass("disabled");
		}
	});
	
	$("body").delegate(".btn-remove-selected-items","click",function(){
		if(!$(this).attr("class").match(/disabled/i)){
			object = itemsPerCustomerOfficialSelected.length > 0 ? "item" : "items";
			var dialog = bootbox.confirm({
				title : "Remove item details",
				message :  messageBody("error", "Removing item details cannot be retrieve again. Do you still want to remove selected " + object + "?"),	
				callback : function(result){
					if(result){
						for(i in itemsPerCustomerOfficialSelectedSelected){
							$("#official-selected-items-per-customer" + itemsPerCustomerOfficialSelectedSelected[i]).remove();
							itemsPerCustomerOfficialSelected.splice(itemsPerCustomerOfficialSelected.indexOf(id),1);
						}
						$(".btn-remove-selected-items").addClass("disabled");
						displayNumberOfSeletedItems();		
					}
				}
			});
		}
	});
	
	$("body").delegate(".btn-save-selected-items-per-customer","click",function(){
		if(itemsPerCustomerOfficialSelected.length > 0){
			bootbox.confirm({
				title : "Save selected items",
				message : messageBody("question", "Are you sure to save selected items?"),	
				callback : function(result){
					if(result){
						itemData = [];
						$(".official-selected-items-per-customer").each(function(){
							id = $(this).attr("idosipc");
							price = $("#official-selected-items-per-customer" + id + " input.items-per-customer-new-item-price").val();
							itemData.push([id,price]); 
						});
						customer_id = $(".customer-id-selected").val();
						saveSelectedItemsPerCustomer = ajax({saveSelectedItemsPerCustomer : 1, itemData : itemData, customer_id : customer_id},true);
						showComponents('pagination','.displayItemsPerCsutomer',tblnameForItemsPerCustomer, "",sortOrderForAllItemsPerCustomer, customerName, textDataForAllItemsPerCustomer);
						boxAddItemsPerCustomer.modal("hide");
						updateNoOfItemsPerCustomerStatus();		
					}
				}
			});
		}
	})
	
	// Set Shortcut Keys :D
	
	$.Shortcuts.add({
		type: 'down',
		mask: 'F9',
		enableInInput: true,
		handler: function() {
			if(boxAddItemForAllItems == ""){
				$(".btn-add-items").click();
			}
			
			if(boxAddItemsPerCustomer == ""){
				$(".btn-add-items-per-customer").click();
			}
		}
	});
	
	$.Shortcuts.add({
		type: 'down',
		mask: 'F10',
		enableInInput: true,
		handler: function() {
			if(boxUpdateItemForAllItems == "")
				$(".btn-update-items").click();
			
			if(boxUpdateItemsPerCustomer == "")
				$(".btn-update-items-per-customer").click();
		}
	});
	
	$.Shortcuts.add({
		type: 'down',
		mask: 'F11',
		enableInInput: true,
		handler: function() {
			$(".btn-remove-items").click();
		}
	});
	
	$.Shortcuts.add({
		type: 'down',
		mask: 'Ctrl+S',
		enableInInput: true,
		handler: function() {
			$("#search-items").focus();
			$("#search-items").select();
		}
	});
	
	$.Shortcuts.add({
		type: 'down',
		mask: 'Ctrl+E',
		enableInInput: true,
		handler: function() {
			$("#code").focus();
		}
	});
	
	$.Shortcuts.start();
	// ========================= Functions list ========================================
	
	function getItemsCannotBeRemoved(itemsId){
		getItem = ajax({getItemsCannotBeRemoved : 1, itemsId : itemsId},true);
		return jQuery.parseJSON(getItem);
	}
	
	function updateAllSelectedItems(itemsId, view){
		updateItems = ajax({updateItems : 1, itemsId : itemsId},true);
		if(updateItems) location = "?pg=admin&vw=" + view + "&dir=72275625c8d96d9062889b056513dbc69c029f59";
	}
	
	
	function validateItemInputs(){
		
		code = $.trim($('.code').val());
		stocks = $.trim($('.stocks').val());
		area_position = $.trim($('.area').val());
		supplier = $.trim($('.supplier').val());
		description = $.trim($('.description').val());
		WSP = $.trim($('.whole-sale-price').val());
		unit_id = $('.select-unit').val();
		
		if(code != 0){
			hasCode = true
			$('.code').removeClass('no-input');
			
			$('.input-code').hide();
			$('.input-code-success').show();
			$('.input-code-failed').hide();
			
		}else{
			hasCode = false;
			$('.code').addClass('no-input');
			
			$('.input-code').hide();
			$('.input-code-success').hide();
			$('.input-code-failed').show();
		}
		
		if(stocks != 0){
			hasStocks = true;
			$('.stocks').removeClass('no-input');
			
			$('.input-stocks').hide();
			$('.input-stocks-success').show();
			$('.input-stocks-failed').hide();
		}else{
			hasStocks = false;
			$('.stocks').addClass('no-input');
			
			$('.input-stocks').hide();
			$('.input-stocks-success').hide();
			$('.input-stocks-failed').show();
		}
		
		if(area_position != 0){
			hasArea = true;
			$('.area').removeClass('no-input');
			
			$('.input-area').hide();
			$('.input-area-success').show();
			$('.input-area-failed').hide();
		}else{
			hasArea = false;
			$('.area').addClass('no-input');
			
			$('.input-area').hide();
			$('.input-area-success').hide();
			$('.input-area-failed').show();
		}
		
		if(supplier != 0){
			hasSupplier = true;
			$('.supplier').removeClass('no-input');
			
			$('.input-supplier').hide();
			$('.input-supplier-success').show();
			$('.input-supplier-failed').hide();
		}else{
			hasSupplier = false;
			$('.supplier').addClass('no-input');
			
			$('.input-supplier').hide();
			$('.input-supplier-success').hide();
			$('.input-supplier-failed').show();
		}
		
		if(description != 0){
			hasDescription = true;
			$('.description').removeClass('no-input');
			
			$('.input-description').hide();
			$('.input-description-success').show();
			$('.input-description-failed').hide();
		}else{
			hasDescription = false;
			$('.description').addClass('no-input');
			
			$('.input-description').hide();
			$('.input-description-success').hide();
			$('.input-description-failed').show();
		}
		
		if(WSP != 0){
			hasWSP = true;
			$('.whole-sale-price').removeClass('no-input');
			
			$('.input-whole-sale-price').hide();
			$('.input-whole-sale-price-success').show();
			$('.input-whole-sale-price-failed').hide();
		}else{
			hasWSP = false;
			$('.whole-sale-price').addClass('no-input');
			
			$('.input-whole-sale-price').hide();
			$('.input-whole-sale-price-success').hide();
			$('.input-whole-sale-price-failed').show();
		}
		
		if(unit_id != ''){
			hasUnit_id = true;
			$('.select-unit').removeClass('no-input');
			
			$('.input-unit').hide();
			$('.input-unit-success').show();
			$('.input-unit-failed').hide();
		}else{
			hasUnit_id = false;
			$('.select-unit').addClass('no-input');
			
			$('.input-unit').hide();
			$('.input-unit-success').hide();
			$('.input-unit-failed').show();
		}
		
		if(hasCode == true && hasStocks == true && hasArea == true && hasSupplier == true && hasDescription == true && hasWSP == true){
			return true;
		}else{
			return false;
		}
	}
	
	function changeVerification(){
		
		code = $.trim($('.code').val());
		stocks = $.trim($('.stocks').val());
		description = $.trim($('.description').val());
		WSP = $.trim($('.whole-sale-price').val());
		wholeSalePriceIncrease = $.trim($('.whole-sale-price-increase').val());
		category_id = $('.select-category').val();
		unit_id = $('.select-unit').val();
		supplier_id = $('.select-supplier ').val();
		
		duplicateCode = $.trim($('.duplicate-code').val());
		duplicateStocks = $.trim($('.duplicate-stocks').val());
		duplicateDescription = $.trim($('.duplicate-description').val());
		duplicateWSP = $.trim($('.duplicate-whole-sale-price').val());
		duplicateWholeSalePriceIncrease = $.trim($('.duplicate-whole-sale-price-increase').val());
		duplicateCategory_id = $('.duplicate-category').val();
		duplicateUnit_id = $('.duplicate-unit').val();
		duplicateSupplier_id = $('.duplicate-supplier ').val();
		
		if(code != duplicateCode){
			isCodeChange = true;
		}else{
			isCodeChange = false;
		}
		
		if(stocks != duplicateStocks){
			isStocksChange = true;
		}else{
			isStocksChange = false;
		}
		
		if(description != duplicateDescription){
			isDescriptionChange = true;
		}else{
			isDescriptionChange = false;
		}
		
		if(WSP != duplicateWSP){
			isWholeSalePriceChange = true;
		}else{
			isWholeSalePriceChange = false;
		}
		
		if(wholeSalePriceIncrease != duplicateWholeSalePriceIncrease){
			isWholeSalePriceIncreaseChange = true;
		}else{
			isWholeSalePriceIncreaseChange = false;
		}
		
		if(category_id != duplicateCategory_id){
			isCategoryChange = true;
		}else{
			isCategoryChange = false;
		}
		
		if(unit_id != duplicateUnit_id){
			isUnitChange = true;
		}else{
			isUnitChange =  false;
		}
		
		if(supplier_id != duplicateSupplier_id){
			isSupplierChange = true;
		}else{
			isSupplierChange = false;
		}
		
		if(isCodeChange == true || isStocksChange == true || isDescriptionChange == true || isWholeSalePriceChange == true || isWholeSalePriceIncreaseChange == true || isCategoryChange == true || isUnitChange == true || isSupplierChange == true){
			return true;
		}else{
			return false;
		}
	}
	
	function displayNumberOfSeletedItems(){
		$(".no-of-items-selected").html(itemsPerCustomerOfficialSelected.length);
	}
	
	function verifiIfExistsInTheOfficialItemList(item_id){
		ifExist = false;
		if($("#all-items-per-customer" + id).length != 0){
			ifExist = true;
		}
		return ifExist;
	}
	
	function updateNoOfItemsPerCustomerStatus(){
		$(".total-number-of-items").html($(".all-items-per-customer").length)
	}
	
	function addNewItemInTheList(){
		
		var id = $.trim(ajax({getIdNewITem : 1},true));
		var code = $.trim($('.code').val());
		var stocks = $.trim($('.stocks').val());
		var description = $.trim($('.description').val());
		var WSP = $.trim($('.whole-sale-price').val());
		var wholeSalePriceIncrease = $.trim($('.whole-sale-price-increase').val());
		var category_id = $('.select-category').val();
		var unit = $('.select-unit').val();
		var supplier = $('.supplier').val(); 
		var srp = $('.suggested-retail-price').val(); 
		var area_position = $.trim($('.area').val());
	
		var list_temp = '<tr class="all-items" id="all-items' + id + '" idai="' + id + '">' +
							'<td style="width:300px;text-align:center;">' + unit + '</td>' +
							'<td style="width:300px;text-align:center;">' + code +'</td>' +
							'<td style="width:300px;text-align:center;">' + description +'</td>' +
							'<td style="width:300px;text-align:center;">' + number_format(parseFloat(WSP),2,".",",") +'</td>' +
							'<td style="width:300px;text-align:center;">' + number_format(parseFloat(srp),2,".",",") +'</td>' +
							'<td style="width:300px;text-align:center;">' + supplier +'</td>' +
							'<td style="width:300px;text-align:center;">' + stocks +'</td>' +
							'<td style="width:300px;text-align:center;">' + area_position +'</td>' +
						'</tr>';
						
		$(".displayAllItems").append(list_temp);
	}
	
	function updateSelectedItem(){
		
		var id = $(".frm-update-item").attr("idfui");
		var code = $.trim($('.code').val());
		var stocks = $.trim($('.stocks').val());
		var description = $.trim($('.description').val());
		var WSP = $.trim($('.whole-sale-price').val());
		var wholeSalePriceIncrease = $.trim($('.whole-sale-price-increase').val());
		var category_id = $('.select-category').val();
		var unit = $('.select-unit').val();
		var supplier = $('.supplier ').val(); 
		var srp = $('.suggested-retail-price').val(); 
		var area_position = $.trim($('.area').val());
		
		var data = [unit, code, description, WSP, srp, supplier, stocks, area_position];
		
		for(i in data){
			$("#all-items" + id + " td:nth-of-type(" + (parseInt(i) + 1) + ")").html(data[i]);
		}
	}
	
	function removeItemFromTheList(){
		for(i in allItemsSelected){
			$("#all-items" + allItemsSelected[i]).remove();
		}
	}
	
	function viewNoOfSelectedItems(){
		if(allItemsSelected.length != 0){
			$(".view-no-of-selected-items").css("display","block");
			$(".no-of-selected-items").html(allItemsSelected.length);
		}else{
			$(".view-no-of-selected-items").css("display","none");
			$(".no-of-selected-items").html(0);
		}
	}
	
	function viewNoOfItemsSearched(){
		if(textDataForAllItems != ""){
			$(".view-no-of-selected-searched").css("display","block");
			$(".no-of-search-items").html($(".noOfSearchedItems").html());
		}else{
			$(".view-no-of-selected-searched").css("display","none");
		}
		
	}
	
	function removeItemsNotAlreadyExistsInItemsPerCustomer(){
		ajax({removeItemsNotAlreadyExistsInItemsPerCustomer : 1},true);
	}
	
	function refreshTotalCapital(){
		$(".display-capital").html(ajax({getCapital : 1},true));
	}
})