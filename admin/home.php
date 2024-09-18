<style>
    /* Custom Menu */
    .custom-menu {
        z-index: 1000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid #0000001c;
        border-radius: 5px;
        padding: 8px;
        min-width: 13vw;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    a.custom-menu-list {
        width: 100%;
        display: flex;
        color: #4c4b4b;
        font-weight: 600;
        font-size: 1em;
        padding: 8px 11px;
        transition: background 0.3s;
    }

    a.custom-menu-list:hover,
    .file-item:hover,
    .file-item.active {
        background: #80808024;
        cursor: pointer;
    }

    a.custom-menu-list span.icon {
        width: 1.5em;
        margin-right: 10px;
    }

    /* Card Styling */
    .card {
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Welcome Section */
    .welcome-card {
        background: #007bff;
        color: white;
        position: relative;
        overflow: hidden;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .welcome-card h4 {
        font-size: 1.5em;
        margin-bottom: 0.5rem;
    }

    .welcome-card p {
        font-size: 1.1em;
        margin-bottom: 0;
    }

    .welcome-card span.card-icon {
        position: absolute;
        right: 20px;
        bottom: 20px;
        font-size: 4em;
        opacity: 0.1;
    }

    /* Action Buttons */
    .quick-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .quick-actions .btn {
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
        border-radius: 30px;
        transition: background 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary:hover {
        background-color: #6c757d;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .quick-actions {
            flex-direction: column;
        }

        .quick-actions .btn {
            margin-bottom: 10px;
        }
    }
</style>

<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12"></div>
    </div>

    <div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card welcome-card shadow-lg">
                <h4 class="mb-2">Welcome back, <?= $_SESSION['login_name'] ?>!</h4>
                <p>Today is <?= date('l, F j, Y') ?> and the current time is <span id="currentTime"></span>.</p>
                <span class="card-icon"><i class="fas fa-user"></i></span>
            </div>
        </div>
    </div>

    

</div>

<script>
    // Display the current time and update every second
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        document.getElementById('currentTime').innerHTML = timeString;
    }
    setInterval(updateTime, 1000);
    updateTime();


</script>
