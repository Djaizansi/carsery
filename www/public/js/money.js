new Chart(document.getElementById("chartjs-4"), {
  type: "doughnut",
  data: {
    labels: ["Ventes de pièces détachés", "Véhicules vendus"],
    datasets: [
      {
        label: "My First Dataset",
        data: [300, 100],
        backgroundColor: ["rgb(54, 162, 235)", "rgb(255, 205, 86)"],
      },
    ],
  },
});
