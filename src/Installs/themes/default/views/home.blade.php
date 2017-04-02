<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

    	<title>{{ CoreConfigs::getByKey('sitename') }}</title>

		<!-- #Bootstrap Core CSS -->
		<link type="text/css" href="{{ Theme::asset('default::landing-page/css/bootstrap.min.css') }}" rel="stylesheet">

		<!-- #SLIDER REVOLUTION 4.x CSS SETTINGS -->
		<link rel="stylesheet" type="text/css" href="{{ Theme::asset('default::landing-page/css/extralayers.css') }}" media="screen">
		<link rel="stylesheet" type="text/css" href="{{ Theme::asset('default::landing-page/css/settings.css') }}" media="screen">

		<!-- #RELATED CSS -->
		<link type="text/css" href="{{ Theme::asset('default::landing-page/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
		<link type="text/css" href="{{ Theme::asset('default::landing-page/css/nivo-lightbox.css') }}" rel="stylesheet">
		<link type="text/css" href="{{ Theme::asset('default::landing-page/css/nivo-lightbox-theme/default/default.css') }}" rel="stylesheet">
		<link type="text/css" href="{{ Theme::asset('default::landing-page/css/animate.css') }}" rel="stylesheet">

		<!-- #SMARTADMIN LANDING CSS -->
		<link type="text/css" href="{{ Theme::asset('default::landing-page/css/main.css') }}" rel="stylesheet">
		<link type="text/css" href="{{ Theme::asset('default::landing-page/color/default.css') }}" rel="stylesheet">

		<!-- #FAVICONS -->
		<link rel="shortcut icon" href="{{ Theme::asset('default::landing-page/img/favicon/favicon.ico') }}" type="image/x-icon">
		<link rel="icon" href="{{ Theme::asset('default::landing-page/img/favicon/favicon.ico') }}" type="image/x-icon">

		<!-- #GOOGLE FONT -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

	</head>

	<!--

	TABLE OF CONTENTS.
	
	Use search to find needed section.
	
	===================================================================
	
	|  01. #MENU                                                      |
	|  02. #INTRO                                                     |
	|  03. #PRICING                                                   |
	|  04. #TEAM                                                      |
	|  05. #FEATURES                                                  |
	|  06. #SCREENSHOT                                                |
	|  07. #UPDATES                                                   |
	|  08. #QUOTES                                                    |
	|  09. #CONTACT                                                   |
	|  10. #BOTTOM CONTENT                                            |
	|  11. #FOOTER                                                    |
	|  12. #Core Javascript                                           |
	|  13. #REVOLUITION SLIDER                                        |
	|  14. #PAGE SCRIPT                                               |
	
	===================================================================
	
	-->

	<body data-spy="scroll">

		<div class="container">

			<!-- Section: #MENU -->
			<ul id="gn-menu" class="gn-menu-main">
				<li class="gn-trigger">
					<a class="gn-icon gn-icon-menu"><span>Menu</span></a>
					<nav class="gn-menu-wrapper">
						<div class="gn-scroller">
							<ul class="gn-menu">
								<li class="gn-search-item">
									<input placeholder="Search" type="search" class="gn-search">
									<a class="gn-icon gn-icon-search"><span>Search</span></a>
								</li>
								<li>
									<a href="#pricing" class="gn-icon gn-icon-download">Pricing</a>
								</li>
								<li>
									<a href="#team" class="gn-icon gn-icon-article">Team</a>
								</li>
								<li>
									<a href="#features" class="gn-icon gn-icon-help">Features</a>
								</li>
								<li>
									<a href="#screenshots" class="gn-icon gn-icon-pictures">Screenshots</a>
								</li>
								<li>
									<a href="#updates" class="gn-icon gn-icon-cog">Updates</a>
								</li>
								<li>
									<a href="#contact" class="gn-icon gn-icon-archive">Contact</a>
								</li>
							</ul>
						</div><!-- /gn-scroller -->
					</nav>
				</li>
				<li class="hidden-xs">
					<a href="index.html"><img src="{{ Theme::asset('default::landing-page/img/logo.png') }}" alt="logo" style="width: 135px; margin-top: -4px;" /></a>
				</li>
				<li>
					<ul class="company-social">
						<li class="social-facebook">
							<a href="javascript:void(0);" target="_blank"><i class="fa fa-facebook"></i></a>
						</li>
						<li class="social-twitter">
							<a href="javascript:void(0);" target="_blank"><i class="fa fa-twitter"></i></a>
						</li>
						<li class="social-dribble">
							<a href="javascript:void(0);" target="_blank"><i class="fa fa-dribbble"></i></a>
						</li>
						<li class="social-google">
							<a href="javascript:void(0);" target="_blank"><i class="fa fa-google-plus"></i></a>
						</li>
					</ul>
				</li>
			</ul>
			<!-- Section: #MENU -->
		
		</div>

		<!-- Section: #INTRO -->
		<section class="intro">
			<div class="slogan">

				<!--
				#################################
				- THEMEPUNCH BANNER -
				#################################
				-->
				<div class="tp-banner-container">
					<div class="tp-banner" >
						<ul>
							<!-- SLIDE  -->
							<li data-transition="fade" data-slotamount="7" data-masterspeed="500" data-thumb="{{ Theme::asset('default::landing-page/img/slider/homeslider_thumb1.jpg') }}"  data-saveperformance="on"  data-title="Intro Slide">
								<!-- MAIN IMAGE -->
								<img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}"  alt="slidebg1" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/slidebg1.jpg') }}" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
								<!-- LAYERS -->

								<!-- LAYER NR. 1 -->
								<div class="tp-caption lft customout rs-parallaxlevel-0"
								data-x="695"
								data-y="83"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="700"
								data-start="1550"
								data-easing="Power3.easeInOut"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								style="z-index: 2;"><img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}" alt="" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/plate2.png') }}">
								</div>

								<!-- LAYER NR. 2 -->
								<div class="tp-caption lft customout rs-parallaxlevel-0"
								data-x="564"
								data-y="96"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="700"
								data-start="1400"
								data-easing="Power3.easeInOut"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								style="z-index: 3;"><img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}" alt="" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/plate1.png') }}">
								</div>

								<!-- LAYER NR. 3 -->
								<div class="tp-caption lft customout rs-parallaxlevel-0"
								data-x="480"
								data-y="99"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="700"
								data-start="1100"
								data-easing="Power3.easeInOut"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								style="z-index: 4;"><img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}" alt="" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/woman1.png') }}">
								</div>

								<!-- LAYER NR. 4 -->
								<div class="tp-caption grey_heavy_72 skewfromrightshort tp-resizeme rs-parallaxlevel-0"
									data-x="197"
									data-y="154" 
									data-speed="500"
									data-start="2250"
									data-easing="Power3.easeInOut"
									data-splitin="chars"
									data-splitout="none"
									data-elementdelay="0.1"
									data-endelementdelay="0.1"
									style="z-index: 5; max-width: auto; max-height: auto; white-space: nowrap;">Better!
								</div>

								<!-- LAYER NR. 5 -->
								<div class="tp-caption customin rs-parallaxlevel-0"
									data-x="86"
									data-y="184" 
									data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
									data-speed="500"
									data-start="2000"
									data-easing="Power3.easeInOut"
									data-elementdelay="0.1"
									data-endelementdelay="0.1"
									style="z-index: 6;"><img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}" alt="" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/redbg.png') }}">
								</div>

								<!-- LAYER NR. 6 -->
								<div class="tp-caption black_heavy_60 skewfromleftshort tp-resizeme rs-parallaxlevel-0"
									data-x="-2"
									data-y="133" 
									data-speed="500"
									data-start="1850"
									data-easing="Power3.easeInOut"
									data-splitin="chars"
									data-splitout="none"
									data-elementdelay="0.1"
									data-endelementdelay="0.1"
									style="z-index: 7; max-width: auto; max-height: auto; white-space: nowrap;">Now
								</div>

								<!-- LAYER NR. 7 -->
								<div class="tp-caption white_heavy_40 customin tp-resizeme rs-parallaxlevel-0"
									data-x="98"
									data-y="187" 
									data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
									data-speed="500"
									data-start="2050"
									data-easing="Power3.easeInOut"
									data-splitin="none"
									data-splitout="none"
									data-elementdelay="0.1"
									data-endelementdelay="0.1"
									style="z-index: 8; max-width: auto; max-height: auto; white-space: nowrap;">Even
								</div>

								<!-- LAYER NR. 8 -->
								<div class="tp-caption grey_regular_18 customin tp-resizeme rs-parallaxlevel-0"
								data-x="78"
								data-y="318"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="500"
								data-start="2600"
								data-easing="Power3.easeInOut"
								data-splitin="none"
								data-splitout="none"
								data-elementdelay="0.05"
								data-endelementdelay="0.1"
								style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap;">
									<div style="text-align:center;">
										SmartAdmin is highly acclaimed
										<br/>
										WebApp hydra template with
										<br/>
										multiple versions has been the
										<br/>
										solution for many businesses
										<br />
										and have greatly been appricated
										<br />
										by developers world wide.
									</div>
								</div>

								<!-- LAYER NR. 9 -->
								<div class="tp-caption black_thin_34 customin tp-resizeme rs-parallaxlevel-0"
								data-x="58"
								data-y="238"
								data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
								data-speed="500"
								data-start="2350"
								data-easing="Back.easeOut"
								data-splitin="none"
								data-splitout="none"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								style="z-index: 10; max-width: auto; max-height: auto; white-space: nowrap;">
									Packed with features!
								</div>

								<!-- LAYER NR. 10 -->
								<div class="tp-caption customin rs-parallaxlevel-0"
								data-x="6"
								data-y="290"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="300"
								data-start="2500"
								data-easing="Power3.easeInOut"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								style="z-index: 11;"><img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}" alt="" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/greyline.png') }}">
								</div>

								<!-- LAYER NR. 11 -->
								<div class="tp-caption customin tp-resizeme rs-parallaxlevel-0"
								data-x="73"
								data-y="502"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="500"
								data-start="2900"
								data-easing="Power3.easeInOut"
								data-splitin="none"
								data-splitout="none"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-linktoslide="next"
								style="z-index: 12; max-width: auto; max-height: auto; white-space: nowrap;">
									<a href='#' class='largeredbtn'>CONTINUE THE TOUR</a>
								</div>

								<!-- LAYER NR. 12 -->
								<div class="tp-caption arrowicon customin rs-parallaxlevel-0"
								data-x="303"
								data-y="526"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="300"
								data-start="3200"
								data-easing="Power3.easeInOut"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-linktoslide="next"
								style="z-index: 13;">
									<div class=" rs-slideloop" 			data-easing="Power3.easeInOut"
									data-speed="0.5"
									data-xs="-5"
									data-xe="5"
									data-ys="0"
									data-ye="0"
									>
										<img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}" alt="" data-ww="18" data-hh="11" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/doublearrow2.png') }}">
									</div>
								</div>
							</li>
							<!-- SLIDE  -->
							<li data-transition="slideleft" data-slotamount="7" data-masterspeed="2000" data-thumb="{{ Theme::asset('default::landing-page/img/slider/homeslider_thumb2.jpg') }}" data-delay="10000"  data-saveperformance="on"  data-title="Slide">
								<!-- MAIN IMAGE -->
								<img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}"  alt="laptopmockup_sliderdy" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/laptopmockup_sliderdy.jpg') }}" data-bgposition="right top" data-kenburns="on" data-duration="12000" data-ease="Power0.easeInOut" data-bgfit="115" data-bgfitend="100" data-bgpositionend="center bottom">
								<!-- LAYERS -->

								<!-- LAYER NR. 1 -->
								<div class="tp-caption customin fadeout rs-parallaxlevel-10"
									data-x="848"
									data-y="196" 
									data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
									data-speed="300"
									data-start="2700"
									data-easing="Power3.easeInOut"
									data-elementdelay="0.1"
									data-endelementdelay="0.1"
									data-endspeed="300"
									style="z-index: 2;"><img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}" alt="" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/redbg_big.png') }}">
								</div>

								<!-- LAYER NR. 2 -->
								<div class="tp-caption light_heavy_70 customin fadeout tp-resizeme rs-parallaxlevel-10"
									data-x="862"
									data-y="204" 
									data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
									data-speed="300"
									data-start="2850"
									data-easing="Power3.easeInOut"
									data-splitin="none"
									data-splitout="none"
									data-elementdelay="0.1"
									data-endelementdelay="0.1"
									data-endspeed="300"
									style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;">Effect
								</div>

								<!-- LAYER NR. 3 -->
								<div class="tp-caption black_heavy_70 skewfromleftshort fadeout tp-resizeme rs-parallaxlevel-10"
									data-x="717"
									data-y="143" 
									data-speed="500"
									data-start="2400"
									data-easing="Power3.easeInOut"
									data-splitin="chars"
									data-splitout="none"
									data-elementdelay="0.1"
									data-endelementdelay="0.1"
									data-endspeed="300"
									style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;">Rendering
								</div>

								<!-- LAYER NR. 4 -->
								<div class="tp-caption black_bold_40 skewfromrightshort fadeout tp-resizeme rs-parallaxlevel-10"
									data-x="937"
									data-y="282" 
									data-speed="500"
									data-start="3200"
									data-easing="Power3.easeInOut"
									data-splitin="chars"
									data-splitout="none"
									data-elementdelay="0.1"
									data-endelementdelay="0.1"
									data-endspeed="300"
									style="z-index: 5; max-width: auto; max-height: auto; white-space: nowrap;">Improved!
								</div>


								<!-- LAYER NR. 5 -->
								<div class="tp-caption black_bold_bg_20 sfr fadeout tp-resizeme rs-parallaxlevel-10"
								data-x="970"
								data-y="367"
								data-speed="300"
								data-start="4000"
								data-easing="Power3.easeInOut"
								data-splitin="none"
								data-splitout="none"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="300"
								style="z-index: 6; max-width: auto; max-height: auto; white-space: nowrap;">
									FASTER
								</div>

								<!-- LAYER NR. 6 -->
								<div class="tp-caption greenbox30 customin fadeout tp-resizeme rs-parallaxlevel-10"
								data-x="939"
								data-y="367"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="300"
								data-start="4000"
								data-easing="Power3.easeInOut"
								data-splitin="none"
								data-splitout="none"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="300"
								style="z-index: 7; max-width: auto; max-height: auto; white-space: nowrap;">
									&nbsp;
								</div>

								<!-- LAYER NR. 7 -->
								<div class="tp-caption arrowicon customin fadeout rs-parallaxlevel-10"
								data-x="948"
								data-y="374"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="300"
								data-start="4200"
								data-easing="Power3.easeInOut"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="300"
								style="z-index: 8;"><img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}" alt="" data-ww="17" data-hh="17" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/check.png') }}">
								</div>

								<!-- LAYER NR. 8 -->
								<div class="tp-caption black_bold_bg_20 sfr fadeout tp-resizeme rs-parallaxlevel-10"
								data-x="970"
								data-y="407"
								data-speed="300"
								data-start="4500"
								data-easing="Power3.easeInOut"
								data-splitin="none"
								data-splitout="none"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="300"
								style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap;">
									SMOOTHER
								</div>

								<!-- LAYER NR. 9 -->
								<div class="tp-caption greenbox30 customin fadeout tp-resizeme rs-parallaxlevel-10"
								data-x="939"
								data-y="407"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="300"
								data-start="4500"
								data-easing="Power3.easeInOut"
								data-splitin="none"
								data-splitout="none"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="300"
								style="z-index: 10; max-width: auto; max-height: auto; white-space: nowrap;">
									&nbsp;
								</div>

								<!-- LAYER NR. 10 -->
								<div class="tp-caption arrowicon customin fadeout rs-parallaxlevel-10"
								data-x="948"
								data-y="414"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="300"
								data-start="4700"
								data-easing="Power3.easeInOut"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="300"
								style="z-index: 11;"><img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}" alt="" data-ww="17" data-hh="17" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/check.png') }}">
								</div>

								<!-- LAYER NR. 11 -->
								<div class="tp-caption black_bold_bg_20 sfr fadeout tp-resizeme rs-parallaxlevel-10"
								data-x="970"
								data-y="447"
								data-speed="300"
								data-start="5000"
								data-easing="Power3.easeInOut"
								data-splitin="none"
								data-splitout="none"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="300"
								style="z-index: 12; max-width: auto; max-height: auto; white-space: nowrap;">
									EASY TO USE
								</div>

								<!-- LAYER NR. 12 -->
								<div class="tp-caption greenbox30 customin fadeout tp-resizeme rs-parallaxlevel-10"
								data-x="939"
								data-y="447"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="300"
								data-start="5000"
								data-easing="Power3.easeInOut"
								data-splitin="none"
								data-splitout="none"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="300"
								style="z-index: 13; max-width: auto; max-height: auto; white-space: nowrap;">
									&nbsp;
								</div>

								<!-- LAYER NR. 13 -->
								<div class="tp-caption arrowicon customin fadeout rs-parallaxlevel-10"
								data-x="948"
								data-y="454"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="300"
								data-start="5200"
								data-easing="Power3.easeInOut"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="300"
								style="z-index: 14;"><img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}" alt="" data-ww="17" data-hh="17" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/check.png') }}">
								</div>
							</li>
							<!-- SLIDE  -->
							<li data-transition="zoomin" data-slotamount="7" data-masterspeed="1500" data-thumb="{{ Theme::asset('default::landing-page/img/slider/homeslider_thumb4.jpg') }}"  data-saveperformance="on"  data-title="Mobile Interaction">
								<!-- MAIN IMAGE -->
								<img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}"  alt="slidebg1" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/slidebg1.jpg') }}" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
								<!-- LAYERS -->

								<!-- LAYER NR. 1 -->
								<div class="tp-caption lfb rs-parallaxlevel-9"
								data-x="center" data-hoffset="-40"
								data-y="bottom" data-voffset="-10"
								data-speed="1500"
								data-start="2400"
								data-easing="Power4.easeInOut"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="300"
								style="z-index: 2;"><img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}" alt="" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/ipad2.png') }}">
								</div>

								<!-- LAYER NR. 2 -->
								<div class="tp-caption customin rs-parallaxlevel-1"
								data-x="515"
								data-y="331"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="500"
								data-start="4400"
								data-easing="Power4.easeInOut"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="300"
								style="z-index: 3;">
									<div class=" rs-pulse" 			data-easing="Power4.easeInOut"
									data-speed="0.5"
									data-zoomstart="0.75"
									data-zoomend="1"
									>
										<img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}" alt="" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/pulse1.png') }}">
									</div>
								</div>

								<!-- LAYER NR. 4 -->
								<div class="tp-caption lfb rs-parallaxlevel-9"
								data-x="693"
								data-y="191"
								data-speed="1500"
								data-start="2900"
								data-easing="Power4.easeInOut"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="300"
								style="z-index: 5;"><img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}" alt="" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/iphone.png') }}">
								</div>

								<!-- LAYER NR. 5 -->
								<div class="tp-caption black_heavy_70 customin randomrotateout tp-resizeme rs-parallaxlevel-5"
								data-x="315"
								data-y="40"
								data-customin="x:0;y:100;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:1;scaleY:3;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:0% 0%;"
								data-speed="500"
								data-start="1400"
								data-easing="Power3.easeInOut"
								data-splitin="chars"
								data-splitout="none"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="600"
								style="z-index: 6; max-width: auto; max-height: auto; white-space: nowrap;">
									Mobile
								</div>

								<!-- LAYER NR. 6 -->
								<div class="tp-caption customin randomrotateout rs-parallaxlevel-7"
								data-x="434"
								data-y="98"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="300"
								data-start="1900"
								data-easing="Power3.easeInOut"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="600"
								style="z-index: 7;"><img src="{{ Theme::asset('default::landing-page/img/slider/dummy.png') }}" alt="" data-lazyload="{{ Theme::asset('default::landing-page/img/slider/largegreen.png') }}">
								</div>

								<!-- LAYER NR. 7 -->
								<div class="tp-caption light_heavy_70 customin randomrotateout tp-resizeme rs-parallaxlevel-7"
								data-x="448"
								data-y="106"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="300"
								data-start="2200"
								data-easing="Power3.easeInOut"
								data-splitin="none"
								data-splitout="none"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="600"
								style="z-index: 8; max-width: auto; max-height: auto; white-space: nowrap;">
									Device
								</div>

								<!-- LAYER NR. 8 -->
								<div class="tp-caption black_bold_40 skewfromrightshort randomrotateout tp-resizeme rs-parallaxlevel-6"
								data-x="619"
								data-y="177"
								data-speed="500"
								data-start="2500"
								data-easing="Power3.easeInOut"
								data-splitin="chars"
								data-splitout="none"
								data-elementdelay="0.1"
								data-endelementdelay="0.1"
								data-endspeed="600"
								style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap;">
									Friendly
								</div>
							</li>
						</ul>
						<div class="tp-bannertimer"></div>
					</div>
				</div>

			</div>
		</section>
		<!-- /Section: INTRO -->

		<!-- Section: #PRICING -->
		<section id="pricing" class="home-section text-center">
			<div class="heading-about marginbot-50">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 col-lg-offset-2">

							<div class="section-heading">
								<h2>Our Deals</h2>
								<p>
									Lorem ipsum dolor sit amet, no nisl mentitum recusabo per, vim at blandit qualisque dissentiunt. Diam efficiantur conclusionemque ut has
								</p>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="container">

			<div class="row">
				
		        <div class="col-xs-12 col-sm-6 col-md-3">
		            <div class="panel panel-success pricing-big">
		            	
		                <div class="panel-heading">
		                    <h3 class="panel-title">
		                        Lite version</h3>
		                </div>
		                <div class="panel-body no-padding text-align-center">
		                    <div class="the-price">
		                        <h1>
		                            <strong>FREE</strong></h1>
		                    </div>
							<div class="price-features">
								<ul class="list-unstyled text-left">
						          <li><i class="fa fa-check text-success"></i> 2 years access <strong> to all storage locations</strong></li>
						          <li><i class="fa fa-check text-success"></i> <strong>Unlimited</strong> storage</li>
						          <li><i class="fa fa-check text-success"></i> Limited <strong> download quota</strong></li>
						          <li><i class="fa fa-check text-success"></i> <strong>Smart File Storage</strong></li>
						          <li><i class="fa fa-check text-success"></i> All time <strong> updates</strong></li>
						          <li><i class="fa fa-times text-danger"></i> <strong>Unlimited</strong> access to all files</li>
						          <li><i class="fa fa-times text-danger"></i> <strong>Allowed</strong> to be exclusing per sale</li>
						        </ul>
							</div>
		                </div>
		                <div class="panel-footer text-align-center">
		                    <a href="javascript:void(0);" class="btn btn-primary btn-block" role="button">Download <span> now!</span></a>
		                	<div>
		                		Or <a href="javascript:void(0);">Sign up</a>
		                	</div>
		                </div>
		            </div>
		        </div>
		        
		        <div class="col-xs-12 col-sm-6 col-md-3">
		            <div class="panel panel-success pricing-big">
		            	
		                <div class="panel-heading">
		                    <h3 class="panel-title">
		                        Personal Project</h3>
		                </div>
		                <div class="panel-body no-padding text-align-center">
		                    <div class="the-price">
		                        <h1>
		                            $99<span class="subscript">/ mo</span></h1>
		                    </div>
							<div class="price-features">
								<ul class="list-unstyled text-left">
						          <li><i class="fa fa-check text-success"></i> 2 years access <strong> to all storage locations</strong></li>
						          <li><i class="fa fa-check text-success"></i> <strong>Unlimited</strong> storage</li>
						          <li><i class="fa fa-check text-success"></i> Superbig <strong> download quota</strong></li>
						          <li><i class="fa fa-check text-success"></i> <strong>Smart File Storage</strong></li>
						          <li><i class="fa fa-check text-success"></i> All time <strong> updates</strong></li>
						          <li><i class="fa fa-check text-success"></i> <strong>Unlimited</strong> access to all files</li>
						          <li><i class="fa fa-check text-success"></i> <strong>Allowed</strong> to be exclusing per sale</li>
						        </ul>
							</div>
		                </div>
		                <div class="panel-footer text-align-center">
		                    <a href="javascript:void(0);" class="btn btn-primary btn-block" role="button">Purchase <span>via Paypal</span></a>
		                	<div>
		                		<a href="javascript:void(0);"><i>We accept all major credit cards</i></a>
		                	</div>
		                </div>
		            </div>
		        </div>
		        
		        <div class="col-xs-12 col-sm-6 col-md-3">
		            <div class="panel panel-primary pricing-big">
		            	<img src="{{ Theme::asset('default::landing-page/img/ribbon.png') }}" class="ribbon" alt="ribbon">
		                <div class="panel-heading">
		                    <h3 class="panel-title">
		                        Developer Bundle</h3>
		                </div>
		                <div class="panel-body no-padding text-align-center">
		                    <div class="the-price">
		                        <h1>
		                            $350<span class="subscript">/ mo</span></h1>
		                    </div>
							<div class="price-features">
								<ul class="list-unstyled text-left">
						          <li><i class="fa fa-check text-success"></i> 2 years access <strong> to all storage locations</strong></li>
						          <li><i class="fa fa-check text-success"></i> <strong>Unlimited</strong> storage</li>
						          <li><i class="fa fa-check text-success"></i> Superbig <strong> download quota</strong></li>
						          <li><i class="fa fa-check text-success"></i> <strong>Smart File Storage</strong></li>
						          <li><i class="fa fa-check text-success"></i> All time <strong> updates</strong></li>
						          <li><i class="fa fa-check text-success"></i> <strong>Unlimited</strong> access to all files</li>
						          <li><i class="fa fa-check text-success"></i> <strong>Allowed</strong> to be exclusing per sale</li>
						        </ul>
							</div>
		                </div>
		                <div class="panel-footer text-align-center">
		                    <a href="javascript:void(0);" class="btn btn-primary btn-block" role="button">Purchase <span>via Paypal</span></a>
		                	<div>
		                		<a href="javascript:void(0);"><i>We accept all major credit cards</i></a>
		                	</div>
		                </div>
		            </div>
		        </div>
		        
		        <div class="col-xs-12 col-sm-6 col-md-3">
		            <div class="panel panel-danger pricing-big">
		            	
		                <div class="panel-heading">
		                    <h3 class="panel-title">
		                        Premium Package</h3>
		                </div>
		                <div class="panel-body no-padding text-align-center">
		                    <div class="the-price">
		                        <h1>
		                            $999<span class="subscript">/ mo</span></h1>
		                    </div>
							<div class="price-features">
								<ul class="list-unstyled text-left">
						          <li><i class="fa fa-check text-success"></i> Lifetime access <strong> to all storage locations</strong></li>
						          <li><i class="fa fa-check text-success"></i> <strong>Unlimited</strong> storage</li>
						          <li><i class="fa fa-check text-success"></i> Superbig <strong> download quota</strong></li>
						          <li><i class="fa fa-check text-success"></i> <strong>Smart File Storage</strong></li>
						          <li><i class="fa fa-check text-success"></i> All time <strong> updates</strong></li>
						          <li><i class="fa fa-check text-success"></i> <strong>Unlimited</strong> access to all files</li>
						          <li><i class="fa fa-check text-success"></i> <strong>Allowed</strong> to be exclusing per sale</li>
						        </ul>
							</div>
		                </div>
		                <div class="panel-footer text-align-center">
		                    <a href="javascript:void(0);" class="btn btn-primary btn-block" role="button">Purchase <span>via Paypal</span></a>
		                	<div>
		                		<a href="javascript:void(0);"><i>We accept all major credit cards</i></a>
		                	</div>
		                </div>
		            </div>
		        </div>		    	
    		</div>


			
			</div>
		</section>
		<!-- /Section: PRICING -->

		<!-- Section: #TEAM -->
		<section id="team" class="home-section text-center bg-gray">
			<div class="heading-about marginbot-50">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 col-lg-offset-2">

							<div class="section-heading">
								<h2>SmartAdmin Team</h2>
								<p>
									Lorem ipsum dolor sit amet, no nisl mentitum recusabo per, vim at blandit qualisque dissentiunt. Diam efficiantur conclusionemque ut has
								</p>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="container">

				<div class="row">
					<div class="col-xs-12 col-sm-3 col-md-3">

						<div class="team boxed-grey">
							<div class="inner">
								<h5>John Doe</h5>
								<p class="subtitle">
									CEO
								</p>
								<div class="avatar"><img src="{{ Theme::asset('default::landing-page/img/team/1.jpg') }}" alt="" class="img-responsive" />
								</div>
							</div>
						</div>

					</div>
					<div class="col-xs-12 col-sm-3 col-md-3">

						<div class="team boxed-grey">
							<div class="inner">
								<h5>Barley Kazurkth</h5>
								<p class="subtitle">
									Marketing Director
								</p>
								<div class="avatar"><img src="{{ Theme::asset('default::landing-page/img/team/2.jpg') }}" alt="" class="img-responsive" />
								</div>
							</div>

						</div>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-3">

						<div class="team boxed-grey">
							<div class="inner">
								<h5>Sadi Orlaf</h5>
								<p class="subtitle">
									Marketing Executive
								</p>
								<div class="avatar"><img src="{{ Theme::asset('default::landing-page/img/team/3.jpg') }}" alt="" class="img-responsive" />
								</div>
							</div>
						</div>

					</div>
					<div class="col-xs-12 col-sm-3 col-md-3">

						<div class="team boxed-grey">
							<div class="inner">
								<h5>Tony Shark</h5>
								<p class="subtitle">
									Programmer
								</p>
								<div class="avatar"><img src="{{ Theme::asset('default::landing-page/img/team/4.jpg') }}" alt="" class="img-responsive" />
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>
		<!-- /Section: TEAM -->

		<!-- Section: #FEATURES -->
		<section id="features" class="home-section text-center">

			<div class="heading-about marginbot-50">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 col-lg-offset-2">

							<div class="section-heading">
								<h2>The Power of SmartAdmin</h2>
								<p>
									Lorem ipsum dolor sit amet, no nisl mentitum recusabo per, vim at blandit qualisque dissentiunt. Diam efficiantur conclusionemque ut has
								</p>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-sm-3 col-md-3">

						<div class="service-box">
							<div class="service-icon">
								<i class="fa fa-code fa-3x"></i>
							</div>
							<div class="service-desc">
								<h5>Localization</h5>
								<p>
									Vestibulum tincidunt enim in pharetra malesuada. Duis semper magna metus electram accommodare.
								</p>
							</div>
						</div>

					</div>
					<div class="col-sm-3 col-md-3">

						<div class="service-box">
							<div class="service-icon">
								<i class="fa fa-suitcase fa-3x"></i>
							</div>
							<div class="service-desc">
								<h5>Compact</h5>
								<p>
									Vestibulum tincidunt enim in pharetra malesuada. Duis semper magna metus electram accommodare.
								</p>
							</div>
						</div>

					</div>
					<div class="col-sm-3 col-md-3">

						<div class="service-box">
							<div class="service-icon">
								<i class="fa fa-cog fa-3x"></i>
							</div>
							<div class="service-desc">
								<h5>State of the Art</h5>
								<p>
									Vestibulum tincidunt enim in pharetra malesuada. Duis semper magna metus electram accommodare.
								</p>
							</div>
						</div>

					</div>
					<div class="col-sm-3 col-md-3">

						<div class="service-box">
							<div class="service-icon">
								<i class="fa fa-rocket fa-3x"></i>
							</div>
							<div class="service-desc">
								<h5>Cloud System</h5>
								<p>
									Vestibulum tincidunt enim in pharetra malesuada. Duis semper magna metus electram accommodare.
								</p>
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>
		<!-- /Section: FEATURES -->

		<!-- Section: #SCREENSHOT -->
		<section id="screenshots" class="home-section text-center bg-gray">
			<div class="heading-works marginbot-50">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 col-lg-offset-2">

							<div class="section-heading">
								<h2>Screenshots</h2>
								<p>
									Lorem ipsum dolor sit amet, no nisl mentitum recusabo per, vim at blandit qualisque dissentiunt. Diam efficiantur conclusionemque ut has
								</p>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="container">

				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-12" >

						<div class="row gallery-item">
							<div class="col-md-3">
								<a href="{{ Theme::asset('default::landing-page/img/works/1.jpg') }}" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="{{ Theme::asset('default::landing-page/img/works/1@2x.jpg') }}"> <img src="{{ Theme::asset('default::landing-page/img/works/1.jpg') }}" class="img-responsive" alt="img"> </a>
							</div>
							<div class="col-md-3">
								<a href="{{ Theme::asset('default::landing-page/img/works/2.jpg') }}" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="{{ Theme::asset('default::landing-page/img/works/1@2x.jpg') }}"> <img src="{{ Theme::asset('default::landing-page/img/works/2.jpg') }}" class="img-responsive" alt="img"> </a>
							</div>
							<div class="col-md-3">
								<a href="{{ Theme::asset('default::landing-page/img/works/3.jpg') }}" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="{{ Theme::asset('default::landing-page/img/works/1@2x.jpg') }}"> <img src="{{ Theme::asset('default::landing-page/img/works/3.jpg') }}" class="img-responsive" alt="img"> </a>
							</div>
							<div class="col-md-3">
								<a href="{{ Theme::asset('default::landing-page/img/works/4.jpg') }}" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="{{ Theme::asset('default::landing-page/img/works/1@2x.jpg') }}"> <img src="{{ Theme::asset('default::landing-page/img/works/4.jpg') }}" class="img-responsive" alt="img"> </a>
							</div>
							<div class="col-md-3">
								<a href="{{ Theme::asset('default::landing-page/img/works/5.jpg') }}" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="{{ Theme::asset('default::landing-page/img/works/1@2x.jpg') }}"> <img src="{{ Theme::asset('default::landing-page/img/works/5.jpg') }}" class="img-responsive" alt="img"> </a>
							</div>
							<div class="col-md-3">
								<a href="{{ Theme::asset('default::landing-page/img/works/6.jpg') }}" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="{{ Theme::asset('default::landing-page/img/works/1@2x.jpg') }}"> <img src="{{ Theme::asset('default::landing-page/img/works/6.jpg') }}" class="img-responsive" alt="img"> </a>
							</div>
							<div class="col-md-3">
								<a href="{{ Theme::asset('default::landing-page/img/works/7.jpg') }}" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="{{ Theme::asset('default::landing-page/img/works/1@2x.jpg') }}"> <img src="{{ Theme::asset('default::landing-page/img/works/7.jpg') }}" class="img-responsive" alt="img"> </a>
							</div>
							<div class="col-md-3">
								<a href="{{ Theme::asset('default::landing-page/img/works/8.jpg') }}" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="{{ Theme::asset('default::landing-page/img/works/1@2x.jpg') }}"> <img src="{{ Theme::asset('default::landing-page/img/works/8.jpg') }}" class="img-responsive" alt="img"> </a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>
		<!-- /Section: SCREENSHOT -->

		<!-- Section: #UPDATES -->
		<section id="updates" class="home-section text-center">
			<div class="heading-contact marginbot-50">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 col-lg-offset-2">

							<div class="section-heading">
								<h2>Updates</h2>
								<p>
									Lorem ipsum dolor sit amet, no nisl mentitum recusabo per, vim at blandit qualisque dissentiunt. Diam efficiantur conclusionemque ut has
								</p>
							</div>

						</div>
					</div>
				</div>
			</div>

			<div class="container">
				<div class="row">
					<div class="timeline-centered">
			    
				<article class="timeline-entry">
					
					<div class="timeline-entry-inner">
						<time class="timeline-time" datetime="2014-01-10T03:45"><span>03:45 AM</span> <span>Today</span></time>
						
						<div class="timeline-icon bg-success">
							<i class="entypo-feather"></i>
						</div>
						
						<div class="timeline-label">
							<h2><a href="#">SmartAdmin:</a> <span>Patch was released today</span></h2>
							<p>Tolerably earnestly middleton extremely distrusts she boy now not. Add and offered prepare how cordial two promise. Greatly who affixed suppose but enquire compact prepare all put. Added forth chief trees but rooms think may.</p>
						</div>
					</div>
					
				</article>
				
				
				<article class="timeline-entry left-aligned">
					
					<div class="timeline-entry-inner">
						<time class="timeline-time" datetime="2014-01-10T03:45"><span>03:45 AM</span> <span>4 weeks ago</span></time>
						
						<div class="timeline-icon bg-secondary">
							<i class="entypo-suitcase"></i>
						</div>
						
						<div class="timeline-label">
							<h2><a href="#">SmartAdmin goes public!</a></h2>
							<p>Yahoo buys a share in <strong>SmartAdmin</strong></p>
						</div>
					</div>
					
				</article>
				
				
				<article class="timeline-entry">
					
					<div class="timeline-entry-inner">
						<time class="timeline-time" datetime="2014-01-09T13:22"><span>03:45 AM</span> <span>3 months ago</span></time>
						
						<div class="timeline-icon bg-info">
							<i class="entypo-location"></i>
						</div>
						
						<div class="timeline-label">
							<h2><a href="#">SmartAdmin Convention</a> <span>checked in at</span> <a href="#">Laborator</a></h2>
							
							<blockquote>Place was booked till 3am!</blockquote>
							
							<img src="{{ Theme::asset('default::landing-page/img/map.png') }}" alt="map" class="img-responsive">


						</div>
					</div>
					
				</article>
				
				
				<article class="timeline-entry left-aligned">
					
					<div class="timeline-entry-inner">
						<time class="timeline-time" datetime="2014-01-10T03:45"><span>03:45 AM</span> <span>8 months ago</span></time>
						
						<div class="timeline-icon bg-warning">
							<i class="entypo-camera"></i>
						</div>
						
						<div class="timeline-label">
							<h2><a href="#">We have lift off!</a></h2>
							
							<blockquote>SmartAdmin Launched with grace and beauty</blockquote>

						</div>
					</div>
					
				</article>
				
				
				<article class="timeline-entry begin">
				
					<div class="timeline-entry-inner">
						
						<div class="timeline-icon" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);">
							<i class="entypo-flight"></i>
						</div>
						
					</div>
					
				</article>
				
			</div>
				</div>
			</div>
		</section>
		<!-- /Section: UPDATES -->

		<!-- Section: #QUOTES -->
		<section id="quotes" class="home-section text-center bg-gray">
			
				<div class="container">
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
			                <div class="quote"><i class="fa fa-quote-left fa-4x"></i></div>
							<div class="carousel slide" id="fade-quote-carousel" data-ride="carousel" data-interval="3000">
							  <!-- Carousel indicators -->
			                  <ol class="carousel-indicators">
							    <li data-target="#fade-quote-carousel" data-slide-to="0" class="active"></li>
							    <li data-target="#fade-quote-carousel" data-slide-to="1"></li>
							    <li data-target="#fade-quote-carousel" data-slide-to="2"></li>
							  </ol>
							  <!-- Carousel items -->
							  <div class="carousel-inner">
							    <div class="active item">
							    	<blockquote>
							    		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, veritatis nulla eum laudantium totam tempore optio doloremque laboriosam quas.</p>
							    	</blockquote>
							    	<div class="profile-circle" style="background-color: rgba(0,0,0,.2);"></div>
							    </div>
							    <div class="item">
							    	<blockquote>
							    		<p>Lorem ipsum dolor sit amet, eaque molestias odio aut eius animi. Impedit temporibus nisi accusamus.</p>
							    	</blockquote>
							    	<div class="profile-circle" style="background-color: rgba(77,5,51,.2);"></div>
							    </div>
							    <div class="item">
							    	<blockquote>
							    		<p>Consectetur adipisicing elit. Quidem, veritatis  aut eius animi. Impedit temporibus nisi accusamus.</p>
							    	</blockquote>
							    	<div class="profile-circle" style="background-color: rgba(145,169,216,.2);"></div>
							    </div>
							  </div>
							</div>
						</div>							
					</div>
				</div>
			
		</section>
		<!-- /Section: QUOTES -->

		<!-- Section: #CONTACT -->
		<section id="contact" class="home-section text-center">
			<div class="heading-contact marginbot-50">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 col-lg-offset-2">

							<div class="section-heading">
								<h2>Get in touch</h2>
								<p>
									Lorem ipsum dolor sit amet, no nisl mentitum recusabo per, vim at blandit qualisque dissentiunt. Diam efficiantur conclusionemque ut has
								</p>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="container">

				<div class="row">
					<div class="col-lg-8 col-md-offset-2">
						<div class="boxed-grey">
							<form id="contact-form">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="name"> Name</label>
											<input type="text" class="form-control" id="name" placeholder="Enter name" required="required" />
										</div>
										<div class="form-group">
											<label for="email"> Email Address</label>
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span> </span>
												<input type="email" class="form-control" id="email" placeholder="Enter email" required="required" />
											</div>
										</div>
										<div class="form-group">
											<label for="subject"> Subject</label>
											<select id="subject" name="subject" class="form-control" required="required">
												<option value="">Choose One:</option>
												<option value="service">General Customer Service</option>
												<option value="suggestions">Suggestions</option>
												<option value="product">Product Support</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="name"> Message</label>
											<textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required" placeholder="Message"></textarea>
										</div>
									</div>
									<div class="col-md-12">
										<button type="submit" class="btn btn-skin pull-right" id="btnContactUs">
											Send Message
										</button>
									</div>
								</div>
							</form>
						</div>

						<div class="widget-contact row">
							<div class="col-lg-6">
								<address>
									<strong>SMARTADMIN Ltd.</strong>
									<br>
									Big Villa 334 Awesome, Beautiful Suite 1200
									<br>
									San Francisco, CA 94107
									<br>
									<abbr title="Phone">P:</abbr> (123) 456-7890
								</address>
							</div>

							<div class="col-lg-6">
								<address>
									<strong>Email</strong>
									<br>
									<a href="mailto:#">email.name@example.com</a>
									<br />
									<a href="mailto:#">name.name@example.com</a>
								</address>

							</div>
						</div>
					</div>

				</div>

			</div>
		</section>
		<!-- /Section: CONTACT -->

		<!-- #BOTTOM CONTENT -->
		<div class="bottom-content">
			<div class="container custom-container text-center">
				<h2>We Always Try to Create a Difference</h2>
				<p>
					Thank you for buying this template :)
				</p>
				<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
				<a href="https://bootstraphunter.com" class="btn btn-default btn-lg purchase">Purchase SmartAdmin</a>
			</div>
		</div>
		<!-- /#BOTTOM CONTENT -->

		<!-- #FOOTER -->
		<footer>

			<div class="footer-content clearfix">
				<div class="container custom-container">
					<div class="row">
						<div class="col-md-3 col-sm-6 col-xs-12">
							<a href="#" class="footer-logo">About Us</a>
							<p>
								Fusce gravida tortor felis, ac dictum risus sagittis id.
							</p>
							<p>
								Donec volutpat, mi vel egestas eleifend, dolor arcu iaculis nunc. Fusce gravida tortor felis, ac dictum risus sagittis id. Morbi posuere justo eleifend libero ultricies ultrices.
							</p>
							<a href="#" class="learn-more">learn more</a>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<h3>Recent Tweets</h3>
							<div class="recent-post clearfix">
								<div class="footer-thumb-img">
									<span class="footer-overlay-img"></span>
								</div>
								<p>
									Fusce gravida tortor felis, ac dictum risus sagittis
									<span class="date">November 15, 2014</span>
								</p>

							</div>
							<div class="recent-post clearfix">
								<div class="footer-thumb-img">
									<span class="footer-overlay-img"></span>
								</div>
								<p>
									Fusce gravida tortor felis, ac dictum risus sagittis
									<span class="date">November 11, 2014</span>
								</p>

							</div>
							<div class="recent-post clearfix">
								<div class="footer-thumb-img">
									<span class="footer-overlay-img"></span>
								</div>
								<p>
									Fusce gravida tortor felis, ac dictum risus sagittis
									<span class="date">November 10, 2014</span>
								</p>

							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<h3>Top Tags</h3>
							<div class="footer-tags">
								<ul>
									<li>
										<a href="#">Web Design</a>
									</li>
									<li>
										<a href="#">Services</a>
									</li>
									<li>
										<a href="#">Landing</a>
									</li>
									<li>
										<a href="#">SmartAdmin</a>
									</li>
									<li>
										<a href="#">.Net</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<h3>Flicker photos (recent)</h3>
							<div class="flicker-widget">
								<a href="#"></a>
								<a href="#"></a>
								<a href="#"></a>
								<a href="#"></a>
								<a href="#"></a>
								<a href="#"></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="bottom-footer">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-center">
							<p>
								Copyright © 2015 - Your Company Name
							</p>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- / #FOOTER -->

		<!-- # Core JavaScript Files -->

		<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script>
			if (!window.jQuery) {
				document.write('<script src="{{ Theme::asset('default::landing-page/js/libs/jquery-2.0.2.min.js') }}"><\/script>');
			}
		</script>

		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script>
			if (!window.jQuery.ui) {
				document.write('<script src="{{ Theme::asset('default::landing-page/js/libs/jquery-ui-1.10.3.min.js') }}"><\/script>');
			}
		</script>


		<!-- BOOTSTRAP JS -->
		<script src="{{ Theme::asset('default::landing-page/js/bootstrap/bootstrap.min.js') }}"></script>

		<!--# JS PLUGINS -->
		<script src="{{ Theme::asset('default::landing-page/js/plugins/classie.js') }}"></script>
		<script src="{{ Theme::asset('default::landing-page/js/plugins/gnmenu.js') }}"></script>
		<script src="{{ Theme::asset('default::landing-page/js/plugins/jquery.scrollUp.js') }}"></script>
		<script src="{{ Theme::asset('default::landing-page/js/plugins/nivo-lightbox.min.js') }}"></script>
		<script src="{{ Theme::asset('default::landing-page/js/plugins/smoothscroll.js') }}"></script>
		<script src="{{ Theme::asset('default::landing-page/js/plugins/jquery.themepunch.plugins.min.js') }}"></script>
		<script src="{{ Theme::asset('default::landing-page/js/plugins/jquery.themepunch.revolution.min.js') }}"></script>

		<!-- # Custom Theme JavaScript -->
		<script src="{{ Theme::asset('default::landing-page/js/custom.js') }}"></script>

		<!-- #PAGE SCRIPT -->
		<script type="text/javascript">
			jQuery(document).ready(function() {

				jQuery('.tp-banner').show().revolution({
					dottedOverlay : "none",
					delay : 8000,
					startwidth : 1170,
					startheight : 700,
					hideThumbs : 200,

					thumbWidth : 100,
					thumbHeight : 50,
					thumbAmount : 5,

					navigationType : "bullet",
					navigationArrows : "solo",
					navigationStyle : "preview4",

					touchenabled : "on",
					onHoverStop : "off",

					swipe_velocity : 0.7,
					swipe_min_touches : 1,
					swipe_max_touches : 1,
					drag_block_vertical : false,

					parallax : "mouse",
					parallaxBgFreeze : "on",
					parallaxLevels : [7, 4, 3, 2, 5, 4, 3, 2, 1, 0],

					keyboardNavigation : "off",

					navigationHAlign : "center",
					navigationVAlign : "bottom",
					navigationHOffset : 0,
					navigationVOffset : 20,

					soloArrowLeftHalign : "left",
					soloArrowLeftValign : "center",
					soloArrowLeftHOffset : 20,
					soloArrowLeftVOffset : 0,

					soloArrowRightHalign : "right",
					soloArrowRightValign : "center",
					soloArrowRightHOffset : 20,
					soloArrowRightVOffset : 0,

					shadow : 0,
					fullWidth : "off",
					fullScreen : "on",

					spinner : "spinner4",

					stopLoop : "off",
					stopAfterLoops : -1,
					stopAtSlide : -1,

					shuffle : "off",

					autoHeight : "off",
					forceFullWidth : "off",

					hideThumbsOnMobile : "off",
					hideNavDelayOnMobile : 1500,
					hideBulletsOnMobile : "off",
					hideArrowsOnMobile : "off",
					hideThumbsUnderResolution : 0,

					hideSliderAtLimit : 0,
					hideCaptionAtLimit : 0,
					hideAllCaptionAtLilmit : 0,
					startWithSlide : 0,
					fullScreenOffsetContainer : ""
				});

			});
			//ready

			$.scrollUp();
		</script>

	</body>

</html>
