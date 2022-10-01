
@foreach ($users as $user)
<div class="chat-item  d-flex pl-3 pr-0 pt-3 pb-3" data-id="{{ $user->id }}" id="userID{{ $user->id }}">
    <div class="w-100">
        <div class="d-flex pl-0">
            <img class="rounded-circle avatar-sm mr-3" src="{{ Avatar::create($user->name)->toBase64() }}">
            <div>
                <span id="status{{ $user->id }}">
                    @if($user->last_seen->diffForHumans()  != now())
                        
                    <i class="active_icon fa-sharp fa-solid fa-circle">{{ $user->last_seen->diffForHumans() }}</i>
                    
                    @else

                    <i class="active_icon fa-sharp fa-solid fa-circle">active now</i>
                    @endif
                </span>
                    <p class="name margin-auto fw-400 text-dark-75">{{ $user->name }}</p>

                <div class="d-flex flex-row mt-1">
                    <span>
                        {{-- <div class="svg15 double-check-blue"></div> --}}
                        {{-- <i class="fa-solid fa-period"></i>
                        <i class="fa-sharp fa-solid fa-circle" style="color:green;font-size:12px"></i> --}}
                    </span>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="flex-shrink-0 margin-auto pl-2 pr-3">
        <div class="d-flex flex-column">
            <p class="text-muted text-right fs-13 mb-2">1.9.2021</p>
        </div>
    </div> --}}
</div>


@endforeach