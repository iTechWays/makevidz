<?php
function soundcloud_search_display_music ($conn, $story)
{
	$query = $conn->query("SELECT soundcloud_uri FROM " . DB_POSTS . " WHERE id=" . $story['id']);
	
	if ($query->num_rows == 1)
	{
		$fetch = $query->fetch_array(MYSQLI_ASSOC);

		if (! empty($fetch['soundcloud_uri']))
		{
			return '<div class="soundcloud-wrapper" align="center">
			    <iframe frameborder="0" src="https://w.soundcloud.com/player/?url=' . $fetch['soundcloud_uri'] . '&amp;color=f07b22" width="100%"></iframe>
			</div>';
		}
	}
}
\SocialKit\Addons::register('story_display_addon_data', 'soundcloud_search_display_music');