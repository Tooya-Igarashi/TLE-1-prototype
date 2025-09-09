<!--test test test test test-->

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Patiëntenmonitor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
<section class="section">
    <div class="container">
        <h1 class="title has-text-centered">🩺 Patiëntenmonitor Dashboard</h1>

        <!-- Tabs -->
        <div class="tabs is-centered is-boxed is-large">
            <ul>
                <li class="is-active" data-tab="heart"><a>❤️ Heart Rate</a></li>
                <li data-tab="brain"><a>🧠 Brain Activity</a></li>
                <li data-tab="glucose"><a>🩸 Glucose</a></li>
                <li data-tab="vital"><a>🌡️ Vital Signs</a></li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div id="heart" class="tab-content is-active">
            <h2 class="subtitle">Heart Rate Monitor</h2>
            <table class="table is-striped is-fullwidth">
                <canvas id="heartChart" width="400" height="200"></canvas>
                <thead><tr><th>Tijd</th><th>Hartslag (BPM)</th></tr></thead>
                <tbody><tr><td>08:00</td><td>72</td></tr></tbody>
            </table>
            <div>
                <h3>Delen met arts</h3>
                <!-- Rounded switch -->
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
            </div>
        </div>


        <div id="brain" class="tab-content">
            <h2 class="subtitle">Brain Activity Monitor</h2>
            <table class="table is-striped is-fullwidth">
                <thead><tr><th>Tijd</th><th>EEG Niveau</th></tr></thead>
                <tbody><tr><td>08:00</td><td>Alpha</td></tr></tbody>
            </table>
            <div>
                <h3>Delen met arts</h3>
                <!-- Rounded switch -->
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
            </div>
        </div>

        <div id="glucose" class="tab-content">
            <h2 class="subtitle">Glucose Monitor</h2>
            <table class="table is-striped is-fullwidth">
                <thead><tr><th>Tijd</th><th>Glucose (mg/dL)</th></tr></thead>
                <tbody><tr><td>08:00</td><td>95</td></tr></tbody>
            </table>
            <div>
                <h3>Delen met arts</h3>
                <!-- Rounded switch -->
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
            </div>
        </div>

        <div id="vital" class="tab-content">
            <h2 class="subtitle">Vital Sign Monitor</h2>
            <table class="table is-striped is-fullwidth">
                <thead><tr><th>Tijd</th><th>Temperatuur</th><th>Bloeddruk</th></tr></thead>
                <tbody><tr><td>08:00</td><td>36.8°C</td><td>120/80</td></tr></tbody>
            </table>
            <div>
                <h3>Delen met arts</h3>
                <!-- Rounded switch -->
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
</section>

<!-- Simple JS to switch tabs -->
<script>
    // dit zijn de tabellen van hart, brain , glucose en vital sign
    const tabs = document.querySelectorAll(".tabs ul li");
    const contents = document.querySelectorAll(".tab-content");

    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            tabs.forEach(t => t.classList.remove("is-active"));
            tab.classList.add("is-active");

            contents.forEach(c => c.classList.remove("is-active"));
            document.getElementById(tab.dataset.tab).classList.add("is-active");
        });
    });

    // dit is een heart chart en het meet je hartslag
    const ctx = document.getElementById('heartChart').getContext('2d');
    const heartChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['08:00', '09:00', '10:00', '11:00', '12:00'],
            datasets: [{
                label: 'Hartslag (BPM)',
                data: [72, 75, 78, 74, 76],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false,
                    suggestedMin: 60,
                    suggestedMax: 100
                }
            }
        }
    });

// dit is die toggle switch of je gegevens wilt delen met de arts
    document.querySelectorAll('.switch input').forEach(input => {
        input.addEventListener('change', () => {
            alert("Gegevens gedeeld met arts.");
        });
    });

</script>

</body>
</html>

