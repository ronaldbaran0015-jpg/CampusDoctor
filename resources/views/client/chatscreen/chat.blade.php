@extends('layouts.include.dark')
@section('content')
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Chat With Doctor</title>
<!-- Linking Google fonts for icons -->
<link rel="stylesheet" href="{{asset('assets/font/css/all.css')}}" />
<link rel="stylesheet" href="{{asset('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('boxicons-master/css/boxicons.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/chat.css')}}" />
<meta name="csrf-token" content="{{ csrf_token() }}">



<style>
    /* Add this to your CSS */
    .toggle-icons {
        display: none;
        padding-right: 6px;
        align-items: center;
    }

    .toggle-icons button {
        height: 35px;
        width: 35px;
        border: none;
        cursor: pointer;
        color: #407ef8;
        border-radius: 50%;
        font-size: 1.15rem;
        background: none;
        transition: 0.2s ease;
    }

    .message-menu {
        position: absolute;
        top: 30px;
        right: 10px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 6px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 100;
        min-width: 100px;
    }

    .message-menu button {
        width: 100%;
        padding: 8px 12px;
        background: none;
        border: none;
        text-align: left;
        cursor: pointer;
    }

    .message-menu button:hover {
        background-color: #f5f5f5;
    }
</style>
</head>

<body>
    <!-- Chatbot Toggler -->
    <!-- <button id="chatbot-toggler">
    <span><i class="fa fa-envelope"></i></span>
    <span><i class="fa fa-times"></i></span>
  </button> -->
    <button id="darkSwitch" class="dark-mode-delegate" style="display: none;"></button>

    <div class="chatbot-popup">
        <!-- Chatbot Header -->
        <div class="chat-header">
            <div class="header-info">
                @if (!$sender->image)
                <img src="{{asset('assets/svg/doctor-svgrepo-com.svg')}}" alt="doctor-logo" class="chatbot-logo">
                @else
                <img src="{{asset('uploads/doctors/'. $sender->image)}}" alt="doctor-logo" class="chatbot-logo">
                @endif
                <h2 class="logo-text">Dr. {{$sender->name}}</h2>
            </div>
            <div class="px-2">
                <a href="javascript:history.back()" id="close-chatbot"><i class="fa fa-chevron-down"></i></a>
            </div>
        </div>
        <!-- Chatbot Body -->
        <div class="chat-body">
            <div class="message bot-message">
                <!-- prettier-ignore -->
                @if (!$sender->image)
                <img src="{{asset('assets/svg/doctor-svgrepo-com.svg')}}" alt="doc-avatar" class="bot-avatar">

                @else
                <img src="{{asset('uploads/doctors/'. $sender->image)}}" alt="doc-avatar" class="bot-avatar">
                @endif
                <div class="message-text" style="width:auto; max-width: 75%;"> Hey there <br /> How can I help you today? </div>
            </div>
            @if($messages)
            @foreach($messages as $message)
            @if($message->sender_id == Auth::guard('patient')->user()->pid && $message->sender_type =='patient')
            <div class="message user-message position-relative px-3">
                <i class="fa fa-ellipsis-v fs-5 p-2 position-absolute top-50 end-0 translate-middle-y message-menu-btn"
                    data-message-id="{{ $message->id }}"></i>
                <div class="message-menu d-none">
                    <button class="dropdown-item edit-message" data-id="{{ $message->id }}"><i class="fa fa-edit"></i> Edit</button>
                    <button class="dropdown-item delete-message" data-id="{{ $message->id }}"><i class="fa fa-trash"></i> Delete</button>
                </div>
                <p class="message-text" data-message-id="{{ $message->id }}" style="width:auto; max-width:75%;">{{ $message->message }}</p>
            </div>
            @else

            <div class="message bot-message">
                <!-- prettier-ignore -->
                @if (!$sender->image)
                <img src="{{asset('assets/svg/doctor-svgrepo-com.svg')}}" alt="doc-avatar" class="bot-avatar">

                @else
                <img src="{{asset('uploads/doctors/'. $sender->image)}}" alt="doc-avatar" class="bot-avatar">
                @endif
                <div class="message-text" style="width:auto; max-width: 75%;">{{ $message->message }} </div>
            </div>
            @endif
            @endforeach
            @endif

        </div>
        <!-- Chatbot Footer -->
        <div class="chat-footer">
            <form action="" method="post" class="chat-form">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $receiver_id }}">

                <div class="left-controls" id="left-controls">
                    <div class="file-card">
                        <div class="file-header">
                            <button type="button"><i class="fa fa-plus-circle" id="menuBtn"></i></button>
                        </div>
                        <div class="menu" id="menu">
                            <button type="button" id="mic-button"><i class="fa fa-microphone icon-sm"></i><small>Speech</small></button>
                            <button type="button"><i class="fa fa-paperclip icon-sm"></i><small>Files</small></button>
                            <button type="button" id="read-aloud-btn"><i class="fa fa-volume-up icon-sm"></i><small>Read</small></small></button>
                        </div>
                    </div>
                    <div class="file-upload-wrapper">
                        <input type="file" accept="image/*" id="file-input" hidden />
                        <img src="#" />
                        <button type="button" id="file-upload"><i class="fa fa-image"></i></button>
                        <button type="button" id="file-cancel"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="toggle-icons" id="toggle-icons">
                    <button type="button"><i class="fa fa-arrow-left"></i></button>
                </div>
                <textarea placeholder="Message..." name="message" class="message-input" id="message-input" required></textarea>
                <div class="chat-controls">
                    <!-- <button type="button" id="emoji-picker" class="material-symbols-outlined"><i class="fa fa-smile-wink"></i></button> -->
                    <button type="button" id="send-message">
                        <i class="fa fa-arrow-circle-up"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Edit Message Modal -->
    <div class="modal fade" id="editMessageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="editMessageId">
                    <textarea class="form-control" id="editMessageText" rows="4"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveEdit">Save</button>
                </div>
            </div>
        </div>
    </div>


    <script src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>
    <!-- Linking custom script -->
    <!-- <script src="{{asset('assets/js/chat.js')}}"></script> -->

    <script src="{{asset('assets/js/mic.js')}}"></script>
    <script>
        // AUTO SCROLL FUNCTION
        function scrollToBottom() {
            let chatBody = $('.chat-body');
            chatBody.scrollTop(chatBody[0].scrollHeight);
        }

        // SCROLL TO BOTTOM ON PAGE LOAD (after messages are printed)
        $(document).ready(function() {
            setTimeout(scrollToBottom, 100);
        });

        // AUTO-SCROLL ONLY IF USER IS ALREADY AT BOTTOM
        let autoScroll = true;

        $('.chat-body').on('scroll', function() {
            let chatBody = $(this);
            let distanceFromBottom = chatBody[0].scrollHeight - chatBody.scrollTop() - chatBody.innerHeight();

            // If user scrolls up, disable auto scroll
            autoScroll = distanceFromBottom < 50;
        });

        // WHEN SENDING A MESSAGE → ALWAYS SCROLL DOWN
        $('#send-message').on('click', function() {
            setTimeout(scrollToBottom, 150);
        });

        // WHEN REFRESHING MESSAGES (GET AJAX) → ONLY SCROLL IF autoScroll IS TRUE
        function refreshMessagesUI() {
            if (autoScroll) {
                scrollToBottom();
            }
        }
        $(document).ready(function() {
            var receiver_id = $('input[name="receiver_id"]').val();
            getMessages(receiver_id);

            $('#send-message').on('click', function() {
                var receiver_id = $('input[name="receiver_id"]').val();
                var message = $('#message-input').val();
                $.ajax({
                    type: 'POST',
                    url: '/send-message',
                    data: {
                        receiver_id: receiver_id,
                        message: message,
                        _token: $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        console.log(response);
                        $('#message-input').val('');
                        var html = '<div class="message user-message position-relative p-2"><i class="fa fa-ellipsis-v fs-5 position-absolute top-50 end-0 translate-middle-y ms-5 message-menu-btn data-message-id="{{ $message->id }}"></i><p class="message-text" style="width:auto; max-width: 75%;" data-message-id="{{ $message->id }}">' + message + '</p><div class="message-menu d-none"><button class="dropdown-item edit-message" data-id="{{ $message->id }}">Edit</button><button class="dropdown-item delete-message" data-id="{{ $message->id }}">Delete</button></div></div>';
                        $('.chat-body').append(html);
                    }
                });
            });
        });

        function getMessages(receiver_id) {
            $.ajax({
                type: 'GET',
                url: '/get-messages/' + receiver_id,
                success: function(response) {
                    console.log(response);
                    // Append messages to chat body
                    refreshMessagesUI();

                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Handle all clicks inside the chat using event delegation
            document.addEventListener('click', function(e) {

                // ----- 1. Toggle message menu -----
                if (e.target.classList.contains('message-menu-btn')) {
                    e.stopPropagation();

                    // Close other menus
                    document.querySelectorAll('.message-menu').forEach(menu => {
                        menu.classList.add('d-none');
                    });

                    // Toggle clicked menu
                    const menu = e.target.nextElementSibling;
                    menu.classList.toggle('d-none');
                    return;
                }

                // ----- 2. Edit message -----
                if (e.target.closest('.edit-message')) {
                    const btn = e.target.closest('.edit-message');
                    const messageId = btn.dataset.id;

                    const messageEl = document.querySelector(
                        `.message-text[data-message-id="${messageId}"]`
                    );

                    // Fill modal fields
                    document.getElementById('editMessageId').value = messageId;
                    document.getElementById('editMessageText').value = messageEl.innerText;

                    // Show modal
                    new bootstrap.Modal(document.getElementById('editMessageModal')).show();
                    return;
                }

                // ----- 3. Delete message -----
                if (e.target.closest('.delete-message')) {
                    const btn = e.target.closest('.delete-message');
                    const messageId = btn.dataset.id;

                    if (!confirm('Delete this message?')) return;

                    fetch(`/messages/${messageId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => {
                            if (!res.ok) throw new Error('Request failed');
                            return res.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Remove message from DOM
                                const messageEl = btn.closest('.message');
                                if (messageEl) messageEl.remove();
                            } else {
                                alert(data.error || 'Delete failed');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Something went wrong');
                        });
                    return;
                }

                // ----- 4. Close menus when clicking outside -----
                document.querySelectorAll('.message-menu').forEach(menu => {
                    menu.classList.add('d-none');
                });
            });

            // ----- 5. Save edited message -----
            document.getElementById('saveEdit').addEventListener('click', function() {
                const messageId = document.getElementById('editMessageId').value;
                const messageText = document.getElementById('editMessageText').value.trim();

                if (!messageText) {
                    alert('Message cannot be empty');
                    return;
                }

                fetch(`/messages/${messageId}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            message: messageText
                        })
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Request failed');
                        return res.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Update message text in chat
                            document.querySelector(
                                `.message-text[data-message-id="${messageId}"]`
                            ).innerText = data.message;

                            // Hide modal
                            bootstrap.Modal.getInstance(
                                document.getElementById('editMessageModal')
                            ).hide();
                        } else {
                            alert(data.error || 'Update failed');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Something went wrong');
                    });
            });

        });
    </script>

</body>
@endsection