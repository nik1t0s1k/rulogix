<?php
use yii\helpers\Html;

/** @var $route app\models\Routes */

$this->title = $route->title;
?>

<link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="route-page">

    <h1><?= Html::encode($route->title) ?></h1>

    <p>
        <b>От:</b> <?= Html::encode($route->from_address) ?><br>
        <b>До:</b> <?= Html::encode($route->to_address) ?><br>
        <b>Статус:</b> <?= Html::encode($route->status) ?>
    </p>

    <h3 id="distance">Рассчитываем расстояние...</h3>

    <div id="map" style="height:500px; border-radius:16px;"></div>

</div>

<script>
    const map = L.map('map').setView([55.7558, 37.6173], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    async function geocode(address) {
        const res = await fetch(
            "https://nominatim.openstreetmap.org/search?format=json&q=" + encodeURIComponent(address)
        );
        const data = await res.json();

        if (data.length > 0) {
            return {
                lat: data[0].lat,
                lon: data[0].lon
            };
        }
        return null;
    }

    async function buildRoute() {

        const from = await geocode("<?= addslashes($route->from_address) ?>");
        const to = await geocode("<?= addslashes($route->to_address) ?>");

        if (!from || !to) return;

        // точки
        L.marker([from.lat, from.lon]).addTo(map).bindPopup("A");
        L.marker([to.lat, to.lon]).addTo(map).bindPopup("B");

        // OSRM routing API (реальный маршрут по дорогам)
        const url =
            `https://router.project-osrm.org/route/v1/driving/` +
            `${from.lon},${from.lat};${to.lon},${to.lat}?overview=full&geometries=geojson`;

        const response = await fetch(url);
        const data = await response.json();

        const route = data.routes[0];

        // расстояние в км
        const distanceKm = (route.distance / 1000).toFixed(2);

        document.getElementById('distance').innerText =
            `Расстояние: ${distanceKm} км`;

        // линия маршрута
        const coords = route.geometry.coordinates.map(c => [c[1], c[0]]);

        const polyline = L.polyline(coords, {
            color: 'blue',
            weight: 4
        }).addTo(map);

        map.fitBounds(polyline.getBounds());
    }

    buildRoute();
</script>