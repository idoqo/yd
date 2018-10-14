(function($) {
    $.zoom = function() {
        // append a gallery wrapper to the document body
        $('body').append('<div id="zoom"></div>');
        var zoomedIn = false,  // a flag to know if the gallery is open or not
            zoom = $('#zoom'),
            zoomContent = null,
            opened = null; // the opened image element

        function setup() {
            zoom.hide(); // hide it
            // add the inner elements, initialize the content , close and navigation links
            zoom.prepend('<div class="content"></div>');

            zoom.prepend('<div class="close"><i class="fa fa-remove"></i></div>');
            zoom.prepend('<a href="#previous" class="previous"><i class="fa fa-arrow-circle-left"></i></a>');
            zoom.prepend('<a href="#next" class="next"><i class="fa fa-arrow-circle-right"></i></a>');

            zoomContent = $('#zoom .content');
            // attach events to the added elements
            $('#zoom .close').on('click', close);
            $('#zoom .previous').on('click', openPrevious);
            $('#zoom .next').on('click', openNext);

            // observe keyboard events for navigation and closing the gallery
            $(document).keydown(function(event) {
                if (!opened) {
                    return;
                }
                if (event.which == 27) {
                    $('#zoom .close').click();
                    return;
                }
                if (event.which == 37) {
                    $('#zoom .previous').click();
                    return;
                }
                if (event.which == 39) {
                    $('#zoom .next').click();
                    return;
                }
                return;
            });

            /*if ($('.gallery li a').length == 1) {
                // add 'zoom' class for single image so the navigation links will hide
                $('.gallery li a')[0].addClass('zoom');
            }*/
            // attach click event observer to open the image
            $('.zoom, .gallery li a').on('click', open);
        }

        function open(event) {
            event.preventDefault(); // prevent opening a blank page with the image
            var link = $(this),
                src = link.attr('href'),
                text = link.attr('data-title'),
            // create an image object with the source from the link
                image = $(new Image()).attr('src', src).hide();
            if (!src) {
                return;
            }
            $('#zoom .previous, #zoom .next').show();
            if (link.hasClass('zoom')) {
                $('#zoom .previous, #zoom .next').hide();
            }

            // show the gallery with loading spinner, navigation and close buttons
            if (!zoomedIn) {
                zoomedIn = true;
                zoom.show();
            }
            // clean up and add image object for loading
            zoomContent.empty().prepend('<p class="content-text">'+text+'</p>').prepend(image);
            // event observer for image loading, render() will be
            // called while image is loading
            image.load(render);
            opened = link;
        }

        function openPrevious(event) {
            event.preventDefault();
            if (opened.hasClass('zoom')) {
                return;
            }
            var prev = opened.parent('li').prev();
            if (prev.length == 0) {
                prev = $('.gallery li:last-child');
            }
            prev.children('a').trigger('click');
        }

        function openNext(event) {
            event.preventDefault();
            if (opened.hasClass('zoom')) {
                return;
            }
            var next = opened.parent('li').next();
            if (next.length == 0) {
                next = $('.gallery li:first-child');
            }
            next.children('a').trigger('click');
        }

        function render() {
            // if the image is not fully loaded do nothing
            if (!this.complete) {
                return;
            }
            var image = $(this);
            // if image has the same dimensions as the gallery
            // just show the image don't animate
            if (image.width() == zoomContent.width() &&
                image.height() == zoomContent.height()) {
                show(image);
                return;
            }

            var borderWidth = parseInt(zoomContent.css('borderLeftWidth'));
            // resize the gallery to the image dimensions before
            // displaying the image
            zoomContent.animate({
                width: image.width(),
                height: image.height()
                //marginTop: -(image.height() / 2) - borderWidth,
                //marginLeft: -(image.width() / 2) - borderWidth
            }, 300, function(){
                show(image);
            });

            function show(image) {
                image.fadeIn('fast');
            }
        }

        function close(event) {
            event.preventDefault();
            zoomedIn = false;
            zoom.hide();
            zoomContent.empty();
        }

        setup();
    };
})(jQuery);