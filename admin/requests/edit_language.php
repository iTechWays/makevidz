<?php
if (isset($_POST['edit_lang_scope']) && !empty($_POST['keyword']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true)
{
    $langData = array();
    $keyword = SK_secureEncode($_POST['keyword']);
    $saved = false;

    foreach ($_POST as $PostKey => $PostVal)
    {
        if (preg_match('/^lng\_([a-z_]+)$/', $PostKey))
        {
            $PostKey = str_replace('lng_', '', $PostKey);
            $PostVal = SK_secureEncode($PostVal);

            $typeExistQuery = mysqli_query($dbConnect, "SELECT id FROM " . DB_LANGUAGES . " WHERE type='$PostKey' LIMIT 1");

            if (mysqli_num_rows($typeExistQuery) == 1)
            {
                $keyExistQuery = mysqli_query($dbConnect, "SELECT id FROM " . DB_LANGUAGES . " WHERE type='$PostKey' AND keyword='$keyword'");

                if (mysqli_num_rows($keyExistQuery) > 0)
                {
                    $processQuery = mysqli_query($dbConnect, "DELETE FROM " . DB_LANGUAGES . " WHERE type='$PostKey' AND keyword='$keyword'");
                }

                $processQuery = mysqli_query($dbConnect, "INSERT INTO " . DB_LANGUAGES . " (type,keyword,text) VALUES ('$PostKey','$keyword','$PostVal')");

                if ($processQuery)
                {
                    $saved = true;
                    mysqli_query($dbConnect , "UPDATE " . DB_CONFIGURATIONS . " SET reset_time=" . time());
                }
            }
        }
    }
    
    if ($saved == true)
    {
        $post_message = '<div class="post-success">Language keyword <i>' . $keyword . '</i> was successfully edited!</div>';
    }
    else
    {
        $post_message = '<div class="post-failure">Something went wrong! Please try again.</div>';
    }
}
