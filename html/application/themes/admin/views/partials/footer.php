        <!-- ends the container -->
        </div>

        <!-- Footer -->
        <div id="footer">
            &copy; {{ helper:date format="Y" }} Einstein's Eyes<br>
            972-997-8201 | <a href="mailto:support@einsteinseyes.com">support@einsteinseyes.com</a><br>
            eeCMS v<?php echo ($this->settings->version_modified) ? "{$this->settings->cms_version}+" : $this->settings->cms_version; ?>
        </div>


        <div id="ajax_status">
            <table id="ajax_status_frame">
                <tr>
                    <td>
                        <div id="ajax_status_animation"><img src="<?php echo theme_url('assets/images/ajax-loader.gif'); ?>" /></div>
                        <div id="ajax_status_text"></div>
                    </td>
                </tr>
            </table>
        </div>
    </body>

</html>