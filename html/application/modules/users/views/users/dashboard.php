<div class="row">
	<div class="col-xs-6">

		<h1>User Dashboard</h1>

		<div class="panel panel-default" id="dashboard">
			<div class="panel-body">
				<?php echo $documents; ?>
			</div>
		</div>

	</div>
</div>

<script>
    $(document).ready(function() {

        // Expand and collape folders
        $( "#dashboard .folder" ).click(function() {

            // Click on non-expanded folder
            if ( $(this).hasClass( "expanded" ) == false ) {

            	// Collapse folders
            	$(this).closest( "li" ).siblings().children( ".folder" )
                    .removeClass( "expanded" )
                    .children( ".glyphicon" ).removeClass( "glyphicon-minus" ).addClass( "glyphicon-plus" );

                $(this).closest( "ul" ).find( "ul" ).hide();
            }

            // Toggle folder state
            $(this).toggleClass( "expanded" );
            $(this).siblings( "ul" ).fadeToggle( "fast" );

            // Update icon
            if ($(this).hasClass( "expanded" )) {
            	$(this).children( ".glyphicon" ).removeClass( "glyphicon-plus" ).addClass( "glyphicon-minus" );
            } else {
            	$(this).children( ".glyphicon" ).removeClass( "glyphicon-minus" ).addClass( "glyphicon-plus" );
            }
        });

    });
</script>