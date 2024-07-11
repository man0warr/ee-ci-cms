<div class="box">
    <div class="heading">
        <h1><img alt="" src="<?php echo theme_url('assets/images/icons/general-settings.png'); ?>"> General Settings</h1>

        <div class="buttons">
            <a class="button" href="#" onClick="$('#settings_form').submit();"><span>Save</span></a>
        </div>
    </div>
    <div class="content">

        <?php echo form_open(null, 'id="settings_form"'); ?>
        <div class="tabs">
            <ul class="htabs">
                <li><a href="#general-tab">General</a></li>
                <li><a href="#users-tab">Users</a></li>
                <li><a href="#modules-tab">Modules</a></li>
                <li><a href="#analytics-tab">Analytics</a></li>
            </ul>

            <!-- General Tab -->
            <div id="general-tab">
                <div class="form">
                    <div>
                        <?php echo form_label('<span class="required">*</span> Site Name:', 'sitename'); ?>
                        <?php echo form_input(array('name' => 'site_name', 'id' => 'sitename', 'value' => set_value('site_name', isset($Settings->site_name->value) ? $Settings->site_name->value : ''), 'size' => 50)); ?>
                    </div>
                    <div>
                        <?php echo form_label('<span class="required">*</span> Notification Email:', 'notification_email'); ?>
                        <?php echo form_input(array('name' => 'notification_email', 'id' => 'notification_email', 'value' => set_value('notification_email', isset($Settings->notification_email->value) ? $Settings->notification_email->value : ''), 'size' => 50)); ?>
                    </div>
                    <div>
                      <?php echo form_label('Additional Notification Emails: <span class="help">Any additional emails you want to receive the nofification email, in addition to the main notification email. (comma separated)</span>', 'additional_notification_emails'); ?>
                      <?php echo form_textarea(array('name' => 'additional_notification_emails', 'rows' => 3, 'value' => set_value('additional_notification_emails', isset($Settings->additional_notification_emails->value) ? $Settings->additional_notification_emails->value : ''))); ?>
                    </div>
                	<?php if ($development_mode): ?>
                    <div>
                        <?php echo form_label('<span class="required">*</span> Developer\'s Email:', 'developers_email'); ?>
                        <?php echo form_input(array('name' => 'developers_email', 'id' => 'developers_email', 'value' => set_value('developers_email', isset($Settings->developers_email->value) ? $Settings->developers_email->value : ''), 'size' => 50)); ?>
                    </div>
                    <div>
                        <?php echo form_label('<span class="required">*</span> Development Mode: <span class="help">Send all notifications to the developer\'s email.</span>', 'use_developers_email'); ?>
                        <span>
                            <label><?php echo form_radio(array('name' => 'use_developers_email', 'value' => '1', 'checked' => set_radio('use_developers_email', '1', ( ! empty($Settings->use_developers_email->value)) ? TRUE : FALSE))); ?> Yes</label>
                            <label><?php echo form_radio(array('name' => 'use_developers_email', 'value' => '0', 'checked' => set_radio('use_developers_email', '0', (empty($Settings->use_developers_email->value)) ? TRUE : FALSE))); ?> No</label>
                        </span>
                    </div>
                    <?php endif; ?>
                    <div>
                        <?php echo form_label('Telephone:', 'phone'); ?>
                        <?php echo form_input(array('name' => 'phone', 'id' => 'phone', 'value' => set_value('phone', isset($Settings->phone->value) ? $Settings->phone->value : ''))); ?>
                    </div>
                    <div>
                        <?php echo form_label('Fax:', 'fax'); ?>
                        <?php echo form_input(array('name' => 'fax', 'id' => 'fax', 'value' => set_value('fax', isset($Settings->fax->value) ? $Settings->fax->value : ''))); ?>
                    </div>
                    <div>
                        <?php echo form_label('Address:', 'address'); ?>
                        <?php echo form_textarea(array('name' => 'address', 'rows' => 3, 'id' => 'address', 'value' => set_value('address', isset($Settings->address->value) ? $Settings->address->value : ''))); ?>
                    </div>
                    <div>
                        <?php echo form_label('<span class="required">*</span> Site Homepage:', 'site_homepage'); ?>
                        <?php  echo form_dropdown('content[site_homepage]', option_array_value($Entries, 'id', 'title'), set_value('site_homepage', isset($Settings->site_homepage->value) ? $Settings->site_homepage->value : '')); ?>
                    </div>
                    <div>
                        <?php echo form_label('<span class="required">*</span> Custom 404:', 'custom_404'); ?>
                        <?php  echo form_dropdown('content[custom_404]', option_array_value($Entries, 'id', 'title'), set_value('custom_404', isset($Settings->custom_404->value) ? $Settings->custom_404->value : '')); ?>
                    </div>
                    <div>
                        <?php echo form_label('<span class="required">*</span> Theme:', 'theme'); ?>
                        <?php  echo form_dropdown('theme', $themes, set_value('theme', isset($Settings->theme->value) ? $Settings->theme->value : ''), 'id="theme"'); ?>
                    </div>
                    <div>
                        <?php echo form_label('<span class="required">*</span> Default Layout:', 'layout'); ?>
                        <?php  echo form_dropdown('layout', $layouts, set_value('layout', isset($Settings->layout->value) ? $Settings->layout->value : ''), 'id="theme_layout"'); ?>
                        <span id="layout_ex" class="ex"></span>
                    </div>
                    <div>
                        <?php echo form_label('Content Editor\'s Stylesheet:<span class="help">Enables you to specify a CSS file to extend CKEidtor\'s and TinyMCE\'s default theme and provide custom classes for the styles dropdown.</span>', 'editor_stylesheet'); ?>
                        <span id="editor_stylesheet_path"><?php echo site_url('themes/' . $this->settings->theme) . '/'; ?></span> <?php echo form_input(array('name' => 'editor_stylesheet', 'id' => 'editor_stylesheet', 'value' => set_value('editor_stylesheet', isset($Settings->editor_stylesheet->value) ? $Settings->editor_stylesheet->value : ''))); ?>
                    </div>
                    <div>
                        <?php echo form_label('Admin Toolbar:', 'enable_admin_toolbar'); ?>
                        <span>
                            <label><?php echo form_radio(array('name' => 'enable_admin_toolbar', 'value' => '1', 'checked' => set_radio('enable_admin_toolbar', '1', ( ! empty($Settings->enable_admin_toolbar->value)) ? TRUE : FALSE))); ?> Yes</label>
                            <label><?php echo form_radio(array('name' => 'enable_admin_toolbar', 'value' => '0', 'checked' => set_radio('enable_admin_toolbar', '0', (empty($Settings->enable_admin_toolbar->value)) ? TRUE : FALSE))); ?> No</label>
                        </span>
                    </div>
                    <?php if ($this->Group_session->type == SUPER_ADMIN): ?>
                    <div>
                        <?php echo form_label('Enable Profiler:', 'enable_profiler'); ?>
                        <span>
                            <label><?php echo form_radio(array('name' => 'enable_profiler', 'value' => '1', 'checked' => set_radio('enable_profiler', '1', ( ! empty($Settings->enable_profiler->value)) ? TRUE : FALSE))); ?> Yes</label>
                            <label><?php echo form_radio(array('name' => 'enable_profiler', 'value' => '0', 'checked' => set_radio('enable_profiler', '0', (empty($Settings->enable_profiler->value)) ? TRUE : FALSE))); ?> No</label>
                        </span>
                    </div>
                    <?php endif; ?>
                    <?php if ($this->Group_session->type == SUPER_ADMIN): ?>
                    <div>
                        <?php echo form_label('Suspend Site:', 'suspend'); ?>
                        <span>
                            <label><?php echo form_radio(array('name' => 'suspend', 'value' => '1', 'checked' => set_radio('suspend', '1', ( ! empty($Settings->suspend->value)) ? TRUE : FALSE))); ?> Yes</label>
                            <label><?php echo form_radio(array('name' => 'suspend', 'value' => '0', 'checked' => set_radio('suspend', '0', (empty($Settings->suspend->value)) ? TRUE : FALSE))); ?> No</label>
                        </span>
                    </div>
                    <?php endif; ?>
                    <div>
                        <?php echo form_label('CMS Version:', 'cms_version'); ?>
                        <?php echo form_input(array('name' => 'cms_version', 'id' => 'cms_version', 'value' => set_value('cms_version', $initial_cms_version), 'disabled' => 'disabled')); ?>
                    </div>
                    <div>
                        <?php echo form_label('Version Modified:', 'version_modified'); ?>
                        <?php echo form_checkbox(array('name' => 'version_modified', 'id' => 'version_modified', 'value' => '1', 'checked' => set_checkbox('version_modified', '1', ( ! empty($Settings->version_modified->value) && $Settings->version_modified->value) ? TRUE : FALSE))); ?>
                    </div>
                </div>
            </div>

            <!-- Users Tab -->
            <div id="users-tab">
                <div class="form">
                    <div>
                        <?php echo form_label('<span class="required">*</span> Default User Group:', 'default_group'); ?>
                        <?php  echo form_dropdown('users[default_group]', option_array_value($Groups, 'id', 'name'), set_value('default_group', isset($Settings->default_group->value) ? $Settings->default_group->value : '')); ?>
                    </div>
                    <div>
                        <?php echo form_label('<span class="required">*</span> User Registration:', 'enable_registration'); ?>
                        <span>
                            <label><?php echo form_radio(array('name' => 'users[enable_registration]', 'value' => '1', 'checked' => set_radio('users[enable_registration]', '1', ( ! empty($Settings->enable_registration->value)) ? TRUE : FALSE))); ?> Enabled</label>
                            <label><?php echo form_radio(array('name' => 'users[enable_registration]', 'value' => '0', 'checked' => set_radio('users[enable_registration]', '0', (empty($Settings->enable_registration->value)) ? TRUE : FALSE))); ?> Disabled</label>
                        </span>
                    </div>
                    <div>
                        <?php echo form_label('<span class="required">*</span> Require Email Activation:', 'email_activation'); ?>
                        <span>
                            <label><?php echo form_radio(array('name' => 'users[email_activation]', 'value' => '1', 'checked' => set_radio('users[email_activation]', '1', ( ! empty($Settings->email_activation->value)) ? TRUE : FALSE))); ?> Enabled</label>
                            <label><?php echo form_radio(array('name' => 'users[email_activation]', 'value' => '0', 'checked' => set_radio('users[email_activation]', '0', (empty($Settings->email_activation->value)) ? TRUE : FALSE))); ?> Disabled</label>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Modules Tab -->
            <div id="modules-tab">
                <div class="form">
                    <div>
                        <?php echo form_label('Site Search:', 'search_module'); ?>
                        <span>
	                        <?php echo form_label('Search Term Padding:', 'search_term_padding'); ?>
	                        <?php echo form_input(array('name' => 'search_term_padding', 'id' => 'search_term_padding', 'value' => set_value('search_term_padding', isset($Settings->search_term_padding->value) ? $Settings->search_term_padding->value : ''), 'size' => 1)); ?> characters
                        </span>
                    </div>
                    <?php if ($Module_addons_enabled): ?>
                        <?php foreach($Module_addons_enabled as $module): ?>
                            <div>
                                <?php $radioName = "module[id_" . strtolower($module['id']) . "]"; ?>
                                <?php echo form_label($module['title'], $radioName); ?>
                                <span>
                                    <label><?php echo form_radio(array('name' => $radioName, 'value' => "DISABLE", 'checked' => set_radio($radioName, "DISABLE", (!$module['enabled']) ? TRUE : FALSE))); ?> Disabled</label>
                                    <label><?php echo form_radio(array('name' => $radioName, 'value' => "ENABLE", 'checked' => set_radio($radioName, "ENABLE", ($module['enabled']) ? TRUE : FALSE))); ?> Enabled</label>
                                </span>
                                <?php echo form_label("&nbsp;"); ?>
                                <?php echo $module['description']; ?>
                                <?php if ($module['id'] == 1): ?>
                                <span>
                                    <?php if ($module['enabled']): ?>
                                        <?php echo form_checkbox(array('name' => 'disable_comments', 'id' => 'disable_comments', 'value' => '1', 'checked' => set_checkbox('disable_comments', '1', ( ! empty($Settings->disable_comments->value) && $Settings->disable_comments->value) ? TRUE : FALSE))); ?>
                                    <?php else: ?>
                                        <?php echo form_checkbox(array('name' => 'disable_comments', 'id' => 'disable_comments', 'value' => '1', 'checked' => set_checkbox('disable_comments', '1', ( ! empty($Settings->disable_comments->value) && $Settings->disable_comments->value) ? TRUE : FALSE), 'disabled' => 'disabled')); ?>
                                    <?php endif; ?>
                                    <?php echo form_label('Disable Comments', 'disable_comments'); ?>
                                </span>
                                <?php endif ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif ?>
                </div>
            </div>

            <!-- Analytics Tab -->
            <div id="analytics-tab">
                <div class="form">
                    <div>
                        <?php echo form_label('Analytics Tracking Code:', 'ga_account_id'); ?>
                        <?php echo form_input(array('name' => 'ga_account_id', 'id' => 'ga_account_id', 'value' => set_value('ga_account_id', isset($Settings->ga_account_id->value) ? $Settings->ga_account_id->value : ''))); ?>
                    </div>
                    <div>
                        <?php echo form_label('Analytics Email:', 'ga_email'); ?>
                        <?php echo form_input(array('name' => 'ga_email', 'id' => 'ga_email', 'value' => set_value('ga_email', isset($Settings->ga_email->value) ? $Settings->ga_email->value : ''))); ?>
                    </div>
                    <div>
                        <?php echo form_label('Analytics Password:', 'ga_password'); ?>
                        <?php echo form_password(array('name' => 'ga_password', 'id' => 'ga_password', 'value' => set_value('ga_password', isset($Settings->ga_password->value) ? $Settings->ga_password->value : ''))); ?>
                    </div>
                    <div>
                        <?php echo form_label('Analytics Profile ID:', 'ga_profile_id'); ?>
                        <?php echo form_input(array('name' => 'ga_profile_id', 'id' => 'ga_profile_id', 'value' => set_value('ga_profile_id', isset($Settings->ga_profile_id->value) ? $Settings->ga_profile_id->value : ''))); ?>
                    </div>
                </div>
            </div>

        </div>
        <?php echo form_close(); ?>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $( ".tabs" ).tabs();

        $('#theme').change( function() {

            $('#theme_layout').html('');
            $('#layout_ex').html('Loading Layouts...');

            $.post('<?php echo site_url(ADMIN_PATH . '/settings/general-settings/theme-ajax'); ?>', {theme: $('#theme').val()}, function(response) {
                if (response.status == 'OK')
                {
                    $.each(response.layouts, function(i , val) {
                        $('#theme_layout').append('<option value="' + val + '">' + val + '</option>');
                    });
                    $('#layout_ex').html('');
                }
                else
                {
                    $('#layout_ex').html(response.message);
                }
            }, 'json');

            $('#editor_stylesheet_path').html('<?php echo site_url('themes/') . '/'; ?>' + $('#theme').val() + '/');
        });

        $('#version_modified').change(function() {

            if ($(this).is(":checked"))
            {
                var version = $('#cms_version').val();
                var modified = version + "+";

                $('#cms_version').val(modified);
            }
            else
            {
                var modified = $('#cms_version').val();

                if (modified.slice(-1) == "+")
                {
                    var version = modified.substring(0, modified.length - 1);

                    $('#cms_version').val(version);
                }
            }
        });

        $('input[name="module[id_1]"]').change(function() {
            if ($(this).val() == "ENABLE")
            {
                $('#disable_comments').removeAttr('disabled');
            }
            else
            {
                $('#disable_comments').attr('disabled', 'disabled');
            }
        });
    });
</script>
