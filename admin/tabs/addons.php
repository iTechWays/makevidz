<?php
function addons()
{
    global $config;

    $settings = "";

    if ( isset($_GET['settings']) )
    {
        $settings = $_GET['settings'];
    }

    if (! file_exists('../addons/' . $settings . '/settings.json') )
    {
        $settings = "";
    }

    if (! empty($settings) )
    {
        if (! empty($_POST['save_btn']) )
        {
            unset($_POST['save_btn']);
            file_put_contents('../addons/' . $settings . '/data.json', json_encode($_POST));
        }

        $settings_json = json_decode(file_get_contents('../addons/' . $settings . '/settings.json'), true);
        $data_json = array();

        if ( file_exists('../addons/' . $settings . '/data.json') )
        {
            $data_json = json_decode(file_get_contents('../addons/' . $settings . '/data.json'), true);
        }
        ?>
        <form class="content-container" method="post" action="?tab1=addons&settings=<?php echo $settings; ?>">
            <div class="content-header"><a href="?tab1=addons">Addons</a> &#8658; <?php echo ucfirst(str_replace(array('_', 'add.'), '', preg_replace('/([A-Z])/', ' $1', $settings))); ?></div>
            <?php
            foreach ($settings_json as $label => $input)
            {
            ?>
                <div class="content-wrapper">
                    <div class="label float-left"><?php echo $label; ?></div>
                    <div class="input float-left">
                        <?php
                        if ($input['tag'] == "input")
                        {
                        ?>
                            <input type="<?php echo $input['type']; ?>" name="<?php echo $input['name']; ?>" value="<?php echo (isset($data_json[$input['name']])) ? $data_json[$input['name']] : ""; ?>" placeholder="<?php echo $input['placeholder']; ?>">
                        <?php
                        }
                        elseif ($input['tag'] == "select")
                        {
                        ?>
                            <select name="<?php echo $input['name']; ?>">
                                <?php
                                $default_value = (isset($data_json[$input['name']])) ? $data_json[$input['name']] : "";

                                foreach ($input['options'] as $opt_value => $opt_label)
                                {
                                ?>
                                    <option value="<?php echo $opt_value; ?>" <?php if ($opt_value == $default_value) echo 'selected'; ?>><?php echo $opt_label; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        <?php
                        }
                        if ( isset($input['info']) )
                        {
                        ?>
                            <div class="info">
                                <?php echo $input['info']; ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="float-clear"></div>
                </div>
            <?php
            }
            ?>
            <div class="button-wrapper">
                <input type="submit" name="save_btn" value="Save Changes">
            </div>
        </form>
    <?php
    }
    else
    {
    ?>
        <div class="addon-container">
            <div class="addon-header">Addons</div>
            <?php
            $addons = glob('../addons/add.*', GLOB_ONLYDIR);
            
            foreach ($addons as $addon)
            {
                include($addon . '/info.php');
                $enabled = false;

                if ( file_exists($addon . '/enabled.html') )
                {
                    $enabled = true;
                }
            ?>
                <div class="addon-wrapper">
                    <div class="float-left icon">
                        <img src="<?php echo $addon; ?>/icon.png" width="87%" alt="<?php echo $name; ?>" valign="middle">
                    </div>
                    <div class="float-left info">
                        <div class="name">
                            <strong><?php echo $name; ?></strong>
                        </div>
                        <div class="version">
                            <label>Supported Version:</label> <?php echo $supported_version; ?>
                        </div>
                        <div class="author">
                            <label>Author:</label> <a href="<?php echo $author_url; ?>"><?php echo $author; ?></a>
                        </div>

                        <div class="btn">
                            <?php
                            if ($enabled)
                            {
                            ?>
                                <form method="post" action="?tab1=addons">
                                    <button class="activate-btn active-btn">Enabled</button>
                                    <input type="hidden" name="disable_addon" value="1">
                                    <input type="hidden" name="addon" value="<?php echo str_replace('../addons/', '', $addon); ?>">
                                    <input type="hidden" name="keep_blank" value="">
                                </form>
                            <?php
                            }
                            else
                            {
                            ?>
                                <form method="post" action="?tab1=addons">
                                    <button class="activate-btn">Enable</button>
                                    <input type="hidden" name="enable_addon" value="1">
                                    <input type="hidden" name="addon" value="<?php echo str_replace('../addons/', '', $addon); ?>">
                                    <input type="hidden" name="keep_blank" value="">
                                </form>
                            <?php
                            }
                            if ( file_exists($addon . '/settings.json') )
                            {
                            ?>
                                <form method="get" action="?">
                                    <button class="activate-btn">Settings</button>
                                    <input type="hidden" name="tab1" value="addons">
                                    <input type="hidden" name="settings" value="<?php echo str_replace('../addons/', '', $addon); ?>">
                                </form>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="float-clear"></div>
                </div>
            <?php
            }
            ?>
            <div class="addon-wrapper">
                <div class="info">To install an addon, upload it on the <strong>addons</strong> folder.</div>
            </div>
        </div>
    <?php
    }
}
?>