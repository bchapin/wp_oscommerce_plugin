<?php   
    /* 
    Plugin Name: OSCommerce Product Display 
    Plugin URI: http://www.chapinproductions.com 
    Description: Plugin for displaying products from an OSCommerce shopping cart database 
    Author: B. Chapin 
    Version: 1.0 
    Author URI: http://www.chapinproductions.com 
    
    and add a line to this file too
    
    */ 
    
    function oscimp_getproducts($product_cnt=1) {  
    
    
    //Connect to the OSCommerce database  
    $oscommercedb = new wpdb(get_option('oscimp_dbuser'),get_option('oscimp_dbpwd'), get_option('oscimp_dbname'), get_option('oscimp_dbhost'));  
  
    $retval = '';  
    for ($i=0; $i<$product_cnt; $i++) {  
        //Get a random product  
        $product_count = 0;  
        while ($product_count == 0) {  
            $product_id = rand(0,30);  
            $product_count = $oscommercedb->get_var("SELECT COUNT(*) FROM products WHERE products_id=$product_id AND products_status=1");  
        }  
          
        //Get product image, name and URL  
        $product_image = $oscommercedb->get_var("SELECT products_image FROM products WHERE products_id=$product_id");  
        $product_name = $oscommercedb->get_var("SELECT products_name FROM products_description WHERE products_id=$product_id");  
        $store_url = get_option('oscimp_store_url');  
        $image_folder = get_option('oscimp_prod_img_folder');  
  
        //Build the HTML code  
        $retval .= '<div class="oscimp_product">';  
        $retval .= '<a href="'. $store_url . 'product_info.php?products_id=' . $product_id . '"><img src="' . $image_folder . $product_image . '" /></a><br />';  
        $retval .= '<a href="'. $store_url . 'product_info.php?products_id=' . $product_id . '">' . $product_name . '</a>';  
        $retval .= '</div>'; 
    } 
  	
  		
  	//$retval .= "Hello";
      
    return $retval;  
}  
    
    function oscimp_admin() {  
    	include('oscommerce_import_admin.php');  
	} 

    function oscimp_admin_actions() {  
		//add_options_page("OSCommerce Product Display", "OSCommerce Product Display", 'manage_options', "OSCommerce Product Display", "oscimp_admin");  
		
		//	add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
			add_options_page('OSCommerce Product Display', 'OSCommerce Product Display', 'manage_options', 'oscommerce_importer', 'oscimp_admin');
		
	}  
  
	add_action('admin_menu', 'oscimp_admin_actions'); 
?>  