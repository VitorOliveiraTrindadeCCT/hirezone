<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<main class="oportunidades">
    <h1>Job Opportunities</h1>

    <section class="filters">
        <label>
            Category:
            <select>
                <option>All</option>
                <option>Technology</option>
                <option>Design</option>
                <option>Marketing</option>
            </select>
        </label>

        <label>
            Location:
            <select>
                <option>All</option>
                <option>Dublin</option>
                <option>Remote</option>
                <option>Galway</option>
            </select>
        </label>

        <label>
            Contract Type:
            <select>
                <option>All</option>
                <option>Full-time</option>
                <option>Part-time</option>
                <option>Internship</option>
            </select>
        </label>
    </section>

    <section class="job-cards">
        <div class="card">
            <h3>Backend Developer</h3>
            <p>Company: CodeWorks</p>
            <p>Location: Dublin</p>
            <p>Contract: Full-time</p>
            <a href="JobDetails.php" class="btn btn-small">View Details</a>
        </div>

        <div class="card">
            <h3>Backend Developer</h3>
            <p>Company: CodeWorks</p>
            <p>Location: Dublin</p>
            <p>Contract: Full-time</p>
            <a href="JobDetails.php" class="btn btn-small">View Details</a>
        </div>

            <div class="card">
            <h3>Backend Developer</h3>
            <p>Company: CodeWorks</p>
            <p>Location: Dublin</p>
            <p>Contract: Full-time</p>
            <a href="JobDetails.php" class="btn btn-small">View Details</a>
        </div>

    </section>
</main>

<?php include 'footer.php'; ?>
