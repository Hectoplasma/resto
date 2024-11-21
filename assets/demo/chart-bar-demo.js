// Ensure the data is available globally
document.addEventListener("DOMContentLoaded", function () {
  if (typeof jenisMakananCounts !== "undefined") {
    // Extract data from the JSON object
    const labels = ["Sarapan", "Makanan Ringan", "Makanan Berat"];
    const data = [
      jenisMakananCounts.sarapan,
      jenisMakananCounts["makanan ringan"],
      jenisMakananCounts["makanan berat"]
    ];

    // Render the bar chart
    var ctx = document.getElementById("myBarChart").getContext("2d");
    var myBarChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels,
        datasets: [{
          label: "Jumlah Jenis Makanan",
          backgroundColor: ["#007bff", "#ffc107", "#28a745"],
          borderColor: ["#007bff", "#ffc107", "#28a745"],
          data: data,
        }],
      },
      options: {
        scales: {
          xAxes: [{
            gridLines: { display: false },
            ticks: { maxTicksLimit: 3 },
          }],
          yAxes: [{
            ticks: { beginAtZero: true, maxTicksLimit: 5 },
            gridLines: { display: true },
          }],
        },
        legend: { display: false },
      },
    });
  } else {
    console.error("Jenis Makanan data is not available.");
  }
});
