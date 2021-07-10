<?php $title = '404 Error Found!'; require_once('mainheader.php'); ?>
<section class="content" style="margin-left:50px;">
    <div class="error-page">
		<h2 class="headline text-yellow" style="margin-bottom:-30px">404</h2><br>
		<div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
            <p>
				<?php session_start();?>
				 We could not find the page you were looking for.
				 Meanwhile, you may <a href="?pg=<?php echo parseSession($_SESSION['account_id'],1); ?>">return to home</a>.
            </p>
        </div><!-- /.error-content -->
      </div><!-- /.error-page -->
</section><!-- /.content -->