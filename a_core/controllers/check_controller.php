<?php
    class check extends CrudController{
        public function setup_tree_select_info($table,$assign_1, $assign_2){
            $this->data['assign_info'] = array(
                'table'=>$table,
                'assign_1'=>$assign_1,
                'assign_2'=>$assign_2
            );
            $row_id = false;
            if(isset($_REQUEST['row_id'])){
                $row_id = $_REQUEST['row_id'];
            }
            elseif(isset($this->data['row_id'])){
                $row_id = $this->data['row_id'];
            }
            if(!$row_id){
                $this->row_error_message();
                return $this->eject_redirect();
            }
    
            $this->data['item_info'] = $this->get_item_info($row_id);
            if(!$this->data['item_info']){
                $this->row_error_message();
                return $this->eject_redirect();
            }
    
            $item_assign_arr = $this->get_item_assign_list($row_id,$table,$assign_1, $assign_2);
            $checked_assigns = array();
            foreach($item_assign_arr as $item_assign){
                $checked_assigns[$item_assign[$assign_1]] = true;
            }
    
            $add_is_checked_value = array(
                'controller'=>$this,
                'method'=>'add_assign_is_checked_param',
                'more_info'=>array(
                    'item_assign_arr'=>$checked_assigns
                ),
            );
    
            $payload = array('add_custom_param'=>$add_is_checked_value);
    
            $assign_tree_item = array(
                'id'=>'0',
                'checked'=>true,
                'label'=>'begin',
                'open_state'=>true,
    
                'children'=>$this->get_assign_item_offsprings_tree($table,$assign_1, $assign_2, $payload));
    
    
    
            $assign_tree_item = $this->add_has_checked_children_param($assign_tree_item);
            if(!isset($this->data['assign_trees'])){
                $this->data['assign_trees'] = array();
            }

            $this->data['assign_trees'][$table] = $assign_tree_item;
        }
    
        public function add_recursive_assign_select_view($assign_tree_item){
    
            $open_state_class = "closed";
            if($assign_tree_item['open_state']){
                $open_state_class = "open";
            }
            $assign_tree_item['open_class'] = $open_state_class;
            $this->include_view("tree/select_assigns_children.php",array('item'=>$assign_tree_item));
        }
    
    
        protected function add_has_checked_children_param($assign_tree_item, $count = 0){
            $count++;
            if($count>10){
                exit("count is $count");
            }
            $has_checked_children = false;
            $open_state = false;
            if($assign_tree_item['checked']){
                $open_state = true;
            }
            if($assign_tree_item['children']){
                foreach($assign_tree_item['children'] as $key=>$child_item){
                    $child_item = $this->add_has_checked_children_param($child_item, $count);
                    if($child_item['checked'] || $child_item['has_checked_children'] || $child_item['open_state']){
                        $has_checked_children = true;
                        $open_state = true;                
                    }
                    $assign_tree_item['children'][$key] = $child_item;
                }
            }
            $assign_tree_item['has_checked_children'] = $has_checked_children;
            $assign_tree_item['open_state'] = $open_state;
            return $assign_tree_item;
        }
    
    
        public function add_assign_is_checked_param($assign_info, $more_info){
            $assign_info['checked'] = '0';
            if(isset($more_info['item_assign_arr']) && is_array($more_info['item_assign_arr'])){
                if(isset($more_info['item_assign_arr'][$assign_info['id']])){
                    $assign_info['checked'] = '1';
                }
            }
            return $assign_info;
        }
    
        public function set_assignsSend(){
            $row_id = $_REQUEST['row_id'];
            $selected_assigns = array();
            global $action;
            if(isset($_REQUEST['assign'])){
                $selected_assigns = $_REQUEST['assign'];
            }
            $this->assign_to_item($row_id, $selected_assigns, $action);
            $this->add_assign_success_message($action);
            $this->redirect_back_to_assignment($row_id, $action);
        }
    

        public function add_assign_success_message($action){
            return null;
        }

        public function get_category_item_offsprings_tree($payload){
            return null;
        }
    
        public function get_item_assignlist($row_id){
            return null;
        }
    
        public function assign_to_item($row_id,$selected_cats, $action){
            return null;
        }
    
        public function redirect_back_to_assignment($row_id, $action){
            $this->redirect_to(inner_url(""));
        }
    }

?>