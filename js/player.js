/**
 * Audio Player - HTML5 with Flash fallback
 *
 * @author Cormorant
 * @version 1.0
 * @package nomad2011
 **/

jQuery(document).ready(function(){

	//initAudio('/wp-content/uploads/2011/08/Testrack-Witch-Mono-320.mp3', 'Test Name');
	
});

function initAudio(src, title) {
    
    var supportsAudio = !!document.createElement('audio').canPlayType,
            audio,
            loadingIndicator,
            positionIndicator,
            timeleft,
            loaded = false,
            manualSeek = false;

    if (supportsAudio) {
        
        var player = '<span class="close" /><p class="player">\
                                      <span id="playtoggle" />\
                                      <span id="gutter">\
                                        <span id="loading" />\
                                        <span id="handle" class="ui-slider-handle" />\
                                      </span>\
                                      <span id="timeleft" />\
									  <span id="audio-title" />\
                                      <audio preload="metadata">\
                                        <source src="'+src+'" type="audio/mpeg"></source>\
                                        </audio>\
                                    </p>';                                  
        
		jQuery('#player').html(player);
        jQuery('#audio-title').html(title);

        audio = jQuery('.player audio').get(0);
        loadingIndicator = jQuery('.player #loading');
        positionIndicator = jQuery('.player #handle');
        timeleft = jQuery('.player #timeleft');
        
        if ((audio.buffered != undefined) && (audio.buffered.length != 0)) {
            jQuery(audio).bind('progress', function() {
                var loaded = parseInt(((audio.buffered.end(0) / audio.duration) * 100), 10);
                loadingIndicator.css({width: loaded + '%'});
            });
        }
        else {
            loadingIndicator.remove();
        }
        
        jQuery(audio).bind('timeupdate', function() {
            
            var rem = parseInt(audio.duration - audio.currentTime, 10),
                    pos = (audio.currentTime / audio.duration) * 100,
                    mins = Math.floor(rem/60,10),
                    secs = rem - mins*60;
            
            timeleft.text('-' + mins + ':' + (secs < 10 ? '0' + secs : secs));
            if (!manualSeek) { positionIndicator.css({left: pos + '%'}); }
            if (!loaded) {
                loaded = true;
                
                jQuery('.player #gutter').slider({
                        value: 0,
                        step: 0.01,
                        orientation: "horizontal",
                        range: "min",
                        max: audio.duration,
                        animate: true,                  
                        slide: function(){                          
                            manualSeek = true;
                        },
                        stop:function(e,ui){
                            manualSeek = false;                 
                            audio.currentTime = ui.value;
                        }
                    });
            }
            
        }).bind('play',function(){
            jQuery("#playtoggle").addClass('playing');       
        }).bind('pause ended', function() {
            jQuery("#playtoggle").removeClass('playing');        
        });     
        
        jQuery("#playtoggle").click(function() {         
            if (audio.paused) { audio.play();   } 
            else { audio.pause(); }         
        });

    }
    
    
}