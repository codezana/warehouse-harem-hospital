@extends('layouts.nav')

@section('name', 'Sticky Note')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/stickynote/sticky.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <style>
        .note {
            position: relative;
            transition: transform 0.2s;
        }


        .note {
            /* Your existing styles... */
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
            /* Add this line */
        }


        .deleted {
            opacity: 0;

            transition: all 0.5s ease-in-out;
            /* Add this line */
            transform: scaleY(0);
        }
    </style>

    <div class="page-wrapper page-wrapper-one cardhead">
        <div class="content ">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Sticky Note 📓</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item ">Write your Note {{ Auth::user()->username }}✍️</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">

                @if (session('result'))
                    <div class="alert alert-success">{{ session('success') }} <i class='bx bx-cool'></i></div>
                @endif
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title">Sticky Note 📓 
                                <a class="btn btn-primary float-sm-end m-l-10" style="font-family: 'Times New Roman', Times, serif" id="add_new_note" href="javascript:;">Add New Note</a>
                            </h5>
                        </div>
                        
                        <div class="card-body">
                            <div class="sticky-note" id="board">
                                @foreach ($notes as $note)
                                    <div class="note" data-note-id="{{ $note->id }}">
                                        <a href="javascript:;" class="button remove">X</a>
                                        <div class="note_cnt">
                                            <textarea class="title" name="titles[]" placeholder="Enter note title">{{ $note->title }}</textarea>
                                            <textarea class="cnt" name="contents[]" placeholder="Enter note description here">{{ $note->content }}</textarea>
                                            <button type="button" class="btn btn-success edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        



                            <form action="{{ route('addnote.store') }}" method="POST" enctype="multipart/form-data"
                                style="display: inline">
                                @csrf
                                <!-- Textarea for note title and content -->
                                <div class="note" style="display: none;">
                                    <a href="javascript:;" class="button remove">X</a>
                                    <div class="note_cnt">
                                        <textarea class="title" name="title" placeholder="Enter note title"></textarea>
                                        <textarea class="cnt" name="content" placeholder="Enter note description here"></textarea>

                                        <button class="btn btn-primary "><i class="fa-regular fa-floppy-disk"></i> </button>

                                    </div>
                                </div>
                                <div class="sticky-note" id="board"></div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('custom-js')



    <script>
        const notes = document.querySelectorAll('.note');

        document.addEventListener('DOMContentLoaded', function() {
            const board = document.getElementById('board');

            // Check if there are no notes present
            if (board.childElementCount === 0) {
                // Trigger the click event on the "Add New Note" button
                document.getElementById('add_new_note').click();
            }
        });


        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove')) {
                const note = event.target.closest('.note');
                const noteId = parseInt(note.getAttribute('data-note-id'));
                const board = document.getElementById('board');
                const notes = board.querySelectorAll('.note');

                // Remove the note with animation
                note.classList.add('deleted');
                setTimeout(function() {
                    note.remove();
                }, 300); // Wait for the transition to complete (300ms in this example)

                // Update the data-note-id attributes of remaining notes
                notes.forEach((note, index) => {
                    if (index > noteId) {
                        note.setAttribute('data-note-id', index - 1);
                    }
                });
            }
        });
    </script>





<script>
$(document).ready(function() {
    // Function to create a new note
    function createNewNote() {
        var newNote = `
            <div class="note">
                <a href="javascript:;" class="button remove">X</a>
                <div class="note_cnt">
                    <textarea class="title" name="titles[]" placeholder="Enter note title"></textarea>
                    <textarea class="cnt" name="contents[]" placeholder="Enter note description here"></textarea>
                    <button type="button" class="btn btn-primary save"><i class="fa-regular fa-floppy-disk"></i> Save</button>
                </div>
            </div>
        `;

        $("#board").append(newNote);
    }

    // Event listener to add a new note
    $("#add_new_note").click(function() {
        createNewNote();
    });

    // Event listener to save a note
$("#board").on("click", ".btn.save", function() {
    var note = $(this).closest(".note");

    var title = note.find(".title").val();
    var content = note.find(".cnt").val();

    // Check if title or content is empty
    if (title.trim() === "" || content.trim() === "") {
        alert("Title and content cannot be empty!");
        return;
    }

    $.ajax({
        url: "{{ route('addnote.store') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            title: title,
            content: content
        },
        success: function(response) {
            console.log("Note saved successfully!");
        },
        error: function(error) {
            console.error("Error saving note:", error);
        }
    });
});



    // Event listener for the remove button
    $("#board").on("click", ".button.remove", function() {
        var note = $(this).closest(".note");
        var id = note.data("note-id");

        $.ajax({
            url: "{{ url('deletenote') }}/" + id,
            method: "DELETE",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log("Note deleted successfully!");
                note.remove();
            },
            error: function(error) {
                console.error("Error deleting note:", error);
            }
        });
    });
});
</script>


   
   
   
   {{-- automatic save title and content  --}}
   
   <script>
        $(document).ready(function() {
            // Event listener for the edit button
            $(".edit-btn").click(function() {
                var note = $(this).closest(".note");
                var title = note.find(".title").val();
                var content = note.find(".cnt").val();
                var id = note.data("note-id");

                $.ajax({
                    url: "{{ url('updatenote') }}/" +
                    id, // Assuming your route is 'updatenote/{id}'
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        title: title,
                        content: content
                    },
                    success: function(response) {
                        console.log("Note updated successfully!");
                    },
                    error: function(error) {
                        console.error("Error updating note:", error);
                    }
                });
            });

            // Event listener for title and content changes
            $(".title, .cnt").change(function() {
                var note = $(this).closest(".note");
                note.find(".edit-btn").click();
            });
        });
    </script>


    
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/plugins/stickynote/sticky.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"
        integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
