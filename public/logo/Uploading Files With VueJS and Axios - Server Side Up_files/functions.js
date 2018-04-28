/*
	Flags whether the posts are being loaded or not. The viewport
	will be in view while they load so this prevents double loading.
*/
var ssuLoadingPosts = false;

/*
	Initialize Highlight.js when the page is ready
*/
hljs.initHighlightingOnLoad();

/*
|-------------------------------------------------------------------------------
| Document Ready
|-------------------------------------------------------------------------------
| Listens to the ready event for the document
*/
jQuery(document).ready(function($){
	jQuery.each( jQuery('.article-title'), function( index, value ){
		$clamp( value, { clamp: 2 });
	} );

	jQuery.each( jQuery('.affiliate-product-header'), function( index, value ){
		$clamp( value, { clamp: 2 });
	} );

	jQuery.each( jQuery('.article-excerpt p'), function( index, value ){
		$clamp( value, { clamp: 3 });
	} );

	jQuery.each( jQuery('.affiliate-link-description p'), function( index, value ){
		$clamp( value, { clamp: 3 });
	} );

	ssuCenterSeriesText();

	jQuery('.watch').on('click', function(){
		$('#ssu-series-trailer-modal').show();
	});

	jQuery('#ssu-series-trailer-modal').on('click', function(){
		$(this).hide();
	});

	/*
		Handles the click on the load more button.
	*/
	jQuery('#load-more').on('click', function(){
		ssuLoadMorePosts();
	});

	/*
		Applies fluid box to anchor elements that wrap images.
	*/
	jQuery('a.ssu-anchor-img').fluidbox({
		resizeThrottle: 300
	});

	/*
		When the user scrolls, we need to determine if they are
		at the bottom of the posts list and the load more is in
		the view port, then we load more posts.
	*/
	jQuery( window ).on('scroll', function(){
		if( jQuery('#load-more').length > 0
			&& ssuLoadMoreInViewPort( jQuery('#load-more') )
			&& currentPostCount < totalPostCount ){
				ssuLoadMorePosts();
		}
	});

	/*
		Sets all of the time ago elements to the timezone based
		time ago text.
	*/
	jQuery('.author-time').each( function( index, value ){
		jQuery(this).html( ssuDisplayTimeAgo( jQuery(this).attr('data-attr-date') ) + ' ago' );
	});

	/*
		Keeps the header sizes consistant
	*/
	setHeaderSize();
});

/*
	When the window resizes, we keep the header size consistent.
*/
jQuery(window).on('resize', function(){
	setHeaderSize();
});

/*
	Set the header size with gradient and content.
*/
function setHeaderSize(){
	jQuery('#header').css('min-height', jQuery('#header-content').height() + 'px' );
	jQuery('#header-gradient').css('min-height', jQuery('#header-content').height() + 'px' );
	jQuery('#header-content').css('margin-top', '-'+jQuery('#header-content').height() + 'px' );
}

/*
|-------------------------------------------------------------------------------
| Load More In Viewport
|-------------------------------------------------------------------------------
| Determines whether the load more element is in the view port or not
|
| Help From:
|
| http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport/7557433#7557433
|
| PARAMETERS:
|	loadMoreElement 	-> The load more element that we are determinining is
| 						   in the viewport or not.
*/
function ssuLoadMoreInViewPort( loadMoreElement ){
	/*
		Ensures we have the right load more element when using jQuery
	*/
	if( typeof jQuery === 'function' && loadMoreElement instanceof jQuery ){
		loadMoreElement = loadMoreElement[0]
	}

	/*
		Gets the bounding rectangle for the load more element.
	*/
	var rect = loadMoreElement.getBoundingClientRect();

	/*
		Returns whether or not the element is in the viewport.
	*/
	return (
		rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= ( window.innerHeight || document.documentElement.clientHeight ) &&
        rect.right <= ( window.innerWidth || document.documentElement.clientWidth )
	);
}

/*
|-------------------------------------------------------------------------------
| Load More Posts
|-------------------------------------------------------------------------------
| Determines loads more posts for the page if there are some available.
*/
function ssuLoadMorePosts(){
	/*
		Ensures the load posts method is not still running.
	*/
	if( !ssuLoadingPosts ){
		/*
			Flag the method load posts method as running.
		*/
		ssuLoadingPosts = true;

		/*
			Hides the text and show the loading wheel
		*/
		jQuery('#load-more-text').hide();
		jQuery('#load-more-loading').show();

		/*
			Send the post request to the server to load more posts
		*/
		jQuery.post(
			SSUAjax.ajaxurl,
			{
				action: 'ssu_load_posts',
				ssuLoadPostsNonce: SSUAjax.loadPostsNonce,
				offset: currentPostCount,
				category: category
			},
			function( response ){
				/*
					Display the posts returned from the server.
				*/
				ssuDisplayLoadedPosts( response.posts, response.shown_posts );

				jQuery.each( jQuery('.article-title'), function( index, value ){
					$clamp( value, { clamp: 2 });
				} );

				jQuery.each( jQuery('.article-excerpt p'), function( index, value ){
					$clamp( value, { clamp: 3 });
				} );
			}
		);
	}
}

/*
|-------------------------------------------------------------------------------
| Display Time Ago
|-------------------------------------------------------------------------------
| Displays how long ago the post was written
|
| PARAMETERS:
| 	date 	-> The date the post was written.
*/
function ssuDisplayTimeAgo( date ){
	/*
		Get the current date object and the date time object
		from the date passed in.
	*/
	var now = new Date();
	var datetime =  new Date( date.replace(/-/g, "/") );

	/*
		Sets the date time to be the proper time.
	*/
	datetime.setTime( datetime.getTime() );

	/*
		Computes the seconds that have gone by since
		the date.
	*/
	var seconds = Math.floor( ( now.getTime() - datetime.getTime() ) / 1000 );

	/*
		Checks to see if the interval is greater than
		a year.
	*/
	var interval = Math.floor( seconds / 31536000 );

	if ( interval > 1 ) {
		if( interval == 1 ){
			return interval + " year";
		}else{
			return interval + " years";
		}
	}

	/*
		Checks to see if the interval is greater than
		a month.
	*/
	interval = Math.floor( seconds / 2592000 );

	if ( interval >= 1 ) {
		if( interval == 1 ){
			return interval + " month";
		}else{
			return interval + " months";
		}
	}

	/*
		Checks to see if the interval is greater than
		a day.
	*/
	interval = Math.floor( seconds / 86400 );

	if ( interval >= 1 ) {
		if( interval == 1 ){
			return interval + " day";
		}else{
			return interval + " days";
		}
	}

	/*
		Checks to see if the interval is greater than
		an hour.
	*/
	interval = Math.floor( seconds / 3600 );

	if ( interval >= 1 ) {
		if( interval == 1 ){
			return interval + " hour";
		}else{
			return interval + " hours";
		}
	}

	/*
		Checks to see if the interval is greater than
		a minute.
	*/
	interval = Math.floor( seconds / 60 );

	if ( interval >= 1 ) {
		if( interval == 1 ){
			return interval + " minute";
		}else{
			return interval + " minutes";
		}
	}

	/*
		Returns the seconds since the date has passed.
	*/
	return Math.floor( seconds ) + " seconds";
}

/*
|-------------------------------------------------------------------------------
| SSU Display Loaded Posts
|-------------------------------------------------------------------------------
| Displays the loaded posts returned from the server.
*/
function ssuDisplayLoadedPosts( posts, shownPosts ){
	/*
		Removes the end class from all of the columns
	*/
	jQuery('.columns').removeClass('end');

	/*
		Iterates over all of the posts loaded, appending the posts to the page.
	*/
	jQuery.each( posts, function( index, value ){
		/*
			Builds the post display.
		*/
		var postText = '';

		postText += '<div class="large-4 medium-6 small-12 columns">';
			postText += '<div class="article">';
				postText += '<a href="'+value.permalink+'"><img src="'+value.image+'" class="article-header"/></a>';
				postText += '<div class="article-content">';
					postText += '<a href="'+value.permalink+'"><div class="article-title">'+value.title+'</div></a>';
					postText += '<div class="article-excerpt"><p>'+value.excerpt+'</p></div>';
				postText += '</div>';
				postText += '<div class="article-footer">';
					postText += '<img src="'+value.author.image+'" class="author-image"/>';
					postText += '<div class="author-meta">';
						postText += '<span class="author-name">'+value.author.name+'</span>';
						postText += '<span class="author-time">'+ssuDisplayTimeAgo( value.date )+' ago</span><span class="author-dot">&#183;</span>';
						postText += '<span class="author-tag">';

							/*
								Iterates over all of the categories
								appending them to the post display. Makes
								sure we don't add any of the categories like
								Featured Posts or Uncategorized.
							*/
							jQuery.each( value.category, function( catIndex, catValue ){
								if( !( catValue == 'Featured Posts'
									|| catValue == 'Uncategorized' ) ){
										postText += '<a href="/'+catValue.toLowerCase()+'/">'+catValue+'</a>';
									}
							});

						postText += '</span>';
					postText += '</div>';
				postText += '</div>';
			postText += '</div>';
		postText += '</div>';

		/*
			Adds the post to the page before the load more container so the
			container is always at the end.
		*/
		jQuery('#load-more-container').before( postText );

	});

	/*
		Shows the text and hides the loader
	*/
	jQuery('#load-more-text').show();
	jQuery('#load-more-loading').hide();

	/*
		If the shown posts matches the total post count, then we hide
		the load more button, otherwise we add the 'end' class to the
		load more container.
	*/
	if( shownPosts == totalPostCount ){
		jQuery('#load-more').hide();
	}else{
		jQuery('#load-more-container').addClass('end');
	}

	/*
		Sets the current post count to the shown posts on the screen.
	*/
	currentPostCount = shownPosts;

	/*
		Flag the loading post method as complete.
	*/
	ssuLoadingPosts = false;
}

/*
	Centers the series text on the page.
*/
function ssuCenterSeriesText(){
	if( jQuery('#series-feature-overlay') ){
		var seriesFeatureOverlayHeight = jQuery('#series-feature-overlay').height();
		var seriesFeatureOverlayTextContainerHeight = jQuery('.series-feature-overlay-text-container').height();

		jQuery('.series-feature-overlay-text-container').css('margin-top', ( seriesFeatureOverlayHeight / 2 ) - ( seriesFeatureOverlayTextContainerHeight / 2 ) + 'px' );
	}
}
