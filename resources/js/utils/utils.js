const utils = {
    initDatePickers: function() {
        $('.datepicker').datepicker();
    },

    showToastMessage: function(message, classes) {
        classes = 'rounded white-text z-depth-1 ' + classes;
        M.toast({html: message, classes: classes});
    },

    showErrorMessage: function(message) {
        this.showToastMessage(message, 'red');
    },

    showWarningMessage: function(message) {
        this.showToastMessage(message, 'orange darken-3');
    },

    showSuccessMessage: function(message) {
        this.showToastMessage(message, 'green lighten-2');
    },

    onPageLoadShowToastSessionMessage: function() {
        const msgBox = $('#sessionErrorList');

        if (msgBox.length) {
            const text = msgBox.text();
            const errors = text.split(',');
            errors.forEach(error => {
                this.showErrorMessage(error);
            });
        }
    },

    showLoader: function() {
        $('.loader-container').show();
    },

    hideLoader: function() {
        $('.loader-container').hide();
    },

    attachFilesToForm: async function(photoUrls) {
        const fileInput = $('#place_photos');
        const dataTransfer = new DataTransfer();

        for (let i = 0; i < photoUrls.length; i++) {
            const imgBlob = await this.fetchImageData(photoUrls[i]);
            const file = new File([imgBlob], photoUrls[i], {
                type: 'image/png',
                lastModified: new Date(),
            });
            dataTransfer.items.add(file);
        }

        fileInput.files = dataTransfer.files;
        $(fileInput).trigger('change');
    },

    fetchImageData: async function(url) {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Failed to fetch image');
        }
        return await response.blob();
    },

    handleError: function(xhr, status, error) {
        utils.hideLoader();
        utils.showErrorMessage('Something went wrong! Please, try again later.');
    },

    parseLocation: function (longitude, latitude) {
        const parsedLocation = {};
        parsedLocation.lat = parseFloat(latitude);
        parsedLocation.lng = parseFloat(longitude);

        return parsedLocation;
    }
};

export default utils;
