document.addEventListener("DOMContentLoaded",()=>{
    initBizForm();
});

initBizForm = ()=>{
    document.querySelectorAll('.biz-form-placeholder').forEach(
        formWrapElement=>{
            bizForm = new BizForm(formWrapElement);
        }
    );
}

class BizForm{

    constructor(formWrapElement) {
        this.formWrapElement = formWrapElement;
        this.fetchUrl = this.formWrapElement.dataset.fetch_url;
        this.apitoui = this.formWrapElement.querySelector(".bizform-apitoui");
        this.appendSpot = this.formWrapElement.querySelector(".append-spot");
        this.loadingMsg = this.formWrapElement.querySelector(".loading-msg");
        this.parentAEventListenerBinded = this.parentAEventListener.bind(this);
        this.selectEventListenerBinded = this.selectEventListener.bind(this);
        this.activeParent = this.formWrapElement.dataset.active_parent;
        this.max_stock = 0;
        this.treeSelect = this.formWrapElement.querySelector(".tree-select");
        this.treeSelect.classList.add("binded-select-listen"); 
        this.treeSelect.addEventListener("change", this.selectEventListenerBinded, true);
        this.formWrapElement.querySelectorAll(".source-parent-a").forEach(parentA => {
            parentA.addEventListener("click",this.parentAEventListenerBinded,true);
        });
    }

    selectEventListener(){
        this.fetchParentChildren();        
    }
    fetchParentChildren(){
        if(this.treeSelect.value == ''){
            console.log("change value to " + this.activeParent);
            
            return;
        }
        else{
            
            console.log("but now to " + this.treeSelect.value);
        }
        this.showLoadingMsg();
        fetch(this.fetchUrl+"?cat_id="+this.treeSelect.value).then((res) => res.json()).then(info => {
            this.handleSelectedCatChanged(info);
            this.hideLoadingMsg();
        }).catch(function(err) {
            console.log(err);
            alert("Something went wrong. please reload the page");
        });
    }
    handleSelectedCatChanged(info){
        if(!info.success){
            return alert(info.err_message);
        }
        if(info.cat_info.has_children){
            this.updateSelectOptions(this.treeSelect,info.cat_info.children);
            this.appendParentA(info.cat_info);
        }
    }

    updateSelectOptions(select,options){
        select.innerHTML = "";
        const option = this.prepareSelectOption("---","",false);
        select.append(option);
        options.map(childInfo => {
            const option = this.prepareSelectOption(childInfo.label,childInfo.id,childInfo.selected);
            select.append(option);
        });
    }

    appendParentA(cat_info){
        const parentA = this.apitoui.querySelector(".parent-a-template").cloneNode(true);
        this.formWrapElement.insertBefore(parentA, this.appendSpot);
        parentA.dataset.cat_id = cat_info.id;
        parentA.dataset.parent_id = this.activeParent;
        
        parentA.classList.add("child-of-"+this.activeParent);
        this.activeParent = cat_info.id;
        parentA.querySelector(".val-placeholder").innerHTML = cat_info.label;
        parentA.addEventListener("click", this.parentAEventListenerBinded, true);
        
    }
    parentAEventListener(event){
        
        this.revertSelectionToParent(event.target.closest('.parent-a-template'));
    }

    revertSelectionToParent(parentA){
        this.showLoadingMsg();
        const parentCatId = parentA.dataset.parent_id;
        this.activeParent = parentCatId;
        
        fetch(this.fetchUrl+"?cat_id="+parentCatId).then((res) => res.json()).then(info => {
            this.handleParentCatChanged(info);
            this.hideLoadingMsg();
        }).catch(function(err) {
            console.log(err);
            alert("Something went wrong. please reload the page");
        });
        this.max_stock = 0;
        this.removeOffsprinngsOf(parentCatId);
    }

    handleParentCatChanged(info){
        if(!info.success){
            return alert(info.err_message);
        }
        if(info.cat_info.has_children){
            this.updateSelectOptions(this.treeSelect,info.cat_info.children);
        }
    }

    prepareSelectOption(label,value,selected){
        const option = this.apitoui.querySelector(".options-template-wrap option").cloneNode(true);
        if(label != "---"){
            option.innerHTML = label;
        }
        
        option.value = value;
        if(selected){
            option.setAttribute("selected",'1');
        }
        
        return option;
    }

    removeOffsprinngsOf(parentCatId){
        this.max_stock++;
        if(this.max_stock > 10){
            return;
        }
        
        this.formWrapElement.querySelectorAll(".child-of-"+ parentCatId).forEach(childRemove => {
            const catId = childRemove.dataset.cat_id;
            this.removeOffsprinngsOf(catId);
            childRemove.remove();          
        });
    }

    hideLoadingMsg(){
        this.loadingMsg.classList.add("hidden");
    }
    showLoadingMsg(){
        this.loadingMsg.classList.remove("hidden");
    }

}