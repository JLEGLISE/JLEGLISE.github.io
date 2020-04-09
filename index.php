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
        <h1>Chronologie du design français</h1>
        <div id='timeline-embed' style="width: 100%; height: 600px"></div>
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
                document.getElementsByTagName("body")[0].appendChild(tlControls);
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

          </section>
    </body>
</html>