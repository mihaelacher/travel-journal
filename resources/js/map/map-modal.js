import utils from "@/utils/utils.js";
import { lazySizeUnveil } from "@/utils/lazy-size-initializer.js";

const mapModal = {
    fetchModal(place) {
        utils.showLoader();
        $.ajax({
            method: 'GET',
            url: '/ajax/location-modal/' + place.location_id,
            contentType: 'application/json',
            data: {
                photo_urls: JSON.stringify(place.photo_urls),
                name: place.name,
                location: utils.parseLocation(place.longitude, place.latitude),
                visited_at: place.visited_at,
                user_id: place.user_id,
                is_shared: place.is_shared,
            },
            success: async (data) => {
                await this.initModal(data, place);
                utils.hideLoader();
            },
            error: utils.handleError
        });
    },

    initModalFormSubmitHandler() {
        $('#place-visited-form').submit((e) => {
            utils.showLoader();
            e.preventDefault();

            this.handleFormSubmission();
        });
    },

    handleFormSubmission() {
        const formData = new FormData($('#place-visited-form')[0]);
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const images = $('#place_photos').prop('files');

        for (let i = 0; i <= images.length; i++) {
            formData.append('uploaded_files[]', images[i]);
        }

        $.ajax({
            type: 'POST',
            url: '/ajax/location/' + formData.get('latitude') + '/' + formData.get('longitude') + '/mark-as-visited',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: (response) => {
                $('#location-modal').modal('hide');
                utils.hideLoader();
            },
            error: utils.handleError
        });
    },

    async initModal(data, place) {
        await $('#map').append(data);
        lazySizeUnveil($('#modal .carousel.carousel-slider.center').find('img.lazyload'));
        const modalElement = $('#location-modal');

        M.Modal.init(
            modalElement,
            {
                onCloseEnd: () => {
                    this.detachModalFormHandlers();
                    modalElement.remove();
                }
            });

        $('.carousel').carousel({ fullWidth: true, indicators: true });
        utils.initDatePickers();
        this.initModalFormSubmitHandler();

        if (place.visited_at) {
            await utils.attachFilesToForm(place.photo_urls);
            this.deleteVisitedLocationHandler();
        }

        M.Modal.getInstance(modalElement).open();
    },

    detachModalFormHandlers() {
        $('#place-visited-form').off();
    },

    deleteVisitedLocationHandler() {
        $('#delete-location-btn').click(function (e) {
            e.preventDefault();

            const locationId = $('#location_id').val();
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            this.deleteVisitedLocation(locationId, csrfToken)
        }.bind(this));
    },

    deleteVisitedLocation(locationId, csrfToken) {
        $.ajax({
            type: 'DELETE',
            url: '/ajax/visited-locations/' + locationId,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: (response) => {
                $('#location-modal').modal('hide');
                utils.hideLoader();
            },
            error: utils.handleError
        });
    }
};

export default mapModal;
