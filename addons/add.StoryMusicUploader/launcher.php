<?php
function music_upload_launchericon()
{
	global $user;
	$addon_data = json_decode(file_get_contents('addons/add.StoryMusicUploader/data.json'), true);
	
	if ($addon_data['verified_only'] == 1 && $user['verified'] == 0)
	{
		return "";
	}
	
	return '<span class="option" onclick="javascript:$(\'.story-publisher-box\').find(\'input.music-upload-input\').click();">
		<i class="fa fa-file-audio-o"></i>
	</span>

	<input class="music-upload-input" type="file" name=\'music_upload\' multiple="yes" accept=".mp3" onchange="viewMusicUploadDisplayer(this);" style="height:1px;width:1px;overflow:hidden;margin-left:-999px;display:none;">

	<script>
	function viewMusicUploadDisplayer(input)
	{
		music = input.files[0];
		music_size = ' . $addon_data['max_upload_limit'] * 1024 * 1024 . ';

		if (music.size > music_size)
		{
			alert("File size is too large. Maximum file upload limit is ' . $addon_data['max_upload_limit'] . ' MB");
			$(".music-upload-input").val("");
		}

		if (music.name.length > 4 && music.size < music_size)
    	{
    		parent_wrapper = $(\'.story-publisher-box\');
    		input_wrapper = parent_wrapper.find(\'.music-upload-wrapper\');
    		group_id = input_wrapper.attr(\'data-group\');

    		parent_wrapper.find(\'.music-upload-container\').html(\'<i class="fa fa-file-audio-o"></i> \' + music.name);

	    	$(\'.input-wrapper[data-group=\' + group_id + \']\').slideUp();
	    	input_wrapper.slideDown();

	    	allowPost();
    	}
	}
	</script>';
}
\SocialKit\Addons::register('new_story_feature_launchericon', 'music_upload_launchericon');
