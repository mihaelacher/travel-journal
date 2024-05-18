import lazySizes from 'lazysizes';

export function lazySizeUnveil(images) {
    for (let i = 0; i < images.length; i++) {
        window.lazySizes.loader.unveil(images[i]);
    }
}


