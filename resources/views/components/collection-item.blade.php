<li class="collection-item avatar hoverable">
    <input type="hidden" id="user-id" value="{{$user['id']}}">
    <input type="hidden" id="user-email" value="{{$user['email']}}">
    @if(! is_null($user['pic']))
        <img alt="{{$user['name'] . ' avatar'}}" class="circle" src="{{$user['pic']}}"/>
    @else
        <i class="material-icons circle">face</i>
    @endif
    <span class="title">Title</span>
    <p>{{$user['name']}}<br>
        {{$user['email']}}
    </p>
    <div class="secondary-content">
        <i class="show-locations material-icons small hoverable">playlist_add</i>
        <i class="hide-locations material-icons small hoverable" style="display: none">playlist_add_check</i>
        @csrf
        <i class="share-locations material-icons small hoverable" @if(! $share) style="display: none" @endif>share</i>
    </div>
</li>
