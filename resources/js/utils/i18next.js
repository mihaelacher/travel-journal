import i18next from 'i18next';
import XHR from 'i18next-http-backend';

i18next
    .use(XHR)
    .init({
        lng: 'en', // Default language
        fallbackLng: 'en',
        debug: true,
        interpolation: {
            escapeValue: false,
        },
        backend: {
            loadPath: '/{{ns}}/{{lng}}.json',
        },
    });

export default i18next;
