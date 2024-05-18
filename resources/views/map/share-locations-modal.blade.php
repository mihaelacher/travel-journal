<div id="share-locations-modal" class="modal bottom-sheet">
    <div class="card-content">
        <h5>Users Shared Locations</h5>
        <ul class="collection">
            @forelse($userSharedLocationsUsers as $user)
                <x-collection-item :user="$user" share="{{! isset($userShareLocationsWithUsers[$user['id']])}}"/>
            @empty
                <p>nothing</p>
            @endforelse
        </ul>
    </div>
    <div class="card-content">
        <h5>Shared Location With Users</h5>
        <ul class="collection">
            @forelse($userShareLocationsWithUsers as $user)
                <x-collection-item :user="$user" share="{{false}}" show="{{false}}"/>
            @empty
                <p>nothing</p>
            @endforelse
        </ul>
    </div>
</div>
