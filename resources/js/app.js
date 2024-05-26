import mapInitializer from './map/map-init.js';

// Default Laravel bootstrapper
import './bootstrap';

// Added: Actual Bootstrap JavaScript dependency
import 'bootstrap';

// Added: Popper.js dependency for popover support in Bootstrap
import '@popperjs/core';

import i18next from "@/utils/i18next.js";

mapInitializer.init();
