<?php
function story_insert_youtube_search_data ($conn, $storyId, $Data)
{
	if (is_numeric($storyId))
	{
		if (! empty($Data['youtube_title']) && ! empty($Data['youtube_video_id']))
		{
			$escapeObj = new \SocialKit\Escape();
			$title = $escapeObj->stringEscape($Data['youtube_title']);
			$videoid = $escapeObj->stringEscape($Data['youtube_video_id']);

			$conn->query("UPDATE " . DB_POSTS . " SET youtube_video_id='$videoid',youtube_title='$title' WHERE id=" . $storyId);
		}
	}
}
\SocialKit\Addons::register('new_story_insert_data', 'story_insert_youtube_search_data');