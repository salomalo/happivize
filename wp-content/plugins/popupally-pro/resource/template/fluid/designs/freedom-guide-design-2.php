<?php
if (!class_exists('PopupAllyProFluidTemplateFreedomGuideDesign2')) {
	class PopupAllyProFluidTemplateFreedomGuideDesign2 extends PopupAllyProFluidTemplate {
		public function __construct() {
			parent::__construct();
			$this->uid = 'fluid_qemkkqa';
			$this->template_name = 'Freedom Guide - Make a Choice';

			$this->default_values = array($this->uid => array(
					"checked-customization-opened" => "false",
					"checked-hide-overlay" => "false",
					"overlay-color" => "#505050",
					"overlay-opacity" => "0.5",
					"overlay-color-rgba" => "80,80,80,0.5",
					"checked-disable-overlay-close" => "false",
					"selected-responsive" => "0",
					'element-order' => array('0', '1', '2'),
					"elements" => array(
						"0" => array(
							"type" => "text",
							"title" => "Headline",
							"text" => "WANT TO TRAVEL TO FUN EXOTIC LOCATIONS WHILE YOUR BUSINESS KEEPS RUNNING AND MAKING MONEY WITHOUT YOU?",
							"select-click-action" => "none",
							"click-link" => "",
							"click-new-link" => "",
							"click-popup-id" => "",
							),
						"1" => array(
							"type" => "text",
							"title" => "Yes Button",
							"text" => "OOOH,<br/>thats sound nice...",
							"select-click-action" => "popup",
							"click-link" => "",
							"click-new-link" => "",
							"click-popup-id" => "",
							),
						"2" => array(
							"type" => "text",
							"title" => "No Button",
							"text" => "UM,<br/>no thanks",
							"select-click-action" => "popup",
							"click-link" => "",
							"click-new-link" => "",
							"click-popup-id" => "",
							),
						),
					"responsive" => array(
						"0" => array(
							"preview-window-background-color" => "#FFFFFF",
							"responsive-breakpoint" => "1024",
							"select-border-box-shadow" => "0 5px 10px rgba(0,0,0,0.5)",
							"background-color" => "#FEFEFE",
							"background-image-url" => PopupAllyPro::$PLUGIN_URI . "resource/img/travel-bg.png",
							"label" => "Desktop",
							"width" => "800",
							"height" => "530",
							"select-popup-location" => "center",
							"select-popup-vertical-selection" => "top",
							"select-popup-horizontal-selection" => "left",
							"popup-top" => "50%",
							"popup-left" => "50%",
							"popup-bottom" => "50%",
							"popup-right" => "50%",
							"checked-auto-adjust" => "false",
							"elements" => array(
								"0" => array(
									"css" => array(
										"width" => "630px",
										"height" => "auto",
										"top" => "65px",
										"left" => "95px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "24",
										"font-style" => "italic",
										"text-align" => "center",
										"line-height" => "35",
										),
									),
								"1" => array(
									"css" => array(
										"width" => "341px",
										"height" => "158px",
										"top" => "260px",
										"left" => "65px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/purple_button.png",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "24",
										"font-style" => "italic",
										"text-align" => "center",
										"line-height" => "30",
										"border-radius" => "5",
										"padding-top" => "40",
										),
									),
								"2" => array(
									"css" => array(
										"width" => "341px",
										"height" => "158px",
										"top" => "260px",
										"left" => "420px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/grey_button.png",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "24",
										"font-style" => "italic",
										"text-align" => "center",
										"line-height" => "30",
										"border-radius" => "5",
										"padding-top" => "40",
										),
									),
								),
							),
						"1" => array(
							"preview-window-background-color" => "#FFFFFF",
							"responsive-breakpoint" => "960",
							"select-border-box-shadow" => "0 5px 10px rgba(0,0,0,0.5)",
							"background-color" => "#FEFEFE",
							"background-image-url" => PopupAllyPro::$PLUGIN_URI . "resource/img/travel-bg.png",
							"label" => "Tablet",
							"width" => "600",
							"height" => "398",
							"select-popup-location" => "center",
							"select-popup-vertical-selection" => "top",
							"select-popup-horizontal-selection" => "left",
							"popup-top" => "50%",
							"popup-left" => "50%",
							"popup-bottom" => "50%",
							"popup-right" => "50%",
							"checked-auto-adjust" => "false",
							"elements" => array(
								"0" => array(
									"css" => array(
										"width" => "503px",
										"height" => "auto",
										"top" => "40px",
										"left" => "51px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "22",
										"font-style" => "italic",
										"text-align" => "center",
										"line-height" => "26",
										),
									"inherit" => array(
										"color" => "true",
										"font-family" => "true",
										"font-style" => "true",
										"text-align" => "true",
										),
									),
								"1" => array(
									"css" => array(
										"width" => "256px",
										"height" => "119px",
										"top" => "196px",
										"left" => "49px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/purple_button.png",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "22",
										"font-style" => "italic",
										"text-align" => "center",
										"line-height" => "25",
										"border-radius" => "5",
										"padding-top" => "30",
										),
									"inherit" => array(
										"background-image" => "true",
										"color" => "true",
										"font-family" => "true",
										"font-style" => "true",
										"text-align" => "true",
										"border-radius" => "true",
										),
									),
								"2" => array(
									"css" => array(
										"width" => "256px",
										"height" => "119px",
										"top" => "196px",
										"left" => "315px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/grey_button.png",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "22",
										"font-style" => "italic",
										"text-align" => "center",
										"line-height" => "25",
										"border-radius" => "5",
										"padding-top" => "30",
										),
									"inherit" => array(
										"background-image" => "true",
										"color" => "true",
										"font-family" => "true",
										"font-style" => "true",
										"text-align" => "true",
										"border-radius" => "true",
										),
									),
								),
							"checked-popup-location-inherit" => "true",
							"checked-background-color-inherit" => "true",
							"checked-background-image-inherit" => "true",
							"checked-border-box-shadow-inherit" => "true",
							"checked-full-width-inherit" => "true",
							),
						"2" => array(
							"preview-window-background-color" => "#FFFFFF",
							"responsive-breakpoint" => "640",
							"select-border-box-shadow" => "0 5px 10px rgba(0,0,0,0.5)",
							"background-color" => "#FEFEFE",
							"background-image-url" => PopupAllyPro::$PLUGIN_URI . "resource/img/travel-bg.png",
							"label" => "Large Phone",
							"width" => "450",
							"height" => "298",
							"select-popup-location" => "center",
							"select-popup-vertical-selection" => "top",
							"select-popup-horizontal-selection" => "left",
							"popup-top" => "50%",
							"popup-left" => "50%",
							"popup-bottom" => "50%",
							"popup-right" => "50%",
							"checked-auto-adjust" => "false",
							"elements" => array(
								"0" => array(
									"css" => array(
										"width" => "434px",
										"height" => "auto",
										"top" => "27px",
										"left" => "8px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "18",
										"font-style" => "italic",
										"text-align" => "center",
										"line-height" => "25",
										),
									"inherit" => array(
										"color" => "true",
										"font-family" => "true",
										"font-style" => "true",
										"text-align" => "true",
										),
									),
								"1" => array(
									"css" => array(
										"width" => "192px",
										"height" => "89px",
										"top" => "147px",
										"left" => "37px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/purple_button.png",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "18",
										"font-style" => "italic",
										"text-align" => "center",
										"line-height" => "20",
										"border-radius" => "5",
										"padding-top" => "20",
										),
									"inherit" => array(
										"background-image" => "true",
										"color" => "true",
										"font-family" => "true",
										"font-style" => "true",
										"text-align" => "true",
										"border-radius" => "true",
										),
									),
								"2" => array(
									"css" => array(
										"width" => "192px",
										"height" => "89px",
										"top" => "147px",
										"left" => "236px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/grey_button.png",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "18",
										"font-style" => "italic",
										"text-align" => "center",
										"line-height" => "20",
										"border-radius" => "5",
										"padding-top" => "20",
										),
									"inherit" => array(
										"background-image" => "true",
										"color" => "true",
										"font-family" => "true",
										"font-style" => "true",
										"text-align" => "true",
										"border-radius" => "true",
										),
									),
								),
							"checked-popup-location-inherit" => "true",
							"checked-background-color-inherit" => "true",
							"checked-background-image-inherit" => "true",
							"checked-border-box-shadow-inherit" => "true",
							"checked-full-width-inherit" => "true",
							),
						"3" => array(
							"preview-window-background-color" => "#FFFFFF",
							"responsive-breakpoint" => "480",
							"select-border-box-shadow" => "0 5px 10px rgba(0,0,0,0.5)",
							"background-color" => "#FEFEFE",
							"background-image-url" => PopupAllyPro::$PLUGIN_URI . "resource/img/travel-bg_s.png",
							"label" => "Small Phone",
							"width" => "280",
							"height" => "200",
							"select-popup-location" => "center",
							"select-popup-vertical-selection" => "top",
							"select-popup-horizontal-selection" => "left",
							"popup-top" => "50%",
							"popup-left" => "50%",
							"popup-bottom" => "50%",
							"popup-right" => "50%",
							"checked-auto-adjust" => "false",
							"elements" => array(
								"0" => array(
									"css" => array(
										"width" => "280px",
										"height" => "auto",
										"top" => "10px",
										"left" => "0px",
										"color" => "#ffffff",
										"font-family" => "Georgia, serif",
										"font-size" => "18",
										"font-style" => "italic",
										"text-align" => "center",
										"line-height" => "17",
										),
									"inherit" => array(
										"font-family" => "true",
										"font-style" => "true",
										"text-align" => "true",
										),
									),
								"1" => array(
									"css" => array(
										"width" => "119px",
										"height" => "55px",
										"top" => "130px",
										"left" => "23px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/purple_button.png",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "14",
										"font-style" => "italic",
										"text-align" => "center",
										"line-height" => "16",
										"border-radius" => "5",
										"padding-top" => "10",
										),
									"inherit" => array(
										"background-image" => "true",
										"color" => "true",
										"font-family" => "true",
										"font-style" => "true",
										"text-align" => "true",
										"border-radius" => "true",
										),
									),
								"2" => array(
									"css" => array(
										"width" => "119px",
										"height" => "55px",
										"top" => "130px",
										"left" => "147px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/grey_button.png",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "14",
										"font-style" => "italic",
										"text-align" => "center",
										"line-height" => "16",
										"border-radius" => "5",
										"padding-top" => "10",
										),
									"inherit" => array(
										"background-image" => "true",
										"color" => "true",
										"font-family" => "true",
										"font-style" => "true",
										"text-align" => "true",
										"border-radius" => "true",
										),
									),
								),
							"checked-popup-location-inherit" => "true",
							"checked-background-color-inherit" => "true",
							"checked-background-image-inherit" => "false",
							"checked-border-box-shadow-inherit" => "true",
							"checked-full-width-inherit" => "true",
							),
						),
				));
		} /* end __construct */
	}
	
	PopupAllyProFluidTemplate::add_template(new PopupAllyProFluidTemplateFreedomGuideDesign2());
}