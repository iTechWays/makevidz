<?php
if (isset($_POST['delete_lang']) && !empty($_POST['lang_name']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true)
{
    $langname = SK_secureEncode($_POST['lang_name']);
    $saved = false;

    if ($langname != $config['language'])
    {
        $processQuery = mysqli_query($dbConnect, "DELETE FROM " . DB_LANGUAGES . " WHERE type='$langname'");

        if ($processQuery)
        {
            $saved = true;
            mysqli_query($dbConnect , "UPDATE " . DB_CONFIGURATIONS . " SET reset_time=" . time());
        }
    }

    if ($saved == true)
    {
        $post_message = '<div class="post-success">Language <i>' . ucfirst(trim(preg_replace('/[^A-Za-z]+/i', ' ', $langname))) . '</i> was deleted!</div>';
    }
    else
    {
        $post_message = '<div class="post-failure">Something went wrong! Please try again.</div>';
    }
}