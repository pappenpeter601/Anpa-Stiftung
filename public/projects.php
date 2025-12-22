<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';
$pageTitle = 'Geförderte Projekte';
$pageDescription = 'Entdecken Sie die von der Andreas Pareigis Stiftung geförderten Projekte für sozial benachteiligte Kinder und Jugendliche in Soltau. Bildung, Kultur und Jugendhilfe stehen im Fokus unserer Förderung.';
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
    <h1 class="display-5 mb-3">Geförderte Projekte</h1>
    <p class="lead text-muted mx-auto" style="max-width: 700px;">
      Entdecken Sie die Projekte, mit denen wir Kinder und Jugendliche in Soltau unterstützen
    </p>
  </div>
</div>

<div class="container mb-5">
  <div class="row mb-4">
    <div class="col-lg-8">
      <h4 class="fw-bold">
        <?php if ($filter_year): ?>
          Projekte aus <?php echo htmlspecialchars($filter_year); ?>
        <?php else: ?>
          Alle Projekte
        <?php endif; ?>
      </h4>
      <p class="text-muted"><?php echo count($projects); ?> Projekt<?php echo count($projects) !== 1 ? 'e' : ''; ?> angezeigt</p>
    </div>
    <div class="col-lg-4 text-lg-end">
      <div class="dropdown d-inline-block">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="yearFilter" data-bs-toggle="dropdown" aria-expanded="false">
          <svg width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;">
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
          </svg>
          Nach Jahr filtern
        </button>
        <ul class="dropdown-menu" aria-labelledby="yearFilter">
          <li><a class="dropdown-item <?php echo !$filter_year ? 'active' : ''; ?>" href="projects.php">Alle Jahre</a></li>
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
          Keine Projekte für das ausgewählte Jahr gefunden.
        </div>
      </div>
    <?php else: ?>
      <?php foreach ($projects as $p): ?>
        <div class="col-md-6 col-lg-4">
          <?php 
            $hasLink = !empty($p['website']);
            $fetchLogo = !isset($p['fetch_logo']) || $p['fetch_logo'] !== false;
            $placeholderUrl = BASE_URL . 'assets/img/kids-support-placeholder.svg';
          ?>
          
          <?php if ($hasLink): ?>
          <a href="<?php echo htmlspecialchars($p['website']); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
          <?php endif; ?>
          
          <div class="card h-100 shadow-sm project-card <?php echo $hasLink ? 'hoverable-card' : ''; ?>">
            <div class="position-relative">
              <img src="<?php echo $placeholderUrl; ?>" 
                   class="card-img-top project-logo" 
                   alt="<?php echo htmlspecialchars($p['title']); ?>"
                   data-website="<?php echo ($hasLink && $fetchLogo) ? htmlspecialchars($p['website']) : ''; ?>"
                   style="object-fit: contain; padding: 20px; background: #f8f9fa; min-height: 200px;">
              <?php if ($hasLink && $fetchLogo): ?>
              <div class="position-absolute top-0 end-0 m-2">
                <span class="badge bg-light text-dark" style="font-size: 0.7rem; opacity: 0.8;" title="Logo wird von der Website geladen">
                  <svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                  </svg>
                  Externe Quelle
                </span>
              </div>
              <?php endif; ?>
              <div class="logo-loading-spinner position-absolute top-50 start-50 translate-middle" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Lädt Logo...</span>
                </div>
              </div>
            </div>
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">
                <?php echo htmlspecialchars($p['title']); ?>
                <?php if ($hasLink): ?>
                <svg width="14" height="14" fill="currentColor" class="ms-1" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;opacity:0.5;">
                  <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
                  <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
                </svg>
                <?php endif; ?>
              </h5>
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
                    <small class="text-muted">Fördersumme: <strong class="text-gradient"><?php echo htmlspecialchars($p['amount']); ?></strong></small>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          
          <?php if ($hasLink): ?>
          </a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<div class="py-5 mb-5" style="background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), rgba(124, 58, 237, 0.05));">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h3 class="fw-bold mb-3">Sie haben eine Projektidee?</h3>
        <p class="mb-0">Wir suchen stets nach innovativen Projekten, die das Leben von Kindern und Jugendlichen nachhaltig verbessern. Wenn Sie ein Projekt haben, das zu unserem Stiftungszweck passt, freuen wir uns auf Ihre Anfrage.</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
        <a href="request.php" class="btn btn-primary btn-lg">Förderantrag stellen</a>
      </div>
    </div>
  </div>
</div>

<script>
// Lazy load project logos from external websites
document.addEventListener('DOMContentLoaded', function() {
  const projectLogos = document.querySelectorAll('.project-logo[data-website]');
  
  // Use Intersection Observer for true lazy loading
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        loadLogo(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, {
    rootMargin: '50px' // Start loading 50px before image is visible
  });
  
  projectLogos.forEach(img => {
    observer.observe(img);
  });
  
  function loadLogo(imgElement) {
    const website = imgElement.getAttribute('data-website');
    if (!website) return;
    
    const spinner = imgElement.parentElement.querySelector('.logo-loading-spinner');
    const card = imgElement.closest('.project-card');
    
    try {
      const url = new URL(website);
      const domain = url.hostname;
      
      // Try Google's favicon service (most reliable)
      const faviconUrl = `https://www.google.com/s2/favicons?domain=${domain}&sz=128`;
      
      // Show loading spinner
      if (spinner) spinner.style.display = 'block';
      
      // Test if logo loads
      const testImg = new Image();
      testImg.onload = function() {
        // Successfully loaded, update the main image
        imgElement.src = faviconUrl;
        if (spinner) spinner.style.display = 'none';
        
        // Add loaded class for animation
        if (card) card.classList.add('logo-loaded');
      };
      
      testImg.onerror = function() {
        // Failed to load, keep placeholder
        if (spinner) spinner.style.display = 'none';
        console.log('Logo could not be loaded for:', domain);
      };
      
      // Set timeout for loading
      setTimeout(() => {
        if (spinner && spinner.style.display !== 'none') {
          spinner.style.display = 'none';
        }
      }, 5000); // 5 second timeout
      
      testImg.src = faviconUrl;
      
    } catch (e) {
      console.error('Invalid website URL:', website);
      if (spinner) spinner.style.display = 'none';
    }
  }
});
</script>

<?php include __DIR__ . '/../templates/footer.php'; ?>
