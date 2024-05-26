<div class="card modal" id="location-modal">
    <div class="card-image waves-effect waves-block waves-light">
        <div class="carousel carousel-slider center">
            @foreach($photoUrls as $index => $photoUrl)
                <a class="carousel-item">
                    <img data-src={{$photoUrl}} alt="{{'Photo ' . ($index + 1)}}" class="lazyload" width="600"
                         height="400">
                </a>
            @endforeach
        </div>
    </div>
    <div class="card-content">
        <span class="card-title activator grey-text text-darken-4">{{$name}}<i
                class="material-icons medium right">arrow_drop_up</i></span>
    </div>
    @if(! $isShared)
        <div class="card-reveal center col md-8">
            <div class="container">
            <span class="card-title grey-text text-darken-4">{{trans('map.mark_place_as_visited_msg')}}<i
                    class="material-icons medium right">arrow_drop_down</i></span>
                <form id="place-visited-form" class="col md-8" enctype="multipart/form-data">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <input id="location_id" name="location_id" type="hidden" value="{{$locationId}}">
                    <input name="name" type="hidden" value="{{$name}}"/>
                    <input name="latitude" type="hidden" value="{{$latitude}}"/>
                    <input name="longitude" type="hidden" value="{{$longitude}}"/>
                    <x-forms.datepicker name="visited_at" labelText="{{ trans('map.visited_at_label') }}"
                                        value="{{$visitedAt}}"/>
                    <x-forms.file-input name="place_photos" placeholder="{{ trans('map.image_placeholder') }}"/>
                    <div class="row justify-content-center">
                        <div class="col-md-10 text-center">
                            <div class="row">
                                <button class="btn waves-effect waves-light" type="submit">
                                    Submit
                                    <i class="material-icons right">send</i>
                                </button>
                                @if(! empty($visitedAt))
                                    <button class="btn waves-effect waves-light red" id="delete-location-btn">
                                        Delete
                                        <i class="material-icons right">remove_circle</i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
