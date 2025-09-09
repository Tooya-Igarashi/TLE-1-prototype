<!--test test test -->

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Patiëntenmonitor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
<section class="section">
    <div class="container">
        <h1 class="title has-text-centered">🩺 Patiëntenmonitor Dashboard</h1>

        <!-- Tabs -->
        <div class="tabs is-centered is-boxed is-large">
            <ul>
                <li class="is-active" data-tab="heart"><a>Heart Rate</a></li>
                <li data-tab="brain"><a>Brain Activity</a></li>
                <li data-tab="glucose"><a>Glucose</a></li>
                <li data-tab="vital"><a>Vital Signs</a></li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div id="heart" class="tab-content is-active">
            <h2 class="subtitle">Heart Rate Monitor</h2>
            <table class="table is-striped is-fullwidth">
                <thead><tr><th>Tijd</th><th>Hartslag (BPM)</th></tr></thead>
                <tbody><tr><td>08:00</td><td>72</td></tr></tbody>
            </table>
            <h2>Delen met arts</h2>
        </div>

        <div id="brain" class="tab-content">
            <h2 class="subtitle">Brain Activity Monitor</h2>
            <table class="table is-striped is-fullwidth">
                <thead><tr><th>Tijd</th><th>EEG Niveau</th></tr></thead>
                <tbody><tr><td>08:00</td><td>Alpha</td></tr></tbody>
            </table>
        </div>

        <div id="glucose" class="tab-content">
            <h2 class="subtitle">Glucose Monitor</h2>
            <table class="table is-striped is-fullwidth">
                <thead><tr><th>Tijd</th><th>Glucose (mg/dL)</th></tr></thead>
                <tbody><tr><td>08:00</td><td>95</td></tr></tbody>
            </table>
        </div>

        <div id="vital" class="tab-content">
            <h2 class="subtitle">Vital Sign Monitor</h2>
            <table class="table is-striped is-fullwidth">
                <thead><tr><th>Tijd</th><th>Temperatuur</th><th>Bloeddruk</th></tr></thead>
                <tbody><tr><td>08:00</td><td>36.8°C</td><td>120/80</td></tr></tbody>
            </table>
        </div>
    </div>
</section>

<!-- Simple JS to switch tabs -->
<script>
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
</script>
<!--moet nog in css style gezet worden -->
<style>
    .tab-content { display: none; }
    .tab-content.is-active { display: block; }
</style>
</body>
</html>

