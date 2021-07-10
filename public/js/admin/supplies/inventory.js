$(document).ready(function(){
	
	var boxSortInventoryPerDate
	$("body").delegate(".frm-search-item","submit",function(e){
		e.preventDefault();
		
		var name = $.trim($(".item_name").val()); 
		
		if(name != 0){					
			var loc = window.location.href.toString().split(window.location.host)[1].split("/");
			window.location = loc[(loc.length - 1)].replace("&name=" + $(".previous-name").val() ,"") + "&name=" + name;
		}
	});
	
	$("body").delegate(".menu-sort-items-by-date","click",function(){
		var content = ajax({getSortByInventory : 1},true);
		boxSortInventoryPerDate = modalForm("Sort inventory by date", content);
		$(".inventory-date-from").val($(".date-from").val())
		$(".inventory-date-to").val($(".date-to").val())
	});
	
	$("body").delegate(".btn-close-sort-inventory-by-date-form","click",function(){
		boxSortInventoryPerDate.modal("hide");
	});
	
	$("body").delegate(".btn-sort-inventory-by-date-form","click",function(){
		var date_from = $.trim($(".inventory-date-from").val()); 
		var date_to = $.trim($(".inventory-date-to").val()); 
		
		if(date_from != 0 && date_to != ""){
			var loc = window.location.href.toString().split(window.location.host)[1].split("/");
			window.location = loc[(loc.length - 1)].replace("&p_d=" + $(".date_from").val() + "&r_d=" + $(".date_to").val(),"") + "&p_d=" + date_from + "&r_d=" + date_to;
			$(".btn-close-sort-inventory-by-date-form").click();
		}
	});
});