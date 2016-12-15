<?php
function soundcloud_search_upload_option()
{
	global $lang;
	
	return '<div class="input-wrapper soundcloud-search-wrapper" data-group="A">
	    <i class="icon-music icon"></i>

	    <input class="soundcloud-input" type="text" onkeyup="searchSoundcloud(this.value);" value="' . $lang['post_publisher_soundcloud_placeholder'] . '" placeholder="' . $lang['post_publisher_soundcloud_placeholder'] . '" data-placeholder="' . $lang['post_publisher_soundcloud_placeholder'] . '">
	    
	    <div class="input-result-wrapper"></div>
	</div>
	<script>
	soundcloud_query = \'\';
	$(\'.soundcloud-input\').bind(\'input propertychange\', function() {
	    searchSoundcloud($(this).val());
	});

	function searchSoundcloud(query) {
	    if (query != soundcloud_query) {
	        main_wrapper = $(\'.story-publisher-box\');
	        soundcloud_wrapper = main_wrapper.find(\'.soundcloud-search-wrapper\');
	        result_wrapper = soundcloud_wrapper.find(\'.input-result-wrapper\');
	        soundcloud_query = query;
	        
	        if (query.length == 0) {
	            result_wrapper.slideUp(function(){
	                $(this).html(\'\');
	            });
	        } else {
	            result_wrapper.html(\'<div class="loading-wrapper"><i class="icon-spinner icon-spin"></i> ' . $lang['searching'] . '...</div>\').slideDown();
	            setTimeout(function () {
	                if (soundcloud_query == query) {
	                    getSoundcloud(query);
	                }
	            }, 1500);
	        }
	    }
	}

	function getSoundcloud(query) {
	    main_wrapper = $(\'.story-publisher-box\');
	    soundcloud_wrapper = main_wrapper.find(\'.soundcloud-search-wrapper\');
	    result_wrapper = soundcloud_wrapper.find(\'.input-result-wrapper\');
	    
	    if (query.length == 0) {
	        result_wrapper.slideUp(function () {
	            $(this).html(\'\');
	        });
	    } else {
	        query = query.replace("http://", "").replace("https://", "");
	        result_wrapper.html(\'<div class="loading-wrapper"><i class="icon-spinner icon-spin"></i> ' . $lang['searching'] . '...</div>\').slideDown();
	        
	        $.get(reqSource(), {t: \'addon\', a: \'soundcloud_search\', q: query}, function(data) {
	            
	            if (data.status == 200) {
	                
	                if (data.type == "embed") {
	                    soundcloud_wrapper
	                    .append(\'<span class="remove-btn" onclick="removeSoundcloudData();"><i class="icon-remove"></i></span>\')
	                    .find(\'input.soundcloud-input\')
	                    .hide()
	                    .after(\'<div class="result-container"><span class="title">https://\' + query + \'</span><i class="icon-ok"></i><input type="hidden" name="soundcloud_title" value="Embedded"><input type="hidden" name="soundcloud_uri" value="\' + data.sc_uri + \'"></div>\')
	                    .val(\'\');
	                    result_wrapper.slideUp(function () {
	                        $(this).html(\'\');
	                    });
	                } else if (data.type == "api") {
	                    result_wrapper.html(data.html);
	                }
	            }
	            else {
	                result_wrapper.html(\'<div class="no-wrapper">' . $lang['no_result_found'] . '</div>\');
	            }
	        });
	    }
	}

	function addSoundcloudData(title,uri) {
	    $(\'.story-publisher-box\').find(\'.soundcloud-search-wrapper\')
	        .append(\'<span class="remove-btn" onclick="removeSoundcloudData();"><i class="icon-remove"></i></span>\')
	        
	        .find(\'input.soundcloud-input\')
	            .hide()
	            .after(\'<div class="result-container"><span class="title">\' + title.substr(0,70) + \'</span><i class="icon-ok"></i><input type="hidden" name="soundcloud_title" value="\' + title + \'"><input type="hidden" name="soundcloud_uri" value="\' + uri + \'"></div>\')
	            .val(\'\')
	            
	        .end().find(\'.input-result-wrapper\')
	            .slideUp(function () {
	                $(this).html(\'\');
	            });
		allowPost();
	}

	function removeSoundcloudData() {
	    $(\'.story-publisher-box\').find(\'.soundcloud-search-wrapper\')
	        .find(\'.result-container\')
	            .remove()
	        .end().find(\'input.soundcloud-input\')
	            .show()
	            .focus()
	        .end().find(\'.remove-btn\')
	            .remove();
	    clearAllowPost();
	}
	</script>';
}
\SocialKit\Addons::register('new_story_feature_option', 'soundcloud_search_upload_option');
