@forelse ($users as $user)
<a class="list-group-item media" href="{{ route('ChatFetchUserview',$user->slug) }}">
    <div class="pull-left">
        <img src="{{ Avatar::create($user->name)->toBase64()  }}" alt="{{ $user->name }}" class="img-avatar">
    </div>
    <div class="media-body">
        <small class="list-group-item-heading">{{ $user->name }}
            <span id="status{{ $user->id }}" class="status offline"><i class="fa fa-circle"></i></span>
        </small>
    </div>
</a>
@empty
No User Found
@endforelse