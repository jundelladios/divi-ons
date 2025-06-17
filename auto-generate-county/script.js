var acc = document.getElementsByClassName("nf-accordion-title");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("nf-active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
        panel.style.margin = "0 18px";
        } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
        panel.style.margin = "10px 18px";
        } 
    });
}




jQuery(document).ready( function($) {

    $('.banner-adds-slick-item-solo').slick(window.slickoptions);

    $('body').on('click', '[data-chunk-next]', function() {
        var getNextGrid = $(this).parent().parent().next('.cs-grid-row');
        getNextGrid.addClass('show');
        $(this).parent().remove();
        return false;
    });

});



// Javascript for opening modal start here
var has_modal_elements = document.querySelectorAll(".has-custom-modal");
for(i = 0; i < has_modal_elements.length; i++){
    document.querySelectorAll(".has-custom-modal")[i].addEventListener("click",function(){
        var body_class_name = this.getAttribute("data-modal-popup");
        document.querySelector(`.modalparent-${body_class_name}`).classList.add('open');
    })
}
// Javascript for opening modal end here

// Javascript for closing modal start here
var has_modal_elements_close = document.querySelectorAll(".has-custom-modal-close");
for(i = 0; i < has_modal_elements_close.length; i++){
    document.querySelectorAll(".has-custom-modal-close")[i].addEventListener("click",function(){
        var body_class_name = this.getAttribute("data-modal-popup");
        document.querySelector(`.modalparent-${body_class_name}`).classList.remove('open');
    })
}
// Javascript for closing modal end here