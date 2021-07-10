$(document).ready(function(){
	
	//================================================ Supplies ==========================================
	var box = '';
	var sortOrder = 'DESC';
	var tblname = 'tbl_units';
	var page = $('.page').val();
	
	$('body').delegate('.btn-manage-unit','click',function(){
		unitList = ajax({unitList : 1},true);
		box = modalForm('Units',unitList);
		itemCategory_id = $('.select-item-category').val();
		showComponents('pagination','.displayUnitList',tblname,page,sortOrder);
	})
	
	$('body').delegate('.close-unit-form','click',function(){
		box.modal('hide');
		return false;
	});
	
	$('body').delegate('.frm-add-unit','submit',function(e){
		e.preventDefault();
		
		unit = $.trim($('.txt-new-unit').val());
		if(unit != ''){
			if(confirm('Are you sure to save new unit?')){
				saveNewUnit = ajax({saveNewUnit : 1, unit : unit},true);
				showComponents('pagination','.displayUnitList',tblname,page,sortOrder);
				$('.txt-new-unit').val('')
			}
		}
	});
	
	$('body').delegate('.btn-update-unit','click',function(){
		
		showComponents('pagination','.displayUnitList',tblname,page,sortOrder);
		$('#div-update-unit' + $(this).attr('iduu')).show();
		$('#div-cancel-update-unit' + $(this).attr('iduu')).hide();
	});
	
	$('body').delegate('.btn-cancel-update-unit','click',function(){
		showComponents('pagination','.displayUnitList',tblname,page,sortOrder);
	});
	
	
	$('body').delegate('.frm-update-unit','submit',function(e){
		e.preventDefault()
		
		id = $(this).attr('idfuu');
		unitName = $.trim($('#div-update-unit'+ id +' input[type=text]').val());
		if(unitName != 0){
			if(confirm('Are you sure to update selected unit?')){
				saveUpdateUnit = ajax({saveUpdateUnit : 1, unitName : unitName, id : id},true,true,'Updating selected unit.');
				showComponents('pagination','.displayUnitList',tblname,page,sortOrder);
			}
		}
	});
	
	$('body').delegate('.btn-remove-unit','click',function(){
		id = $(this).attr('idru');
		
		if(!verifyRemoveModule('units' , id)){
			if(confirm('Are you sure to remove selected unit?')){
				removeUnit = ajax({removeUnit: 1, id : id},true,true,'Removing selected unit.');
				processResult(removeUnit,'Selected unit has been successfully removed.','Failed to remove selected unit.');
				showComponents('pagination','.displayUnitList',tblname,page,sortOrder);
			}	
		}else{
			alert("Unable to remove selected unit because it exists as unit of an item in the item list.")
		}
		
	});
	
	$('body').delegate('.unit-sort-order','change',function(){
		sortOrder = $(this).val();
		showComponents('pagination','.displayUnitList',tblname,page,sortOrder);
	})
})