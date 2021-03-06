<?php
function youtube_search_upload_option()
{
	global $lang;
	
	return '<div class="input-wrapper youtube-search-wrapper" data-group="A">
	    <i class="icon-film icon"></i>

	    <input class="youtube-input" type="text" onkeyup="searchYoutube(this.value);" value="' . $lang['post_publisher_youtube_placeholder'] . '" placeholder="' . $lang['post_publisher_youtube_placeholder'] . '" data-placeholder="' . $lang['post_publisher_youtube_placeholder'] . '">
	    
	    <div class="input-result-wrapper"></div>
	</div>
	<script>
	youtube_query = \'\';
	$(\'.youtube-input\').bind(\'input propertychange\', function() {
	    searchYoutube($(this).val());
	});

	function searchYoutube(query) {
	    if (query != youtube_query) {
	        main_wrapper = $(\'.story-publisher-box\');
	        youtube_wrapper = main_wrapper.find(\'.youtube-search-wrapper\');
	        result_wrapper = youtube_wrapper.find(\'.input-result-wrapper\');
	        youtube_query = query;
	        
	        if (query.length == 0) {
	            result_wrapper.slideUp(function(){
	                $(this).html(\'\');
	            });
	        } else {
	            result_wrapper.html(\'<div class="loading-wrapper"><i class="icon-spinner icon-spin"></i> ' . $lang['searching'] . '...</div>\').slideDown();
	            setTimeout(function () {
	                if (youtube_query == query) {
	                    getYoutube(query);
	                }
	            }, 1500);
	        }
	    }
	}

	function getYoutube(query) {
	    main_wrapper = $(\'.story-publisher-box\');
	    youtube_wrapper = main_wrapper.find(\'.youtube-search-wrapper\');
	    result_wrapper = youtube_wrapper.find(\'.input-result-wrapper\');
	    
	    if (query.length == 0) {
	        result_wrapper.slideUp(function () {
	            $(this).html(\'\');
	        });
	    } else {
	        query = query.replace("http://", "").replace("https://", "");
	        result_wrapper.html(\'<div class="loading-wrapper"><i class="icon-spinner icon-spin"></i> ' . $lang['searching'] . '...</div>\').slideDown();
	        
	        $.get(reqSource(), {t: \'addon\', a: \'youtube_search\', q: query}, function(data) {
	            
	            if (data.status == 200) {
	                
	                if (data.type == "embed") {
	                    youtube_wrapper
	                    .find(\'.youtube-link\')
	                    .remove()
	                    .end()
	                    .find(\'input.youtube-input\')
	                    .after(\'<input class="youtube-link" type="hidden" name="youtube_video_id" value="\' + query + \'">\')
	                    result_wrapper.slideUp();
	                } else if (data.type == "api") {
	                    result_wrapper.html(data.html);
	                }
	                
	            } else {
	                result_wrapper.html(\'<div class="no-wrapper">' . $lang['no_result_found'] . '</div>\');
	            }
	        });
	    }
	}

	function addYoutubeData(id,title) {
	    $(\'.story-publisher-box\').find(\'.youtube-search-wrapper\')
	        .append(\'<span class="remove-btn" onclick="removeYoutubeData();"><i class="icon-remove"></i></span>\')
	        .find(\'input.youtube-input\')
	            .hide()
	            .after(\'<div class="result-container"><span class="title">\' + title.substr(0,70) + \'</span><i class="icon-ok"></i><input type="hidden" name="youtube_title" value="\' + title + \'"><input type="hidden" name="youtube_video_id" value="\' + id + \'"></div>\')
	            .val(\'\')
	        .end().find(\'.input-result-wrapper\')
	            .slideUp(\'fast\',function(){
	                $(this).html(\'\');
	            });
		allowPost();
	}

	function removeYoutubeData() {
	    $(\'.story-publisher-box\').find(\'.youtube-search-wrapper\')
	        .find(\'.result-container\')
	            .remove()
	        .end().find(\'input.youtube-input\')
	            .show()
	            .focus()
	        .end().find(\'.remove-btn\')
	            .remove();
	    clearAllowPost();
	}
	</script>';
}
\SocialKit\Addons::register('new_story_feature_option', 'youtube_search_upload_option');
