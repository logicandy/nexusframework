<?php

function nxs_widgets_commercialmsgs_geticonid() {
	$widget_name = basename(dirname(__FILE__));
	return "nxs-icon-bubble";
}

// Setting the widget title
function nxs_widgets_commercialmsgs_gettitle() {
	return nxs_l18n__("Commercial Messages", "nxs_td");
}

// Unistyle
function nxs_widgets_commercialmsgs_getunifiedstylinggroup() {
	return "commercialmsgswidget";
}

/* WIDGET STRUCTURE
----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------- */

// Define the properties of this widget
function nxs_widgets_commercialmsgs_home_getoptions($args) 
{
	$options = array
	(
		"sheettitle" => nxs_widgets_commercialmsgs_gettitle(),
		"sheeticonid" => nxs_widgets_commercialmsgs_geticonid(),
		"sheethelp" => nxs_l18n__("https://docs.google.com/spreadsheets/d/1lTcFyiKYRUiUdlJilsVaigkHT7a69eL-lVKKPp53v9c/edit#gid=1764396204"),
		"unifiedstyling" => array
		(
			"group" => nxs_widgets_commercialmsgs_getunifiedstylinggroup(),
		),
		"fields" => array
		(
			// SLIDES			
			
			array( 
				"id" 				=> "wrapper_input_begin",
				"type" 				=> "wrapperbegin",
				"label" 			=> nxs_l18n__("Slides", "nxs_td"),
			),
			
			array(
				"id" 				=> "item_durationvisibility",	
				"type" 				=> "select",
				"label" 			=> nxs_l18n__("Visibility duration", "nxs_td"),
				"dropdown" 			=> nxs_convertindexarraytoassociativearray(array("3000","4000","5000","6000","9000","12000")),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "item_transitionduration",
				"type" 				=> "select",
				"label" 			=> nxs_l18n__("item_transitionduration", "nxs_td"),
				"dropdown" 			=> nxs_convertindexarraytoassociativearray(array("200","300","400")),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "slider_width",
				"type" 				=> "select",
				"label" 			=> nxs_l18n__("Slider width", "nxs_td"),
				"dropdown" 			=> array("100%"=>"100%","90%"=>"90%","80%"=>"80%","70%"=>"70%","60%"=>"60%","50%"=>"50%"),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "border_width",
				"type" 				=> "select",
				"label" 			=> nxs_l18n__("Image border size", "nxs_td"),
				"dropdown" 			=> nxs_style_getdropdownitems("border_width"),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "pause_transition",
				"type" 				=> "checkbox",
				"label" 			=> nxs_l18n__("Pause transition on hover", "nxs_td"),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "shadow",
				"type" 				=> "checkbox",
				"label" 			=> nxs_l18n__("Slide shadow", "nxs_td"),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "fullwidth_height",
				"type" 				=> "select",
				"label" 			=> nxs_l18n__("Height of each slide", "nxs_td"),
				"dropdown" 			=> array
				(
					"@@@nxsempty@@@" => nxs_l18n__("None", "nxs_td"),
					"200px" => nxs_l18n__("200px", "nxs_td"),
					"300px" => nxs_l18n__("300px", "nxs_td"),
					"400px" => nxs_l18n__("400px", "nxs_td"),
					"500px" => nxs_l18n__("500px", "nxs_td"),
					"600px" => nxs_l18n__("600px", "nxs_td"),
					"screenheight" => nxs_l18n__("Height of screen", "nxs_td"),
				),
				"tooltip" 			=> nxs_l18n__("This option set's the height of the caption container between the header and the rest of the content", "nxs_td"),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "widescreen_slider",
				"type" 				=> "checkbox",
				"label" 			=> nxs_l18n__("Widescreen slider ", "nxs_td"),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "responsive_display",
				"type" 				=> "select",
				"label" 			=> nxs_l18n__("Responsive display", "nxs_td"),
				"dropdown" 			=> array
				(
					"@@@nxsempty@@@" => nxs_l18n__("Always", "nxs_td"),
					"display480" => nxs_l18n__("480", "nxs_td"),
					"display720" => nxs_l18n__("720", "nxs_td"),
					"display960" => nxs_l18n__("960", "nxs_td"),
					"display1200" => nxs_l18n__("1200", "nxs_td"),
				),
				"tooltip" 			=> nxs_l18n__("This option let's you set the sliders display at a certain viewport and up", "nxs_td"),
				"unistylablefield"	=> true
			),
			
			array( 
				"id" 				=> "wrapper_input_end",
				"type" 				=> "wrapperend"
			),
			
			// MEDIA META
			
			array( 
				"id" 				=> "wrapper_input_begin",
				"type" 				=> "wrapperbegin",
				"initial_toggle_state"	=> "closed",
				"label" 			=> nxs_l18n__("Media meta", "nxs_td"),
			),

			array(
				"id" 				=> "media_meta",
				"type" 				=> "input",
				"label" 			=> nxs_l18n__("Media meta", "nxs_td"),
			),
			
			array( 
				"id" 				=> "wrapper_input_end",
				"type" 				=> "wrapperend"
			),			
			// NAVIGATION AND METADATA
			
			array( 
				"id" 				=> "wrapper_input_begin",
				"type" 				=> "wrapperbegin",
				"label" 			=> nxs_l18n__("Navigation and metadata", "nxs_td"),
				"unistylablefield"	=> true
			),
			
			array(
				"id" 				=> "metadata_layout",
				"type" 				=> "select",
				"label" 			=> nxs_l18n__("Text layout", "nxs_td"),
				"dropdown" 			=> array
				(
					"@@@nxsempty@@@" => nxs_l18n__("Default", "nxs_td"),
					"center" => nxs_l18n__("center", "nxs_td"),
				),
				"tooltip" 			=> nxs_l18n__("This option let's you set the sliders display at a certain viewport and up", "nxs_td"),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "metadata",
				"type" 				=> "checkbox",
				"label" 			=> nxs_l18n__("Show title and description", "nxs_td"),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "main_controllers",
				"type" 				=> "checkbox",
				"label" 			=> nxs_l18n__("Show controllers", "nxs_td"),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "title_fontsize",
				"type" 				=> "select",
				"label" 			=> nxs_l18n__("Title fontsize", "nxs_td"),
				"dropdown" 			=> nxs_style_getdropdownitems("fontsize"),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "title_fontzen",
				"type" 				=> "fontzen",
				"label" 			=> nxs_l18n__("Title fontzen", "nxs_td"),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "text_fontzen",
				"type" 				=> "fontzen",
				"label" 			=> nxs_l18n__("Text fontzen", "nxs_td"),
				"unistylablefield"	=> true
			),
            array(
				"id" 				=> "button_scale",
				"type" 				=> "select",
				"label" 			=> nxs_l18n__("Button size", "nxs_td"),
				"dropdown" 			=> nxs_style_getdropdownitems("button_scale"),
				"unistylablefield"	=> true,
			),
			array( 
				"id" 				=> "button_color",
				"type" 				=> "colorzen", // "select",
				"label" 			=> nxs_l18n__("Button color", "nxs_td"),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "button_fontzen",
				"type" 				=> "fontzen",
				"label" 			=> nxs_l18n__("Button fontzen", "nxs_td"),
				"unistylablefield"	=> true
			),
			array(
				"id" 				=> "button_alignment",
				"type" 				=> "radiobuttons",
				"subtype" 			=> "halign",
				"label" 			=> nxs_l18n__("Button alignment", "nxs_td"),
				"unistylablefield"	=> true,
			),
			array( 
				"id" 				=> "bgcolor",
				"type" 				=> "colorzen",
				"label" 			=> nxs_l18n__("Background color", "nxs_td"),
				"unistylablefield"	=> true
			),
			array( 
				"id" 				=> "metadata_color",
				"type" 				=> "colorzen",
				"label" 			=> nxs_l18n__("Description background color", "nxs_td"),
				"unistylablefield"	=> true
			),
			array(
				"id"     			=> "metadata_padding",
				"type"     			=> "select",
				"label"    			=> nxs_l18n__("Description padding", "nxs_td"),
				"dropdown"   		=> nxs_style_getdropdownitems("padding"),
				"unistylablefield"	=> true
			),
			
			array( 
				"id" 				=> "wrapper_input_end",
				"type" 				=> "wrapperend",
				"unistylablefield"	=> true
			),
		)
	);
	
	nxs_extend_widgetoptionfields($options, array("backgroundstyle"));
	
	return $options;
}


/* WIDGET HTML
----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------- */

function nxs_widgets_commercialmsgs_render_webpart_render_htmlvisualization($args) 
{	
	// Importing variables
	extract($args);
	
	// Every widget needs it's own unique id for all sorts of purposes
	// The $postid and $placeholderid are used when building the HTML later on
	$temp_array = nxs_getwidgetmetadata($postid, $placeholderid);
	
	$unistyle = $temp_array["unistyle"];
	if (isset($unistyle) && $unistyle != "") {
		// blend unistyle properties
		$unistyleproperties = nxs_unistyle_getunistyleproperties(nxs_widgets_commercialmsgs_getunifiedstylinggroup(), $unistyle);
		$temp_array = array_merge($temp_array, $unistyleproperties);	
	}
	
	// The $mixedattributes is an array which will be used to set various widget specific variables (and non-specific).
	$mixedattributes = array_merge($temp_array, $args);
	
	// Output the result array and setting the "result" position to "OK"
	$result = array();
	$result["result"] = "OK";
	
	
	global $nxs_global_row_render_statebag;
	
	/* HOVER MENU HTML
	---------------------------------------------------------------------------------------------------- */
	
	nxs_ob_start();

	?>
	<ul>
		<a href='#' title='<?php nxs_l18n_e("Edit[nxs:tooltip]", "nxs_td"); ?>' onclick="nxs_js_edit_widget(this); return false;">
				<li title='<?php nxs_l18n_e("Edit[nxs:tooltip]", "nxs_td"); ?>'>
					<span class='nxs-icon-bubble'></span>
				</li>
			</a>
		<li title='<?php nxs_l18n_e("Move[nxs:tooltip]", "nxs_td"); ?>' class='nxs-draggable nxs-existing-pageitem nxs-dragtype-placeholder' id='draggableplaceholderid_<?php echo $placeholderid; ?>'>
			<span class='nxs-icon-move'></span>
			<div class="nxs-drag-helper" style='display: none;'>
				<div class='placeholder'>
					<span id='placeholdertemplate_<?php echo $placeholdertemplate; ?>' class='<?php echo nxs_widgets_commercialmsgs_geticonid();?>'></span>
				</div>
			</div>					
		</li>
		<a class='nxs-no-event-bubbling' href='#' onclick='nxs_js_popup_placeholder_wipe("<?php echo $postid; ?>", "<?php echo $placeholderid; ?>"); return false;'>
			<li title='<?php nxs_l18n_e("Delete[nxs:tooltip]", "nxs_td"); ?>'><span class='nxs-icon-trash'></span></li>
		</a>
		<?php 
		if (nxs_shoulddebugmeta())
		{
			nxs_ob_start();
			?>
			<a class='nxs-no-event-bubbling' href='#' onclick="nxs_js_edit_widget_v2(this, 'debug'); return false; return false;">
       	<li title='<?php nxs_l18n_e("Debug[tooltip]", "nxs_td"); ?>'>
       		<span class='nxs-icon-search'></span>
       	</li>
    	</a>
    	<?php
    	$debughtml = nxs_ob_get_contents();
			nxs_ob_end_clean();
		}
		else
		{
			$debughtml = "";
		}
		echo $debughtml;
		?>
	</ul>
	<?php 
	
	$menu = nxs_ob_get_contents();
	nxs_ob_end_clean();
	
	global $nxs_global_placeholder_render_statebag;
	$nxs_global_placeholder_render_statebag["menutopright"] = $menu;
	
	/* EXPRESSIONS
	---------------------------------------------------------------------------------------------------- */
	
	// TRANSITION DURATION
	if ($item_transitionduration == "") { $item_transitionduration = "2500"; }
	if ($item_durationvisibility == "") { $item_durationvisibility = "5000"; }
	
	// PAUSE TRANSITION
	if ($pause_transition == "") 	{ $pause_transition = "false"; }
	else 							{ $pause_transition = "true"; }
	
	// SLIDER WIDTH
	if ($slider_width == "")
	{
		$slider_width = "100%";
	}
	$slider_width_val = intval(str_replace("%", "", $slider_width));
	$margin = (100 - $slider_width_val)/2;
	$margin_left = 'margin-left: '.$margin.'%;';
	$margin_right = 'margin-right: '.$margin.'%;';
	$slider_width = 'max-width: '.$slider_width.' !important;';
	
	// SLIDE SHADOW
	if ($shadow != "") 	{ $shadow = "nxs-shadow"; }
	
	// Background Color
	if ($bgcolor == "") { $bgcolor = 'base2-a0-6'; }
	$bgcolor_cssclass = nxs_getcssclassesforlookup("nxs-colorzen-", $bgcolor);
	
	// Metadata background color and padding
	$metadata_color_cssclass = nxs_getcssclassesforlookup("nxs-colorzen-", $metadata_color);
	$metadata_padding_cssclass = nxs_getcssclassesforlookup("nxs-padding-", $metadata_padding);
	
	// SLIDESHOW BORDER
	
		// Multiplier
		if (strlen($border_width) > 3) {
			$multiplier = substr($border_width, -4, 2);
		} else {
			$multiplier = substr($border_width, -3, 1);
		}
		// Border width
		settype($multiplier, "integer");
		$factor = 3;
		$border_width = $multiplier * $factor; 
		$slide_border_width = 'box-shadow: inset 0 0 0 '.$border_width.'px white;';
		
		// Metadata layout
		if  ($metadata_layout != "") {
			// margin-top
			$factor = 4.5;
			$metadata_margin_top = 'margin-top: -'.($multiplier * $factor).'px;';
			// margin-left
			$factor = 6;
			$metadata_margin_left = 'margin-left: -'.($multiplier * $factor).'px;';
			$metadata_alignment = "left: ".$border_width."px;";
		}
		
		
	
	// Title fontsize,fontzen and Text fontzen
	$title_fontsize_cssclass = nxs_getcssclassesforlookup("nxs-head-fontsize-", $title_fontsize);
	$title_fontzen_cssclass = nxs_getcssclassesforlookup("nxs-fontzen-", $title_fontzen);
	$text_fontzen_cssclass = nxs_getcssclassesforlookup("nxs-fontzen-", $text_fontzen);


	// MAIN CONTROLLERS
	if ($metadata != "" && $main_controllers != "") {
		$main_controllers = '<div id="controllers_'.$placeholderid.'" class="nxs-slider-controller" style="bottom: '.($border_width + 16).'px; right: '.$border_width.'px; '.$margin_right.'"></div>';	
	} else if ($metadata == "" && $main_controllers != "") {
		$main_controllers = '
			<div class="main-controllers-bg '.$bgcolor_cssclass.'" style="bottom: '.$border_width.'px; '.$slider_width.' '.$margin_left.'"></div>
			<div id="controllers_'.$placeholderid.'" class="nxs-slider-controller fullwidth" style="bottom: '.($border_width + 16). 'px;"></div>';
	}
	
	// SIDE CONTROLLERS
	if ($side_controllers != "") {
		$side_controllers = '
		<!-- left -->
		<a id="' .$placeholderid.'" class="nxs-slider-prev"><span></span></a>
		<!-- right -->
		<a id="next_' .$placeholderid.'" class="nxs-slider-next"><span></span></a>		
		';
	}
		
	// FULLWIDTH PARAMS
	if ($fullwidth_height != "") {
		if ($fullwidth_height == "screenheight") {
			$slideset_inlinestyle = 'overflow: hidden;'; // height: 99px !important;';
			$slide_img_inlinestyle = ''; // 'min-height: 99px !important;';
		} else  {
			if (!nxs_stringendswith($fullwidth_height, "px")) {
				$fullwidth_height = $fullwidth_height . "px";
			} else {
				// already is defined in px
			}
		
			$slideset_inlinestyle = 'overflow: hidden; height: '.$fullwidth_height.' !important;';
			$slide_img_inlinestyle = 'min-height: '.$fullwidth_height.' !important;';
		}
	}
	
	// WIDESCREEN 
	if ($widescreen_slider != "") {
		// forceer dat bij het renderen (in de shortcode) de regel
		// als een fullwidth wordt getekend
		$nxs_global_row_render_statebag["upgradetowidescreen"] = "yes";	
	}
	
	nxs_ob_start();
	
	// Default name class
	$nxs_global_placeholder_render_statebag["widgetclass"] = "nxs-slider ";
	
	// Default media query display
	$nxs_global_placeholder_render_statebag["widgetclass"] .= " " . $responsive_display;
	
	if (false) 
	{ // $existingsidebarid != "") {
		if (nxs_has_adminpermissions()) 
		{
			nxs_renderplaceholderwarning(nxs_l18n__("Slider can only be used when the sidebar is suppressed[nxs:warning]", "nxs_td"));
		}
	} 
	else if (true) 
	{ 
		// $nxs_global_row_render_statebag["pagerowtemplate"] == "one") {
		
		// we markeren dat deze regel geen filler moet krijgen (wordt verwerkt door shortcode)
		
		//$nxs_global_row_render_statebag["suppressfilleratrow0"] = true;
		// do not crop the widget, the slider contains left/right buttons that exceed the regular widget boundaries
		
		// grab all commercial messages
		global $nxs_g_modelmanager;
		$contentmodel = $nxs_g_modelmanager->getcontentmodel();
		$datasource = "nxs_commercialmsg";
		
		$slidesdataset = array();
		foreach ($contentmodel[$datasource]["instances"] as $instance)
		{
			$enabled = $instance["enabled"];
			if ($enabled == "") { continue; }
			$index++;
			$media = $instance["content"]["media"];
			$post_id = $instance["content"]["post_id"];
			$post_title = $instance["content"]["title"];			// "post_title"
			$post_excerpt = $instance["content"]["excerpt"];		
			//$image_imageid = $instance["content"]["post_thumbnail_id"];
			
			$width = 300;
			$height = 100;
			
			// media_meta = "w:300;h:100";
			$metapieces = explode(";", $media_meta);
			foreach ($metapieces as $metapiece)
			{
				// metapiece = "w:300";
				$subpieces = explode(":", $metapiece);
				if ($subpieces[0] == "w")
				{
					$width = $subpieces[1];
				}
				else if ($subpieces[0] == "h")
				{
					$height = $subpieces[1];
				}
			}
			
			$imageurl = "https://d3mwusvabcs8z9.cloudfront.net/?nxs_imagecropper=true&requestedwidth={$width}&requestedheight={$height}&debug=tru&url={$media}&scope=lazydetect";
			
			//$lookup = nxs_wp_get_attachment_image_src($image_imageid, 'full', true);
			//$imageurl = $lookup[0];
			//$imageurl = nxs_img_getimageurlthemeversion($imageurl);
			//$width = $lookup[1];
			//$height = $lookup[2];		
			
			if ($height > $heighttallestslide) 
			{
				$heighttallestslide = $height;
			}
				
			$title = $post_title;
			$alt = ""; //$placeholdermetadata['alt'];
			$text = $post_excerpt;
			
			$destination_articleid = "";
			$destinationurl = "";

			$slide_button = "";
				
			$slidesdataset[] = array
			(
				"title" => $title,
				"alt" => $alt,
				"text" => $text,
				"imageurl" => $imageurl,
				"destinationurl" => $destinationurl,
				"target" => $target,
				"width" => $width,
				"height" => $height,
				"slide_button" => $slide_button,
			);
		}
				
		if (count($slidesdataset) > 0) {
			?>
			
			<script type='text/javascript'>
			
				jQuery(document).ready (
					function() {
						nxs_js_requirescript('cycleslider_js', 'js', '<?php echo nxs_getframeworkurl();?>/plugins/nxs-businesssite/widgets/commercialmsgs/js/jquery.cycle.all.min.js', nxs_js_cycleslider_js_loaded_<?php echo $placeholderid; ?>);
					}
				);
				
				<?php
				
				if ($fullwidth_height == "screenheight")
				{
					// if the height is set to the screenheight, dynamically determine the height
					// reset the height of the slider initially when the page is loaded,
					// and reset if after the screen size is adjusted
					?>
					
					function nxs_js_resetcommercialmsgsheight_getheight()
					{
						var windowheight = jQuery(window).height();
						var headerheight = jQuery("#nxs-header").height();
						var updatedheight = windowheight - headerheight;
						nxs_js_log(updatedheight);
						return updatedheight;
					}
					
					function nxs_js_resetcommercialmsgsheight_to_screenheight()
					{
						var updatedheight = nxs_js_resetcommercialmsgsheight_getheight() + "px";
						jQuery(".nxs-slideset").css("height", updatedheight);
						jQuery(".nxs-slide").css("height", updatedheight);
						jQuery(".nxs-slide-img").css("height", updatedheight);
						jQuery(".slide-wrapper").css("height", updatedheight);
					}
					
					jQuery(window).ready
					(
						function()
						{
							nxs_js_resetcommercialmsgsheight_to_screenheight();
						}
					);
					
					jQuery(document).bind
					(
						'nxs_event_resizeend', 
						function() 
						{
							nxs_js_resetcommercialmsgsheight_to_screenheight();
						}
					);
					<?php
				}
				
				?>
				
				var cycleloaded_<?php echo $placeholderid; ?> = false;
				
				function nxs_js_cycleslider_js_loaded_<?php echo $placeholderid; ?>() {
					
					if (cycleloaded_<?php echo $placeholderid; ?> == true) {
						return;
					}
					
					cycleloaded_<?php echo $placeholderid; ?> = true;
					
					//nxs_js_log('slider js loaded');
					//nxs_js_log('initializing slider');
					var theSlider = jQuery('#slideset_<?php echo $placeholderid; ?>');
					var options = {
						timeout: <?php echo $item_durationvisibility; ?>,
						speed: <?php echo $item_transitionduration; ?>,	
						cleartypeNoBg: true,
						prev:   '#prev_<?php echo $placeholderid; ?>', 
						next:   '#next_<?php echo $placeholderid; ?>',
						pager:  '#controllers_<?php echo $placeholderid; ?>',
						pauseOnPagerHover: true,
						//before: nxs_js_slidebox_slideupdated_<?php echo $placeholderid; ?>,
						after: nxs_js_slidebox_slideupdated_<?php echo $placeholderid; ?>
					}
					jQuery(theSlider).cycle(options);
					
					var shouldPauseOnHover = <?php echo $pause_transition; ?>;
					if (shouldPauseOnHover) {
						// pause the slider if user is nxs-hovering
						// for normal web users
						jQuery('#nxs-widget-<?php echo $placeholderid; ?>').hover (
							function()  {
								//nxs_js_log("hover; pausing slider...");
								jQuery(theSlider).cycle('pause');
							},  
							function()  {
								//nxs_js_log("mouse out, resuming slider...");
							 	jQuery(theSlider).cycle('resume');
							}  
		    			);
		    		} else {
	    			// 
	    			}
		    						
					jQuery(window).bind("nxs_recalculateruntimedimensions", function(e) {
							//
							nxs_js_log("gjslide");
						var slideset = jQuery("#slideset_<?php echo $placeholderid; ?>");
						var currentslideindex = jQuery(slideset).data("nxs_activeslideindex");
						
						if (currentslideindex != null) {
							nxs_js_slidebox_updateslidenr_<?php echo $placeholderid; ?>_stage2(currentslideindex);
						}						
					});
					//nxs_js_log("FINISHED EXECUTING SCRIPT");
				}
				
			</script>
			
            <?php

            /* OUTPUT
			---------------------------------------------------------------------------------------------------- */

			// Slide wrapper
			echo '<div class="slide-wrapper nxs-autofit-to-parent" style="'.$slide_border_width.' '.$slider_width.' '.$margin_left.'"></div>';
			
			// Slideset
			echo '
			<div id="slideset_'.$placeholderid.'" class="nxs-slideset '.$shadow.'" style="'.$slider_width.' '.$slideset_inlinestyle.'">';
				
			$slideindex = 0;
			
			foreach ($slidesdataset as $slidedataset) {
				// Resetting variables for next slide
				$title = ''; 
				$alt = '';
				$text = '';
				$description = '';
				$slide_button = '';
				$filler_button = '';
				

				$slideindex++;

				// ALT
				if ($slidedataset["alt"] != "") { 
					$alt = $slidedataset["alt"];
				}
				
				// Image
				$slide_image2 = '<img alt="' . $alt . '" class="nxs-stretch nxs-slide-img" style="opacity: 0; '.$slide_img_inlinestyle.'" src="'.$slidedataset["imageurl"].'" />';
				$slide_image = '
					<div class="nxs-stretch nxs-slide-img" style="'.$slide_img_inlinestyle.' background: url('.$slidedataset["imageurl"].') no-repeat center">
						'.$slide_image2.'
					</div>';
				
				// Title
				if ($slidedataset["title"] != "") { 
					$title = '<h2 class="nxs-slide-title nxs-title '.$title_fontsize_cssclass.' '.$title_fontzen_cssclass.'">'.nxs_render_html_escape_gtlt($slidedataset["title"]).'</h2>'; 
				}
				
				// Text
				if ($slidedataset["text"] != "") { 
					$text = '
						<div class="nxs-default-p">
							<p class="nxs-padding-bottom0 '.$text_fontzen_cssclass.'">'.nxs_render_html_escape_gtlt($slidedataset["text"]).'</p>
						</div>'; 
				}
				
				// Filler
				if ($title != "" && $text != "" && $metadata_layout != "center") { $filler = '<div class="nxs-clear padding"></div>'; }

				// Button
				if ($slidedataset["slide_button"] != "") {
					if($slidedataset['title'] != "" || $slidedataset['text'] != "") {
				 		$filler_button = '<div class="nxs-clear padding"></div>';
					}
					$slide_button = $slidedataset["slide_button"];
				}
				
					
				

				// Description
				if (
					$slidedataset["title"] != "" && $metadata != "" || 
					$slidedataset["text"] != ""  && $metadata != "" || $slidedataset["slide_button"] != ""  && $metadata != "") { 
					$description = '
					<div class="nxs-slide-description '.$metadata_layout.'">
						
						<div id="slide_description_content_'.$placeholderid.'_'.$slideindex.'" class="nxs-slide-description-content '.$bgcolor_cssclass.'" style="right: '.$border_width.'px; '.$metadata_alignment.' top: '.$border_width.'px; ">
							<div class="text-container" style="height: '.$fullwidth_height.';">
								<div class="wrapper '.$metadata_color_cssclass.' '.$metadata_padding_cssclass.'" style="'.$metadata_margin_top.' '.$metadata_margin_left.'">' .
									$title .
									$filler	.								
									$text.
									$filler_button.
									$slide_button.'
								</div>
							</div>
							
						</div>
					
					</div>'; 
				}
				
				// Rendering of individual slide
				echo'
				<div id="nxs-slide-'.$placeholderid.'-'.$slideindex.'" class="nxs-slide" style ="'.$slide.'">';
				
					if ($slidedataset["destinationurl"] != "") 
					{ 
						if ($slidedataset["target"] == "")
						{
							$targethtml = "";
						}
						else
						{
							$target = $slidedataset["target"];
							$targethtml = "target='$target'";
						}
						
						$destinationurl = $slidedataset["destinationurl"];
						echo "<a href='$destinationurl' $targethtml >"; 
					}
					
					echo $slide_image;
					
					if ($slidedataset["destinationurl"] != "" && $slidedataset["slide_button"] != "") 
					{ 
						echo '</a>';
						echo $description; 
					}

					else 
					{

						echo $description;
						echo '</a>'; 
					}						
			
				echo '</div> <!-- end .slide -->';
		    


			} // END foreach
		
			echo '</div> <!-- END #slideset -->';
	
			// Controllers
			echo $main_controllers;
			echo $side_controllers;
				
			?>
			
            
			<script type='text/javascript'>
				
				var heightValue;
				
				function nxs_js_slidebox_slideupdated_<?php echo $placeholderid; ?>(curr, next, opts)
				{
					//nxs_js_log('slide updated');
					//nxs_js_log('--------------');
					
					// only perform next step if image of slide is intitialized / loaded
					// set height of slideset to the height of the current active slide
					var id = jQuery(this).attr('id');	// for example nxs-slide-l3280499763-3 
					var currentslideindex = jQuery(next).attr("id").split("-")[3];
					
					var slideset = jQuery("#slideset_<?php echo $placeholderid; ?>");						
					var visibleslideid = "nxs-slide-" + "<?php echo $placeholderid; ?>" + "-" + currentslideindex;
					
					var currentSlide = jQuery("#" + visibleslideid).find(".nxs-slide-img");
					//nxs_js_log("currentSlide:");
					//nxs_js_log(currentSlide);

					var slideset = jQuery("#slideset_<?php echo $placeholderid; ?>");						
					jQuery(slideset).data("nxs_activeslideindex", currentslideindex);

					nxs_js_slidebox_updateslidenr_<?php echo $placeholderid; ?>_stage2(currentslideindex);
					
					// trigger update of editable boxes (cursor's), if it wasn't trigger before (preventing endless loop)
					var trigger = "nxs-widget-commercialmsgs-<?php echo $placeholderid; ?>-slideupdated";
					
					if (!nxs_js_isrefreshtriggeredbyatleastoneof(trigger))
					{
						var triggers = ['nxs-widget-commercialmsgs-slideupdated', trigger];
						//nxs_js_log('triggers:');
						//nxs_js_log(triggers);
						nxs_gui_set_runtime_dimensions_enqueuerequest(triggers);
					}
					else
					{
						//nxs_js_log('preventing loop');
					}
				}
					
				function nxs_js_slidebox_updateslidenr_<?php echo $placeholderid; ?>_stage2(slideindextoupdate)
				{
					var slideset = jQuery("#slideset_<?php echo $placeholderid; ?>");
					// if slideset is not visible, return
					if (jQuery(slideset).css("display") == "none")
					{
						nxs_js_log("not visible");
						return;
					}
					
					var visibleslideindex = jQuery(slideset).data("nxs_activeslideindex");
					
					if (slideindextoupdate != visibleslideindex)
					{
						//nxs_js_log('recursion stopped; slide traversed to another slide');
						// stop recursion; the slide to update is no longer displayed...
						// update will occur on next cycle, no recursion is needed anymore
						return;
					}

					var visibleslideid = "nxs-slide-" + "<?php echo $placeholderid; ?>" + "-" + visibleslideindex;
					var heighttorender = 0;
					var heightofvisibleslide = jQuery("#" + visibleslideid).find(".nxs-slide-img").outerHeight(true);
					if (heightofvisibleslide > 0)
					{
						heighttorender = heightofvisibleslide;
						//nxs_js_log("hoogte is " + heightofvisibleslide);
					}
					else
					{
						heighttorender = 100;	// dummy height
						//nxs_js_log("hoogte unknown");
					}
					
					<?php
					// if height was statically set, use this static value instead
					if ($fullwidth_height == "screenheight")
					{
						?>
						heighttorender = nxs_js_resetcommercialmsgsheight_getheight();
						<?php
					}
					else if ($fullwidth_height != "")
					{
						?>
						heighttorender = "<?php echo $fullwidth_height; ?>";
						<?php
					}
					else
					{
						//
					}
					?>
					
					// update heights...
										
					// step 1; set height of slideset
					jQuery(slideset).height(heighttorender);
					//nxs_js_log("slideset height to render:" + heighttorender);

					// step 2a; set height of background 'sheet'
					var backgroundsheet = jQuery('#slide_description_background_<?php echo $placeholderid . "_"; ?>' + visibleslideindex);
					jQuery(backgroundsheet).css("height", heighttorender);
					//nxs_js_log("background height: " + heighttorender);
					
					// step 2b; set height of nxs-slide-l1262155070-1 div
					var identifier = '#slide-slide-<?php echo $placeholderid . "-"; ?>' + visibleslideindex;
					//nxs_js_log("identifier:" + identifier);
					var slidecontainer = jQuery('#slide-slide-<?php echo $placeholderid . "-"; ?>' + visibleslideindex);
					jQuery(slidecontainer).css("height", heighttorender);
					//nxs_js_log("slidecontainer height: " + heighttorender);
					
					//nxs_js_log("value:" + heighttorender);
					//nxs_js_log(slidecontainer);
					
					// step 3; set height of left and right buttons
					var topValue = Math.floor(heighttorender / 2) - 18;
					jQuery('#prev_<?php echo $placeholderid; ?>').css("top", topValue);
					jQuery('#next_<?php echo $placeholderid; ?>').css("top", topValue);
					
					if (heightofvisibleslide == 0)
				  {
						//nxs_js_log('image of slide is not yet fully loaded, apparently... todo: recursing ...');
						setTimeout(function() { nxs_js_slidebox_updateslidenr_<?php echo $placeholderid; ?>_stage2(slideindextoupdate); }, 100);
					}
				}
				
				// load slider if script is already loaded (this happens if the widget
				// is dragged on the front end
				if (nxs_js_isscriptlazyloaded("cycleslider_js"))
				{
					nxs_js_log('reinitializing slider (after front end drag drop)');
					nxs_js_cycleslider_js_loaded_<?php echo $placeholderid; ?>();
				}
				else
				{
					// wait for the document ready
				}
				
			</script>
			<?php 
		} else {
			if (nxs_has_adminpermissions()) {
				nxs_renderplaceholderwarning(nxs_l18n__("No slides have been added.[nxs:tooltip]", "nxs_td"));
			}
		}
	} else { 
		nxs_renderplaceholderwarning(nxs_l18n__("Slider can only be used in a row with a single cell[nxs:warning]", "nxs_td"));
	}
	
	$html = nxs_ob_get_contents();
	nxs_ob_end_clean();

	$result["html"] = $html;	
	$result["replacedomid"] = 'nxs-widget-'.$placeholderid;

	// outbound statebag
	global $nxs_global_row_render_statebag;
	if ($nxs_global_row_render_statebag["pagerowtemplate"] == "one")
	{
		// forceer dat bij het renderen (in de shortcode) de regel
		// als een fullwidth wordt getekend
		// $nxs_global_row_render_statebag["upgradetofullwidth"] = "ja";
	}	
	else
	{
		// het item is op een verkeerde plaats neergezet,
		// we promoten hierbij express niet naar een fullwidth
	}

	return $result;
}

/* INITIATING WIDGET DATA
----------------------------------------------------------------------------------------------------*/
function nxs_widgets_commercialmsgs_initplaceholderdata($args)
{
	// delegate to generic implementation
	$widgetname = basename(dirname(__FILE__));
	
	
	// current values as defined by unistyle prefail over the above "default" props
	$unistylegroup = nxs_widgets_commercialmsgs_getunifiedstylinggroup();
	$args = nxs_unistyle_blendinitialunistyleproperties($args, $unistylegroup);
	
	$args["item_durationvisibility"] = "5000";
	$args["item_transitionduration"] = "300";
	$args['ph_margin_bottom'] = "0-0";
	$args['bgcolor_cssclass'] = "base2";
	
	$result = nxs_widgets_initplaceholderdatageneric($args, $widgetname);
	return $result;
}
