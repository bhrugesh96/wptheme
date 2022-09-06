!function($) {
	"use strict";
	/* For Mega Menu*/
    $( document ).ready(function() {
      
        // show or hide megamenu fields on parent and child list items
        armcodirect_menu_item_mouseup_event();
        armcodirect_megamenu_status_update();
        armcodirect_update_megamenu_field_classes();
        
        /* On mouseup event check megamenu status and add class or remove class */
        function armcodirect_menu_item_mouseup_event() {
            $( document ).on( 'mouseup', '.menu-item-bar', function( event, ui ) {
                if ( ! $( event.target ).is( 'a' ) ) {
                    setTimeout( armcodirect_update_megamenu_field_classes, 300 );
                }
            });
        }
          
        /* Check if Mega Menu is enable for parent */
        function armcodirect_megamenu_status_update() {

            $( document ).on( 'click', '.edit-menu-item-armcodirect-mega-menu-item-status', function() {
              
                var parent_li_item = $( this ).parents( 'li.menu-item:eq( 0 )' );

                if ( $( this ).is( ':checked' ) ) {
                    parent_li_item.addClass( 'armcodirect-megamenu-active' );
                } else  {
                    parent_li_item.removeClass( 'armcodirect-megamenu-active' );
                }
                armcodirect_update_megamenu_field_classes();
            });
        }
        
        /* Check onload which menu is checked and add class "armcodirect-megamenu-active" */
        function armcodirect_update_megamenu_field_classes() {
            var armcodirect_menu_li_items = $( '.menu-item' );
            armcodirect_menu_li_items.each( function( i )   {
                var armcodirect_megamenu_status = $( '.edit-menu-item-armcodirect-mega-menu-item-status', this );
                if ( ! $( this ).is( '.menu-item-depth-0' ) ) {
                    var check_item = armcodirect_menu_li_items.filter( ':eq(' + (i-1) + ')' );

                    if ( check_item.is( '.armcodirect-megamenu-active' ) ) {
                        armcodirect_megamenu_status.attr( 'checked', 'checked' );
                        $( this ).addClass( 'armcodirect-megamenu-active' );
                    } else {
                        armcodirect_megamenu_status.attr( 'checked', '' );
                        $( this ).removeClass( 'armcodirect-megamenu-active' );
                    }
                } else {
                    if ( armcodirect_megamenu_status.attr( 'checked' ) ) {
                        $( this ).addClass( 'armcodirect-megamenu-active' );
                    }
                }
            });
        }
    });
}(window.jQuery);