<!DOCTYPE html>
<html lang="fr-FR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chronologie design français</title>
        <link title="timeline-styles" rel="stylesheet" href="https://cdn.knightlab.com/libs/timeline3/latest/css/timeline.css">
        <script src="https://cdn.knightlab.com/libs/timeline3/latest/js/timeline.js"></script>
        <?php include 'GoogleSheet.php'; ?>
        <link rel="stylesheet" href="_css/timelineOverride.css">
    </head>
    <body>
        <div id='timeline-embed' style="width: 100%; height: 600px"></div>
        <?php 
            $Spreadsheet_htmlUrl = 'https://docs.google.com/spreadsheets/d/1n1FvuJDOaLvMgUWPEmNEdkdJ14hL1D1ynsq7OHNH5NQ/pubhtml';
            $Spreadsheet_csvUrl = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRKYXpHMQRv827vwMSmmdzfN1HJcrkZO6CXmliDdPqykS4Jt2ChT4BEaRWX5wKqgc2Nf2bC3hG4YVWT/pub?output=csv';
            $Spreadsheet_htmlUrl_debug = 'https://docs.google.com/spreadsheets/d/1j2keiOzMpsiFfdr4Dwb0tF12MBmbdQpPDHjXJ-B8ZB4/pubhtml';
            $Spreadsheet_csvUrl_debug = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ4GXtZMKH4HXLfiuUJWkYHbbWgI3493nul9BK1i0ec_7HLLiEaFXGl0_zN7KScaplWIeEMdhDO83X5/pub?output=csv';

            $sheet = new GoogleSheet($Spreadsheet_csvUrl);
        ?>
        <script type="text/javascript">


            const timelineOptions = 
            {
                hash_bookmark: true,
                language: "fr"
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
                Start();
            }, false);

          </script>
          <script src="StyleInjector.js"></script>
    </body>
</html>