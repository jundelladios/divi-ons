if(document.querySelectorAll("#header-services .header-services").length > 0){
    for(i = 0; i < document.querySelectorAll("#header-services .header-services").length; i++){
		document.querySelectorAll("#header-services .header-services")[i].addEventListener("click",function(){
		   document.body.classList.add("open-services-modal");
		});
	}
	if(document.querySelectorAll("#header-service-lists .close-click-services").length > 0){
		for(i = 0; i < document.querySelectorAll("#header-service-lists .close-click-services").length; i++){
			document.querySelectorAll("#header-service-lists .close-click-services")[i].addEventListener("click",function(){
			   document.body.classList.remove("open-services-modal");
			});
		}
	}
}

document.querySelectorAll(".file-upload-content").length > 0 &&
    document.querySelectorAll(".file-upload-content")[0].addEventListener("click", function () {
        this.querySelectorAll("input[type=file]")[0].click();
    }),
    document.querySelectorAll(".mobile-show.hamburger").length > 0 &&
        document.querySelectorAll(".mobile-show.hamburger")[0].addEventListener("click", function () {
            var e = document.querySelectorAll(".nav-links-container-mobile")[0];
            e.parentNode.classList.contains("open") ? e.parentNode.classList.remove("open") : e.parentNode.classList.add("open");
        }),
    document.querySelectorAll(".modal-button").length > 0 &&
        document.querySelectorAll(".modal-button")[0].addEventListener("click", function () {
            document.body.classList.remove("modal-open"), (document.querySelectorAll("input#consent")[0].checked = !0);
        }),
    document.querySelectorAll(".modal-opener-services").length > 0 &&
        document.querySelectorAll(".modal-opener-services")[0].addEventListener("click", function () {
            document.body.classList.add("modal-open");
        }),     



jQuery(function($) {
    var Accordion = function(el, multiple) {
        this.el = el || {};
        this.multiple = multiple || false;

        // Variables privadas
        var links = this.el.find('.template-accordion-title');
        // Evento
        links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
    }

    Accordion.prototype.dropdown = function(e) {
        var $el = e.data.el;
            $this = $(this),
            $next = $this.next();

        $next.slideToggle();
        $this.parent().toggleClass('open');

        if (!e.data.multiple) {
            $el.find('.template-accordion-description').not($next).slideUp().parent().removeClass('open');
        };
    }

    var accordion = new Accordion(jQuery('#accordion'), false);          
}); 


/*Image Hover*/
const imgToHover = document.querySelectorAll(".move-mouse-add");
function showImgContent(e) {
    document.removeEventListener('mousemove', showImgContent);

    // e = Mouse click event.
    var rect = e.target.getBoundingClientRect();
    var x = e.clientX - rect.left; //x position within the element.
    var y = e.clientY - rect.top;  //y position within the element.


    this.querySelectorAll("span.img-content-hover")[0].style.transform = `translate3d(${x}px, ${y}px, 0)`;
};

for(i = 0; i < imgToHover.length; i++){
imgToHover[i].addEventListener('mousemove', showImgContent);
}
/*End of Image Hover*/


jQuery(document).ready( function() {
    jQuery('.atf-slider-content-bg').not('.slick-initialized').slick({
        autoplay: true,
        autoplaySpeed: 4000 || 3000,
        fade: true,
        cssEase: 'linear',
        speed: 500,
    });
});

jQuery(function (e) { 
    var $jq = jQuery.noConflict();

    $jq(document).ready(function() { 
        
        var mobileLink = document.querySelectorAll(".nav-links-container-mobile div#hamburg-menu-custom")[0]
        if(mobileLink) {
            mobileLink.onclick = function(){
                var checkClass = document.body.classList.contains("open-sub-nav");
    
                if(checkClass){
                    document.body.classList.remove("open-sub-nav");
                }else{
                    document.body.classList.add("open-sub-nav");
                }
            }
        }

        window.addEventListener("scroll",function() {
            myFunction(); 
        });

        function myFunction() {
            var header = document.querySelectorAll(".et_pb_section_3_tb_header.et_pb_sticky_module")[0];
            if(!header) { return; }
            var sticky = header?.offsetTop;
            if(!sticky) { return; }
            if (window.pageYOffset > sticky) {
            header.classList.add("sticky-shu-shu");
            header.style = "";
            } else {
            header.classList.remove("sticky-shu-shu");
            header.style = "";
            }
        }
    

    });
});


function ModalFunctionCloser(body_class_name){
    document.body.classList.remove('open-'+body_class_name);
}
// Javascript for opening modal start here
var has_modal_elements = document.querySelectorAll(".has-custom-modal");
for(i = 0; i < has_modal_elements.length; i++){
    document.querySelectorAll(".has-custom-modal")[i].addEventListener("click",function(){
        var body_class_name = this.getAttribute("data-modal-popup");
        ModalFunctionOpener(body_class_name);
    })
}
function ModalFunctionOpener(body_class_name){
    document.body.classList.add('open-'+body_class_name);
}
// Javascript for opening modal end here

// Javascript for closing modal start here
var has_modal_elements_close = document.querySelectorAll(".has-custom-modal-close");
for(i = 0; i < has_modal_elements_close.length; i++){
    document.querySelectorAll(".has-custom-modal-close")[i].addEventListener("click",function(){
        var body_class_name = this.getAttribute("data-modal-popup");
        ModalFunctionCloser(body_class_name);
    })
}
// Javascript for closing modal end here