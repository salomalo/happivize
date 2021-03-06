<?php
if (!class_exists('PopupAllyProFluidTemplateSpecialOffersDesign1Dark')) {
	class PopupAllyProFluidTemplateSpecialOffersDesign1Dark extends PopupAllyProFluidTemplate {
		public function __construct() {
			parent::__construct();
			$this->uid = 'fluid_qemsnqs';
			$this->template_name = 'Special Offers - Design 1 (Dark)';

			$this->default_values = array($this->uid => array(
					"checked-customization-opened" => "false",
					"checked-hide-overlay" => "false",
					"overlay-color" => "#505050",
					"overlay-opacity" => "0.5",
					"overlay-color-rgba" => "80,80,80,0.5",
					"checked-disable-overlay-close" => "false",
					"selected-responsive" => "0",
					'element-order' => array('1', '2', '3', '4', '5', '6', '7', '8', '9'),
					"elements" => array(
						"1" => array(
							"type" => "text",
							"title" => "Background Colour",
							"text" => "",
							"select-click-action" => "none",
							"click-link" => "",
							"click-new-link" => "",
							"click-popup-id" => "",
							),
						"2" => array(
							"type" => "text",
							"title" => "Headline",
							"text" => "SAVE 20% AFTER YOU OPT-IN",
							"select-click-action" => "none",
							"click-link" => "",
							"click-new-link" => "",
							"click-popup-id" => "",
							),
						"3" => array(
							"type" => "text",
							"title" => "Horizontal Divider",
							"text" => "____________________________",
							"select-click-action" => "none",
							"click-link" => "",
							"click-new-link" => "",
							"click-popup-id" => "",
							),
						"4" => array(
							"type" => "text",
							"title" => "Sub-headline",
							"text" => "you&#39;ll get a special coupon code:",
							"select-click-action" => "none",
							"click-link" => "",
							"click-new-link" => "",
							"click-popup-id" => "",
							),
						"5" => array(
							"type" => "text",
							"title" => "Label: Your name",
							"text" => "YOUR NAME:",
							"select-click-action" => "none",
							"click-link" => "",
							"click-new-link" => "",
							"click-popup-id" => "",
							),
						"6" => array(
							"type" => "text",
							"title" => "Label: Your email",
							"text" => "YOUR EMAIL:",
							"select-click-action" => "none",
							"click-link" => "",
							"click-new-link" => "",
							"click-popup-id" => "",
							),
						"7" => array(
							"type" => "input",
							"title" => "Input: Name",
							"placeholder" => "",
							"multi-placeholder" => "",
							"select-input-type" => "single",
							"checked-is-email" => "false",
							"form-select-single-field" => "",
							"checked-single-required" => "true",
							"single-field-label" => "Name",
							"form-select-multi-field" => "",
							"checked-multi-required" => "false",
							"multi-field-label" => "Name",
							"form-select-dropdown-field" => "",
							"checked-dropdown-required" => "false",
							"dropdown-field-label" => "Name",
							"dropdown-options" => "",
							"form-select-checkbox-field" => "",
							"select-checkbox-default-value" => "unchecked",
							"checkbox-field-label" => "Name",
							),
						"8" => array(
							"type" => "input",
							"title" => "Input: Email",
							"placeholder" => "",
							"multi-placeholder" => "",
							"select-input-type" => "single",
							"checked-is-email" => "true",
							"form-select-single-field" => "",
							"checked-single-required" => "true",
							"single-field-label" => "Email",
							"form-select-multi-field" => "",
							"checked-multi-required" => "false",
							"multi-field-label" => "Email",
							"form-select-dropdown-field" => "",
							"checked-dropdown-required" => "false",
							"dropdown-field-label" => "Email",
							"dropdown-options" => "",
							"form-select-checkbox-field" => "",
							"select-checkbox-default-value" => "unchecked",
							"checkbox-field-label" => "Email",
							),
						"9" => array(
							"type" => "submit",
							"title" => "Submit Button",
							"text" => "CLICK TO OPT-IN",
							),
						),
					"responsive" => array(
						"0" => array(
							"preview-window-background-color" => "#FFFFFF",
							"responsive-breakpoint" => "1024",
							"select-border-box-shadow" => "0 5px 10px rgba(0,0,0,0.5)",
							"background-color" => "",
							"background-image-url" => PopupAllyPro::$PLUGIN_URI . "resource/img/special-offers-bg.png",
							"label" => "Desktop",
							"width" => "667",
							"height" => "572",
							"select-popup-location" => "center",
							"select-popup-vertical-selection" => "top",
							"select-popup-horizontal-selection" => "left",
							"popup-top" => "40%",
							"popup-left" => "50%",
							"popup-bottom" => "40%",
							"popup-right" => "50%",
							"checked-auto-adjust" => "false",
							"elements" => array(
								"1" => array(
									"css" => array(
										"width" => "609px",
										"height" => "517px",
										"top" => "25px",
										"left" => "30px",
										"background-color" => "#000000",
										"opacity" => "0.69",
										),
									),
								"2" => array(
									"css" => array(
										"width" => "667px",
										"height" => "auto",
										"top" => "100px",
										"left" => "0px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "32",
										"text-align" => "center",
										),
									),
								"3" => array(
									"css" => array(
										"width" => "667px",
										"height" => "auto",
										"top" => "140px",
										"color" => "#FFFFFF",
										"font-size" => "14",
										"text-align" => "center",
										),
									),
								"4" => array(
									"css" => array(
										"width" => "667px",
										"height" => "auto",
										"top" => "190px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "18",
										"text-align" => "center",
										),
									),
								"5" => array(
									"css" => array(
										"width" => "100px",
										"height" => "auto",
										"top" => "245px",
										"left" => "170px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "14",
										),
									),
								"6" => array(
									"css" => array(
										"width" => "100px",
										"height" => "auto",
										"top" => "320px",
										"left" => "170px",
										"color" => "#FFFFFF",
										"font-size" => "14",
										),
									),
								"7" => array(
									"css" => array(
										"width" => "333px",
										"height" => "42px",
										"top" => "265px",
										"left" => "170px",
										"color" => "#FFFFFF",
										"font-size" => "18",
										"padding-left" => "10",
										"border-width" => "2",
										"border-style" => "inset",
										"border-radius" => "5",
										),
									),
								"8" => array(
									"css" => array(
										"width" => "333px",
										"height" => "42px",
										"top" => "340px",
										"left" => "170px",
										"color" => "#FFFFFF",
										"font-size" => "18",
										"padding-left" => "10",
										"border-width" => "2",
										"border-style" => "inset",
										"border-radius" => "5",
										),
									),
								"9" => array(
									"css" => array(
										"width" => "333px",
										"height" => "60px",
										"top" => "410px",
										"left" => "170px",
										"background-color" => "#877E76",
										"color" => "#FFFFFF",
										"font-size" => "20",
										"text-align" => "center",
										"border-radius" => "5",
										),
									),
								),
							),
						"1" => array(
							"preview-window-background-color" => "#FFFFFF",
							"responsive-breakpoint" => "960",
							"select-border-box-shadow" => "0 5px 10px rgba(0,0,0,0.5)",
							"background-color" => "",
							"background-image-url" => PopupAllyPro::$PLUGIN_URI . "resource/img/special-offers-bg.png",
							"label" => "Tablet",
							"width" => "500",
							"height" => "429",
							"select-popup-location" => "center",
							"select-popup-vertical-selection" => "top",
							"select-popup-horizontal-selection" => "left",
							"popup-top" => "40%",
							"popup-left" => "50%",
							"popup-bottom" => "40%",
							"popup-right" => "50%",
							"checked-auto-adjust" => "false",
							"elements" => array(
								"1" => array(
									"css" => array(
										"width" => "457px",
										"height" => "388px",
										"top" => "19px",
										"left" => "22px",
										"background-color" => "#000000",
										"opacity" => "0.69",
										),
									"inherit" => array(
										"background-color" => "true",
										"opacity" => "true",
										),
									),
								"2" => array(
									"css" => array(
										"width" => "500px",
										"height" => "auto",
										"top" => "75px",
										"left" => "0px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "24",
										"text-align" => "center",
										),
									"inherit" => array(
										"color" => "true",
										"font-family" => "true",
										"text-align" => "true",
										),
									),
								"3" => array(
									"css" => array(
										"width" => "500px",
										"height" => "auto",
										"top" => "105px",
										"color" => "#FFFFFF",
										"font-size" => "10",
										"text-align" => "center",
										),
									"inherit" => array(
										"color" => "true",
										"text-align" => "true",
										),
									),
								"4" => array(
									"css" => array(
										"width" => "500px",
										"height" => "auto",
										"top" => "143px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "18",
										"text-align" => "center",
										),
									"inherit" => array(
										"color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"text-align" => "true",
										),
									),
								"5" => array(
									"css" => array(
										"width" => "100px",
										"height" => "auto",
										"top" => "175px",
										"left" => "127px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "14",
										),
									"inherit" => array(
										"color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										),
									),
								"6" => array(
									"css" => array(
										"width" => "100px",
										"height" => "auto",
										"top" => "235px",
										"left" => "127px",
										"color" => "#FFFFFF",
										"font-size" => "14",
										),
									"inherit" => array(
										"color" => "true",
										"font-size" => "true",
										),
									),
								"7" => array(
									"css" => array(
										"width" => "250px",
										"height" => "32px",
										"top" => "199px",
										"left" => "127px",
										"color" => "#FFFFFF",
										"font-size" => "14",
										"padding-left" => "7",
										"border-width" => "1",
										"border-style" => "inset",
										"border-radius" => "4",
										),
									"inherit" => array(
										"color" => "true",
										"border-style" => "true",
										),
									),
								"8" => array(
									"css" => array(
										"width" => "250px",
										"height" => "32px",
										"top" => "255px",
										"left" => "127px",
										"color" => "#FFFFFF",
										"font-size" => "14",
										"padding-left" => "7",
										"border-width" => "1",
										"border-style" => "inset",
										"border-radius" => "4",
										),
									"inherit" => array(
										"color" => "true",
										"border-style" => "true",
										),
									),
								"9" => array(
									"css" => array(
										"width" => "250px",
										"height" => "45px",
										"top" => "308px",
										"left" => "127px",
										"background-color" => "#877E76",
										"color" => "#FFFFFF",
										"font-size" => "15",
										"text-align" => "center",
										"border-radius" => "4",
										),
									"inherit" => array(
										"background-color" => "true",
										"color" => "true",
										"text-align" => "true",
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
							"background-color" => "",
							"background-image-url" => PopupAllyPro::$PLUGIN_URI . "resource/img/special-offers-bg.png",
							"label" => "Large Phone",
							"width" => "400",
							"height" => "343",
							"select-popup-location" => "center",
							"select-popup-vertical-selection" => "top",
							"select-popup-horizontal-selection" => "left",
							"popup-top" => "40%",
							"popup-left" => "50%",
							"popup-bottom" => "40%",
							"popup-right" => "50%",
							"checked-auto-adjust" => "false",
							"elements" => array(
								"1" => array(
									"css" => array(
										"width" => "365px",
										"height" => "310px",
										"top" => "15px",
										"left" => "18px",
										"background-color" => "#000000",
										"opacity" => "0.69",
										),
									"inherit" => array(
										"background-color" => "true",
										"opacity" => "true",
										),
									),
								"2" => array(
									"css" => array(
										"width" => "400px",
										"height" => "auto",
										"top" => "60px",
										"left" => "0px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "20",
										"text-align" => "center",
										),
									"inherit" => array(
										"color" => "true",
										"font-family" => "true",
										"text-align" => "true",
										),
									),
								"3" => array(
									"css" => array(
										"width" => "400px",
										"height" => "auto",
										"top" => "84px",
										"color" => "#FFFFFF",
										"font-size" => "8",
										"text-align" => "center",
										),
									"inherit" => array(
										"color" => "true",
										"text-align" => "true",
										),
									),
								"4" => array(
									"css" => array(
										"width" => "400px",
										"height" => "auto",
										"top" => "110px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "16",
										"text-align" => "center",
										),
									"inherit" => array(
										"color" => "true",
										"font-family" => "true",
										"text-align" => "true",
										),
									),
								"5" => array(
									"css" => array(
										"width" => "100px",
										"height" => "auto",
										"top" => "140px",
										"left" => "102px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "14",
										),
									"inherit" => array(
										"color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										),
									),
								"6" => array(
									"css" => array(
										"width" => "100px",
										"height" => "auto",
										"top" => "192px",
										"left" => "102px",
										"color" => "#FFFFFF",
										"font-size" => "14",
										),
									"inherit" => array(
										"color" => "true",
										"font-size" => "true",
										),
									),
								"7" => array(
									"css" => array(
										"width" => "200px",
										"height" => "25px",
										"top" => "161px",
										"left" => "102px",
										"color" => "#FFFFFF",
										"font-size" => "11",
										"padding-left" => "5",
										"border-width" => "1",
										"border-style" => "inset",
										"border-radius" => "3",
										),
									"inherit" => array(
										"color" => "true",
										"border-style" => "true",
										),
									),
								"8" => array(
									"css" => array(
										"width" => "200px",
										"height" => "25px",
										"top" => "210px",
										"left" => "102px",
										"color" => "#FFFFFF",
										"font-size" => "11",
										"padding-left" => "5",
										"border-width" => "1",
										"border-style" => "inset",
										"border-radius" => "3",
										),
									"inherit" => array(
										"color" => "true",
										"border-style" => "true",
										),
									),
								"9" => array(
									"css" => array(
										"width" => "200px",
										"height" => "36px",
										"top" => "250px",
										"left" => "102px",
										"background-color" => "#877E76",
										"color" => "#FFFFFF",
										"font-size" => "12",
										"text-align" => "center",
										"border-radius" => "3",
										),
									"inherit" => array(
										"background-color" => "true",
										"color" => "true",
										"text-align" => "true",
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
							"background-color" => "",
							"background-image-url" => PopupAllyPro::$PLUGIN_URI . "resource/img/special-offers-bg_s.png",
							"label" => "Small Phone",
							"width" => "280",
							"height" => "343",
							"select-popup-location" => "center",
							"select-popup-vertical-selection" => "top",
							"select-popup-horizontal-selection" => "left",
							"popup-top" => "40%",
							"popup-left" => "50%",
							"popup-bottom" => "40%",
							"popup-right" => "50%",
							"checked-auto-adjust" => "false",
							"elements" => array(
								"1" => array(
									"css" => array(
										"width" => "256px",
										"height" => "310px",
										"top" => "15px",
										"left" => "13px",
										"background-color" => "#000000",
										"opacity" => "0.69",
										),
									"inherit" => array(
										"background-color" => "true",
										"opacity" => "true",
										),
									),
								"2" => array(
									"css" => array(
										"width" => "250px",
										"height" => "auto",
										"top" => "40px",
										"left" => "15px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "20",
										"text-align" => "center",
										),
									"inherit" => array(
										"color" => "true",
										"font-family" => "true",
										"text-align" => "true",
										),
									),
								"3" => array(
									"css" => array(
										"width" => "280px",
										"height" => "auto",
										"top" => "84px",
										"color" => "#FFFFFF",
										"font-size" => "8",
										"text-align" => "center",
										),
									"inherit" => array(
										"color" => "true",
										"text-align" => "true",
										),
									),
								"4" => array(
									"css" => array(
										"width" => "280px",
										"height" => "auto",
										"top" => "114px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "16",
										"text-align" => "center",
										),
									"inherit" => array(
										"color" => "true",
										"font-family" => "true",
										"text-align" => "true",
										),
									),
								"5" => array(
									"css" => array(
										"width" => "100px",
										"height" => "auto",
										"top" => "147px",
										"left" => "51px",
										"color" => "#FFFFFF",
										"font-family" => "Georgia, serif",
										"font-size" => "14",
										),
									"inherit" => array(
										"color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										),
									),
								"6" => array(
									"css" => array(
										"width" => "100px",
										"height" => "auto",
										"top" => "197px",
										"left" => "51px",
										"color" => "#FFFFFF",
										"font-size" => "14",
										),
									"inherit" => array(
										"color" => "true",
										"font-size" => "true",
										),
									),
								"7" => array(
									"css" => array(
										"width" => "180px",
										"height" => "25px",
										"top" => "170px",
										"left" => "51px",
										"color" => "#FFFFFF",
										"font-size" => "11",
										"padding-left" => "4",
										"border-width" => "1",
										"border-style" => "inset",
										"border-radius" => "3",
										),
									"inherit" => array(
										"color" => "true",
										"border-style" => "true",
										),
									),
								"8" => array(
									"css" => array(
										"width" => "180px",
										"height" => "25px",
										"top" => "220px",
										"left" => "51px",
										"color" => "#FFFFFF",
										"font-size" => "11",
										"padding-left" => "4",
										"border-width" => "1",
										"border-style" => "inset",
										"border-radius" => "3",
										),
									"inherit" => array(
										"color" => "true",
										"border-style" => "true",
										),
									),
								"9" => array(
									"css" => array(
										"width" => "180px",
										"height" => "36px",
										"top" => "256px",
										"left" => "51px",
										"background-color" => "#877E76",
										"color" => "#FFFFFF",
										"font-size" => "12",
										"text-align" => "center",
										"border-radius" => "3",
										),
									"inherit" => array(
										"background-color" => "true",
										"color" => "true",
										"text-align" => "true",
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
	
	PopupAllyProFluidTemplate::add_template(new PopupAllyProFluidTemplateSpecialOffersDesign1Dark());
}