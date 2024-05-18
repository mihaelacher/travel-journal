import utils from "@/utils/utils.js";
import MarkerBuilder from "@/builders/marker-builder.js";

class LocationsBuilder {
    constructor(map) {
        if (LocationsBuilder.instance) {
            return LocationsBuilder.instance;
        }

        this.map = map;
        this.mapMarkers = {};
        this.initMarkerBuilder().catch(error => {
            console.error("Failed to initialize MarkerBuilder:", error);
        });

        LocationsBuilder.instance = this;
        return this;
    }

    initMarkerBuilder = async () => {
        try {
            const {PinElement, AdvancedMarkerElement} = await google.maps.importLibrary("marker");
            this.markerBuilder = new MarkerBuilder(this.map, AdvancedMarkerElement, PinElement);
        } catch (error) {
            throw new Error("Failed to initialize MarkerBuilder: " + error);
        }
    }

    fetchLocations = (url, params) => {
        utils.showLoader();
        $.ajax({
            method: 'GET',
            url: '/ajax/' + url,
            contentType: 'application/json',
            data: params,
            success: (response) => {
                this.displayPlaces(response.data); // Use arrow function here
                utils.hideLoader();
            },
            error: utils.handleError
        });
    }

    displayPlaces = (data) => {
        data.forEach((place) => {
            if (this.mapMarkers[place.user_key]) {
                this.mapMarkers[place.user_key].push(this.markerBuilder.buildMarker(place));
            } else {
                this.mapMarkers[place.user_key] = [this.markerBuilder.buildMarker(place)];
            }
        });
    }

    removeMapMarkersByKey = (key) => {
        const mapMarkersForRemove = this.mapMarkers[key];
        if (!mapMarkersForRemove) {
            return;
        }
        mapMarkersForRemove.forEach(marker => {
            marker.setMap(null);
        });
        this.mapMarkers[key] = [];
    }
}

export default LocationsBuilder;
