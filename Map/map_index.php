<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    />
    <title>OSRM Route with Distance Display</title>
    <link
      rel="stylesheet"
      href="style.css"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet/dist/leaflet.css"
    />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="font-sans bg-gray-100">
    <!-- Controls Container -->
    <div
      class="absolute inset-x-0 top-0 z-10 bg-sky-200/[.8] shadow-lg p-4 rounded-md flex flex-col max-w-md mx-auto"
    >
      <label
        for="styleSelect"
        class="block text-sm font-semibold"
        >Map Style:</label
      >
      <select
        id="styleSelect"
        class="mb-4 border rounded p-2"
      >
        <option value="default">Default</option>
        <option value="dark">Dark</option>
        <option value="light">Light</option>
        <option value="terrain">Terrain</option>
      </select>

      <label
        for="destinationInput"
        class="block text-sm font-semibold"
        >Enter Destination:</label
      >
      <input
        type="text"
        id="destinationInput"
        class="border rounded p-2 mb-4"
        placeholder="Enter a place name or address 🚩"
      />

      <label
        for="profileSelect"
        class="block text-sm font-semibold"
        >Travel Mode:</label
      >
      <select
        id="profileSelect"
        class="border rounded p-2 mb-4"
      >
        <option value="driving">Drive🚗</option>
        <option value="bicycle">Bicycle🚲</option>
        <option value="foot">Walk🚶🏽</option>
      </select>

      <button
        id="getDirectionsButton"
        class="bg-blue-700 text-white p-2 rounded"
      >
        Get Directions
      </button>
    </div>

    <!-- Map Container -->
    <div
      id="map"
      class="h-screen z-0"
    ></div>

    <script src="main.js"></script>
  </body>
  <footer>
    <a
      href="https://www.flaticon.com/free-icons/person"
      title="person icons"
      >Person icons created by Freepik - Flaticon</a
    >
    <a
      href="https://www.flaticon.com/free-icons/marker"
      title="marker icons"
      >Marker icons created by Freepik - Flaticon</a
    >
  </footer>
</html>
