<?php
	class sitesModule extends Module{

        public function init_layout(){
            $this->controller->add_model('sites');
            $site = Sites::get_current_site();
            $this->add_asset_mapping(Sites::$asset_mapping);
            if($site){
                
                $this->add_data('page_meta_title', $site['meta_title']);
            }
            else{
                $this->add_data('page_meta_title',get_config('site_title'));
            }
            $this->add_data('site',$site);
            return;
        }        

        public function handle_access_default(){
            return true;
        }

        public function get_assets_dir(){
            $assets_dir = Sites::get_current_site_asset_dir();
            return $assets_dir;
        }

	}
?>