<!DOCTYPE html>
<html lang="en">

	{{ theme:partial name="head" }}

	<body>
		{{ theme:partial name="header" }}

		<!-- Page Content -->
		<div class="container">
			{{ content }}
		</div>

		{{ theme:partial name="footer" }}

	    <!-- Footer Scripts -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<!-- Controller Defined Scripts -->
	    {{ template:foot }}
	</body>

</html>