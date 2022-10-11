<div class="card shadow-line chat chat-panel" id="chat_panel">
    <div class="p-3 chat-header">
        <div class="d-flex">
            <div class="w-100 d-flex pl-0">
                <img class="rounded-circle shadow avatar-sm mr-3 chat-profile-picture"
                    src="{{ Avatar::create($user->name)->toBase64() }}">
                <div class="mr-3">
                    <a href="!#">
                        <p class="fw-400 mb-0 text-dark-75">{{ $user->name }}</p>
                    </a>
                    {{-- <i class="active_icon fa-sharp fa-solid fa-circle">Online</i> --}}

                    <span id="statusmessage{{ $user->id }}">

                        @if($user->last_seen->diffForHumans() == now() )
                        <p class="sub-caption text-muted text-small mb-0"><i class=" fa-sharp fa-solid fa-circle pr-2"
                                style="color: green"></i>Online</p>

                        @else

                        <p class="sub-caption text-muted text-small mb-0"><i class="la la-clock mr-1"></i>last seen
                            {{$user->last_seen->diffForHumans()}}</p>
                        @endif
                    </span>
                </div>
            </div>
            <div class="flex-shrink-0 margin-auto">
                <a href="#" class="btn btn-sm btn-icon btn-light active text-dark ml-2">
                    <svg viewBox="0 0 24 24" width="15" height="15" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round" class="feather">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </a>
                <a href="#" class="btn btn-sm btn-icon btn-light active text-dark ml-2">
                    <svg viewBox="0 0 24 24" width="15" height="15" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round" class="feather">
                        <polygon points="23 7 16 12 23 17 23 7"></polygon>
                        <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                    </svg>
                </a>
                <a href="#" class="btn btn-sm btn-icon btn-light active text-dark ml-2">
                    <svg viewBox="0 0 24 24" width="15" height="15" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round" class="feather">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </a>
                <a href="#" class="btn btn-sm btn-icon btn-light active text-dark ml-2">
                    <svg viewBox="0 0 24 24" width="15" height="15" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round" class="feather">
                        <circle cx="12" cy="12" r="1"></circle>
                        <circle cx="12" cy="5" r="1"></circle>
                        <circle cx="12" cy="19" r="1"></circle>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="d-flex flex-row mb-3 navigation-mobile scrollable-chat-panel chat-panel-scroll" id="scroll">
        <div class="w-100 p-3" id="appen_message">
            {{-- <div class="svg36 loader-animate3 horizontal-margin-auto mb-2"></div>
            <div class="text-center letter-space drop-shadow text-uppercase fs-12 w-100 mb-3">
                Today</div> --}}
            @foreach ($messages as $message)
            @if ($message->from_id == $user->id)
            <div class="left-chat-message fs-13 mb-2 ">
                <p class="mb-0 mr-3 pr-4 mr-5">{{ $message->body }} </p>
                <div class="message-options mt-3">
                    <div class="message-time">{{ $message->created_at->diffForHumans() }}</div>
                    <div class="message-arrow"><i class="text-muted la la-angle-down fs-17"></i></div>
                </div>
            </div>
            @endif
            @if ($message->from_id == auth()->id())
            <div class="d-flex flex-row-reverse mb-2">
                <div class="right-chat-message fs-13 mb-2 ">
                    <div class="mb-0 mr-3 pr-4 mr-5">
                        <div class="d-flex flex-row">
                            <div class="pr-2">{{ $message->body }}</div>
                            <div class="pr-4"></div>
                        </div>
                    </div>
                    <div class="message-options dark mt-3">
                        <div class="message-time">
                            <div class="d-flex flex-row ">
                                <div class="mr-2 ">{{ $message->created_at->diffForHumans() }}</div>
                                <div class="svg15 double-check"></div>
                            </div>
                        </div>
                        <div class="message-arrow"><i class="text-muted la la-angle-down fs-17"></i></div>
                    </div>
                </div>
            </div>
            @endif
            
            {{-- <div class="left-chat-message fs-13 mb-2 ">
                <p class="mb-0 mr-3 ">Typing... </p>
            </div> --}}
            @endforeach
            {{-- <div id="new_text">
            </div>
            <div id="client-typing">
            </div> --}}
        </div>
    </div>
    <div class="chat-search {{ ($messages->count() == 0) ? 'fix': '' }} pl-3 pr-3 ">
        <form action="{{ route('SendMessage') }}" method="POST" id="SendTextForm">
            @csrf
            <input type="hidden" name="to_id" value="{{ $user->id }}">
            <div class="input-group">
                <input type="text" id="body" name="body" class="form-control" placeholder="Write a message">
                <div class="input-group-append prepend-white">
                    <span class="input-group-text pl-2 pr-2">
                        <i class="chat-upload-trigger fs-19 bi bi-file-earmark-plus ml-2 mr-2"></i>
                        <i class="fs-19 bi bi-emoji-smile ml-2 mr-2"></i>
                        <i class="fs-19 bi bi-camera ml-2 mr-2"></i>
                        <button type="submit" id="submit" class="btn btn-regular" data-id="{{ $user->id }}">
                            <i class="fs-19 bi bi-cursor ml-2 mr-2"></i>
                        </button>
                        <div class="chat-upload">
                            <div class="d-flex flex-column">
                                <div class="p-2">
                                    <button type="button"
                                        class="btn btn-secondary btn-md btn-icon btn-circle btn-blushing">
                                        <i class="fs-15 bi bi-camera"></i>
                                    </button>
                                </div>
                                <div class="p-2">
                                    <button type="button"
                                        class="btn btn-success btn-md btn-icon btn-circle btn-blushing">
                                        <i class="fs-15 bi bi-file-earmark-plus"></i>
                                    </button>
                                </div>
                                <div class="p-2">
                                    <button type="button"
                                        class="btn btn-warning btn-md btn-icon btn-circle btn-blushing">
                                        <i class="fs-15 bi bi-person"></i>
                                    </button>
                                </div>
                                <div class="p-2">
                                    <button type="button"
                                        class="btn btn-danger btn-md btn-icon btn-circle btn-blushing">
                                        <i class="fs-15 bi bi-card-image"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>