<?php
if (!empty($_POST['addon']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true)
{
    $addon = SK_secureEncode($_POST['addon']);
    $saved = false;

    $enable_file = '../addons/' . $addon . '/enabled.html';

    if ( isset($_POST['enable_addon']) )
    {
        file_put_contents($enable_file, 1);
        $saved = true;
    }
    elseif ( isset($_POST['disable_addon']) )
    {
        unlink($enable_file);
    }

    mysqli_query($dbConnect , "UPDATE " . DB_CONFIGURATIONS . " SET reset_time=" . time());

    $_SESSION['load_addons'] = array();
    $_SESSION['addons'] = array();
    
    if ($saved == true)
    {
        $post_message = '<div class="post-success">Addon has been enabled!</div>';
    }
    else
    {
        $post_message = '<div class="post-success">Addon has been disabled!</div>';
    }
}
