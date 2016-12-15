<?php
function manage_languages()
{
global $config, $dbConnect;
?>
<div class="list-container">
    <?php
    $mainpage = true;
    $label = "";
    $type = "";

    if (! empty($_GET['set_default']))
    {
        $setDefaultLang = SK_secureEncode($_GET['set_default']);
        $langExistQuery = mysqli_query($dbConnect, "SELECT id FROM " . DB_LANGUAGES . " WHERE type='$setDefaultLang' LIMIT 1");
        if (mysqli_num_rows($langExistQuery) == 1)
        {
        $mainpage = false;
        ?>
        <div class="list-header"><a href="?tab1=languages">Languages</a> &#8658; Set default: <?php echo ucfirst(trim(preg_replace('/[^A-Za-z]+/i', ' ', $setDefaultLang))); ?></div>
        <div class="user-data-wrapper">
            <form class="float-left span100" align="left" method="post" action="?tab1=languages">
                Are you sure you want to set this as your website's default language? <input type="submit" value="Yes, set as default">
                <input type="hidden" name="lang_name" value="<?php echo $setDefaultLang; ?>">
                <input type="hidden" name="set_default_lang" value="1">
                <input type="hidden" name="keep_blank" value="">
            </form>
            <div class="float-clear"></div>
        </div>
        <?php
        }
    }
    elseif (! empty($_GET['delete']))
    {
        $deleteLang = SK_secureEncode($_GET['delete']);
        $langExistQuery = mysqli_query($dbConnect, "SELECT id FROM " . DB_LANGUAGES . " WHERE type='$deleteLang' LIMIT 1");
        if (mysqli_num_rows($langExistQuery) == 1)
        {
        $mainpage = false;
        ?>
        <div class="list-header"><a href="?tab1=languages">Languages</a> &#8658; Delete: <?php echo ucfirst(trim(preg_replace('/[^A-Za-z]+/i', ' ', $deleteLang))); ?></div>
        <div class="user-data-wrapper">
            <form class="float-left span100" align="left" method="post" action="?tab1=languages">
                Are you sure you want to delete this language? <input type="submit" value="Yes, delete">
                <input type="hidden" name="lang_name" value="<?php echo $deleteLang; ?>">
                <input type="hidden" name="delete_lang" value="1">
                <input type="hidden" name="keep_blank" value="">
            </form>
            <div class="float-clear"></div>
        </div>
        <?php
        }
    }
    elseif (! empty($_GET['add_keyword']))
    {
    $mainpage = false;
    ?>
    <div class="list-header"><a href="?tab1=languages">Languages</a> &#8658; New keyword</div>
    <div class="user-data-wrapper">
        <form class="float-left span100" align="left" method="get" action="?">
            <input type="text" name="label" placeholder="Type your keyword..."> <input type="submit" value="Next">
            <input type="hidden" name="tab1" value="languages">
        </form>
        <div class="float-clear"></div>
    </div>
    <?php
    }
    elseif (! empty($_GET['add_new']))
    {
    $mainpage = false;
    ?>
    <div class="list-header"><a href="?tab1=languages">Languages</a> &#8658; Add new language</div>
    <div class="user-data-wrapper">
        <form class="float-left span100" align="left" method="post" action="?tab1=languages">
            <input type="text" name="new_lang_name" placeholder="Name of your language (use alphabets and spaces only)"> <input type="submit" value="Add">
            <input type="hidden" name="add_new_lang" value="1">
            <input type="hidden" name="keep_blank" value="">
        </form>
        <div class="float-clear"></div>
    </div>
    <?php
    }
    elseif (! empty($_GET['label']))
    {
    $label = preg_replace('/[^a-z_]+/', '', strtolower(SK_secureEncode($_GET['label'])));
    $mainpage = false;
    ?>
    <div class="list-header"><a href="?tab1=languages">Languages</a> &#8658; Keyword: <i><?php echo $label; ?></i></div>
    <form method="post" action="?tab1=languages&label=<?php echo $label; ?>">
        <?php
        $labelQ1 = mysqli_query($dbConnect, "SELECT DISTINCT type FROM " . DB_LANGUAGES . " ORDER BY type ASC");
        while ($lbl = mysqli_fetch_assoc($labelQ1))
        {
            $labelQ2 = mysqli_query($dbConnect, "SELECT type,text FROM " . DB_LANGUAGES . " WHERE type='" . $lbl['type'] . "' AND keyword='$label' ORDER BY type ASC");
            if (mysqli_num_rows($labelQ2) == 1)
            {
                $lbl = mysqli_fetch_assoc($labelQ2);
            }
            else
            {
                $lbl['text'] = "";
            }

        ?>
        <div class="user-data-wrapper">
            <div class="float-left span20" align="left">
                <?php echo ucfirst(trim(preg_replace('/[^A-Za-z]+/i', ' ', $lbl['type']))); ?>:
            </div>
            <div class="float-left span70" align="left">
                <textarea name="lng_<?php echo $lbl['type']; ?>" placeholder="Write your text" style="width: 100%; height: 50px; resize: vertical;"><?php echo $lbl['text']; ?></textarea>
            </div>
            <div class="float-clear"></div>
        </div>
        <?php
        }
        ?>
        <div class="user-data-wrapper">
            <div class="float-left span20" align="left"></div>
            <div class="float-left span70" align="left">
                <input type="submit" value="Save Changes">
            </div>
            <div class="float-clear"></div>
        </div>
        <input type="hidden" name="keyword" value="<?php echo $label; ?>">
        <input type="hidden" name="edit_lang_scope" value="1">
        <input type="hidden" name="keep_blank" value="">
        </form>
        <?php
    }
    elseif (! empty($_GET['type']))
    {
        $type = SK_secureEncode($_GET['type']);
        $typeQ1 = mysqli_query($dbConnect, "SELECT keyword,text FROM " . DB_LANGUAGES . " WHERE type='$type' ORDER BY keyword ASC");

        if (mysqli_num_rows($typeQ1) > 0)
        {
            $mainpage = false;

            if (! empty($_GET['search_query']))
            {
                $searchQuery = SK_secureEncode($_GET['search_query']);
                $typeQ1 = mysqli_query($dbConnect, "SELECT keyword,text FROM " . DB_LANGUAGES . " WHERE type='$type' AND (keyword='$searchQuery' OR text LIKE '%$searchQuery%') ORDER BY keyword ASC");
            }
            ?>
            <div class="list-header"><a href="?tab1=languages">Languages</a> &#8658; <?php echo ucfirst(trim(preg_replace('/[^A-Za-z]+/i', ' ', $type))); ?></div>

            <div class="search-wrapper"><form method="get" action="?">
                <input type="hidden" name="tab1" value="languages">
                <input type="hidden" name="type" value="<?php echo $type; ?>">
                <input type="text" name="search_query" placeholder="Search for languages by keywords or texts"> <input type="submit" value="Search">
            </form></div>

            <div class="user-data-wrapper">
                <div class="float-left span40" align="left">
                    <strong>Keyword</strong>
                </div>
                <div class="float-left span50" align="left">
                    <strong>Text</strong>
                </div>
                <div class="float-left span10" align="center">
                    <strong>Options</strong>
                </div>
                <div class="float-clear"></div>
            </div>

            <?php
            while ($lng = mysqli_fetch_assoc($typeQ1))
            {
            ?>
            <div class="user-data-wrapper">
                <div class="float-left span40" align="left">
                    <?php echo $lng['keyword']; ?>
                </div>
                <div class="float-left span50" align="left">
                    <?php echo $lng['text']; ?>
                </div>
                <div class="float-left span10" align="center">
                    <a href="?tab1=languages&label=<?php echo $lng['keyword']; ?>">Edit</a>
                </div>
                <div class="float-clear"></div>
            </div>
            <?php
            }
        }
    }

    if ($mainpage)
    {
    ?>
    <div class="list-header">Languages</div>
    
    <?php
    $languages = mysqli_query($dbConnect, "SELECT DISTINCT type FROM " . DB_LANGUAGES . " ORDER BY type ASC");
    while ($language = mysqli_fetch_assoc($languages))
    {
    ?>
        <div class="user-data-wrapper">
            <div class="float-left span65" align="left">
                <?php echo ucfirst(trim(preg_replace('/[^A-Za-z]+/i', ' ', $language['type']))); ?>
            </div>
            <div class="float-left span35" align="center">
                <a href="?tab1=languages&type=<?php echo $language['type']; ?>">Edit Language</a>
                <?php
                if ($language['type'] != $config['language'])
                {
                ?>
                 - <a href="?tab1=languages&set_default=<?php echo $language['type']; ?>">Set default</a> - <a href="?tab1=languages&delete=<?php echo $language['type']; ?>">Delete</a>
                <?php
                }
                ?>
            </div>
            <div class="float-clear"></div>
        </div>
    <?php
    }
    ?>
    <div class="user-data-wrapper">
        <div class="float-left span100" align="center">
            <a href="?tab1=languages&add_new=1">Add new language</a> - <a href="?tab1=languages&add_keyword=1">Add new keyword</a>
        </div>
        <div class="float-clear"></div>
    </div>
    <?php
}
?>
</div>
<script src="jquery.js"></script>
<script>
function SK_loadMoreUsers() {
    after_user_id = $('.manage-user-list:last').attr('data-user-id');
    
    show_more_text = $('.show-more-wrapper').find('a').text();
    $('.show-more-wrapper').find('a').text('Loading...');
    
    $.get('ajax.php', {t: 'manage_users', after_user_id: after_user_id}, function (data) {
        
        if (data.status == 200) {
            $('.manage-user-list-wrapper').append(data.html);
            $('.show-more-wrapper').find('a').text(show_more_text);
        }
        else {
            $('.show-more-wrapper').remove();
        }
    });
}
</script>
<?php } ?>