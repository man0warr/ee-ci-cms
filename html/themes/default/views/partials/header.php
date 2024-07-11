<header>

	<nav class="navbar navbar-default">
		<div class="container">

		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navigation" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
				</button>
				<a class="navbar-brand visible-xs-block" href="{{ site_url }}">{{ settings:site_name }}</a>
		    </div>

		    <!-- Site Navigation -->
		    <div class="collapse navbar-collapse" id="main-navigation">
		    	{{ navigations:nav nav_id="1" class="nav navbar-nav" current_class="active" }}

				<ul class="nav navbar-nav navbar-right">
					{{ if users:is_logged_in }}
			        <li><a href="/users/logout">Log out</a></li>
			        {{ else }}
			        <li><a href="/users/login">Log in</a></li>
			        {{ endif }}
			    </ul>
		    </div>

		</div>
	</nav>

</header>