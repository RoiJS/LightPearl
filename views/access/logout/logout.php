<?php
require_once('functions/sqlQuery.function.php');
require_once('functions/system.function.php');

$account_id = parseSession($_SESSION['account_id']);
query('UPDATE tbl_accounts','SET flag = :flag WHERE account_id = :id',[':flag' => 0, ':id' => $account_id]);
session_destroy();

?>
	<script type="text/javascript">
       window.location = "?pg=access";
     </script>
<?php
	
?>