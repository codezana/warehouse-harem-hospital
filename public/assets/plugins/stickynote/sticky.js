'use strict';
(function ($) {
    $.fn.autogrow = function (options) {
        return this.filter('textarea').each(function () {
            var self = this;
            var $self = $(self);
            var minHeight = $self.height();
            var noFlickerPad = $self.hasClass('autogrow-short') ? 0 : parseInt($self.css('lineHeight')) || 0;
            var shadow = $('<div></div>').css({
                position: 'absolute',
                top: -10000,
                left: -10000,
                width: $self.width(),
                fontSize: $self.css('fontSize'),
                fontFamily: $self.css('fontFamily'),
                fontWeight: $self.css('fontWeight'),
                lineHeight: $self.css('lineHeight'),
                resize: 'none',
                'word-wrap': 'break-word'
            }).appendTo(document.body);
            var update = function (event) {
                var times = function (string, number) {
                    for (var i = 0, r = ''; i < number; i++) r += string;
                    return r;
                };
                var val = self.value.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/&/g, '&amp;').replace(/\n$/, '<br/>&nbsp;').replace(/\n/g, '<br/>').replace(/ {2,}/g, function (space) {
                    return times('&nbsp;', space.length - 1) + ' '
                });
                if (event && event.data && event.data.event === 'keydown' && event.keyCode === 13) {
                    val += '<br />';
                }
                shadow.css('width', $self.width());
                shadow.html(val + (noFlickerPad === 0 ? '...' : ''));
                $self.height(Math.max(shadow.height() + noFlickerPad, minHeight));
            }
            $self.change(update).keyup(update).keydown({
                event: 'keydown'
            }, update);
            $(window).resize(update);
            update();
        });
    };
})(jQuery);
var noteTemp = 
   '<div class="note">' +
    '<a href="javascript:;" class="button remove">X</a>' +
    '<div class="note_cnt">' +
    '<textarea class="title" name="title" placeholder="Enter note title"></textarea>' +
    '<textarea class="cnt" name="content" placeholder="Enter note description here"></textarea>' +
    '</div> ' +
    '<button class="btn btn-secondery float-sm-end m-l-10" ><i class="fa-regular fa-floppy-disk"></i></button>' +
    '</div>'
    ;
var noteZindex = 1;
$(document).ready(function() {
    function deleteNote() {
        $(this).parent('.note').hide("puff", { percent: 133 }, 250);
    }

    
    function newNote() {
        $(noteTemp).hide().appendTo("#board").show("fade", 300).draggable().on('dragstart', function () {
            $(this).zIndex(++noteZindex);
        });

        $('.remove').click(deleteNote);
        $('textarea').autogrow();

        var title = $(this).find('.title').val();
        var content = $(this).find('.cnt').val();

        $.ajax({
            url: '/addnote',
            method: 'POST',
            data: {
                title: title,
                content: content
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle success (if needed)
            },
            error: function(error) {
                // Handle error (if needed)
            }
        });

        return false;
    }

    $("#board").height($(document).height());
    $("#add_new").click(newNote);
    $('.remove').click(deleteNote);
    newNote();
});

function fetchUserNotes(user_id) {
    $.ajax({
        url: '/getusernotes/' + user_id,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.notes.length > 0) {
                response.notes.forEach(function(note) {
                    var newNote = $(noteTemp).hide().appendTo("#board").show("fade", 300).draggable().on('dragstart', function () {
                        $(this).zIndex(++noteZindex);
                    });
                    newNote.find('.title').val(note.title);
                    newNote.find('.cnt').val(note.content);
                });
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}

$(document).ready(function() {
    var user_id = '{{ auth()->user()->id }}';
    
    // Display existing notes on page load
    fetchUserNotes(user_id);
    
    // Your existing code...
});
