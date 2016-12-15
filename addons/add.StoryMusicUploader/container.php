<?php
function music_upload_option()
{
	global $user;
	$addon_data = json_decode(file_get_contents('addons/add.StoryMusicUploader/data.json'), true);
	
	if ($addon_data['verified_only'] == 1 && $user['verified'] == 0)
	{
		return "";
	}
	return '<div class="input-wrapper music-upload-wrapper" data-group="D">
	    <div class="float-left">
			<div class="music-upload-container">No music uploaded</div>
		</div>

		<div class="float-clear"></div>
	</div>';
}
\SocialKit\Addons::register('new_story_feature_option', 'music_upload_option');
