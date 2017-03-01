<?php
/*
Plugin Name: Nxs Business Site
Version: 1.0.12
Plugin URI: https://github.com/TODO
Description: TODO
Author: GJ
Author URI: https://github.com/TODO/
*/

class businesssite_instance
{
	function containssyncedcontent($post)
	{
		$result = false;
		$previoussyncedcontenthash = get_post_meta($post->ID, 'nxs_synced_contenthash', $single = true);
		if ($previoussyncedcontenthash != "")
		{
			$result = true;
		}
		return $result;
	}
	
	function iscontentmodifiedsincelastsync($post)
	{
		$result = true;
		$contenthash = $this->getcontenthash($post);
		$previoussyncedcontenthash = get_post_meta($post->ID, 'nxs_synced_contenthash', $single = true);
		if ($contenthash == $previoussyncedcontenthash)
		{
			$result = false;
		}
		return $result;
	}
	
	function getcontenthash($post)
	{
		// title, slug, content, excerpt, image
		$hash = "";
		$hash .= md5($post->post_title);
		$hash .= md5($post->post_name);
		$hash .= md5($post->post_excerpt);
		$hash .= md5($post->post_content);
		$result = md5($hash);
		return $result;
	}
	
	function f_shouldrenderaddnewrowoption($result)
	{
		global $post;
		if (!$this->iscontentmodifiedsincelastsync($post))
		{
			$result = false;
		}
		return $result;
	}
	
	function sc_nxscomment($atts, $content=null)
	{
		if ($atts["condition"] == "authenticatedonly")
		{
			if (!is_user_logged_in())
			{
				// suppress it
				$content = "";
			}
		}
		else if ($atts["condition"] == "backendonly")
		{
			// suppress it
			$content = "";
		}
		
		return $content;
	}
	
	// container order sets functionality
	function getcontainerid($taxonomy)
	{
		$containerid = $this->getcontainerid_internal($taxonomy);
		if ($containerid === false) 
		{
			error_log("getcontainerid; creating container for $taxonomy");	

			//echo "containerid not yet found, creating...";
			$result = $this->createnewcontainer_internal($taxonomy);
			if ($result["result"] != "OK") { echo "unexpected;"; var_dump($result); die(); }
			$containerid = $result["postid"];
		}
		
		return $containerid;
	}
	
	function getcontainerid_internal($taxonomy)
	{
		// published pagedecorators
		$publishedargs = array();
		$publishedargs["post_status"] = "publish";
		$publishedargs["post_type"] = "nxs_genericlist";
		
		$publishedargs['tax_query'] = array
		(
			array
			(
				'taxonomy' => 'nxs_tax_subposttype',
				'field' => 'slug',
				'terms' => "{$taxonomy}_set",
			)
		);
		
		$publishedargs["orderby"] = "post_date";//$order_by;
		$publishedargs["order"] = "DESC"; //$order;
		$publishedargs["showposts"] = -1;	// allemaal!
	  $posts = get_posts($publishedargs);
	  $result = false;
	  if (count($posts) >= 1) 
	  {
	  	$result = $posts[0]->ID;
	  }
	  
	  return $result;
	}
	
	function createnewcontainer_internal($taxonomy)
	{
		$subargs = array();
		$subargs["nxsposttype"] = "genericlist";
		$subargs["nxssubposttype"] = "{$taxonomy}_set";	// NOTE!
		$subargs["poststatus"] = "publish";
		$subargs["titel"] = nxs_l18n__("Set Order", "nxs_td") . " {$taxonomy} " . nxs_generaterandomstring(6);
		$subargs["slug"] = $subargs["titel"];
		$subargs["postwizard"] = "defaultgenericlist";
		
		$response = nxs_addnewarticle($subargs);
		if ($response["result"] != "OK")
		{
			echo "failed to create container?!";
			die();
		}
		else
		{
			//
		}
		
		return $response;
	}

	function getcontentmodeltaxonomyinstances($arg)
	{
		$taxonomy = $arg["taxonomy"];
		$contentmodel = $this->getcontentmodel();
		$result = $contentmodel[$taxonomy]["instances"];
		return $result;
	}
	
	// virtual posts
	function businesssite_the_posts($result, $args)
	{
		global $wp,$wp_query;
		
		if (!is_main_query()) { return $result; }
		if (is_admin()) { return $result; }
		
		$countmatches = count($result);
		$is404 = ($countmatches == 0);
		
		if (!$is404) { return $result; }
		
		// it would become a 404, unless we intercept the request
		// and inject some virtual values :)
		
		$uri = nxs_geturicurrentpage();
		$uripieces = explode("?", $uri);
		$requestedslug = $uripieces[0];
		$requestedslug = trim($requestedslug, "/");
		
		// loop over the contentmodel,
		// and verify if the requestedslug matches any of the components
		// of the contentmodel
		$contentmodel = $this->getcontentmodel();
		$taxonomiesmeta = nxs_business_gettaxonomiesmeta("nexusthemescompany");
		
		$foundmatch = false;
		foreach ($taxonomiesmeta as $taxonomy => $taxonomymeta)
		{
			$instances = $contentmodel[$taxonomy]["instances"];
			foreach ($instances as $instance)
			{
				$post_slug = $instance["content"]["post_slug"];
				if ($post_slug == $requestedslug)
				{
					// there's a match! inject the content of the model to the post

					$foundmatch = true;
		
					//$wp_query->is_nxs_portfolio = true;
					$wp_query->is_singular = true;
					$wp_query->is_page = true;
					$wp_query->is_404 = false;
					$wp_query->is_attachment = false;
					$wp_query->is_archive = false;
					unset($wp_query->query_vars["error"]);
					if ($wp_query->queried_object != NULL)
					{
						$wp_query->queried_object->term_id = -1;
						$wp_query->queried_object->name = $taxonomy;	//$id;
					}
					
					$newpost = new stdClass;
					
					// replicate all fields from the model
					foreach ($instance["content"] as $key => $val)
					{
						$newpost->$key = $val;
					}
					
					// 
					
					$newpost->ID = -999001;	// "hi"; // 0-$instance["content"]["post_id"]; // -1;	//"virtual" . $id;
					$newpost->post_author = 1;
					$newpost->post_name = $instance["content"]["post_slug"];
					$newpost->guid = "test guid";
					$newpost->post_title = $instance["content"]["title"];
					$newpost->post_excerpt = $instance["content"]["excerpt"];
					$newpost->to_ping = "";
					$newpost->pinged = "";
					$newpost->post_content = $instance["content"]["content"];
					$newpost->post_status = "publish";
					$newpost->comment_status = "closed";
					$newpost->ping_status = "closed";
					$newpost->post_password = "";
					$newpost->comment_count = 0;
					$newpost->post_date = current_time('mysql');	
					$newpost->filter = "raw";
					$newpost->post_date_gmt = current_time('mysql',1);
					$newpost->post_modified = current_time('mysql',1);
					$newpost->post_modified_gmt = current_time('mysql',1);
					$newpost->post_parent = 0;
					$newpost->post_type = $taxonomy;
					$newpost->nxs_content_license = json_encode(array("type" => "attribution", "author" => "benin"));
					
					$wp_query->posts[0] = $newpost;
					$wp_query->found_posts = 1;	 
					$wp_query->max_num_pages = 1;
						
					$result[]= $newpost;
					
					// there can/may be only one match
					return $result;
				}
				else
				{
					//echo "mismatch: ($post_slug) vs ($requestedslug)<br />";
					//var_dump($instance);
				}
				// echo "<br />";
			}
		}
		
		return $result;
	}
	
	function getcontentmodel()
	{
		global $nxs_g_contentmodel;
		if (!isset($nxs_g_contentmodel))
		{
			$nxs_g_contentmodel = $this->getcontentmodel_actual();
		}
		return $nxs_g_contentmodel;
	}
	
	function ismaster()
	{
		$result = true;
		$homeurl = nxs_geturl_home();
		if ($homeurl == "http://theme1.testgj.c1.us-e1.nexusthemes.com/")
		{
			$result = false;	
		}
		else if ($homeurl == "http://theme2.testgj.c1.us-e1.nexusthemes.com/")
		{
			$result = false;	
		}
		else if ($homeurl == "http://theme3.testgj.c1.us-e1.nexusthemes.com/")
		{
			$result = false;	
		}
		else if ($homeurl == "http://blablabusiness.testgj.c1.us-e1.nexusthemes.com/")
		{
			$result = false;	
		}
		return $result;
	}
	
	function getcontentmodel_actual()
	{
		$ismaster = $this->ismaster();
		if ($ismaster)
		{
			 $result = "";// $this->getcontentmodel_actual_local();
		}
		else
		{
			$result = $this->getcontentmodel_actual_slave();
		}
		return $result;
	}
	
	function getcontentmodel_actual_slave()
	{
		// 
		$homeurl = nxs_geturl_home();
		
		$businesstype = $_REQUEST["businesstype"];
		$businessid = $_REQUEST["businessid"];
		if ($businessid == "")
		{
			if ($_COOKIE["businessid"] != "")
			{
				$businessid = $_COOKIE["businessid"];
			}
		}
		
		if ($businessid == "x")
		{
			$businessid = "";
		}
		
		if ($businessid != "")
		{
			$url = "https://turnkeypagesprovider.websitesexamples.com/api/1/prod/businessmodel/{$businessid}/?nxs=contentprovider-api&licensekey={$licensekey}&nxs_json_output_format=prettyprint";
			// also store the businessid in the cookie
			setcookie("businessid", $businessid);
		}
		else
		{
			// fallback		
			$url = "http://master.testgj.c1.us-e1.nexusthemes.com/api/1/prod/businessmodel/?nxs=site-api&nxs_json_output_format=prettyprint&homeurl={$homeurl}";
		}
		$content = file_get_contents($url);
		$json = json_decode($content, true);
		$result = $json["contentmodel"];
		
		$all_slugs = array();
		
		// enrich the model
		// the slug is determined "at runtime"; its derived from the title
		$taxonomiesmeta = nxs_business_gettaxonomiesmeta("nexusthemescompany");
		foreach ($taxonomiesmeta as $taxonomy => $taxonomymeta)
		{
			//echo "tax: $taxonomy <br />";
			
			$titlefield = "";
			$slugfield = "post_slug";
			
			$instanceextendedproperties = $taxonomymeta["instanceextendedproperties"];
			foreach ($instanceextendedproperties as $field => $fieldmeta)
			{
				if ($fieldmeta["persisttype"] == "wp_title")
				{
					$titlefield = $field;
				}
				if ($fieldmeta["persisttype"] == "wp_slug")
				{
					$slugfield = $field;
				}
			}
			
			//echo "titlefield: $titlefield <br />";
			//echo "slugfield: $slugfield <br />";
			
			//
			
			$instances = $result[$taxonomy]["instances"];
			foreach ($instances as $index => $instance)
			{
				$content = $instance["content"];
				$title = $content[$titlefield];
				$slug = $title;
				$slug = strtolower($slug);
				$slug = preg_replace('/[^A-Za-z0-9.]/', '-', $slug); // Replaces any non alpha numeric with -
				for ($cnt = 0; $cnt < 3; $cnt++)
				{
					$slug = str_replace("--", "-", $slug);
				}
				
				if (in_array($slug, $all_slugs))
				{
					// this slug is already in use; make it unique
					$count = count($all_slugs);
					$slug .= "_{$count}";
				}
				
				$all_slugs[]= $slug;
				
				$result[$taxonomy]["instances"][$index]["content"][$slugfield] = $slug;
				$result[$taxonomy]["instances"][$index]["content"]["post_slug"] = $slug;
			}
		}
		
		// allow plugins to override/extend the behaviour
		$result = apply_filters("nxs_f_getcontentmodel_actual_slave", $result, $args);
		//error_log("returned from nxs_f_getcontentmodel_actual_slave");
		
		// add the realm to the model
		// todo: in the future, the realm should already be set by the slave
		$realm = "nexusthemescompany";
		$result["meta"]["realm"] = $realm;
		
		return $result;
	}
	
	function getwidgets($result, $widgetargs)
	{
		$nxsposttype = $widgetargs["nxsposttype"];
		$pagetemplate = $widgetargs["pagetemplate"];
		
		if ($nxsposttype == "post") 
		{
			$result[] = array("widgetid" => "entities");
			$result[] = array("widgetid" => "phone");
			$result[] = array("widgetid" => "socialaccounts");
			$result[] = array("widgetid" => "commercialmsgs");
		}
		else if ($nxsposttype == "sidebar") 
		{
			$result[] = array("widgetid" => "entities");
			$result[] = array("widgetid" => "phone");
			$result[] = array("widgetid" => "socialaccounts");
		}
		else if ($nxsposttype == "header") 
		{
			$result[] = array("widgetid" => "phone");
			$result[] = array("widgetid" => "buslogo");
			$result[] = array("widgetid" => "socialaccounts");
			$result[] = array("widgetid" => "commercialmsgs");
		}
		
		if ($pagetemplate == "pagedecorator") 
		{
			$result[] = array("widgetid" => "taxpageslider", "tags" => array("nexus"));		
		}
		
		return $result;
	}
	
	function a_edit_form_after_title() 
	{
		global $post;
		if ($this->containssyncedcontent($post))
		{
			if ($this->iscontentmodifiedsincelastsync($post))
			{
		    ?>
		    <div>
		      <p>This post is no longer synchronized with the content server as you made at least one modification in the title, excerpt, slug or content</p>
		    </div>
		    <?php
		  }
		  else
		  {
		  	?>
		  	<style>
		  		.businesssite-admin 
		  		{
					  position: relative;
					  margin-top:20px;
					}
		  		.businesssite-enabled .businesssite-admin-tabs 
		  		{
				    border: none;
				    margin: 10px 0 0;
					}
					.businesssite-admin-tabs a 
					{
				    border-color: #dfdfdf #dfdfdf #f0f0f0;
				    border-style: solid;
				    border-width: 1px 1px 0;
				    color: #aaa;
				    font-size: 12px;
				    font-weight: bold;
				    line-height: 16px;
				    display: inline-block;
				    padding: 8px 14px;
				    text-decoration: none;
				    margin: 0 4px -1px 0;
				    border-top-left-radius: 3px;
				    border-top-right-radius: 3px;
				    -moz-border-top-left-radius: 3px;
				    -moz-border-top-right-radius: 3px;
				    -webkit-border-top-left-radius: 3px;
				    -webkit-border-top-right-radius: 3px;
					}
					.businesssite-enabled .businesssite-admin-ui 
					{
					  display: block;
					}
					.businesssite-admin-ui h3 
					{
				    font-family: Helvetica, sans-serif !important;
				    font-size: 18px !important;
				    font-weight: 300 !important;
				    margin: 0 0 30px 0 !important;
				    padding: 0 !important;
					}
					.businesssite-enabled .businesssite-admin-ui 
					{
					   display: block;
					}
					.businesssite-admin-ui 
					{
				    border: 1px solid #ccc;
				    border-top-right-radius: 3px;
				    border-bottom-right-radius: 3px;
				    border-bottom-left-radius: 3px;
				    -moz-border-top-right-radius: 3px;
				    -moz-border-bottom-right-radius: 3px;
				    -moz-border-bottom-left-radius: 3px;
				    -webkit-border-top-right-radius: 3px;
				    -webkit-border-bottom-right-radius: 3px;
				    -webkit-border-bottom-left-radius: 3px;
				    margin-bottom: 20px;
				    padding: 45px 0 50px;
				    text-align: center;
					}
					.businesssite-admin-tabs a.active 
					{
				    border-width: 1px;
				    color: #464646;
					}
		  	</style>
		  	
				<div class="businesssite-admin">
					<div class="businesssite-admin-tabs">
						<a href="javascript:void(0);" onclick="return false;" class="active">Copyrighted Article</a>
						<!-- <a href="javascript:void(0);" onclick="return false;" class="active">Page Builder</a> -->
					</div>
					<div class="businesssite-admin-ui">
						<h3>Copyrighted article.</h3>
						<p>
		      		Note; this is a <b>copyrighted</b> guest article provided by XYZ. You can use the article on your site for free as long as you keep the attribution and content in place.<br />
		      		To hide the attribution, or to customize the content you will need to buy a non-exclusive license from the author.<br />
						</p>
						<a href="#" class="button button-primary button-large">Remove Article Attribution</a>
						<a href="#" class="button button-primary button-large">Contact Author</a>
						<a href="#postdivrich" onclick="jQuery(this).hide();jQuery('#postdivrich').show(); $(window).scrollTop($(window).scrollTop()+1); return false;" class="button button-primary button-large">Regular WP Editor</a>
					</div>
					<div class="businesssite-loading"></div>
				</div>
		  	
				<!-- -->		  	
		  	
		    <style>
		    	#postdivrich { display: none; }
		    </style>
		    <?php
		  }
	  }
	}
	
	function instance_admin_head()
	{
		if (is_admin())
		{
			add_action( 'edit_form_after_title', array($this, "a_edit_form_after_title"), 30, 1);
		}
	}
	
	function instance_init()
	{
		// widgets
		nxs_lazyload_plugin_widget(__FILE__, "entities");
		nxs_lazyload_plugin_widget(__FILE__, "phone");
		nxs_lazyload_plugin_widget(__FILE__, "buslogo");
		nxs_lazyload_plugin_widget(__FILE__, "socialaccounts");
		nxs_lazyload_plugin_widget(__FILE__, "commercialmsgs");

		// page decorators
		nxs_lazyload_plugin_widget(__FILE__, "taxpageslider");
	}
	
	function wp_nav_menu_items($result, $args ) 
	{
    if ($_REQUEST["nxs"] == "debugmenu")
    {
    	var_dump($result);
    	var_dump($args);
    	die();
    }

    return $result;
	}
	
	function walker_nav_menu_start_el($result, $item, $depth, $args ) 
	{
  	if ($_REQUEST["nxs"] == "debugmenu")
    {
    	//var_dump($result);
    	//var_dump($args);
    	//die();
    }
    
    // $result = "[" . $result . "]";
    
  	return $result;
	}
	
	// kudos to https://teleogistic.net/2013/02/11/dynamically-add-items-to-a-wp_nav_menu-list/
	function wp_nav_menu_objects($result, $menu, $args)
	{
		if (true) //$_REQUEST["nxs"] == "debugmenu2")
    {
    	$newresult = array();
    	
    	$contentmodel = $this->getcontentmodel();
			$taxonomiesmeta = nxs_business_gettaxonomiesmeta("nexusthemescompany");
    	
    	// process taxonomy menu items (adds custom child items,
    	// and etches items that are empty)
    	
    	foreach ($result as $post)
    	{
    		//echo "found menu item;" . $post->object . " <br />";
    		
    		$title = $post->title;
    		$shouldbeprocessed = false;
    		if (nxs_stringcontains($title, "nxs_"))
    		{
    			$shouldbeprocessed = true;
    		}
    		
    		if ($shouldbeprocessed)
    		{
    			$found = false;
    			$posttype = $post->title;
    			
    			foreach ($taxonomiesmeta as $taxonomy => $taxonomymeta)
					{
						$shouldrender = false;
						if ($posttype == $taxonomy)
						{
							$shouldrender = true;
						}
						else if ($contentmodel[$taxonomy]["taxonomy"]["postid"] == $singleton_instanceid)
						{
							$shouldrender = true;
						}
						
						
						
						if ($shouldrender)
						{
							// this is the taxonomy we were looking for
							$found = true;
							
							if ($taxonomymeta["caninstancesbereferenced"] == true)
							{
								$instances = $contentmodel[$taxonomy]["instances"];
								if (count($instances) > 0)
								{
									// update this item (the "parent")
									$title = $contentmodel[$taxonomy]["taxonomy"]["title"];
									if ($title == "")
									{
										$title = "(empty)";
									}
									$post->title = $title;
									
									
									// make it not clickable
									$post->url = "#";
									$post->classes[] = "nxs-menuitemempty";
									$newresult[] = $post;
									
									// add instances as child elements to the list
									$childindex = -1;
									foreach ($instances as $instance)
									{
										$childindex++;
	
										$childpost = array
										(
							        'title'            => $instance["content"]["title"],
							        'menu_item_parent' => $post->ID,
							        'ID'               => '',
							        'db_id'            => '',
							        'url'              => '/' . $instance["content"]["slug"] . '/',
							      );
							      $newresult[] = (object) $childpost;
									}
								}
								else
								{
									// if there's "no" instances we remove/etch the item from the 
									// menu by simply not adding it to the newresult list
								}
							}
							else
							{
								// the instances cannot be referenced, thus we skip them
								// (item is 
							}
						}
						else
						{
							// some other taxonomy; ignore
						}
					}
					
					if (!$found)
					{
						// absorb
					}
				}
				else
				{
					// clone as-is
					//$post->title = $post->object . ";" . $singleton_instanceid;
					$newresult[] = $post;		
				}
			}
			
			// swap
			$result = $newresult;
    }
    
    //echo "sofar";
    //die();
    
		return $result;
	}
	
	function the_content($content) 
	{
  	global $post;
  	$posttype = $post->post_type;
  	$taxonomy = $posttype;
  	$businessmodeltaxonomies = nxs_business_gettaxonomiesmeta("nexusthemescompany");
  	
		// only do so when the attribution is a feature of this taxonomy
		$shouldprocess = $businessmodeltaxonomies[$taxonomy]["features"]["contentattribution"]["enabled"] == true;
  	if ($shouldprocess)
  	{
	  	$nxs_content_license = $post->nxs_content_license;
	  	if ($nxs_content_license != "")
	  	{
	  		$data = json_decode($nxs_content_license, true);
	  		if ($data["type"] == "attribution")
	  		{
		  		// for now this is hardcoded
		  		if ($data["author"] == "benin")
		  		{
		    		$content .= "<p style='font-size:small'>Benin Brown is a web copywriter who specializes in providing high quality website content for digital marketing professionals. As a white label content provider he is well-versed in writing for all industries. To learn more you can visit <a target='_blank' href='http://www.brownwebcopy.com'>www.brownwebcopy.com</p>";
		    	}
		    	else
		    	{
		    		$content .= $nxs_content_license;
		    	}
		    }
	    }
	  }
	  return $content;
	}
	
	function __construct()
  {
  	add_filter( 'init', array($this, "instance_init"), 5, 1);
		add_action( 'nxs_getwidgets',array( $this, "getwidgets"), 20, 2);
		add_shortcode( 'nxscomment', array($this, "sc_nxscomment"), 20, 2);
		add_filter("nxs_f_shouldrenderaddnewrowoption", array($this, "f_shouldrenderaddnewrowoption"), 1, 1);
		add_action('admin_head', array($this, "instance_admin_head"), 30, 1);
		
		//add_filter('wp_nav_menu_items','wp_nav_menu_items', 10, 2);
		add_filter('walker_nav_menu_start_el', array($this, 'walker_nav_menu_start_el'), 10, 4);
		
		add_filter('wp_nav_menu_objects', array($this, 'wp_nav_menu_objects'), 10, 3);
		
		add_filter( 'the_content', array($this, 'the_content'), 10, 1);
		
		add_filter("the_posts", array($this, "businesssite_the_posts"), 1000, 2);
  }
  
	/* ---------- */
}

global $businesssite_instance;
$businesssite_instance = new businesssite_instance();