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
            $info = $this->action_data;
            if(isset($info['relative_site']) && $info['relative_site'] == 'master'){
                $master_site = Sites::get_by_domain(get_config('master_domain'));
                $assets_dir = Sites::get_site_asset_dir($master_site);
                return $assets_dir;
            }
            else{
                $assets_dir = Sites::get_current_site_asset_dir();
                return $assets_dir;
            }
        }

        public function add_global_essential_ajax_info(){
            $print_resut = $this->action_data;
            $print_resut['system'] = 'sites';
            return $print_resut;
        }
	}
?>