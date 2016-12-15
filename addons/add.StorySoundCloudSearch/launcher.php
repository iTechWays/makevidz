<?php
function soundcloud_search_launchericon()
{
	return '<span class="option" onclick="toggleMediaGroup(\'.soundcloud-search-wrapper\');">
        <i class="icon-music"></i>
    </span>';
}
\SocialKit\Addons::register('new_story_feature_launchericon', 'soundcloud_search_launchericon');
