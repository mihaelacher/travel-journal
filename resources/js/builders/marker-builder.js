import mapModal from "../map/map-modal.js";
import utils from "@/utils/utils.js";

class MarkerBuilder {
    constructor(map, AdvancedMarkerElement, PinElement) {
        if (MarkerBuilder.instance) {
            return MarkerBuilder.instance;
        }

        this.map = map;
        this.AdvancedMarkerElement = AdvancedMarkerElement;
        this.PinElement = PinElement;
        MarkerBuilder.instance = this;
        return this;
    }

    buildMarker = (place) => {
        const pinElement = new this.PinElement({
            glyph: new URL(place.icon),
            scale: 1.5,
            background: place.is_visited ? "#046e1f" : "#8ab4f8",
            borderColor: place.is_visited ? "#046e1f" : "#e8ecf2",
        });

        const marker = new this.AdvancedMarkerElement({
            map: this.map,
            position: utils.parseLocation(place.longitude, place.latitude),
            title: place.name,
            content: pinElement.element,
        });

        marker.addListener("click", async () => {
            mapModal.fetchModal(place);
        });

        return marker;
    }
}

export default MarkerBuilder;
