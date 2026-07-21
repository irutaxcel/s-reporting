'use strict';

const CACHE_VERSION = 'satraco-pwa-v1';

const STATIC_CACHE = `${CACHE_VERSION}-static`;
const DYNAMIC_CACHE = `${CACHE_VERSION}-dynamic`;

const OFFLINE_URL = '/offline.html';

const STATIC_FILES = [
    '/',
    '/offline.html',
    '/manifest.json',

    '/assets/pwa/icons/icon-192x192.png',
    '/assets/pwa/icons/icon-512x512.png',

    /*
     * Ajoute ici seulement les fichiers CSS et JS
     * qui existent réellement dans ton projet.
     */

    // '/assets/dist/css/adminlte.min.css',
    // '/assets/plugins/jquery/jquery.min.js',
    // '/assets/plugins/bootstrap/js/bootstrap.bundle.min.js',
    // '/assets/dist/js/adminlte.min.js'
];

/*
|--------------------------------------------------------------------------
| Installation
|--------------------------------------------------------------------------
*/

self.addEventListener('install', event => {

    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then(cache => cache.addAll(STATIC_FILES))
            .then(() => self.skipWaiting())
    );

});

/*
|--------------------------------------------------------------------------
| Activation
|--------------------------------------------------------------------------
*/

self.addEventListener('activate', event => {

    event.waitUntil(
        caches.keys().then(cacheNames => {

            return Promise.all(
                cacheNames
                    .filter(cacheName => {
                        return cacheName.startsWith('satraco-pwa-') &&
                            cacheName !== STATIC_CACHE &&
                            cacheName !== DYNAMIC_CACHE;
                    })
                    .map(cacheName => caches.delete(cacheName))
            );

        }).then(() => self.clients.claim())
    );

});

/*
|--------------------------------------------------------------------------
| Requêtes réseau
|--------------------------------------------------------------------------
*/

self.addEventListener('fetch', event => {

    const request = event.request;

    if (request.method !== 'GET') {
        return;
    }

    const requestUrl = new URL(request.url);

    /*
     * Ne pas intercepter les ressources externes.
     */
    if (requestUrl.origin !== self.location.origin) {
        return;
    }

    /*
     * Pour les pages HTML :
     * priorité au réseau.
     *
     * C'est important pour une application de gestion,
     * afin d'éviter d'afficher d'anciennes données.
     */
    if (request.mode === 'navigate') {

        event.respondWith(
            fetch(request)
                .then(response => {

                    const responseClone = response.clone();

                    caches.open(DYNAMIC_CACHE)
                        .then(cache => {
                            cache.put(request, responseClone);
                        });

                    return response;
                })
                .catch(async () => {

                    const cachedPage = await caches.match(request);

                    if (cachedPage) {
                        return cachedPage;
                    }

                    return caches.match(OFFLINE_URL);
                })
        );

        return;
    }

    /*
     * Pour les fichiers CSS, JS, images et polices :
     * priorité au cache, puis récupération sur le réseau.
     */
    event.respondWith(
        caches.match(request)
            .then(cachedResponse => {

                if (cachedResponse) {
                    return cachedResponse;
                }

                return fetch(request)
                    .then(networkResponse => {

                        if (
                            !networkResponse ||
                            networkResponse.status !== 200 ||
                            networkResponse.type !== 'basic'
                        ) {
                            return networkResponse;
                        }

                        const responseClone = networkResponse.clone();

                        caches.open(DYNAMIC_CACHE)
                            .then(cache => {
                                cache.put(request, responseClone);
                            });

                        return networkResponse;
                    });
            })
    );

});