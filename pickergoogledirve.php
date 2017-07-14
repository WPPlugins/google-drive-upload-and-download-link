<?php
/*
Plugin Name:Google Drive upload and download link
Description: Upload and insert or download link to your files in Google Drive |Sube e inserta un enlace de descarga para los archivos en Google Drive
Author: Oscar Uh
Version: 1.0
Author URI: http://develoteca.com/
Plugin URI: http://develoteca.com/

*/
	function googlepicker_media_menu($tabs) {
		$newtab = array('googlepicker' => __('Google drive', 'googlepicker'));
		return array_merge($tabs, $newtab);
	}
	add_filter('media_upload_tabs', 'googlepicker_media_menu');
	add_action('media_upload_googlepicker', 'googlepicker_media_menu_handle');

	// Adjuntos shortcode //Atach
	add_shortcode('atachfilegoogle', 'the_atachment_files');
	function the_atachment_files($atts, $content = null){
	extract(shortcode_atts(array(  
          "link" => '#',
		  "descripcion" => 'Archivo'
		), $atts)); 
	
	if(trim($link)==''){$link='#';}
		return '<a href="http://'.$link.'">Download</a>';
	}


function googlepicker_media_menu_handle() { 
			
			echo '<script src="http://www.google.com/jsapi"></script>';
			echo '<script>';
			echo 'var createPicker = function() {			
					var picker = new google.picker.PickerBuilder()
					.addView(google.picker.ViewId.RECENTLY_PICKED)
					.addView(google.picker.ViewId.DOCS)
					.addView(new google.picker.DocsUploadView())
					.setAppId("")
					.setCallback(function pickerCallback(data) {
						switch (data.action) {
							case google.picker.Action.PICKED:
								console.log(data);
								insertar_attachment("docs.google.com/uc?id=" + encodeURIComponent(data.docs[0].id));
							break;
						}
					}).build();
					picker.setVisible(true);
				}
				google.setOnLoadCallback(createPicker);
				google.load("picker", "1");
				function insertar_attachment(archivo){
					insertHTML = function(html) {
						var win = window.dialogArguments || opener || parent || top;
						win.send_to_editor(html);
					}
					textinsert =\'[atachfilegoogle link="\'+archivo+\'"]\';
					insertHTML(textinsert);		
				}';
			echo '</script>';
	
} ?>