/* =========================================================
   schoolium PWA – Service Worker
   ========================================================= */

const CACHE_VERSION = "schoolium-v2.2.0";
const CACHE_NAME = `schoolium-cache-${CACHE_VERSION}`;

/* ---------------------------------------------------------
   FILES TO PRE-CACHE (STATIC ONLY)
   --------------------------------------------------------- */
const STATIC_ASSETS = [
  "/",                       // landing / welcome
  "/manifest.json",

  /* CSS */
  "/assets/css/app.css",

  /* JS */

  /* Icons */
  "/assets/icons/icon-192x192.png?v=2",
  "/assets/icons/icon-512x512.png?v=2"
];

/* =========================================================
   INSTALL – Cache core assets
   ========================================================= */
self.addEventListener("install", event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(STATIC_ASSETS))
      .then(() => self.skipWaiting())
  );
});

/* =========================================================
   ACTIVATE – Clean old caches
   ========================================================= */
self.addEventListener("activate", event => {
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(
        keys.map(key => {
          if (key !== CACHE_NAME) {
            return caches.delete(key);
          }
        })
      )
    ).then(() => self.clients.claim())
  );
});

/* =========================================================
   FETCH STRATEGY
   ---------------------------------------------------------
   - HTML pages → Network first (auth safe)
   - CSS / JS / Images → Cache first
   - API / POST → Network only
   ========================================================= */
self.addEventListener("fetch", event => {

  /* Ignore non-GET requests (POST, PUT, DELETE) */
  if (event.request.method !== "GET") {
    return;
  }

  const requestURL = new URL(event.request.url);

  /* ---- HTML / Navigation ---- */
  if (event.request.mode === "navigate") {
    event.respondWith(
      fetch(event.request)
        .then(response => {
          const copy = response.clone();
          caches.open(CACHE_NAME).then(cache => cache.put(event.request, copy));
          return response;
        })
        .catch(() => caches.match(event.request) || caches.match("/"))
    );
    return;
  }

  /* ---- Static assets (CSS, JS, images) ---- */
  if (
    requestURL.pathname.startsWith("/assets/") ||
    requestURL.hostname.includes("fonts.googleapis.com") ||
    requestURL.hostname.includes("fonts.gstatic.com")
  ) {
    event.respondWith(
      caches.match(event.request).then(cached => {
        return (
          cached ||
          fetch(event.request).then(response => {
            const copy = response.clone();
            caches.open(CACHE_NAME).then(cache => cache.put(event.request, copy));
            return response;
          })
        );
      })
    );
    return;
  }

  /* ---- Default: Network first ---- */
  event.respondWith(
    fetch(event.request).catch(() => caches.match(event.request))
  );

});
