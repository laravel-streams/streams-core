<?php

return [
    '403'                 => 'Access denied.',
    '503'                 => 'Be right back.',
    '404'                 => 'Page not found.',
    '500'                 => 'There was an error.',
    'no_results'          => 'No results.',
    'no_fields_available' => 'No fields available.',
    'delete_success'      => ':count row(s) were deleted successfully.',
    'reorder_success'     => ':count row(s) were reordered successfully.',
    'csrf_token_mismatch' => 'Your security token has expired. Please submit the form again.',
    'delete_installer'    => 'The installer module still exists! Please delete it from your server! Leaving it online means control of this site could be granted to somebody else.<br><br><strong>' . link_to(
            'admin/addons/modules/delete/anomaly.module.installer',
            'Click here to delete the installer now.'
        ) . '</strong>',
    'create_success'      => ':name created successfully.',
    'edit_success'        => ':name updated successfully.',
    'confirm_delete'      => 'Are you sure you want to delete?<br><small>This can not be undone.</small>',
    'prompt_delete'       => 'Are you sure you want to delete?<br><small>Type \"yes\" to confirm.</small>',
];
