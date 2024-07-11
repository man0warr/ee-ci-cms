<div class="box">
    <div class="heading">
        <h1><img alt="" src="<?php echo theme_url('assets/images/icons/manage-uploaded-files.png'); ?>">Mange User Documents</h1>
    </div>
    <div class="content">

        <div class="form">
            <div>
                <label>Mange User Documents: <span class="help">Manage uploaded user documents. Each user has a folder matching their User ID.</span></label>
                <button class="choose_file">Launch File Manager</button>
            </div>
        </div>

        <table class="list">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($Users->exists()): ?>
                    <?php foreach($Users as $User): ?>
                        <tr>
                            <td><?php echo $User->id ?></td>
                            <td><?php echo $User->full_name() ?></td>
                            <td><?php echo $User->email ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="center">No results found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

<script>
    $(document).ready( function() {

        $('.choose_file').click( function() {
            var link = $(this);

            window.KCFinder = {
                callBack: function(url) {
                    window.KCFinder = null;
                    link.parent().find('.filename').html(url);
                    link.parent().find('.hidden_file').val(url);
                }
            };
            var left = (screen.width/2)-(800/2);
            var top = (screen.height/2)-(600/2);
            window.open(THEME_URL + '/assets/js/kcfinder/browse.php?type=userdownloads',
                'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
                'directories=0, resizable=1, scrollbars=0, width=800, height=600, top=' + top + ', left=' + left
            );
        });

        $('.remove_file').click( function() {
            var link = $(this);

            link.parent().find('.filename').html('No File Added');
            link.parent().find('.hidden_file').attr('value', '');
        });

    });
</script>