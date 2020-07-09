<?php

/**
 * Template Name: Live streaming and chat forum
 * by ilc.upd.edu.ph
 */

get_header(); 
?>
<style>
	body{ overflow-y:scroll; }
     .main-content-background {
       padding-left: 3%;
       padding-right: 3%;
     }
	.panel-grid{ width:100%; }
	.streaming-container{ margin:5px; }
	.display-inline {
		display:inline-block;
		vertical-align:top;
	}
	.column-one {
		width:60%;
	}
	.column-two{
		width:40%;
	}
	.youtube-embed {
		padding:3px 10px;
		position:relative;
		height:0;
		padding-bottom:40%;
	}
	.youtube-embed iframe {
		position:absolute;
		top:0;
		left:0;
		width:100%;
		height:100%;
	}
	.tlkio-embed {
		padding-top:0px;
		padding-right:0px;
		padding-left:10px;
		padding-bottom:3px;
		width:100%;
		display:block;
		float:right;
	}
	.streaming-description {
		display:block;
		padding:5px;
	}
	.streaming-description p, .streaming-description b, .streaming-description li{
		font-family:tahoma, arial, helvetica Neue, sans-serif !important;
	}
	.chatforum-description{
		display:block;
		padding:5px;
	}
	.chatforum-description p, .chatforum-description b, .chatforum-description li{
		font-family:tahoma, arial, helvetica Neue, sans-serif !important;
	}
@media (min-width:601px) and (max-width:992px) {
	.tlkio-embed { padding:10px 0px; }
	.column-one {
                width:100%;
        }
	.column-two{
		width:100%;
	}
        .youtube-embed {
                padding-bottom:56.25%;
        }
   	.tlkio-embed {
        	width:100%;
    	}	
}
@media screen and (max-width:600px){
	.tlkio-embed { padding:10px 0px; }
	.column-one {
		width:100%;
	}
	.column-two{
		width:100%;
	}
	.youtube-embed {
		padding-bottom:56.25%;
	}
	.tlkio-embed {
		width:100%;
	}
}
</style>	
<body>
	<div class="streaming-container">
		<div class="column-one display-inline">
			<div class="youtube-embed">
				<iframe width="100%" height="713" 
        				src="https://www.youtube.com/embed/qPOAN4-F9wI" 
        				frameborder="0" 
        				allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
        				allowfullscreen>
				</iframe>
			</div>
			<div class="streaming-description">
                                <br>
                                <p style="color: #252525">
                                <b style="color:#800000; font-size: 28px;">2018 Election of Faculty Regent Forum</b> <br>
                                Live at the Malcolm Hall, UP Diliman <br>
                                8:30-11:00am, 12 November 2018
                                </p>

                                <hr>
                                <div style="">
                                <p style='margin: 0px; color: #252525; font-weight: bold'>CVs and Plans of Actions</p>
                                <ul style="list-style-type: disc;">
                                  <li style="color: #252525; font-size: 16px;"><a target='_blank' href='https://www.up.edu.ph/wp-content/uploads/2018/10/R-Guillermo-updated.pdf'>Guillermo, Ramon</a></li>
                                  <li style="color: #252525; font-size: 16px;"><a target='_blank' href='https://www.up.edu.ph/wp-content/uploads/2018/10/VJ-PAZ.pdf'>Paz, Victor</a></li>
                                  <li style="color: #252525; font-size: 16px;"><a target='_blank' href='https://www.up.edu.ph/wp-content/uploads/2018/10/AA-SALVADOR.pdf'>Salvador, Arnel</a></li>
                                </ul>

                                <br>
                                <p style='margin: 0px; color: #252525; font-weight: bold'>How to join the Forum's Chat facility</p>
                                <ul style="list-style-type: disc;">
                                  <li style="color: #252525; font-size: 16px;">Use your Twitter or FB account, by clicking the corresponding button; or key-in your nickname in the Name field.</li>
                                  <li style="color: #252525; font-size: 16px;">You may then send your reaction/s and/or question/s for the nominees.<br></li>
                                  <li style="color: #252525; font-size: 16px;">Note that this is a public chat (anyone may see and participate) intended only for the Forum's purposes. It is moderated by the UP Diliman FR Selection Secretariat.</li>
                                </ul>

                                <br>
                                <p style='margin: 0px; color:#252525; font-weight: bold'>Use of Forum's Chat facility</p>
                                <ul style="list-style-type: disc;">
                                  <li style="color:#252525; font-size: 16px;">Please be responsible and respectful. Debates or arguments are not allowed, but questions and opinions are encouraged. Messages in this chatroom will be recorded. Note that the chatroom's Moderator has the right to purge messages.</li>
                                  <li style="color: #252525; font-size: 16px;">Please be mindful that this chatroom is for the Forum's purposes - reactions and/or questions from the presentations and/or open forum. Campaigning is not allowed. No inappropriate contents, and no spamming, flooding, or off-topic discussions.</li>
                                </ul>
                                </div>
                	</div>
		</div>
		<div class="column-two display-inline">
			<div id="tlkio" class="tlkio-embed" 
				data-channel="chatroom_fr18" data-theme="theme--minimal" 
				style="max-width:100%;height:550px;">
			</div>
			<div class="chatforum-description">
				<p style="color:#252525;"> <b>Disclaimer: </b> <br>
					This chat forum is hosted by tlk.io and is not affiliated in any way to University of the Philippines.
				</p>	
			</div>
		</div>
	</div>
<script async src="http://tlk.io/embed.js" type="text/javascript"></script>

<?php get_footer(); ?>

