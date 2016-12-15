<?php
function story_insert_soundcloud_search_data ($conn, $storyId, $Data)
{
	if (is_numeric($storyId))
	{
		if (! empty($Data['soundcloud_uri']) && ! empty($Data['soundcloud_title']))
		{
			$escapeObj = new \SocialKit\Escape();
			$uri = $escapeObj->stringEscape($Data['soundcloud_uri']);
			$title = $escapeObj->stringEscape($Data['soundcloud_title']);

			$conn->query("UPDATE " . DB_POSTS . " SET soundcloud_uri='$uri',soundcloud_title='$title' WHERE id=" . $storyId);
		}
	}
}
\SocialKit\Addons::register('new_story_insert_data', 'story_insert_soundcloud_search_data');