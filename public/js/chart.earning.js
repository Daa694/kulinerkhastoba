// Chart.js Earning Chart
// Requires Chart.js to be loaded in the page
window.renderEarningChart = function(labels, data) {
    const ctx = document.getElementById('earningChart').getContext('2d');
    if(window.earningChartInstance) window.earningChartInstance.destroy();
    window.earningChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Penghasilan',
                data: data,
                borderColor: '#2E5A43',
                backgroundColor: 'rgba(46,90,67,0.1)',
                pointBackgroundColor: '#D2552D',
                pointBorderColor: '#fff',
                tension: 0.3,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                x: { title: { display: true, text: 'Periode' } },
                y: { title: { display: true, text: 'Penghasilan (Rp)' }, beginAtZero: true }
            }
        }
    });
};
