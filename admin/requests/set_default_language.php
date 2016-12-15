<?php
if (isset($_POST['set_default_lang']) && !empty($_POST['lang_name']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true)
{
    $langname = SK_secureEncode($_POST['lang_name']);
    $saved = false;

    if ($langname != $config['language'])
    {
        $processQuery = mysqli_query($dbConnect, "UPDATE " . DB_CONFIGURATIONS . " SET language='$langname'");

        if ($processQuery)
        {
            $saved = true;
            mysqli_query($dbConnect , "UPDATE " . DB_CONFIGURATIONS . " SET reset_time=" . time());
        }
    }

    if ($saved == true)
    {
        $post_message = '<div class="post-success">Language <i>' . ucfirst(trim(preg_replace('/[^A-Za-z]+/i', ' ', $langname))) . '</i> was set as default!</div>';
    }
    else
    {
        $post_message = '<div class="post-failure">Something went wrong! Please try again.</div>';
    }
}