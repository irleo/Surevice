document.addEventListener('DOMContentLoaded', () => {
  const ctx = document.getElementById('earningsChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'March', 'May', 'Jul', 'Sep', 'Nov'],
      datasets: [{
        label: 'Earnings (last 12 months)',
        data: [1000, 1800, 2900, 2800, 3600, 4200],
        borderColor: 'black',
        backgroundColor: 'orange',
        fill: false,
        tension: 0.4,
        pointRadius: 5,
        pointBackgroundColor: 'black',
      }]
    },
    options: {
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
});
