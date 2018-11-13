<div id="header">
			<div id="header"  style="float: none;display:block;max-width:60em;margin-top: 0px;margin-right: auto;margin-bottom: 0px;margin-left: auto;">
				<a class="header_genotate" href='/'>Genotate</a> 
				<li class="dropdown"><a href="#" class="header_dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Annotate<span style='margin-left:7px;' class="caret"></span></a>
					<ul class="dropdown-menu">
						<a class="header_dropdown_link" href="/index.php?page=annotate_single_transcript">Single transcript</a>
						<a class="header_dropdown_link" href="/index.php?page=annotate_multiple_transcripts">Multiple transcripts</a>
					</ul>
				</li>
        <?php if (checkMenu(2,$user->data()->id)){  //Links for permission level 2 (default admin) ?>
				<li class="dropdown"><a href="#" class="header_dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Explore annotations<span style='margin-left:7px;' class="caret"></span></a>
					<ul class="dropdown-menu">
						<a class="header_dropdown_link" href="/index.php?page=search_annotations">Search annotations</a>
						<a class="header_dropdown_link" href="/index.php?page=manage_annotations">Manage annotations</a>
					</ul>
				</li>
        <?php }else{ // is user an admin ?>
						<a class="header_link" href="/index.php?page=search_annotations">Explore annotation results</a>
						<a class="header_link" href="/index.php?page=manage_annotations">Manage annotation results</a>
        <?php } // is user an admin ?>
				<li class="dropdown"><a href="#" class="header_dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help<span style='margin-left:7px;' class="caret"></span></a>
					<ul class="dropdown-menu">
						<a class="header_dropdown_link" href="/index.php?page=tutorial">Tutorial<span class="sr-only"></a>
							<a class="header_dropdown_link" href="/index.php?page=about">About<span class="sr-only"></a>
								</ul>
							</li> 
          <a style="vertical-align: middle;float:right;font-size:16px;background-color:black;height:40px;width:40px;padding:10px;" href="/admin_pages/index.php"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></a>
            
				<?php if($user->isLoggedIn()){ //anyone is logged in?>
				<li class="dropdown"><a href="#" class="header_dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">User: <?php echo echousername($user->data()->id);?><span style='margin-left:7px;' class="caret"></span></a>
						<ul class="dropdown-menu"> <!-- open tag for User dropdown menu -->
          <?php if (checkMenu(2,$user->data()->id)){  //Links for permission level 2 (default admin) ?>
						<a class="header_dropdown_link" href="/users/admin.php"><i class="fa fa-fw fa-cogs"></i> Admin Dashboard</a>
						<a class="header_dropdown_link" href="/users/admin_users.php"><i class="glyphicon glyphicon-user"></i> User Management</a>
						<a class="header_dropdown_link" href="/users/admin_permissions.php"><i class="glyphicon glyphicon-lock"></i> User Permissions</a>
						<a class="header_dropdown_link" href="/users/admin_pages.php"><i class="glyphicon glyphicon-wrench"></i> System Pages</a>
						<a class="header_dropdown_link" href="/users/admin_messages.php"><i class="glyphicon glyphicon-envelope"></i> Messages Admin</a>
						<a class="header_dropdown_link" href="/users/admin_logs.php"><i class="glyphicon glyphicon-search"></i> System Logs</a>
					<?php } // is user an admin ?>
							<a class="header_dropdown_link" href="/users/account.php"><i class="fa fa-fw fa-user"></i> Account</a>
							<a class="header_dropdown_link" href="/users/logout.php"><i class="fa fa-fw fa-sign-out"></i> Logout</a>
						</ul> <!-- close tag for User dropdown menu -->
					</li>
				<?php }else{ // no one is logged in so display default items ?>
					<li><a href="/users/login.php" style="float:right" class="header_link"><i class="fa fa-sign-in"></i> Login</a></li>
					<li><a href="/users/join.php" style="float:right" class="header_link"><i class="fa fa-plus-square"></i> Register</a></li>
				<?php } //end of conditional for menu display ?>
				</ul> <!-- End of UL for navigation link list -->
				</div> <!-- End of Div for right side navigation list -->
</div>
