<?php
function youtube_search_launchericon()
{
	return '<span class="option" onclick="toggleMediaGroup(\'.youtube-search-wrapper\');">
        <i class="icon-film"></i>
    </span>';
}
\SocialKit\Addons::register('new_story_feature_launchericon', 'youtube_search_launchericon');
