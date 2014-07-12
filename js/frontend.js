/**
 * Main Front End JS Stuff:
 * Sticky Nav / Listen links / Player
 *
 * @author Cormorant
 * @version 1.0
 * @package nomad2011
 **/

soundManager.url = themedir+'/js/soundmanager/swf/';
soundManager.flashVersion = 9;
soundManager.useFlashBlock = false;
soundManager.consoleOnly = true;

jQuery(document).ready(function(){
	
	var nav = jQuery('#nav'),
		head = jQuery('header#top'),
		player = jQuery('#player'),
		player_loaded = false;
	
	/* Stick the nav bar / player to the top of the window when it scrolls out of view */
	
	jQuery(window).scroll(function() {
		if (getYOffset() > 140 ) {
			if(!nav.hasClass('sticky')) {
				var h = head.height();
				head.height(h+30);
				nav.addClass('sticky');
			}
		} else {
			nav.removeClass('sticky');
			head.height('auto');
			//jQuery('header#top').
		}
	});
	
	// Preload button images
	jQuery([themedir+'/images/audio-pause.png', 
		themedir+'/images/audio-play.png', 
		themedir+'/images/listen.png',
		themedir+'/images/audio-buffering.gif']).preload();
	
	soundManager.onready(function(){
	
		// SM2 loaded, so make the player
		var player_code = 
		'<span class="close" />\
		<p class="player-ctrl">\
			<span id="playtoggle" />\
			<span id="gutter">\
				<span id="loading" />\
				<span id="handle" class="ui-slider-handle" />\
			</span>\
			<span id="timeleft" />\
			<span id="audio-title" />\
		</p>';
		player.html(player_code);
		
		// Get elements for later
		var bufferEl = jQuery('.player-ctrl #loading'),
	        posEl = jQuery('.player-ctrl #handle'),
	        timeleftEl = jQuery('.player-ctrl #timeleft'),
			playEl = jQuery("#playtoggle"),
			titleEl = jQuery('#audio-title'),
			audioObj; 
		
		// Make slider
		var manualSeek = false;
		positionSlider = jQuery('.player-ctrl #gutter').slider({
			value: 0,
			step: 0.01,
			orientation: "horizontal",
			range: "min",
			//max: audioObj.durationEstimate, (set dynamically on audio load)
			animate: true,                  
			slide: function(){                          
			    manualSeek = true;
			},
			stop:function(e,ui){
			    manualSeek = false;    
			    audioObj.setPosition(ui.value);
				console.log("slide to"+ui.value);
			}
		});
		
		// Play / Pause action
		playEl.click(function(){
			audioObj.togglePause();
		});
		
		function initAudio(src, title) {

			titleEl.html(title);
			
			// get rid of any previous audio
			soundManager.destroySound('nomad');
			// Show loading spinner
			//playEl.addClass('')
			audioObj = soundManager.createSound({
				id: 'nomad',
				url: src,
				onload: function() {
					
				},
				onbufferchange: function() {
					if(audioObj.isBuffering) {
						playEl.addClass('buffering');
					} else {
						playEl.removeClass('buffering');
					}
				},
				whileloading: function() {
					// Update buffer bar
					var loaded = parseInt(((audioObj.bytesLoaded / audioObj.bytesTotal) * 100), 10);
					bufferEl.css({width: loaded + '%'});
					//console.log("NOMAD: whileloading - de="+audioObj.durationEstimate);
					//console.log(positionSlider);
					// Update slider range
					positionSlider.slider('option', 'max', audioObj.durationEstimate);
				},
				onplay: function() {
					playEl.addClass('playing');  
					target_links('_blank');
					_gaq.push(['_trackEvent', 'Player', 'Play', title]);
				},
				onresume: function() {
					playEl.addClass('playing');
					target_links('_blank');  
				},
				onpause: function() {
					playEl.removeClass('playing');
					target_links('_self');
				},
				whileplaying: function() {
					if(!manualSeek){
						var dur = audioObj.durationEstimate,
							pos = audioObj.position,
							pc = (pos / dur) * 100;
						posEl.css({left: pc + '%'});
						//positionSlider.slider("value", audioObj.position);
						//console.log("ms = false");
					} else {
						//console.log("ms = true");
					}
				}
			});
		
			audioObj.play();
		
		}
	
		/* Create Listen links */

		jQuery('a.music-action.download').each( function() {
			var e = jQuery(this);
			var h = e.attr('href');
			e.after('<a href="'+h+'" class="music-action listen" onclick="return false;">Listen</a>');
		});

		/* Handle Listen Buttons - Tell player to play MP3s */

		jQuery('.music-action.listen').click( function() {
	
			// Get info for player
			var src = jQuery(this).attr('href');
			var title = jQuery(this).parent().parent().find('a[rel=bookmark]').html();
	
			initAudio(src, title);
			//playAudio();
			player.addClass('active');
			// target_links('_blank');
	
			/* Close button */
			jQuery('span.close').click(function(){
				//console.log("close");
				audioObj.stop();
				player.removeClass('active');
				target_links('_self');
				return false;
			})
	
			return false;
	
		});
	});
	
	soundManager.ontimeout(function(){
		// SM2 could not start.
		console.log("NOMAD: SM2 Timeout");
		player.html("Error. The Player Didn't load - SM2 Timeout");
		player.addClass('active');
	});
	
});



/* HELPER FUNCTIONS -------------------------------- */

/* Make links open in new windows */

function target_links(t) {
	jQuery('a:not(.music-action)').attr('target', t);
}

/* Preload Images */

jQuery.fn.preload = function() {
    this.each(function(){
        jQuery('<img/>')[0].src = this;
    });
}

/* Get Page Offset (cross-browser) */

function getYOffset() {
    var pageY;
    if(typeof(window.pageYOffset)=='number') {
       pageY=window.pageYOffset;
    }
    else {
       pageY=document.documentElement.scrollTop;
    }
    return pageY;
}

