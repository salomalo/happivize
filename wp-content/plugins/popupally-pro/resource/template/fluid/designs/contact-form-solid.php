<?php
if (!class_exists('PopupAllyProFluidTemplateContactFormSolid')) {
	class PopupAllyProFluidTemplateContactFormSolid extends PopupAllyProFluidTemplate {
		public function __construct() {
			parent::__construct();
			$this->uid = 'fluid_qemsnqw';
			$this->template_name = 'Contact Form - Solid';

			$this->default_values = array($this->uid => array(
					"checked-customization-opened" => "false",
					"checked-hide-overlay" => "false",
					"overlay-color" => "#505050",
					"overlay-opacity" => "0.5",
					"overlay-color-rgba" => "80,80,80,0.5",
					"checked-disable-overlay-close" => "false",
					"selected-responsive" => "0",
					'element-order' => array('1', '2', '3', '4', '5', '6', '7', '9', '10'),
					"elements" => array(
						"1" => array(
							"type" => "text",
							"title" => "Headline",
							"text" => "GET IN TOUCH WITH US",
							"select-click-action" => "none",
							"click-link" => "",
							"click-new-link" => "",
							"click-popup-id" => "",
							),
						"2" => array(
							"type" => "input",
							"title" => "Name (Input)",
							"placeholder" => "enter your name:",
							"multi-placeholder" => "enter your name:",
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
						"3" => array(
							"type" => "input",
							"title" => "Email (Input)",
							"placeholder" => "enter your email:",
							"multi-placeholder" => "enter your email:",
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
						"4" => array(
							"type" => "input",
							"title" => "Subject (Input)",
							"placeholder" => "enter your subject:",
							"multi-placeholder" => "enter your subject:",
							"select-input-type" => "single",
							"checked-is-email" => "false",
							"form-select-single-field" => "",
							"checked-single-required" => "true",
							"single-field-label" => "Subject",
							"form-select-multi-field" => "",
							"checked-multi-required" => "false",
							"multi-field-label" => "Subject",
							"form-select-dropdown-field" => "",
							"checked-dropdown-required" => "false",
							"dropdown-field-label" => "Subject",
							"dropdown-options" => "",
							"form-select-checkbox-field" => "",
							"select-checkbox-default-value" => "unchecked",
							"checkbox-field-label" => "Subject",
							),
						"5" => array(
							"type" => "input",
							"title" => "Phone (Input)",
							"placeholder" => "enter your phone number:",
							"multi-placeholder" => "enter your phone number:",
							"select-input-type" => "single",
							"checked-is-email" => "false",
							"form-select-single-field" => "",
							"checked-single-required" => "true",
							"single-field-label" => "Phone",
							"form-select-multi-field" => "",
							"checked-multi-required" => "false",
							"multi-field-label" => "Phone",
							"form-select-dropdown-field" => "",
							"checked-dropdown-required" => "false",
							"dropdown-field-label" => "Phone",
							"dropdown-options" => "",
							"form-select-checkbox-field" => "",
							"select-checkbox-default-value" => "unchecked",
							"checkbox-field-label" => "Phone",
							),
						"6" => array(
							"type" => "input",
							"title" => "Message (Input)",
							"placeholder" => "place your message here:",
							"multi-placeholder" => "place your message here:",
							"select-input-type" => "multi",
							"checked-is-email" => "false",
							"form-select-single-field" => "",
							"checked-single-required" => "true",
							"single-field-label" => "Message",
							"form-select-multi-field" => "",
							"checked-multi-required" => "true",
							"multi-field-label" => "Message",
							"form-select-dropdown-field" => "",
							"checked-dropdown-required" => "false",
							"dropdown-field-label" => "Message",
							"dropdown-options" => "",
							"form-select-checkbox-field" => "",
							"select-checkbox-default-value" => "unchecked",
							"checkbox-field-label" => "Message",
							),
						"7" => array(
							"type" => "text",
							"title" => "Logo (Img)",
							"text" => "",
							"select-click-action" => "none",
							"click-link" => "",
							"click-new-link" => "",
							"click-popup-id" => "",
							),
						"9" => array(
							"type" => "text",
							"title" => "Button Shadow (Img)",
							"text" => "",
							"select-click-action" => "none",
							"click-link" => "",
							"click-new-link" => "",
							"click-popup-id" => "",
							),
						"10" => array(
							"type" => "submit",
							"title" => "Submit Button",
							"text" => "SEND YOUR NOTE",
							),
						),
					"responsive" => array(
						"0" => array(
							"preview-window-background-color" => "#FFFFFF",
							"responsive-breakpoint" => "1024",
							"select-border-box-shadow" => "0 5px 10px rgba(0,0,0,0.5)",
							"background-color" => "#FEFEFE",
							"background-image-url" => "",
							"label" => "Desktop",
							"width" => "444",
							"height" => "577",
							"select-popup-location" => "center",
							"select-popup-vertical-selection" => "top",
							"select-popup-horizontal-selection" => "left",
							"popup-top" => "50%",
							"popup-left" => "50%",
							"popup-bottom" => "50%",
							"popup-right" => "50%",
							"checked-auto-adjust" => "false",
							"elements" => array(
								"1" => array(
									"css" => array(
										"width" => "444px",
										"height" => "61px",
										"color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "24",
										"text-align" => "center",
										"padding-top" => "20",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									),
								"2" => array(
									"css" => array(
										"width" => "444px",
										"height" => "61px",
										"top" => "60px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "30",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									),
								"3" => array(
									"css" => array(
										"width" => "444px",
										"height" => "61px",
										"top" => "120px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "30",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									),
								"4" => array(
									"css" => array(
										"width" => "444px",
										"height" => "61px",
										"top" => "180px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "30",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									),
								"5" => array(
									"css" => array(
										"width" => "444px",
										"height" => "61px",
										"top" => "240px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "30",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									),
								"6" => array(
									"css" => array(
										"width" => "444px",
										"height" => "151px",
										"top" => "300px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-top" => "20",
										"padding-left" => "30",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									),
								"7" => array(
									"css" => array(
										"width" => "162px",
										"height" => "127px",
										"top" => "450px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/logo.png",
										"color" => "#333333",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									),
								"9" => array(
									"css" => array(
										"width" => "283px",
										"height" => "127px",
										"top" => "450px",
										"left" => "161px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/shadow.png",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									),
								"10" => array(
									"css" => array(
										"width" => "261px",
										"height" => "52px",
										"top" => "460px",
										"left" => "172px",
										"background-color" => "#333333",
										"color" => "#FFFFFF",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "16",
										"font-style" => "italic",
										"text-align" => "center",
										),
									),
								),
							),
						"1" => array(
							"preview-window-background-color" => "#FFFFFF",
							"responsive-breakpoint" => "960",
							"select-border-box-shadow" => "0 5px 10px rgba(0,0,0,0.5)",
							"background-color" => "#FEFEFE",
							"background-image-url" => "",
							"label" => "Tablet",
							"width" => "385",
							"height" => "500",
							"select-popup-location" => "center",
							"select-popup-vertical-selection" => "top",
							"select-popup-horizontal-selection" => "left",
							"popup-top" => "50%",
							"popup-left" => "50%",
							"popup-bottom" => "50%",
							"popup-right" => "50%",
							"checked-auto-adjust" => "false",
							"elements" => array(
								"1" => array(
									"css" => array(
										"width" => "385px",
										"height" => "53px",
										"color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "24",
										"text-align" => "center",
										"padding-top" => "17",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"text-align" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"2" => array(
									"css" => array(
										"width" => "385px",
										"height" => "53px",
										"top" => "52px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "26",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"3" => array(
									"css" => array(
										"width" => "385px",
										"height" => "53px",
										"top" => "104px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "26",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"4" => array(
									"css" => array(
										"width" => "385px",
										"height" => "53px",
										"top" => "156px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "26",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"5" => array(
									"css" => array(
										"width" => "385px",
										"height" => "53px",
										"top" => "208px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "26",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"6" => array(
									"css" => array(
										"width" => "385px",
										"height" => "131px",
										"top" => "260px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-top" => "17",
										"padding-left" => "26",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"7" => array(
									"css" => array(
										"width" => "140px",
										"height" => "110px",
										"top" => "390px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/logo.png",
										"color" => "#333333",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"background-image" => "true",
										"color" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"9" => array(
									"css" => array(
										"width" => "246px",
										"height" => "110px",
										"top" => "390px",
										"left" => "139px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/shadow.png",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"background-image" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"10" => array(
									"css" => array(
										"width" => "226px",
										"height" => "45px",
										"top" => "399px",
										"left" => "149px",
										"background-color" => "#333333",
										"color" => "#FFFFFF",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "16",
										"font-style" => "italic",
										"text-align" => "center",
										),
									"inherit" => array(
										"background-color" => "true",
										"color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
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
							"background-color" => "#FEFEFE",
							"background-image-url" => "",
							"label" => "Large Phone",
							"width" => "308",
							"height" => "400",
							"select-popup-location" => "center",
							"select-popup-vertical-selection" => "top",
							"select-popup-horizontal-selection" => "left",
							"popup-top" => "50%",
							"popup-left" => "50%",
							"popup-bottom" => "50%",
							"popup-right" => "50%",
							"checked-auto-adjust" => "false",
							"elements" => array(
								"1" => array(
									"css" => array(
										"width" => "308px",
										"height" => "42px",
										"color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "22",
										"text-align" => "center",
										"padding-top" => "12",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"font-family" => "true",
										"text-align" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"2" => array(
									"css" => array(
										"width" => "308px",
										"height" => "42px",
										"top" => "41px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "16",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"3" => array(
									"css" => array(
										"width" => "308px",
										"height" => "42px",
										"top" => "82px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "16",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"4" => array(
									"css" => array(
										"width" => "308px",
										"height" => "42px",
										"top" => "123px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "16",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"5" => array(
									"css" => array(
										"width" => "308px",
										"height" => "42px",
										"top" => "164px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "16",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"6" => array(
									"css" => array(
										"width" => "308px",
										"height" => "109px",
										"top" => "205px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-top" => "12",
										"padding-left" => "16",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"7" => array(
									"css" => array(
										"width" => "112px",
										"height" => "88px",
										"top" => "312px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/logo.png",
										"color" => "#333333",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"background-image" => "true",
										"color" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"9" => array(
									"css" => array(
										"width" => "197px",
										"height" => "88px",
										"top" => "312px",
										"left" => "111px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/shadow.png",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"background-image" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"10" => array(
									"css" => array(
										"width" => "181px",
										"height" => "36px",
										"top" => "319px",
										"left" => "119px",
										"background-color" => "#333333",
										"color" => "#FFFFFF",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "16",
										"font-style" => "italic",
										"text-align" => "center",
										),
									"inherit" => array(
										"background-color" => "true",
										"color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
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
						"4" => array(
							"preview-window-background-color" => "#FFFFFF",
							"responsive-breakpoint" => "480",
							"select-border-box-shadow" => "0 5px 10px rgba(0,
											0,
											0,
											0.5)",
							"background-color" => "#FEFEFE",
							"background-image-url" => "",
							"label" => "Small Phone",
							"width" => "280",
							"height" => "364",
							"select-popup-location" => "center",
							"select-popup-vertical-selection" => "top",
							"select-popup-horizontal-selection" => "left",
							"popup-top" => "50%",
							"popup-left" => "50%",
							"popup-bottom" => "50%",
							"popup-right" => "50%",
							"checked-auto-adjust" => "false",
							"elements" => array(
								"1" => array(
									"css" => array(
										"width" => "280px",
										"height" => "38px",
										"color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "18",
										"text-align" => "center",
										"padding-top" => "10",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"font-family" => "true",
										"text-align" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"2" => array(
									"css" => array(
										"width" => "280px",
										"height" => "38px",
										"top" => "37px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "15",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"3" => array(
									"css" => array(
										"width" => "280px",
										"height" => "38px",
										"top" => "74px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "15",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"4" => array(
									"css" => array(
										"width" => "280px",
										"height" => "38px",
										"top" => "111px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "15",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"5" => array(
									"css" => array(
										"width" => "280px",
										"height" => "38px",
										"top" => "148px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-left" => "15",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"6" => array(
									"css" => array(
										"width" => "280px",
										"height" => "100px",
										"top" => "185px",
										"color" => "#333333",
										"placeholder-color" => "#333333",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "15",
										"font-style" => "italic",
										"padding-top" => "10",
										"padding-left" => "15",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"color" => "true",
										"placeholder-color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"7" => array(
									"css" => array(
										"width" => "102px",
										"height" => "80px",
										"top" => "284px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/logo.png",
										"color" => "#333333",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"background-image" => "true",
										"color" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"9" => array(
									"css" => array(
										"width" => "179px",
										"height" => "80px",
										"top" => "284px",
										"left" => "101px",
										"background-image" => PopupAllyPro::$PLUGIN_URI . "resource/img/shadow.png",
										"border-width" => "1",
										"border-style" => "solid",
										"border-color" => "#000000",
										),
									"inherit" => array(
										"background-image" => "true",
										"border-width" => "true",
										"border-style" => "true",
										"border-color" => "true",
										),
									),
								"10" => array(
									"css" => array(
										"width" => "164px",
										"height" => "33px",
										"top" => "290px",
										"left" => "107px",
										"background-color" => "#333333",
										"color" => "#FFFFFF",
										"font-family" => '"Times New Roman", Times, serif',
										"font-size" => "16",
										"font-style" => "italic",
										"text-align" => "center",
										),
									"inherit" => array(
										"background-color" => "true",
										"color" => "true",
										"font-family" => "true",
										"font-size" => "true",
										"font-style" => "true",
										"text-align" => "true",
										),
									),
								),
							"checked-popup-location-inherit" => "true",
							"checked-background-color-inherit" => "true",
							"checked-background-image-inherit" => "true",
							"checked-border-box-shadow-inherit" => "false",
							"checked-full-width-inherit" => "true",
							),
						),
				));
		} /* end __construct */
	}
	
	PopupAllyProFluidTemplate::add_template(new PopupAllyProFluidTemplateContactFormSolid());
}