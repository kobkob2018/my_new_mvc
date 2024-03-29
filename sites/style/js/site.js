

var open_sub_menu = false;
function show_sub_menu(sender_el){  
    menu_item_el = document.getElementById(sender_el.dataset.item_id);

    if(menu_item_el.classList.contains('active-sub')){
        menu_item_el.classList.remove('active-sub');
    }
    else{
        close_all_top_submenus();
        menu_item_el.classList.add('active-sub');
        open_sub_menu = menu_item_el;

        document.addEventListener("click", close_top_sub_menus, true);

    }
}

function close_top_sub_menus(event){
    if(!open_sub_menu.contains(event.target)){
        close_all_top_submenus();

    }
}

function close_all_top_submenus(){
    selectedItems = document.querySelectorAll('.active-sub');

    selectedItems.forEach(sel=>{
        sel.classList.remove("active-sub");
    });
    document.removeEventListener("click", close_top_sub_menus, true);
}


function openDrawer(drawerId) {
    
    document.getElementById(drawerId + "_wrap").style.width = "300px";
    document.getElementById(drawerId + "_drawer_overlay").style.display = "block";
  }
  
  function closeDrawer(drawerId) {
    document.getElementById(drawerId + "_wrap").style.width = "0";
    document.getElementById(drawerId + "_drawer_overlay").style.display = "none";
  }