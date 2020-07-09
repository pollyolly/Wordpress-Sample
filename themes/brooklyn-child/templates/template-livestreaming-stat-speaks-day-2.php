<?php

/**
 * Template Name: Stat Speaks Day 2 - Livestream
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
		padding:150px 10px;
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
	.youtube-embed iframe,
	.youtube-embed object,
	.youtube-embed embed {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
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
				<iframe
					width="560"
					height="315"
					src="https://www.youtube.com/embed/y0iY7QHx5FE"
					frameborder="0"
					allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
					allowfullscreen>
				</iframe>
			</div>
			<div class="streaming-description">
				<br>
				<p>
					<b style="color:#800000; font-size: 28px;">Stat Speaks - Day 2</b>
				</p>
				<p style="color:#252525;">
					Colloquium on the Statistical Sciences<br><br>
					<span style="font-style:italic; color:#646464">January 14,2020 (Tuesday) and January 16,2020 (Thursday)<br>
					5:00 PM Lecture Hall 1</span>
					<br><br>
					<a href="https://ilc.upd.edu.ph/livestream-1">Day 1 Livestream</a>
				</p>
                                <hr>
                                <div style="">
                                <br>
                                </div>
                	</div>
		</div>
		</div>
	</div>

<?php get_footer(); ?>
