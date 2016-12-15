<?php
$themeData['about_page_url'] = smoothLink('index.php?tab1=terms&tab2=about');
$themeData['create_page_url'] = smoothLink('index.php?tab1=create_page');
$themeData['create_group_url'] = smoothLink('index.php?tab1=create_group');
$themeData['contact_page_url'] = smoothLink('index.php?tab1=terms&tab2=contact');
$themeData['privacy_page_url'] = smoothLink('index.php?tab1=terms&tab2=privacy');
$themeData['tos_page_url'] = smoothLink('index.php?tab1=terms&tab2=tos');
$themeData['disclaimer_page_url'] = smoothLink('index.php?tab1=terms&tab2=disclaimer');
$themeData['developers_page_url'] = smoothLink('index.php?tab1=terms&tab2=developers');
$themeData['admin_url'] = $config['site_url'] . '/admin/';
$themeData['languages'] = getLanguages();
$themeData['year'] = date('Y');
$themeData['footer_pages'] = ($isLogged) ? \SocialKit\UI::view('footer/pages') : \SocialKit\UI::view('footer/guest-pages');
$themeData['footer_pages'] .= \SocialKit\Addons::invoke(array('footer_add_page', 'string'));
$themeData['footer'] = \SocialKit\UI::view('footer/content');

/* Chat and Onlines */
if ($isLogged && $config['chat'] == 1)
{
    $themeData['num_onlines'] = countOnlines();

    if ($themeData['num_onlines'] == 0)
    {
        $themeData['no_onlines'] = ($config['friends'] == true) ? $lang['no_friends_online'] : $lang['no_followers_online'];
        $themeData['list_onlines'] = \SocialKit\UI::view('chat/no-onlines');
    }
    else
    {
        $listOnlines = '';

        foreach (getOnlines() as $k => $v)
        {
            $themeData['list_online_id'] = $v['id'];
            $themeData['list_online_name'] = $v['name'];
            $themeData['list_online_thumbnail_url'] = $v['thumbnail_url'];
            $themeData['list_online_name_short'] = substr($v['name'], 0, 15);
            $themeData['list_online_class'] = ($v['online'] == true) ? 'active' : '';
            $themeData['list_online_num_messages_html'] = (($themeData['list_online_num_messages'] = countMessages(0, $v['id'], true)) > 0) ? \SocialKit\UI::view('chat/list-num-messages-each') : "";
            $listOnlines .= \SocialKit\UI::view('chat/online-column');
        }

        $themeData['list_onlines'] = $listOnlines;
    }

    $themeData['footer'] .= \SocialKit\UI::view('chat/container');
}

$themeData['footer'] .= '<audio id="notification-sound" preload="auto"><source src="{{CONFIG_THEME_URL}}/sounds/notification.ogg" type="audio/ogg"><source src="{{CONFIG_THEME_URL}}/sounds/notification.mp3" type="audio/mpeg"><source src="{{CONFIG_THEME_URL}}/sounds/notification.wav" type="audio/wav"></audio><script>function updateAlerts(){$(".update-alert").each(function(){var t=1*$(this).text();0==t&&$(this).hide()}),$(".new-update-alert").each(function(){var t=1*$(this).text();0==t&&$(this).hide()})}function SK_checkUsername(t,e,a,s){a=$(a),target_html="",$.get(SK_source(),{t:"username",a:"check",q:t,timeline_id:e},function(t){200==t.status?1==s?target_html=\'<span style="color: #94ce8c;"><i class="icon-ok"></i> ' . $lang['username_available'] . '</span>\':target_html=\'<span style="color: #94ce8c;"><i class="icon-ok"></i></span>\':201==t.status?1==s?target_html=\'<span style="color: #94ce8c;">' . $lang['username_this_is_you'] . '</span>\':target_html=\'<span style="color: #94ce8c;"></span>\':410==t.status?1==s?target_html=\'<span style="color: #ee2a33;"><i class="icon-remove"></i> ' . $lang['username_not_available'] . '</span>\':target_html=\'<span style="color: #ee2a33;"><i class="icon-remove"></i></span>\':406==t.status&&(1==s?target_html=\'<span style="color: #ee2a33;"><i class="icon-remove"></i> ' . $lang['username_requirements'] . '</span>\':target_html=\'<span style="color: #ee2a33;"><i class="icon-remove"></i></span>\'),0==target_html.length?a.html("").hide():a.html(target_html).show()})}$(function(){updateAlerts()});</script>';
$themeData['footer'] .= \SocialKit\Addons::invoke(array('body_end_add_content', 'string'));
