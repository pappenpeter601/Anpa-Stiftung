<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';
$pageTitle = 'Satzung';
$pageDescription = 'Offizielle Satzung der Andreas Pareigis Stiftung - eine gemeinnützige Stiftung des bürgerlichen Rechts mit Sitz in Soltau zur Förderung von Jugendhilfe, Bildung und Kultur.';

// Load documents
$documents = load_json('data/documents.json');
// Filter visible documents and sort by order
$documents = array_filter($documents, function($doc) {
  return isset($doc['visible']) && $doc['visible'] === true;
});
usort($documents, function($a, $b) {
  return ($a['order'] ?? 999) - ($b['order'] ?? 999);
});

include __DIR__ . '/../templates/header.php';
?>

<div class="hero pt-5 pb-5 mb-5">
  <div class="container text-center">
    <h1 class="display-5 mb-3">Satzung der Andreas Pareigis Stiftung</h1>
    <p class="lead text-muted mx-auto" style="max-width: 700px;">
      Offizielle Satzung und Gründungsdokument der Andreas Pareigis Stiftung
    </p>
  </div>
</div>

<div class="container mb-5">
  <div class="row">
    <div class="col-lg-9 mx-auto">
      <div class="card border-0 shadow-lg p-4 mb-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
          <div>
            <h4 class="fw-bold mb-2">Stiftungssatzung</h4>
            <p class="text-muted mb-0">Sitz: Meinern 15a, 29614 Soltau</p>
          </div>
          <button class="btn btn-outline-primary" onclick="window.print()">
            <svg width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;">
              <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
              <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
            </svg>
            Drucken
          </button>
        </div>

        <div class="statute-content">
          <h5 class="fw-bold mt-4 mb-3">§ 1 Name, Sitz und Rechtsform</h5>
          <ol>
            <li>Die Stiftung führt den Namen "Andreas Pareigis Stiftung"</li>
            <li>Sie ist eine rechtsfähige Stiftung des bürgerlichen Rechts.</li>
            <li>Der Sitz der Stiftung ist Meinern 15a, 29614 Soltau</li>
            <li>Geschäftsjahr ist das Kalenderjahr</li>
          </ol>

          <h5 class="fw-bold mt-4 mb-3">§ 2 Stiftungszweck</h5>
          <p><strong>1.</strong> Die Stiftung fördert mildtätige Zwecke gemäß § 53 AO. Sie fördert außerdem folgende gemeinnützige Zwecke:</p>
          <ul>
            <li>Förderung der Jugendhilfe</li>
            <li>Förderung der Erziehung und Bildung</li>
            <li>Förderung der Kunst und Kultur</li>
          </ul>
          
          <p>Der jährlich aus der Stiftung erzielte Ertrag soll hierbei gemeinnützigen Institutionen zugute kommen, die aufgrund ihrer Satzung oder in ihren täglichen Arbeitsbereichen die folgende Punkte erfüllen. Es gilt der §58 Nr. 1 AO.</p>

          <p><strong>1.1.</strong> Sozial benachteiligten Kindern und Jugendlichen die Teilnahme an Kultur und Bildung zu ermöglichen</p>
          <p><strong>Und/oder</strong></p>
          <p><strong>1.2.</strong> Sozial benachteiligte Kinder und Jugendliche in die Gesellschaft zu integrieren</p>

          <p>Der Satzungszweck wird verwirklicht durch die Beschaffung von Mitteln für die Förderung dieser Zwecke durch eine andere steuerbegünstigte Körperschaft oder eine Körperschaft des öffentlichen Rechts.</p>

          <p><strong>2.</strong> Gefördert werden ausschließlich in Soltau ansässige Einrichtungen, soweit diese den Status als gemeinnützig anerkannt aufweisen.</p>

          <p><strong>3.</strong> Die Stiftung ist berechtigt, Gelder für die Aufstockung des Stiftungsvermögens einzuwerben.</p>

          <p><strong>4.</strong> Folgende Institutionen sind Beispiele im Stiftungssinne, diese sollen für entsprechende Projekte Fördermittel erhalten:</p>

          <div class="ps-3">
            <p><strong>a) Heidekreis-Musikschule e. V.</strong></p>
            <p class="ps-3">Die Heidekreis-Musikschule e. V. erhält anteilig einen Stiftungsertrag. Damit sollen ausschließlich Kinder und Jugendliche im Rahmen der von der Musikschule gewährten Sozialermäßigung unterstützt werden.</p>

            <p><strong>b) Verein Sprungbrett e. V.</strong></p>
            <p class="ps-3">Der anteilige Stiftungsertrag soll dem Verein für die Durchführung von Betreuungsweisungen, Arbeitsauflagen und Täter-Opfer-Ausgleichsverfahren zugute kommen, um die ambulanten und präventiven Möglichkeiten der Jugendstrafrechtspflege zu verbessern sowie die fachkundige Betreuung junger Straffälliger im Alter zwischen 14 bis 25 Jahren zu ermöglichen.</p>

            <p><strong>c) Förderverein der Oberschule Soltau e.V.</strong></p>
            <p class="ps-3">Hilfe für sozial benachteiligte Schüler an der "Oberschule" Soltau - z.B. im Bereich der Nachhilfe</p>

            <p><strong>d) Heimatbund Soltau e.V.</strong></p>
            <p class="ps-3">Falls Projekte anstehen, die "Jung" und "Alt" zusammenbringen, sowie Schülerprojekte zur Geschichtsforschung in Soltau</p>

            <p><strong>e) Erlebniswerkstatt Buchdruck-Museum Soltau e.V.</strong></p>
            <p class="ps-3">Für Schülerprojekte aller Art</p>

            <p><strong>f) Kulturinitiative Soltau e.V.</strong></p>
            <p class="ps-3">Für Veranstaltungen mit / für Schüler / Kinder</p>

            <p><strong>g) Freundeskreis Filmmuseum Bendestorf e.V.</strong></p>
            <p class="ps-3">Für z.B. Klassenfahrtzuschüsse von Soltau nach Bendestorf, Schulprojekte, Workshops für sozial benachteiligte Schüler</p>
          </div>

          <h5 class="fw-bold mt-4 mb-3">§ 3 Gemeinnützigkeit</h5>
          <p><strong>1.</strong> Die Stiftung verfolgt ausschließlich gemeinnützige und mildtätige Zwecke im Sinne des Abschnitts "Steuerbegünstigte Zwecke" der Abgabenordnung.</p>
          
          <p><strong>2.</strong> Die Stiftung ist selbstlos tätig. Sie verfolgt nicht in erster Linie eigenwirtschaftliche Zwecke. Der Stifter und seine Erben erhalten keine Zuwendungen aus Mitteln der Stiftung.</p>
          
          <p><strong>3.</strong> Mittel der Stiftung dürfen nur für die satzungsmäßigen Zwecke verwendet werden. Es darf keine Person durch Ausgaben, die dem Zweck der Stiftung fremd sind, oder durch unverhältnismäßig hohe Vergütung begünstigt werden.</p>

          <h5 class="fw-bold mt-4 mb-3">§ 4 Stiftungsvermögen</h5>
          <p><strong>1.</strong> Die Stiftung ist mit einem Vermögen ausgestattet, dessen Höhe sich aus dem Stiftungsgeschäft und zwischenzeitlichen Erhöhungen ergibt.</p>
          
          <p><strong>2.</strong> Das Vermögen der Stiftung kann durch Zustiftungen erhöht werden, soweit diese dazu bestimmt sind. Werden Spenden nicht ausdrücklich dem Vermögen gewidmet, so dienen sie ausschließlich und unmittelbar den in § 2 genannten Zwecken.</p>
          
          <p><strong>3.</strong> Freie Rücklagen dürfen im Rahmen der steuerlichen Vorschriften (§ 62 Abs. 1 Nr. 3 der Abgabenordnung) gebildet werden. Die in die freie Rücklage eingestellten Beträge gehören zum Stiftungsvermögen.</p>
          
          <p><strong>4.</strong> Das Stiftungsvermögen ist Ertrag bringend in solchen Werten anzulegen, die nach der mit Sorgfalt eines ordentlichen Kaufmannes vorzunehmenden Auswahl als sicher gelten.</p>
          
          <p><strong>5.</strong> Im Interesse des langfristigen Bestandes der Stiftung ist das Stiftungsvermögen in seinem Bestand dauernd und ungeschmälert zu erhalten. Vermögensumschichtungen sind zulässig, wobei der Grundsatz der Bestandserhaltung zu beachten ist.</p>
          
          <p><strong>6.</strong> Die Stiftung ist berechtigt, unselbständige Stiftungen zu verwalten.</p>

          <h5 class="fw-bold mt-4 mb-3">§ 5 Verwendung der Vermögenserträge und Zuwendungen</h5>
          <p><strong>1.</strong> Die Erträge des Stiftungsvermögens und dazu bestimmten Zuwendungen (Spenden) sind zur Erfüllung des Stiftungszwecks zu verwenden.</p>
          
          <p><strong>2.</strong> Die Stiftung kann ihre Mittel ganz oder teilweise einer Rücklage zuführen, soweit dies erforderlich ist um ihre steuerbegünstigten satzungsmäßigen Zwecke nachhaltig erfüllen zu können, und soweit für die Verwendung der Rücklage konkrete Ziel- und Zeitvorstellungen bestehen.</p>
          
          <p><strong>3.</strong> Ein Rechtsanspruch auf Gewährung von Stiftungsleistungen besteht nicht.</p>

          <h5 class="fw-bold mt-4 mb-3">§ 6 Organe der Stiftung</h5>
          <p><strong>1.</strong> Die Organe der Stiftung sind:</p>
          <ul>
            <li>Der Vorstand</li>
            <li>Das Kuratorium</li>
          </ul>
          
          <p><strong>2.</strong> Die Mitglieder der Organe sind ehrenamtlich für die Stiftung tätig. Ihnen dürfen keine Vermögensvorteile aus Mitteln der Stiftung zugewendet werden. Sie haben Anspruch auf Ersatz angemessener Auslagen.</p>

          <h5 class="fw-bold mt-4 mb-3">§ 7 Vorstand</h5>
          <p><strong>1.</strong> Der Vorstand der Stiftung besteht aus mindestens 3 höchstens 5 Mitgliedern.</p>
          
          <p><strong>2.</strong> Die Mitglieder des Vorstandes werden vom Kuratorium für einen Zeitraum von längstens 3 Jahren gewählt. Erstmals erfolgt die Berufung durch den Erblasser. Die Wiederwahl ist zulässig.</p>
          
          <p><strong>3.</strong> Das Amt des Stiftungsvorstandes endet außer im Todesfall:</p>
          <ul>
            <li>3.1 durch Abberufung</li>
            <li>3.2 durch Niederlegung, die jederzeit zulässig ist</li>
          </ul>
          
          <p><strong>4.</strong> Nach dem Ausscheiden eines Vorstandsmitglied wird der Nachfolger vom Kuratorium mit der Mehrheit seiner Mitglieder gewählt. Mitglieder des Kuratoriums dürfen nicht zugleich dem Vorstand angehören.</p>
          
          <p><strong>5.</strong> Das Kuratorium kann ein Vorstandsmitglied mit der Mehrheit von zwei Drittel seiner Mitglieder aus wichtigem Grund abberufen.</p>
          
          <p><strong>6.</strong> Der Vorstand wählt aus seiner Mitte einen Vorsitzenden, einen stellvertretenden Vorsitzenden und einen Schatzmeister.</p>

          <h5 class="fw-bold mt-4 mb-3">§ 8 Rechte und Pflichten des Vorstandes</h5>
          <p><strong>1.</strong> Der Vorstand verwaltet die Stiftung nach Maßgabe dieser Satzung in eigener Verantwortung und vertritt die Stiftung gerichtlich und außergerichtlich. Der/die Vorsitzende oder der/die stellvertretende Vorsitzende und der/die Schatzmeister/in sind Vorstand im Sinne der §§ 86, 26 des Bürgerlichen Gesetzbuches (BGB). Je zwei von ihnen vertreten die Stiftung gemeinsam.</p>
          
          <p><strong>2.</strong> Der Vorstand hat im Rahmen des Stiftungsgesetzes und dieser Satzung den Willen des Stifters so wirksam wie möglich zu erfüllen.</p>
          
          <p>Seine Aufgabe ist insbesondere:</p>
          <ul>
            <li>die gewissenhafte und sparsame Verwaltung des Stiftungsvermögens und der sonstigen Mittel</li>
            <li>die Aufstellung des Wirtschaftsplanes</li>
            <li>die Beschlussfassung über die Verwendung der Erträgnisse des Stiftungsvermögens</li>
            <li>die Aufstellung der Jahresrechnung einschließlich einer Vermögensübersicht und die Bestellung eines Rechnungsprüfers</li>
            <li>die jährliche Aufstellung eines Berichts über die Erfüllung des Stiftungszwecks</li>
          </ul>

          <h5 class="fw-bold mt-4 mb-3">§ 9 Geschäftsgang des Vorstandes</h5>
          <p>Die Beschlüsse des Vorstandes werden in der Regel in Sitzungen gefasst. Vorstandssitzungen finden statt, wenn das Interesse der Stiftung dies erfordert, mindestens jedoch einmal im Halbjahr.</p>
          
          <p><strong>1.</strong> Die Einladung zur Vorstandssitzung erfolgt textlich durch Brief oder Telekommunikationsmittel unter Angabe der Tagesordnung, wobei zwischen dem Tag der Absendung der Ladung und dem Tag der Sitzung 14 Tage liegen müssen.</p>
          
          <p><strong>2.</strong> Ein Vorstandsmitglied kann sich in der Sitzung durch ein anderes Vorstandsmitglied vertreten lassen. Kein Vorstandsmitglied kann mehr als ein anderes Vorstandsmitglied vertreten.</p>
          
          <p><strong>3.</strong> Der Vorstand ist beschlussfähig, wenn nach ordnungsgemäßer Ladung mindestens die Hälfte seiner Mitglieder, darunter der Vorsitzende oder der stellvertretende Vorsitzende, anwesend oder vertreten sind.</p>
          
          <p><strong>4.</strong> Beschlüsse werden, soweit nicht die Satzung eine andere Regelung vorsieht, mit einfacher Mehrheit der anwesenden Stimmen gefasst. Bei Stimmengleichheit entscheidet die Stimme des Vorsitzenden, ersatzweise die des stellvertretenden Vorsitzenden.</p>

          <h5 class="fw-bold mt-4 mb-3">§ 10 Kuratorium</h5>
          <p><strong>1.</strong> Das Kuratorium besteht aus mindestens 3, höchstens 7 Personen. Das erste Kuratorium wird durch den Stifter im Stiftungsgeschäft bestimmt. Die Amtszeit des Kuratoriums beträgt fünf Jahre.</p>
          
          <p><strong>2.</strong> Die Sitzungen des Kuratorium werden nach Bedarf von dem/der Vorsitzenden einberufen, wobei mindestens einmal im Jahr eine Sitzung durchgeführt werden muss. Die Ladungsfrist beträgt 14 Tage.</p>
          
          <p><strong>3.</strong> Das Kuratorium ist beschlussfähig, wenn mehr als die Hälfte der Mitglieder anwesend sind. Es fasst seine Beschlüsse mit einfacher Mehrheit der anwesenden Mitglieder.</p>

          <h5 class="fw-bold mt-4 mb-3">§ 11 Rechte und Pflichten des Kuratoriums</h5>
          <p><strong>1.</strong> Das Kuratorium berät, unterstützt und überwacht den Vorstand bei seiner Tätigkeit.</p>
          
          <p>Die Aufgaben sind insbesondere:</p>
          <ul>
            <li>die Beschlussfassung über Empfehlungen für die Verwaltung des Stiftungsvermögens und die Verwendung der Stiftungsmittel, soweit diese EUR 1.000,00 im Einzelfall überschreiten</li>
            <li>die Genehmigung des Wirtschaftsplanes</li>
            <li>die Genehmigung der Jahresabrechnung einschließlich Vermögensübersicht</li>
            <li>die Entlastung des Vorstandes</li>
            <li>die Bestellung und Abberufung von Mitgliedern des Stiftungsvorstandes</li>
          </ul>

          <h5 class="fw-bold mt-4 mb-3">§ 12 Geschäftsführung</h5>
          <p><strong>1.</strong> Der Vorstand kann eine/n oder mehrere Geschäftsführer/innen bestellen - und auch abberufen.</p>
          
          <p><strong>2.</strong> Der Vorstand kann für die Geschäftsführung eine Geschäftsordnung erlassen.</p>

          <h5 class="fw-bold mt-4 mb-3">§ 13 Satzungsänderungen</h5>
          <p><strong>1.</strong> Über Änderungen dieser Satzung beschließt das Kuratorium mit einer Mehrheit von drei Vierteln seiner Mitglieder; der Vorstand muss mit Mehrheit seiner Mitglieder zustimmen. Der Stiftungszweck nach § 2 der Satzung darf nicht geändert werden.</p>
          
          <p><strong>2.</strong> Die Beschlüsse nach Absatz 1 bedürfen der Genehmigung der Stiftungsaufsichtsbehörde. Er ist dem Finanzamt anzuzeigen.</p>

          <h5 class="fw-bold mt-4 mb-3">§ 14 Zusammenlegung und Auflösung</h5>
          <p><strong>1.</strong> Über die Auflösung der Stiftung beschließen Kuratorium und Stiftungsvorstand einstimmig in einer gemeinsamen Sitzung.</p>
          
          <p><strong>2.</strong> Wird die Erfüllung des Stiftungszwecks unmöglich oder ändern sich die Verhältnisse derart, dass die Erfüllung des Stiftungszwecks nicht mehr sinnvoll erscheint, können Vorstand und Kuratorium gemeinsam die Zusammenlegung mit einer anderen Stiftung beschließen.</p>
          
          <p><strong>3.</strong> Der Beschluss darf die Steuerbegünstigung der Stiftung nicht beeinträchtigen.</p>
          
          <p><strong>4.</strong> Der Beschluss wird erst nach Genehmigung durch die Stiftungsaufsichtsbehörde wirksam.</p>
          
          <p><strong>5.</strong> Bei Auflösung oder Aufhebung der Stiftung oder bei Wegfall der steuerbegünstigten Zwecke fällt das Vermögen der Stiftung an die Stadt Soltau oder deren Rechtsnachfolgerin, die es unmittelbar und ausschließlich für gemeinnützige oder mildtätige Zwecke zu verwenden hat.</p>

          <h5 class="fw-bold mt-4 mb-3">§ 15 Stiftungsaufsicht</h5>
          <p><strong>1.</strong> Die Stiftung untersteht der staatlichen Aufsicht nach Maßgabe der einschlägigen stiftungsrechtlichen Gesetzesbestimmungen.</p>
          
          <p><strong>2.</strong> Die Stiftungsaufsichtsbehörde ist auf Wunsch jederzeit über die Angelegenheit der Stiftung zu unterrichten. Mitteilungen über Änderungen in der Zusammensetzung der Stiftungsorgane sowie der Jahresabschluss einschließlich der Vermögensübersicht und des Bericht über die Verwendung der Stiftungsmittel sind unaufgefordert vorzulegen.</p>

          <h5 class="fw-bold mt-4 mb-3">§ 16 Schlussbestimmung</h5>
          <p>Die vorstehende Satzung tritt mit dem Tag der Genehmigung in Kraft.</p>

          <div class="mt-5 pt-4 border-top">
            <p class="text-muted small mb-0">Die Andreas Pareigis Stiftung ist eine rechtsfähige Stiftung bürgerlichen Rechts mit Sitz in Soltau.</p>
          </div>
        </div>
      </div>

      <div class="card border-0 shadow-sm p-4">
        <h5 class="fw-bold mb-3">Zusätzliche Dokumente</h5>
        <?php if (empty($documents)): ?>
          <p class="text-muted">Derzeit sind keine zusätzlichen Dokumente verfügbar.</p>
        <?php else: ?>
          <ul class="list-unstyled mb-0">
            <?php foreach ($documents as $index => $doc): ?>
              <li class="<?php echo $index < count($documents) - 1 ? 'mb-3' : 'mb-0'; ?> d-flex align-items-start">
                <svg width="20" height="20" fill="currentColor" class="me-3 text-primary flex-shrink-0 mt-1" viewBox="0 0 16 16">
                  <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                </svg>
                <div class="flex-grow-1">
                  <div class="d-flex justify-content-between align-items-start">
                    <div>
                      <strong><?php echo htmlspecialchars($doc['title']); ?></strong>
                      <p class="text-muted small mb-0"><?php echo htmlspecialchars($doc['description'] ?? ''); ?></p>
                    </div>
                    <a href="<?php echo BASE_URL; ?>download_pdf.php?doc=<?php echo urlencode($doc['filename']); ?>" 
                       class="btn btn-sm btn-outline-primary ms-3 flex-shrink-0"
                       target="_blank">
                      <svg width="14" height="14" fill="currentColor" class="me-1" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                      </svg>
                      Download
                    </a>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="py-5 mb-5" style="background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), rgba(124, 58, 237, 0.05));">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h3 class="fw-bold mb-3">Fragen zu unserer Stiftung?</h3>
        <p class="mb-0">Wir sind der Transparenz und Rechenschaftspflicht verpflichtet. Wenn Sie Fragen zu unserer Satzung, Verwaltung oder Tätigkeit haben, zögern Sie bitte nicht, uns zu kontaktieren.</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
        <a href="contact.php" class="btn btn-primary btn-lg">Kontakt aufnehmen</a>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
