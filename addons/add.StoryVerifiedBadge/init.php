<?php
function story_verified_badge ($conn, $story, $uiContent)
{
	$verifiedQuery = $conn->query("SELECT id FROM " . DB_ACCOUNTS . " WHERE id=" . $story['timeline']['id'] . " AND verified=1 AND active=1");

	if ($verifiedQuery->num_rows == 1)
	{
		$uiBadge = '<span class="story-verified-badge"><i class="icon-ok"></i></span>';
		$uiContent = str_replace('{{STORY_TIMELINE_LINK}}', '{{STORY_TIMELINE_LINK}} ' . $uiBadge, $uiContent);
	}

	return $uiContent;
}
\SocialKit\Addons::register('story_content_ui_editor', 'story_verified_badge');

/* CSS */
function story_verified_badge_css()
{
	return '<style>
	.story-verified-badge {
		display: inline-block;
		vertical-align: middle;
		background: #2B90B9;
		color: white;
		text-shadow: 0 0 0 white;
		font-size: 7px;
		margin-bottom: 5px;
		padding: 0 1px 1px 2px;
		border: 2px solid white;
		border-radius: 100%;
	}
	</style>';
}
\SocialKit\Addons::register('head_tags_add_content', 'story_verified_badge_css');