<?php 
    include 'GoogleSheet.php';
    include 'Group.php';

    $Spreadsheet_htmlUrl = 'https://docs.google.com/spreadsheets/d/1n1FvuJDOaLvMgUWPEmNEdkdJ14hL1D1ynsq7OHNH5NQ/pubhtml';
    $Spreadsheet_csvUrl = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRKYXpHMQRv827vwMSmmdzfN1HJcrkZO6CXmliDdPqykS4Jt2ChT4BEaRWX5wKqgc2Nf2bC3hG4YVWT/pub?output=csv';

    $sheet = new GoogleSheet($Spreadsheet_csvUrl);

    $Columns = array("BG_COL" => 18, "TXT_COL" => 19, "HEADLINE" => 9, 'GROUP_NAME' => 16);
?>
<!DOCTYPE html>
<html lang="fr-FR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chronologie design français</title>
        <link title="timeline-styles" rel="stylesheet" href="https://cdn.knightlab.com/libs/timeline3/latest/css/timeline.css">
        <script src="https://cdn.knightlab.com/libs/timeline3/latest/js/timeline.js"></script>
        <link rel="stylesheet" href="_css/timelineOverride.css">
        <link rel="stylesheet" href="_css/page.css">
        <style>
            <?php

                $groupData = array_filter($sheet->getData(), function($row) use ($Columns)
                {
                    return is_numeric($row[$Columns['HEADLINE']]);
                });

                $groupData = array_map(function($row) use ($Columns)
                {
                    return new Group(
                        $row[$Columns['BG_COL']],
                        $row[$Columns['TXT_COL']],
                        (int)$row[$Columns['HEADLINE']],
                        $row[$Columns['GROUP_NAME']]
                    );
                }, $groupData);

                $groupCount = sizeof($groupData);
                foreach ($groupData as $i => $group)
                {
                    echo $group->getCSS($groupCount);
                }
                
            ?>
        </style>
    </head>
    <body>
        <h1 id="title">Chronologie du design français</h1>
        <div id='timeline-embed' style="width: 100%; height: 70vh;"></div>
        <div id="zoomContainer"></div>
        <script type="text/javascript">


            const timelineOptions = 
            {
                hash_bookmark: true,
                language: "fr",
                scale_factor: 7,
                start_at_slide: 11
            }

            // The TL.Timeline constructor takes at least two arguments:
            // the id of the Timeline container (no '#'), and
            // the URL to your JSON data file or Google spreadsheet.
            // the id must refer to an element "above" this code,
            // and the element must have CSS styling to give it width and height
            // optionally, a third argument with configuration options can be passed.
            // See below for more about options.
            const timeline = new TL.Timeline(
                'timeline-embed',
                '<?php echo $Spreadsheet_htmlUrl; ?>',
                timelineOptions);

            const timelineData = <?php echo json_encode($sheet->getData()); ?>;
            
            document.addEventListener('DOMContentLoaded', function()
            {
                SetMarkerColors();
                // SetGroupColors();
                OverrideMenuBar();
                
                //HideGroupStartMarkers();

            }, false);

            function OverrideMenuBar() 
            {
                let menuBar = document.getElementsByClassName("tl-menubar")[0];
                if (menuBar === undefined)
                {
                    console.error("menuBar is undefined");
                    return
                }

                let tlControls = menuBar.cloneNode(true);
                document.getElementById("zoomContainer").appendChild(tlControls);
                tlControls.style = "";
                tlControls.classList.remove("tl-menubar");
                tlControls.classList.add("timeline-controls")

                tlControls.childNodes[0].addEventListener('click', e => timeline._menubar._onButtonZoomIn(e))
                tlControls.childNodes[1].addEventListener('click', e => timeline._menubar._onButtonZoomOut(e))
                tlControls.childNodes[2].addEventListener('click', e => timeline.goTo(timelineOptions.start_at_slide))

            }

            function HideGroupStartMarkers()
            {
                setTimeout(() =>
                {
                    let groupCount = timeline._timenav._groups.length;

                    for (let i = 1; i < groupCount; i++) 
                    {
                        // TODO: Find and hide marker
                    }
                }, 10000);
            }

        </script>
        <script src="StyleInjector.js"></script>
        <section id="content">
            <h1 id="legendTitle">À quoi correspondent ces catégories ?</h1>
            <div id="elementContainer">
                <div class="legendElement">
                    <h2>Évènements historiques</h2>
                    <p>Cette première catégorie a pour objectif de placer un contexte sur lequel le lecteur va pouvoir se reposer pour comprendre la temporalité des éléments. Nous avons choisi d'y placer des événements majeurs de l'histoire française qui ont, d'une façon ou d'une autre, influencés le monde du design.</p>
                    <span class="bloc"></span>
                </div>
                <div class="legendElement">
                    <h2>Acteurs influents</h2>
                    <p>Cette catégorie regroupe des évènements majeurs du design français. Elle présente les mouvements artistiques, des groupes qui firent figures d'autorité.</p>
                    <span class="bloc"></span>
                </div>
                <div class="legendElement">
                    <h2>Design novateur</h2>
                    <p>Tout élément novateur à sut marquer son temps. Par une rupture idélogique, esthétique, technique, technologique ou bien un objet qui a révolutionné les usages.</p>
                    <span class="bloc"></span>
                </div>
                <div class="legendElement">
                    <h2>Design intégré</h2>
                    <p>Cette catégorie met en évidence l’émergence du design intégré au sein des entreprises françaises. Le design intégré révèle une forme d’acceptation de l’importance du design de la part des grandes marques permet de le faire rentrer dans al culture d'entreprise et dans l'esprit du public.</p>
                    <span class="bloc"></span>
                </div>
                <div class="legendElement">
                    <h2>Design institutionnel</h2>
                    <p>Ce groupe met en avant des projets qui ont été commandités par l’état, des institutions, des villes ou des collectivitées. L’idée est de comprendre à quel moment le design et les designers ont accéquérit assez de notoriété pour être les porteur de projets à forte responsabilité symbolique.  Il est intéressant de comparer cette catégorie avec celle du design intégré et de la communication du design afin de comprendre l’évolution de la place du design en France.</p>
                    <span class="bloc"></span>
                </div>
                <div class="legendElement">
                    <h2>Communication du design</h2>
                    <p>Cette catégorie vise à révéler la présence de médias du design (magazines, journaux, émissions, podcasts,etc ) qui ont permis une certaine sensibilisation au design auprès des acteurs du métier ainsi que du grand public. Cela permet entre autre de comprendre l’émergence et l’évolution du design en France.</p>
                    <span class="bloc"></span>
                </div>
                <div class="legendElement">
                    <h2>Grands distributeurs du design</h2>
                    <p>À travers cette catégorie, nous avons souhaité mettre en avant les moments où le design est employé au service de la grande distribution. Nous avons décidé d’y afficher l’apparition en France de grands distributeurs d'objets sur el territoire. Nous y incluons des distributeurs de mobilier tel que Ikea, bien que l'entreprise ne soit pas Française elle a impacté notre environnement esthétique, ainsi que Prisunic qui acollaboré avec de nombreux designers, en allant jusqu’à des distributeurs d'électroménagers comme Darty par exemple qui diffuse notamment les objets ménagers et électroniques.</p>
                    <span class="bloc"></span>
                </div>
                <div class="legendElement">
                    <h2>Production à grande échelle</h2>
                    <p>Cette catégorie vise à présenter des produits qui ont été produits à un très grand nombre d’exemplaires. L’idée est d'observer les moment où la grande distribution utilise le design pour se différencier. Nous nous sommes intéressé particulièrement à la présence du design dans des magasins de grande distribution comme Casino et Carrefour.</p>
                    <span class="bloc"></span>
                </div>
                <div class="legendElement">
                    <h2>Design d'édition</h2>
                    <p>Cette catégorie vise à présenter des produits français issu du milieu de l’édition, produits à moyenne ou petite échelle (quelques centaines d’exemplaires). Nous y avons intégré principalement l’apparition de maisons d’édition françaises.</p>
                    <span class="bloc"></span>
                </div>
                <div class="legendElement">
                    <h2>Design d'exception</h2>
                    <p>Cette dernière catégorie met en évidence des produits du design français qui n’ont été produit qu’à très peu d’exemplaires, voir des pièces uniques. Nous voulions confronter cet aspect du design avec d’autres en opposition comme le design au service de la production à grande échelle.</p>
                    <span class="bloc"></span>
                </div>
            </div>
        </section>
    </body>
</html>