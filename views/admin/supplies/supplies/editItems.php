<?php require_once('views/header.php');?>
<input type="hidden" value="<?php echo $_GET['pg'];?>" class="page"/>
<input type="hidden" value="tbl_suppliers" class="tblname"/>
<?php query('UPDATE tbl_items SET checkStatus = 0');?>
<div id="body-container">
   <div id="body-content">
	<?php require_once('views/'.getPage().'/navbar.php');?>
	
     <section class="nav nav-page nav-page-fixed">
        <div class="container">
            <div class="row">
                <div class="span7">
                    <header class="page-header">
                        <h3>Supplies<br/>
                            <small>Eiblin Enterprises</small>
                        </h3>
                    </header>
                </div>
                <div class="page-nav-options">
                    <div class="span9">
                        <ul class="nav nav-pills">
							 <li class="btn-manage-suppliers">
                                <a>Manage Suppliers</a>
                            </li>
							<li  class="btn-manage-item-category">
                                <a >Manage Item Category</i></a>
                            </li>
							<li class="btn-manage-unit">
                                <a >Manage units</i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	<section class="page container">
		<div class="row">
              
        </div>
	</section>
</div>
<?php require_once('views/executionTransition.php');?>
<script src="public/js/admin/supplies/supplies.js" type="text/javascript" ></script>
<script src="public/js/admin/supplies/suppliers.js" type="text/javascript" ></script>
<script src="public/js/admin/supplies/units.js" type="text/javascript" ></script>
<script src="public/js/admin/supplies/itemCategory.js" type="text/javascript" ></script>

<?php require_once('views/footer.php');?>
