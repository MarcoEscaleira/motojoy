$(function(){

  mobileMenu();
  tabbedNav();

});


function mobileMenu( jQuery ) {

  //  Main Menu Vars
  var $hamburger                = $(".navicon-button");

  //  Dropdown Vars
  var $dropdownPrimary          = $('.mobile-menu-container .dropdown--primary');
  var $dropdownSecondary        = $('.mobile-menu-container .dropdown--secondary');

  var $primaryDropdownTrigger   = $('.mobile-menu-container > .menu > li > a.has-dropdown');
  var $secondaryDropdownTrigger = $('.dropdown--primary a.has-dropdown');

  //  Off-Canvas Menu Vars
  var $offCanvasMenu            = $('#menu--offcanvas');
  var $offcanvasToggle          = $('.toggle--offcanvas');

  //  Quick Menu Vars
  var $quickMenuTriggers        = $('.quick-menu-triggers');
  var $shopMenuTrigger          = $('#trigger--shop-menu');
  var $coursesMenuTrigger       = $('#trigger--courses-menu');
  var $coursesMenu              = $('#menu--courses');
  var $shopMenu                 = $('#menu--shop');

  // Slide Functions
  function slideDown(target)   { target.slideDown(200);   }
  function slideUp(target)     { target.slideUp(200);     }
  function slideToggle(target) { target.slideToggle(200); }

  // Remove Active Classes From Dropdown Menus
  function removeActiveClasses()   {
    $primaryDropdownTrigger.removeClass('active');
    $secondaryDropdownTrigger.removeClass('active');
  }

  // Toggle Offcanvas Menu
  function toggleOffCanvas() {
    // tranform hamburger icon to 'x'
    $(this).toggleClass("open");
    // Activate offcanvas
    $offCanvasMenu.toggleClass('active');
    // Hide the Quick Menu
    $quickMenuTriggers.toggleClass('hide');
  }

  // Open/Swap Dropdown Menus
  function togglePrimaryDropdown() {

    var $thisDropdownSecondary = $(this).siblings('.dropdown--secondary');

    // Set Current Dropdown Menu
    var $currentMenu = $(this).siblings('.menu');

    // Is Current Menu Already Open?
    if ( $currentMenu.is(':visible') ) {

      // Close The Menus
      slideUp($currentMenu);
      slideUp($dropdownSecondary);
      removeActiveClasses();

    // If current menu is not already open,
    // close old menus and open the current one
    } else if ( $currentMenu.not(':visible') ) {

      // Remove Old Active Classes
      removeActiveClasses();
      // Open/Swap The Dropdown Menu
      slideUp($dropdownPrimary);
      slideUp($dropdownSecondary);
      slideDown($currentMenu);
      // Add New Active Class To Current Menu
      $(this).addClass('active');

    }
  }

  // Toggle Second Level Dropdown Items
  function toggleSecondaryDropdown() {

    // get current dropdown
    var $thisDropdownSecondary = $(this).siblings('.dropdown--secondary');

    slideUp( $dropdownSecondary.not( $thisDropdownSecondary ) );
    slideToggle($dropdownSecondary);

    $dropdownSecondary.siblings('a').not(this).removeClass('active');
    $(this).toggleClass('active');
  }

  // Animate/Toggle Quick Menu buttons and items
  function triggerQuickMenu(anchorTarget, menuTarget) {
    $quickMenuTriggers.toggleClass('active ' +  anchorTarget);
    $(menuTarget).toggleClass('active');
    $offcanvasToggle.toggleClass('toggle-is-hidden');
  }

  // Event Listeners
  $hamburger.click( toggleOffCanvas );

  $primaryDropdownTrigger.click( togglePrimaryDropdown );
  $secondaryDropdownTrigger.click( toggleSecondaryDropdown );

  $coursesMenuTrigger.click( function() { triggerQuickMenu( 'active--courses', $coursesMenu ) });
  $shopMenuTrigger.click( function() { triggerQuickMenu( 'active--shop', $shopMenu ) });

}

function tabbedNav( jQuery ) {

  var $this, $href, $menuID;

  var $navPrimaryAnchor   = $('.nav--primary > li > a');
  var $navSecondary       = $('.nav--secondary');
  var $navSecondaryLi     = $('.nav--secondary > ul > li');
  var $navSecondaryAnchor = $('.nav--secondary > ul > li > a');

  $navPrimaryAnchor.click( function(e) {

    e.preventDefault();

    /***********************************
    1. collect href
    2. strip out foreward slashes
    3. assign as current menu
    ************************************/

    var $href        = $(this).attr('href');
    var $menu        = $('.menu');
    var $menuID      = $href.slice(1, -1);

    var $currentMenu = "[data-menu='" + $menuID + "']";

    // Check if clicked link has a subnav
    if ( $(this).hasClass('has-submenu') === true ) {

      // Do nothing if current menu is already open
      if ($('ul').find($currentMenu).hasClass('active') === false) {

        // Move current menu to top of stack
        $navSecondary.find($currentMenu).appendTo($navSecondary);

        /* appending and animating CSS simultaneously
        breaks the transition. adding a miillisecond
        timeout before adding active class fixes this */

        setTimeout(function() {

          // activate new menu items
          $('.nav--primary > li > a[href="' + $href + '"]').parent().addClass('active');
          $($navSecondary).find($currentMenu).addClass('active');

          // deactivate old menu link
          $(".nav--primary li a:not([href='" + $href + "'])").parent().removeClass('active');

          // wait until transition ends
          setTimeout(function() {

            // deactivate old menu
            $menu.not($currentMenu).removeClass('active');

          }, 100);

        }, 50);
      }
    }
  });

  // Trigger Dropdown Function
  function openDropdown(e){
   $(this).siblings('ul').slideDown(250);

  }

  // Trigger Dropdown Listener
  $navSecondaryAnchor.unbind().click( openDropdown );

  // Close Dropdown
  function closeDropdown() {
    $navSecondaryLi.find('ul').slideUp(250);
    $navSecondaryLi.find('.active').removeClass('active');
  }

  // Close Dropdown Listener
  $(document).click(function(e){
    if (! $(e.target).parents().hasClass('has-dropdown')) { closeDropdown() }
  });

}


var colors = new Array(
  [62,35,255],
  [60,255,60],
  [255,35,98],
  [45,175,230],
  [255,0,255],
  [255,128,0]);

var step = 0;
//color table indices for:
// current color left
// next color left
// current color right
// next color right
var colorIndices = [0,1,2,3];

//transition speed
var gradientSpeed = 0.002;

function updateGradient()
{

  if ( $===undefined ) return;

var c0_0 = colors[colorIndices[0]];
var c0_1 = colors[colorIndices[1]];
var c1_0 = colors[colorIndices[2]];
var c1_1 = colors[colorIndices[3]];

var istep = 1 - step;
var r1 = Math.round(istep * c0_0[0] + step * c0_1[0]);
var g1 = Math.round(istep * c0_0[1] + step * c0_1[1]);
var b1 = Math.round(istep * c0_0[2] + step * c0_1[2]);
var color1 = "rgb("+r1+","+g1+","+b1+")";

var r2 = Math.round(istep * c1_0[0] + step * c1_1[0]);
var g2 = Math.round(istep * c1_0[1] + step * c1_1[1]);
var b2 = Math.round(istep * c1_0[2] + step * c1_1[2]);
var color2 = "rgb("+r2+","+g2+","+b2+")";

 $('#gradient').css({
   background: "-webkit-gradient(linear, left top, right top, from("+color1+"), to("+color2+"))"}).css({
    background: "-moz-linear-gradient(left, "+color1+" 0%, "+color2+" 100%)"});

  step += gradientSpeed;
  if ( step >= 1 )
  {
    step %= 1;
    colorIndices[0] = colorIndices[1];
    colorIndices[2] = colorIndices[3];

    //pick two new target color indices
    //do not pick the same as the current one
    colorIndices[1] = ( colorIndices[1] + Math.floor( 1 + Math.random() * (colors.length - 1))) % colors.length;
    colorIndices[3] = ( colorIndices[3] + Math.floor( 1 + Math.random() * (colors.length - 1))) % colors.length;

  }
}

setInterval(updateGradient,10);
