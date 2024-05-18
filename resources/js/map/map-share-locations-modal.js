import utils from "@/utils/utils.js";
import LocationsBuilder from "@/builders/locations-builder.js";

const mapShareLocationsModal = {
    fetchModal(map) {
        utils.showLoader();
        $.ajax({
            method: 'GET',
            url: '/ajax/fetchShareLocationsModal',
            contentType: 'application/json',
            success: async function (data) {
                try {
                    await this.initModal(data, map);
                    this.fetchShareLocationsButton(map);
                    this.attachModalButtonHandlers(map);
                    utils.hideLoader();
                } catch (error) {
                    utils.handleError(null, null, error);
                }
            }.bind(this),
            error: utils.handleError
        });
    },

    async initModal(data, map) {
        try {
            $('#map').append(data);
            return M.Modal.init($('#share-locations-modal'));
        } catch (error) {
            utils.showErrorMessage('Something went wrong! Please, try again later.');
            throw error;
        }
    },

    fetchShareLocationsButton(map) {
        $.ajax({
            method: 'GET',
            url: '/ajax/fetchShareLocationsButton',
            contentType: 'application/json',
            success: function (response) {
                const container = document.createElement('div');
                container.innerHTML = response;
                map.controls[google.maps.ControlPosition.TOP_RIGHT].push(container);

                const modalInstance = M.Modal.getInstance($('#share-locations-modal'));
                $('.shareLocationsBtn').click(() => modalInstance.open());
            },
            error: utils.handleError
        });
    },

    attachModalButtonHandlers: (map) => {
        $('.show-locations').off().on('click', function () {
            mapShareLocationsModal.handleShowLocations(this, map);
        });
        $('.hide-locations').off().on('click', function () {
            mapShareLocationsModal.handleHideLocations(this, map);
        });
        $('.share-locations').off().on('click', function () {
            mapShareLocationsModal.handleShareLocations(this);
        });
    },

    handleShowLocations: function ($this, map) {
        const collectionItem = $($this).closest('.collection-item');
        const userId = collectionItem.find('#user-id').val();
        const locationsBuilder = new LocationsBuilder(map);
        locationsBuilder.fetchLocations('fetchUserVisitedSharedLocations', { 'user_id': userId });
        $($this).hide();
        collectionItem.find('.hide-locations').show();
    },

    handleHideLocations($this, map) {
        const collectionItem = $($this).closest('.collection-item');
        const userId = collectionItem.find('#user-id').val();
        const userEmail = collectionItem.find('#user-email').val();
        const locationsBuilder = new LocationsBuilder(map);

        locationsBuilder.removeMapMarkersByKey(`${userId}_${userEmail}`);
        $($this).hide();
        collectionItem.find('.show-locations').show();
    },

    handleShareLocations($this) {
        const collectionItem = $($this).closest('.collection-item');
        const csrfToken = collectionItem.find('input[name="_token"]').val();
        $.ajax({
            method: 'POST',
            url: '/ajax/shareLocationsWithUser',
            data: { user_id: collectionItem.find('#user-id').val() },
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function (response) {
                utils.hideLoader();
                utils.showSuccessMessage(response.message);
                $($this).hide();
            },
            error: utils.handleError
        });
    },
};

export default mapShareLocationsModal;
