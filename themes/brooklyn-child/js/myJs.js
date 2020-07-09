jQuery(document).ready(function($){
//ServiceWorker
    	if ('serviceWorker' in navigator) {
    		console.log("Will the service worker register?");
    		navigator.serviceWorker.register("https://ilc.upd.edu.ph/wp-content/themes/brooklyn-child/js/service-worker.js")
      		.then(function(reg){
        	console.log("Yes, it did.");
        	}).catch(function(err) {
        	console.log("No it didn't. This happened: ", err)
        	});
  	}
//Modify Footer Link
	var link = $('.footer-srv').find('a').attr('href');
          $('.footer-srv-sub a').each(function(){
              $(this).attr('href', function(i, old){
                    return old.replace('/index.php/services', link);
              });
          });
//Close Modal Keyfunction
$(document).keyup(function(e){
		if(e.which == 27){
			$('.latestpost-modal').css('display', 'none');
		}
	});
//Close Modal Keyfunction
   $(window).scroll(function(e){
    if($(this).scrollTop() < 100) {
        $('.myscroll-to-top').fadeOut();
        $('.icontact-box-button').css('bottom','10px');
        $('.icontact-box').css('bottom','75px');
    } else {
        $('.myscroll-to-top').fadeIn();
        $('.icontact-box-button').css('bottom','75px');
        $('.icontact-box').css('bottom','140px');
    }
  });
//Scroll to Top
  $('.myscroll-to-top').on('click', function(){
     $('html, body').animate({
	scrollTop: 0
	}, 800);
	return false;
  });
//Mobile Menu Clickable
$('#ut-mobile-nav .menu-item-has-children').prepend('<span class="parentmenu-button dashicons dashicons-arrow-right-alt2"></span>');
$('.about-menu-css .parentmenu-button').click(function(e){
     $('.about-menu-css > .sub-menu').toggleClass('show-submenu');
     $(this).toggleClass('rotate-font');
});
$('.announce-menu-css .parentmenu-button').click(function(e){
     $('.announce-menu-css > .sub-menu').toggleClass('show-submenu');
     $(this).toggleClass('rotate-font');
});
$('.service-menu-css .parentmenu-button').click(function(e){
     $('.service-menu-css > .sub-menu').toggleClass('show-submenu');
     $(this).toggleClass('rotate-font');
});
$('.learning-menu-css .parentmenu-button').click(function(e){
     $('.learning-menu-css > .sub-menu').toggleClass('show-submenu');
     $(this).toggleClass('rotate-font');
});
$('.intern-menu-css .parentmenu-button').click(function(e){
     $('.intern-menu-css > .sub-menu').toggleClass('show-submenu');
     $(this).toggleClass('rotate-font');
});
//Mobile Menu Clickable
//Global Google Search
$('.google-search-open').on('click', function(){
    $(this).toggleClass('dashicons-no-alt');
    $(this).toggleClass('dashicons-search');
    $('.header-google-search').toggleClass('display-google-search');
});
//Mobile Google Search
$('.mobiletable-icon-search').on('click', function(){
    $('.mobiletable-icon-search > span').toggleClass('dashicons-no-alt');
    $('.mobiletable-icon-search > span').toggleClass('dashicons-search');
    $('.mobiletablet-google-search').toggleClass('mobiletable-google-show');
    $('html, body').animate({
        scrollTop: 0
        }, 800);
        return false;
});
//Input to Google Search
/*$('.search-form').on('submit',function(){ return false; });
$('.search-submit').on('click',function(){
	if($('.search-field').val() != ''){
		$('.search-modal').fadeIn('slow');
                $('input.gsc-input').val($('.search-field').val());
		$('.gsc-search-button .gsc-search-button-v2').trigger('submit');
	}
});*/
//Remove Team in Archive
$('[name="archive-dropdown"] option[value="https://ilc.upd.edu.ph/2014/10"]').remove();
//AMCHART DATE
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear()+"-"+(month)+"-"+(day);
        $('._my_date').attr('max', today);
//Latest News Modal
        $.ajax({
                type: "POST",
                url: ajaxUrl.ajax_url,
                data: {
                  action:"getLatestPost"
                },
                datatype:"JSON",
                cache: false,
                success: function(data){
		var mydata = JSON.parse(data);
		var html = '<div class="latestpost-modal">' +
                                        '<div class="latestpost-modal-content">' +
                                                '<div class="latestpost-modal-header">' +
                                                        '<span>Latest News</span><span class="close">&times;</span>' +
                                                '</div>' +
                                                '<div class="latestpost-modal-body">' +
                                                        '<div class="latestpost-title">' +
                                                                '<h2> <a href="' + mydata.permalink + '" target="_blank" >'+ mydata.title +'</a> </h2>' +
                                                        '</div>' +
                                                        '<div class="latestpost-excerpt">' +
                                                                '<p>'+ mydata.excerpt +'</p>' +
                                                        '</div>' +
                                                        '<div class="latestpost-readmore">' +
                                                                '<p><a href="' + mydata.permalink+ '" target="_blank"> Read more.</a></p>' +
                                                        '</div>' +
                                                '</div>' +
                                        '</div>' +
                                '</div>';
		if((mydata.postid != mydata.cookies) && (parseInt(mydata.currentdate) < parseInt(mydata.nextweek))){
                    $('#my-latest-post').html(html);
		}
               }});
//Modal Search
    /*$('.modal-search-open').on('click', function(){
      $('.search-modal').fadeIn('slow');
    });
    $('.search-modal-header .close').on('click', function(){
      $('.search-modal').css('display', 'none');
    });
    $('.search-modal').on('click', function(e){
        if($(e.target).closest('.search-modal-content').get(0) == null){
          $('.search-modal').css('display','none');
        }
    });*/
//Latest News Modal Close
    $(document).on('click', '.latestpost-modal-header .close', function(){
      //$('.latestpost-modal').css('display', 'none');
      $('.latestpost-modal-content').css('animation-name','fadeOut');
      setTimeout(function(){$('.latestpost-modal').css('display', 'none');}, 1000);
    });
    $(document).on('click','.latestpost-modal', function(e){
        if($(e.target).closest('.latestpost-modal-content').get(0) == null){
          $('.latestpost-modal').css('display','none');
        }
    });
//Latest News Modal Close
//Modal Helpdesk
    $('.popmake-helpdesk').on('click', function(){
      $('.modal-helpdesk').fadeIn('slow');
    });

    $('.ordinary-modal-header .close').on('click', function(){
      $('.ordinary-modal').css('display', 'none');
    });
    $('.ordinary-modal').on('click', function(e){
        if($(e.target).closest('.ordinary-modal-content').get(0) == null){
          $('.ordinary-modal').css('display','none');
        }
    });
//Modal Surveyform
    $('.popmake-mm-survey-form').on('click', function(){
      $('.modal-surveyform').fadeIn('slow');
    });
//Flash notification
    if(swfobject.hasFlashPlayerVersion("9.0.115")){
       $('.flash-notif').css('display', 'none');
    } else {
       $('.flash-notif').css('display', 'block');
    }
    $('.btn-flash-enable').click(function(){
          let url = '';
       switch(browser()){
          case 'Chrome':
                url = 'https://support.google.com/chrome/answer/6258784';
		console.log('Nice one');
          break;
          case 'Firefox':
               url = 'https://support.mozilla.org/en-US/kb/set-adobe-flash-click-play-firefox';
          break;
          case 'Opera':
               url = 'https://helpx.adobe.com/flash-player/kb/enabling-flash-player-opera.html';
          break;
          case 'Safari':
               url = 'https://helpx.adobe.com/flash-player/kb/enabling-flash-player-safari.html';
          break;
          default:
               url = 'https://google.com';
          break;
       }
       window.open(url, '_blank');
    });
//Accept Privacy policy
   $(document).on('click','.btn-accept-policy', function(e){
           e.preventDefault();
           footer_data_privacy('accepted');
   });
//Load Footer Data Privacy
footer_data_privacy('');
function footer_data_privacy(datas){
    $.ajax({
            type: 'POST',
            url: ajaxUrl.ajax_url,
            data: {
                    action: "footer_agreement_and_policy",
                    accept: (datas == '') ? '' : datas
            },
            datatype:'JSON',
            cache: false,
            success: function(data){
                    var ddata = JSON.parse(data);
                    var dhtml = '<div class="agreement-policy" style="width: 100%;background-color: rgb(0, 87, 63); color: rgb(255, 255, 255);text-align:center;padding: 1rem;position: fixed;bottom:0;opacity:0.8;z-index:100000;">'
                        + '<p style="font-size:11pt !important;margin:0px;">By clicking "Accept" or continuing to use our site, you agree to the university\'s Acceptable Use Policy and this site\'s terms and conditions.</p>'
                        + '<span class="btn-accept-policy" style="height:3rem;width:6rem;background-color:#fff;color:#000;margin:0;padding:.3rem;cursor:pointer;">Accept</span>'
                        + '<a href="https://upd.edu.ph/aup/" target="_blank" class="btn-uap" style="height:3rem;width:6rem;background-color:#fff;color:#000;margin:0;margin-left:2px;padding:.3rem;cursor:pointer;">Acceptable Use Policy</a></div>';
                        if(ddata.privacy == 1){
                                $('.privacy-content').hide();
                        } else {
                                $('.privacy-content').html(dhtml).show();
                        }
                    console.log(data);
            },
            error: function(data){
                    console.log(data);
            }
    });
};
/*News Line*/
/*Marquee*/
try {
$('.marquee').marquee({
    //speed in milliseconds of the marquee
    duration: 8000,
    //gap in pixels between the tickers
    gap: 50,
    //time in milliseconds before the marquee will start animating
    delayBeforeStart: 0,
    //'left' or 'right'
    direction: 'left',
    //true or false - should the marquee be duplicated to show an effect of continues flow
    duplicated: false
});
} catch(e){
  console.log(e);
}
console.log('Working');
/*Marquee*/
/*Announcement Page*/
    $('.categories-title a').click(function(e){
        e.preventDefault();
        e.stopPropagation();
             $('.categories-posts').css('display', 'none');
             $('.catpost-'+$(this).text()).css('display', 'block');
    });
/*Announcement Page*/
//Open Tab through URL
   var hash = document.location.hash;
   if(hash){
	$('#tab-1-1').removeClass('iw-so-tab-active');
	$('#tab-1-1-content').removeClass('iw-so-tab-active');
	$(hash.substr(0, 8)).addClass('iw-so-tab-active');
	$(hash).addClass('iw-so-tab-active');
   }
});
//LazyLoad images
(function(){
[].forEach.call(document.querySelectorAll('img[data-src]'), function(img) {
     img.setAttribute('src', img.getAttribute('data-src'));
     img.onload = function() {
          img.removeAttribute('data-src');
     };
});
})();
//Google Search
  (function() {
    var cx = '012573551502661448464:v6nd9iw69y8';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
//Browser detection
var browser = function() {
    // Return cached result if avalible, else get result then cache it.
    if (browser.prototype._cachedResult)
        return browser.prototype._cachedResult;
    // Opera 8.0+
    var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    // Firefox 1.0+
    var isFirefox = typeof InstallTrigger !== 'undefined';
    // Safari 3.0+ "[object HTMLElementConstructor]" 
    var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);
    // Internet Explorer 6-11
    var isIE = /*@cc_on!@*/false || !!document.documentMode;
    // Edge 20+
    var isEdge = !isIE && !!window.StyleMedia;
    // Chrome 1+
    var isChrome = !!window.chrome;
    // Blink engine detection
    var isBlink = (isChrome || isOpera) && !!window.CSS;
    return browser.prototype._cachedResult =
        isOpera ? 'Opera' :
        isFirefox ? 'Firefox' :
        isSafari ? 'Safari' :
        isChrome ? 'Chrome' :
        isIE ? 'IE' :
        isEdge ? 'Edge' :
        isBlink ? 'Blink' :
        "Don't know";
};
