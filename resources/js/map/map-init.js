import utils from "@/utils/utils.js";
import mapShareLocationsModal from "@/map/map-share-locations-modal.js";
import LocationsBuilder from "@/builders/locations-builder.js";
import i18next from "i18next";

const mapInitializer = {
    async init() {
        try {
            utils.showLoader();
            let locationObj = undefined;

            try {
                locationObj = await this.getCurrentGeoLocation();
            } catch (e) {
                console.warn(i18next.t('logging.geo_location_access_error'));
                locationObj = this.getRandomLocation();
            }

            const map = await this.create(locationObj)

            const locationsBuilder = new LocationsBuilder(map);
            locationsBuilder.fetchLocations('visited-locations');
            this.attachEventListeners(map, locationsBuilder)

            utils.hideLoader();

            mapShareLocationsModal.fetchModal(map);
        } catch (error) {
            console.error(i18next.t('logging.error_initializing_map'), error);
        }
    },

    async getCurrentGeoLocation() {
        return new Promise((resolve, reject) => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => resolve(this.showUserLocation(position)),
                    (error) => reject(this.handleCurrentLocationError(error))
                );
            } else {
                resolve(this.getRandomLocation());
            }
        });
    },

    showUserLocation(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        return {lat: latitude, lng: longitude};
    },

    handleCurrentLocationError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                utils.showWarningMessage(i18next.t('logging.geolocation_request_denied_warn'))
                break;
            case error.POSITION_UNAVAILABLE:
                utils.showWarningMessage(i18next.t('logging.location_info_unavailable_warn'));
                break;
            case error.TIMEOUT:
            case error.UNKNOWN_ERR:
            default:
                utils.showErrorMessage(i18next.t('logging.location_error'));
                break;
        }
    },

    getRandomLocation() {
        // Generate random latitude between -90 and 90
        const latitude = Math.random() * (90 - (-90)) + (-90);

        // Generate random longitude between -180 and 180
        const longitude = Math.random() * (180 - (-180)) + (-180);

        return {lat: latitude, lng: longitude};
    },

    async create(location) {
        const {Map} = await google.maps.importLibrary("maps");
        return new Map(document.getElementById("map"), {
            center: location,
            zoom: 8,
            mapId: "ab1e8c59a2a4db56",
        });
    },

    attachEventListeners(map, locationsBuilder) {
        map.addListener("dblclick", (event) => {
            const clickedLocation = {
                lat: event.latLng.lat(),
                lng: event.latLng.lng()
            };
            locationsBuilder.fetchLocations(
                'nearby-locations',
                {clickedLocation: JSON.stringify(clickedLocation)}
            );
        });
    },
}

export default mapInitializer;
