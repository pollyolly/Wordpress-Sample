<?php

/**
 * Template Name: Gawad Plaridel 2019 - Livestream
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
				<iframe width="100%" height="713"
        				src="https://www.youtube.com/embed/6dq2Fu8tyd0"
        				frameborder="0"
        				allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
        				allowfullscreen>
				</iframe>
			</div>
			<div class="streaming-description">
				<br>
				<p>
					<b style="color:#800000; font-size: 28px;">Gawad Plaridel 2019</b>
				</p>
				<p style="color:#252525;">
					The U.P. College of Mass Communication (UP CMC) is pleased to announce that this year’s U.P. Gawad Plaridel 2019 is Mr. Bonifacio Ilagan.<br><br>
					<span style="font-style:italic; color:#646464">ika-20 ng Nobyembre 2019, Miyerkules, alas dos ng hapon Cine Adarna, U.P. <br>
                                        Film Center, Magsaysay Ave., UP. Diliman, Lungsod ng Quezon</span>
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

