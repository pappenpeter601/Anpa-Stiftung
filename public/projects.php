<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';
$projects = load_json('data/projects.json');

// Filter by year if provided
$filter_year = isset($_GET['year']) ? (int)$_GET['year'] : null;
if ($filter_year) {
    $projects = array_filter($projects, function($p) use ($filter_year) {
        return isset($p['year']) && (int)$p['year'] === $filter_year;
    });
}

// Get unique years for filter
$all_projects = load_json('data/projects.json');
$years = array_unique(array_map(function($p) {
    return $p['year'] ?? date('Y');
}, $all_projects));
rsort($years);

include __DIR__ . '/../templates/header.php';
?>

<div class="hero pt-5 pb-5 mb-5">
  <div class="container text-center">
    <h1 class="display-5 mb-3">Our Funded Projects</h1>
    <p class="lead text-muted mx-auto" style="max-width: 700px;">
      Discover the innovative initiatives we support to empower youth across our communities
    </p>
  </div>
</div>

<div class="container mb-5">
  <div class="row mb-4">
    <div class="col-lg-8">
      <h4 class="fw-bold">
        <?php if ($filter_year): ?>
          Projects from <?php echo htmlspecialchars($filter_year); ?>
        <?php else: ?>
          All Projects
        <?php endif; ?>
      </h4>
      <p class="text-muted">Showing <?php echo count($projects); ?> project<?php echo count($projects) !== 1 ? 's' : ''; ?></p>
    </div>
    <div class="col-lg-4 text-lg-end">
      <div class="dropdown d-inline-block">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="yearFilter" data-bs-toggle="dropdown" aria-expanded="false">
          <svg width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;">
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
          </svg>
          Filter by Year
        </button>
        <ul class="dropdown-menu" aria-labelledby="yearFilter">
          <li><a class="dropdown-item <?php echo !$filter_year ? 'active' : ''; ?>" href="projects.php">All Years</a></li>
          <?php foreach ($years as $y): ?>
            <li><a class="dropdown-item <?php echo $filter_year === (int)$y ? 'active' : ''; ?>" href="projects.php?year=<?php echo $y; ?>"><?php echo $y; ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <?php if (empty($projects)): ?>
      <div class="col-12">
        <div class="alert alert-info">
          No projects found for the selected year.
        </div>
      </div>
    <?php else: ?>
      <?php foreach ($projects as $p): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 shadow-sm project-card">
            <img src="<?php echo BASE_URL; ?>assets/img/<?php echo htmlspecialchars($p['image'] ?? 'project-placeholder.svg'); ?>" 
                 class="card-img-top" 
                 alt="<?php echo htmlspecialchars($p['title']); ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?php echo htmlspecialchars($p['title']); ?></h5>
              <p class="card-text text-muted flex-grow-1"><?php echo htmlspecialchars($p['summary'] ?? ''); ?></p>
              
              <?php if (!empty($p['description'])): ?>
                <p class="card-text small text-muted"><?php echo htmlspecialchars($p['description']); ?></p>
              <?php endif; ?>
              
              <div class="mt-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <small class="text-muted">
                    <svg width="14" height="14" fill="currentColor" class="me-1" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;">
                      <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                      <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                    </svg>
                    <?php echo htmlspecialchars($p['year'] ?? ''); ?>
                  </small>
                </div>
                
                <?php if (!empty($p['category'])): ?>
                  <span class="badge rounded-pill" style="background: rgba(37, 99, 235, 0.1); color: var(--primary); font-weight: 500;">
                    <?php echo htmlspecialchars($p['category']); ?>
                  </span>
                <?php endif; ?>
                
                <?php if (!empty($p['amount'])): ?>
                  <div class="mt-2">
                    <small class="text-muted">Funding: <strong class="text-gradient"><?php echo htmlspecialchars($p['amount']); ?></strong></small>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<div class="py-5 mb-5" style="background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), rgba(124, 58, 237, 0.05));">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h3 class="fw-bold mb-3">Have a Project Idea?</h3>
        <p class="mb-0">We're always looking for innovative projects that can make a real difference in young people's lives. If you have a project that aligns with our mission, we'd love to hear from you.</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
        <a href="request.php" class="btn btn-primary btn-lg">Submit Your Project</a>
      </div>
    </div>
  </div>
</div>

<div class="container mb-5">
  <div class="section-header">
    <h2>Project Impact by Category</h2>
    <p>Our investments across different areas of youth development</p>
  </div>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card border-0 shadow-sm text-center p-4">
        <div class="feature-icon mx-auto">
          <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z"/>
          </svg>
        </div>
        <h4 class="fw-bold text-gradient mb-2">45%</h4>
        <h6 class="fw-bold">Education</h6>
        <p class="text-muted small mb-0">School supplies, tutoring, educational technology</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm text-center p-4">
        <div class="feature-icon mx-auto">
          <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
          </svg>
        </div>
        <h4 class="fw-bold text-gradient mb-2">35%</h4>
        <h6 class="fw-bold">Health & Wellness</h6>
        <p class="text-muted small mb-0">Mental health, sports programs, health screenings</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm text-center p-4">
        <div class="feature-icon mx-auto">
          <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
            <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3z"/>
          </svg>
        </div>
        <h4 class="fw-bold text-gradient mb-2">20%</h4>
        <h6 class="fw-bold">Skills Development</h6>
        <p class="text-muted small mb-0">Vocational training, mentorship, career prep</p>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
