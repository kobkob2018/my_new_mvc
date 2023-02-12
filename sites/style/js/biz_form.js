document.addEventListener("DOMContentLoaded",()=>{
    initBizForm();
});

initBizForm = ()=>{
    document.querySelectorAll('.biz-form-generator').forEach(
        wrapElement=>{
            bizForm = new BizForm(wrapElement);
        }
    );
}

class BizForm{

    constructor(wrapElement) {
        this.wrapElement = wrapElement;
        this.placeholder = this.wrapElement.querySelector(".biz-form-placeholder");
        this.formElement = this.wrapElement.querySelector("form.biz-form");
        //return;
        this.fetchUrl = this.placeholder.dataset.fetch_url;
        this.form_id = this.placeholder.dataset.form_id;
        this.selected_cat = this.placeholder.dataset.cat_id;
        this.appendSpot = this.placeholder.querySelector(".append-spot");
        this.loadingMsg = this.placeholder.querySelector(".loading-message");
        this.submitButton = wrapElement.querySelector(".submit-button");
        this.submitWrap = wrapElement.querySelector(".submit-wrap");
        
        this.selectEventListenerBinded = this.selectEventListener.bind(this);
        this.submitEventListenerBinded = this.submitEventListener.bind(this);
        this.submitButton.addEventListener("click", this.submitEventListenerBinded, true);
        this.max_stock = 0;
        this.initFetch();
    }

    initFetch(){
        const cat_id = this.placeholder.dataset.cat_id;
        this.fetchForCat(cat_id);

    }
    fetchForCat(cat_id){
        this.enterLoadingState();
        fetch(this.fetchUrl+"?cat_id="+cat_id+"&form_id="+this.form_id).then((res) => res.json()).then(info => {
            console.log(info);
            if(info.success){
                this.appendChildren(info.html,cat_id);
                this.bindCatSelectEvents(cat_id);
                this.outLoadingState(info);
            }
        }).catch(function(err) {
            
            console.log(err);
            console.log("Something went wrong. please reload the page");
            //alert("Something went wrong. please reload the page");
        });
    }
    enterLoadingState(){
        this.showLoading();
        this.enterPendingState();

    }
    outLoadingState(info){
        this.hideLoading();
        if(info.state == "ready"){
            this.enterReadyState();
        }
    }
    enterPendingState(){
        this.submitButton.dataset.status = 'pending';
        this.submitWrap.classList.remove("ready-state");
        this.submitWrap.classList.add("pending-state");
    }
    enterReadyState(){
        this.submitButton.dataset.status = 'ready';
        this.submitWrap.classList.remove("pending-state");
        this.submitWrap.classList.add("ready-state");
    }
    showLoading(){
        this.loadingMsg.classList.remove("hidden");
    }
    hideLoading(){
        this.loadingMsg.classList.add("hidden");
    }
    catChildClassName(cat_id){
        return 'child-of-'+cat_id;
    }
    removeChildrenOf(childEl){
        this.max_stock++;
        if(this.max_stock > 10){
            alert("max_stock");
            return;
        }
        if(childEl.getAttribute("data-cat_id") === "undefined"){
            return;
        }
        if(childEl.dataset.cat_id == ""){
            return;
        }
        const childEl_cat_id = childEl.dataset.cat_id;
        const className = this.catChildClassName(childEl_cat_id);
        console.log("remving"+className);
        this.placeholder.querySelectorAll("."+className).forEach(child => {
            // if(child.classList.contains("binded-cat-select")){
                this.removeChildrenOf(child);
            // }
            child.remove();
        });
    }
    appendChildren(html,cat_id){
        const new_elements = document.createElement('div');
        new_elements.innerHTML = html;
        let have_new_elements = false;
        new_elements.querySelectorAll(".child-element").forEach(childEl => {
            have_new_elements = true;
            const className = this.catChildClassName(cat_id);
            childEl.classList.add(className);
            this.placeholder.insertBefore(childEl, this.appendSpot);
        }); 
        return have_new_elements;
    }
    bindCatSelectEvents(){
        this.placeholder.querySelectorAll("select.to-bind").forEach(select => {
            select.classList.remove("to-bind");
            select.classList.add("binded-cat-select");
            select.addEventListener("change", this.selectEventListenerBinded, true);
        });
    }

    selectEventListener(event){
        const select = event.target;
        const cat_id = select.value;
        const childEl = select.closest('.child-element');
        this.max_stock = 0;
        this.removeChildrenOf(childEl);
        childEl.dataset.cat_id = cat_id;
        this.selected_cat = cat_id;
        if(cat_id != ''){
            this.fetchForCat(cat_id);
        }
    }
    submitEventListener(event){
        if(this.submitButton.dataset.state == "ready"){
            const selected_cat = this.selected_cat;
            if(this.selected_cat == ""){
                console.log("no category selected");
                return;
            }
            alert("we are going to submit!!!");
        }
        else{
            console.log("not ready");
        }
    }
}