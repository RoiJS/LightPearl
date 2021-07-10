<div class="navbar navbar-fixed-top" >
    <div class="navbar-inner">
		<div class="container">
            <button class="btn btn-navbar" data-toggle="collapse" data-target="#app-nav-top-bar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
			<a class="brand">
				<div class="row">
					<div class="span1" style="margin-right:-10px;">
						<h4 style="font-weight:bold;font-size:55px;font-family:'Edwardian Script ITC';color:#FFFF;">L</h4>
					</div>
					<div class="span4" style="margin-top:20px;">
						<i>Light Pearl Enterprises</i>
					</div>
				</div>
			</a>
            <div id="app-nav-top-bar" class="nav-collapse">	
                <ul class="nav pull-right">
					<li>
						<a class="btn-update-account">Profile</a>
					</li>
					<li hidden>
						<a class="btn-update-account">Settings</a>
					</li>
                    <li>
                        <a href="?pg=access&vw=logout&dir=<?php echo sha1('logout');?>">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<br>
<script src="public/js/admin/accounts/accounts.js" type="text/javascript"></script>