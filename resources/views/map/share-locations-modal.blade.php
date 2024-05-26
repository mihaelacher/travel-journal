<div id="share-locations-modal" class="modal bottom-sheet">
    <div class="card-content">
        <h5>{{ trans('map.users_shared_locations') }}</h5>
        <ul class="collection">
            @forelse($userSharedLocationsUsers as $user)
                <x-collection-item :user="$user" share="{{! isset($userShareLocationsWithUsers[$user['id']])}}"/>
            @empty
                <p>{{ trans('map.nothing') }}</p>
            @endforelse
        </ul>
    </div>
    <div class="card-content">
        <h5>{{ trans('map.shared_locations_with_user') }}</h5>
        <ul class="collection">
            @forelse($userShareLocationsWithUsers as $user)
                <x-collection-item :user="$user" share="{{false}}" show="{{false}}"/>
            @empty
                <p>nothing</p>
            @endforelse
        </ul>
    </div>
</div>
