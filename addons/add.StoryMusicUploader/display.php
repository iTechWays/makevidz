<?php
function story_display_music ($conn, $story)
{
	$query = $conn->query("SELECT * FROM story_music_uploads WHERE story_id=" . $story['id']);
	
	if ($query->num_rows == 1)
	{
		$fetch = $query->fetch_array(MYSQLI_ASSOC);
		return '<audio id="story-' . $story['id'] . '-music-upload" class="story-music-upload-html" src="' . $fetch['url'] . '" controls="yes" preload="no" style="width: 100%;">
			Your browser does not support the audio tag.
		</audio>
		<script>$(\'audio#story-' . $story['id'] . '-music-upload\').mediaelementplayer();</script>';
	}
}
\SocialKit\Addons::register('story_display_addon_data', 'story_display_music');