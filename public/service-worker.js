// importScripts("https://js.pusher.com/beams/service-worker.js");
var CACHE_VERSION = 'app-v3';
var CACHE_FILES = [
    // '/',
    // 'js/app.js',
    // 'css/app.css'
];
self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_VERSION)
        .then(function(cache) {
            console.log('Opened cache');
            return cache.addAll(CACHE_FILES);
        })
    );
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        // // Try the cache
        // caches.match(event.request).then(function(response) {
        //     // Fall back to network
        //     return response || fetch(event.request);
        // }).catch(function() {
        //     // If both fail, show a generic fallback:
        //     return caches.match('/offline.html');
        //     // However, in reality you'd have many different
        //     // fallbacks, depending on URL & headers.
        //     // Eg, a fallback silhouette image for avatars.
        // })
    );
});