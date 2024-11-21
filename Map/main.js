const map = L.map("map").setView([104.0354718802255, 1.1291339818308566], 12); // Default to Jakarta
let userLocationMarker, destinationMarker, routeLayer, distanceLabel;
let userLocation;

// Create a custom icon
const userLocationIcon = L.icon({
  iconUrl: "./assets/person.png", // URL to the custom image or SVG
  iconSize: [30, 30], // Size of the icon [width, height]
  iconAnchor: [15, 30], // Point of the icon which will correspond to marker's location
  popupAnchor: [0, -30], // Point from which the popup should open relative to the iconAnchor
});

const destinationLocationIcon = L.icon({
  iconUrl: "./assets/location-pin.png", // URL to the custom image or SVG
  iconSize: [30, 30], // Size of the icon [width, height]
  iconAnchor: [15, 30], // Point of the icon which will correspond to marker's location
  popupAnchor: [0, -30], // Point from which the popup should open relative to the iconAnchor
});

// Add OpenStreetMap tiles
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19,
  attribution: "&copy; OpenStreetMap contributors",
}).addTo(map);

// Function to get user's current location
function getUserLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        userLocation = [position.coords.latitude, position.coords.longitude];
        map.setView(userLocation, 13);

        // Place a marker at the user's location
        if (userLocationMarker) {
          map.removeLayer(userLocationMarker);
        }
        userLocationMarker = L.marker(userLocation, { icon: userLocationIcon })
          .addTo(map)
          .bindPopup("Your Location")
          .openPopup();
      },
      (error) => {
        console.error("Error getting user location:", error);
        alert(
          "Unable to retrieve your location. Please allow location access."
        );
      }
    );
  } else {
    alert("Geolocation is not supported by this browser.");
  }
}

// Call function to get user's location
getUserLocation();

// Function to calculate and display route
async function calculateRoute(destinationLatLng, profile) {
  if (!userLocation) {
    alert("User location not set. Please try again.");
    return;
  }

  // Construct the OSRM API URL using the selected travel mode (profile)
  const osrmUrl = `https://router.project-osrm.org/route/v1/${profile}/${userLocation[1]},${userLocation[0]};${destinationLatLng.lng},${destinationLatLng.lat}?overview=full&geometries=geojson`;

  console.log(`Fetching route with profile: ${profile}`);
  console.log(`OSRM URL: ${osrmUrl}`);

  try {
    const response = await fetch(osrmUrl);
    const data = await response.json();

    if (data.routes && data.routes.length > 0) {
      const route = data.routes[0];
      const routeCoordinates = route.geometry.coordinates.map((coord) => [
        coord[1],
        coord[0],
      ]);
      const distanceInKm = (route.distance / 1000).toFixed(2); // Convert meters to kilometers and format to 2 decimal places

      // Calculate estimated time based on distance and transport mode
      let estimatedTime = 0;
      let speed = 0;

      // Assign speed based on the selected mode of transport
      if (profile === "driving") {
        speed = 30; // Average speed for driving in km/h
      } else if (profile === "bicycle") {
        speed = 15; // Average speed for bicycle in km/h
      } else if (profile === "foot") {
        speed = 5; // Average speed for walking in km/h
      }

      // Ensure speed is set and distance is not zero
      if (speed > 0 && distanceInKm > 0) {
        estimatedTime = (distanceInKm / speed) * 60; // Time in minutes
      }

      // Round the time for a more accurate representation (Google Maps gives a rounded figure)
      estimatedTime = Math.round(estimatedTime);

      // Check if the estimated time is too small, set a minimum value
      if (estimatedTime < 1) {
        estimatedTime = 1; // If the time is less than 1 minute, set it to 1 minute
      }

      // Remove existing route and distance label if any
      if (routeLayer) {
        map.removeLayer(routeLayer);
      }
      if (distanceLabel) {
        map.removeLayer(distanceLabel);
      }

      // Draw the route on the map
      routeLayer = L.polyline(routeCoordinates, {
        color: "#ef4444",
        weight: 5,
      }).addTo(map);

      // Add a label showing the distance and estimated time near the middle of the route
      const midPointIndex = Math.floor(routeCoordinates.length / 2);
      const midPoint = routeCoordinates[midPointIndex];
      distanceLabel = L.marker(midPoint, {
        icon: L.divIcon({
          html: `<div class="font-sans absolute bg-white w-120 p-1 rounded-sm">Distance: ${distanceInKm} km, Time: ${estimatedTime} minutes</div>`,
        }),
      }).addTo(map);

      // Fit map bounds to the route
      map.fitBounds(routeLayer.getBounds());
    } else {
      alert("No route found. Please try a different location.");
    }
  } catch (error) {
    console.error("Error fetching route data:", error);
    alert("An error occurred while fetching route data.");
  }
}

// Event listener for "Get Directions" button
document
  .getElementById("getDirectionsButton")
  .addEventListener("click", async () => {
    const destination = document.getElementById("destinationInput").value;

    if (!destination) {
      alert("Please enter a destination.");
      return;
    }

    const profile = document.getElementById("profileSelect").value;

    // Log the selected travel mode to confirm selection
    console.log(`Selected travel mode: ${profile}`);

    // Using a basic geocoding API to get the destination's coordinates (You can use services like OpenCage, Mapbox, or Nominatim)
    const geocodeUrl = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(
      destination
    )}&format=json&limit=1`;

    try {
      const response = await fetch(geocodeUrl);
      const results = await response.json();

      if (results && results.length > 0) {
        const destinationLatLng = {
          lat: parseFloat(results[0].lat),
          lng: parseFloat(results[0].lon),
        };

        // Set destination marker
        if (destinationMarker) {
          map.removeLayer(destinationMarker);
        }
        destinationMarker = L.marker(destinationLatLng, {
          icon: destinationLocationIcon,
        })
          .addTo(map)
          .bindPopup(`Destination: ${destination}`)
          .openPopup();

        // Calculate and display route with the selected travel mode
        calculateRoute(destinationLatLng, profile);
      } else {
        alert(
          "Destination not found. Please enter a valid address or place name."
        );
      }
    } catch (error) {
      console.error("Error fetching geocode data:", error);
      alert("An error occurred while fetching the destination location.");
    }
  });

// Event listener for style change
document.getElementById("styleSelect").addEventListener("change", (event) => {
  const selectedStyle = event.target.value;
  switch (selectedStyle) {
    case "dark":
      L.tileLayer(
        "https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png",
        {
          maxZoom: 19,
          attribution: "&copy; OpenStreetMap contributors &copy; CartoDB",
        }
      ).addTo(map);
      break;
    case "light":
      L.tileLayer(
        "https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png",
        {
          maxZoom: 19,
          attribution: "&copy; OpenStreetMap contributors &copy; CartoDB",
        }
      ).addTo(map);
      break;
    case "satellite":
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution: "&copy; OpenStreetMap contributors",
      }).addTo(map);
      break;
    case "terrain":
      L.tileLayer("https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png", {
        maxZoom: 17,
        attribution: "&copy; OpenStreetMap contributors &copy; OpenTopoMap",
      }).addTo(map);
      break;
    default:
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution: "&copy; OpenStreetMap contributors",
      }).addTo(map);
      break;
  }
});
