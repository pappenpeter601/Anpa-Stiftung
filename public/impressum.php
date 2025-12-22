<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';
$pageTitle = 'Impressum';
$pageDescription = 'Impressum und rechtliche Angaben der Andreas Pareigis Stiftung, Soltau.';
include __DIR__ . '/../templates/header.php';
?>

<div class="container my-5 py-5">
  <div class="row">
    <div class="col-lg-8 mx-auto">
      <div class="card border-0 shadow-lg p-4">
        <h1 class="fw-bold mb-4">Impressum</h1>
        
        <h5 class="fw-bold mt-4 mb-3">Angaben gemäß § 5 TMG</h5>
        <p>
          <strong>Andreas Pareigis Stiftung</strong><br>
          Rechtsfähige Stiftung des bürgerlichen Rechts<br>
          Meinern 15a<br>
          29614 Soltau
        </p>

        <h5 class="fw-bold mt-4 mb-3">Vertreten durch</h5>
        <p>
          <strong>Vorstand:</strong><br>
          Peter Scharringhausen (Vorsitzender)<br>
          Birte Flammann (Stellvertretende Vorsitzende)<br>
          Michael Lihograj (Schatzmeister)
        </p>

        <h5 class="fw-bold mt-4 mb-3">Kontakt</h5>
        <p>
          E-Mail: <a href="mailto:info@andreas-pareigis-stiftung.de">info@andreas-pareigis-stiftung.de</a><br>
          Telefon: +49 152 08987931
        </p>

        <h5 class="fw-bold mt-4 mb-3">Registereintrag</h5>
        <p>
          Rechtsfähige Stiftung des bürgerlichen Rechts<br>
          Sitz: Soltau
        </p>

        <h5 class="fw-bold mt-4 mb-3">Steuernummer</h5>
        <p>
          Gemeinnützig anerkannt gemäß § 53 AO
        </p>

        <h5 class="fw-bold mt-4 mb-3">Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV</h5>
        <p>
          Peter Scharringhausen<br>
          Wüsthof 1<br>
          29614 Soltau
        </p>

        <h5 class="fw-bold mt-4 mb-3">Haftungsausschluss</h5>
        
        <h6 class="fw-bold mt-3">Haftung für Inhalte</h6>
        <p class="text-muted small">
          Die Inhalte unserer Seiten wurden mit größter Sorgfalt erstellt. Für die Richtigkeit, Vollständigkeit und Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen. Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen. Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.
        </p>

        <h6 class="fw-bold mt-3">Haftung für Links</h6>
        <p class="text-muted small">
          Trotz sorgfältiger inhaltlicher Kontrolle übernehmen wir keine Haftung für die Inhalte externer Links. Für den Inhalt eventuell verlinkter Seiten sind ausschließlich deren Betreiber verantwortlich.
        </p>

        <h6 class="fw-bold mt-3">Urheberrecht</h6>
        <p class="text-muted small">
          Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers. Downloads und Kopien dieser Seite sind nur für den privaten, nicht kommerziellen Gebrauch gestattet. Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter beachtet. Insbesondere werden Inhalte Dritter als solche gekennzeichnet. Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitten wir um einen entsprechenden Hinweis. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte umgehend entfernen.
        </p>

        <h5 class="fw-bold mt-4 mb-3">Datenschutz</h5>
        <p class="text-muted small">
          Die Nutzung unserer Webseite ist in der Regel ohne Angabe personenbezogener Daten möglich. Soweit auf unseren Seiten personenbezogene Daten (beispielsweise Name, Anschrift oder E-Mail-Adressen) erhoben werden, erfolgt dies, soweit möglich, stets auf freiwilliger Basis. Diese Daten werden ohne Ihre ausdrückliche Zustimmung nicht an Dritte weitergegeben. Wir weisen darauf hin, dass die Datenübertragung im Internet (z.B. bei der Kommunikation per E-Mail) Sicherheitslücken aufweisen kann. Ein lückenloser Schutz der Daten vor dem Zugriff durch Dritte ist nicht möglich.
        </p>

        <h5 class="fw-bold mt-4 mb-3">Copyright</h5>
        <p>
          © <?php echo date('Y'); ?> Andreas Pareigis Stiftung. Alle Rechte vorbehalten.
        </p>

        <div class="mt-4 pt-4 border-top">
          <p class="text-muted small mb-0">
            <strong>Hinweis:</strong> Bei Fragen zum Impressum oder rechtlichen Hinweisen kontaktieren Sie uns bitte unter 
            <a href="mailto:info@andreas-pareigis-stiftung.de">info@andreas-pareigis-stiftung.de</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
