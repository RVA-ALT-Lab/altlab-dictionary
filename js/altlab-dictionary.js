// Fully accessible tooltip jQuery plugin with delegation. from https://codepen.io/geraldfullam/pen/MYpKyj
// Ideal for view containers that may re-render content.
(function ($) {
  jQuery.prototype.tooltip = function () {
    this
    // Delegate to tooltip, Hide if tooltip receives mouse or is clicked (tooltip may stick if parent has focus)
      .on('mouseenter click', '.tooltip', function (e) {
        e.stopPropagation();
        $(this).removeClass('isVisible');
        console.log(this);
      })
      // Delegate to parent of tooltip, Show tooltip if parent receives mouse or focus
      .on('mouseenter focus', ':has(>.tooltip)', function (e) {
        if (!$(this).prop('disabled')) { // IE 8 fix to prevent tooltip on `disabled` elements
          $(this)
            .find('.tooltip')
            .addClass('isVisible');
            console.log(this);
        }
      })
      // Delegate to parent of tooltip, Hide tooltip if parent loses mouse or focus
      .on('mouseleave blur keydown', ':has(>.tooltip)', function (e) {
        if (e.type === 'keydown') {
          if(e.which === 27) {
            $(this)
              .find('.tooltip')
              .removeClass('isVisible');
              console.log(this);
          }
        } else {
          $(this)
            .find('.tooltip')
            .removeClass('isVisible');
            console.log(this);
        }
      });
    return this;
  };
}(jQuery));

// Bind event listener to container element
jQuery('body').tooltip();