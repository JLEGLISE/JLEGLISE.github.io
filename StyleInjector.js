/*

    CONSTANTS

*/

const Columns = 
{
    BG_COL : 18,
    TXT_COL : 19,
    HEADLINE : 9
}

/*

    MARKER COLORING

*/

function SetMarkerColors() 
{
    console.log("Coloring Markers");
    if (timelineData.length < 1) return;
    if (timelineData[0].length - 1 < Columns.TXT_COL) return;

    let markers = GetTimelineMarkers();

    timelineData.forEach(markerData => 
    {
        marker = markers.filter((m, i) => m.headline === markerData[Columns.HEADLINE])[0];
        if (marker != undefined)
        {
            marker.SetBackgroundColor(markerData[Columns.BG_COL]);
            marker.SetTextColor(markerData[Columns.TXT_COL]);
        }
        
    });
}


function GetTimelineMarkers()
{
    return timeline._timenav._markers
        .map((m,i) => new Marker(m._el, m.data.text.headline));
}

function Marker(el, h)
{
    this.htmlContent = el;
    this.headline = h;

    this.SetBackgroundColor = function(color)
    {
        this.htmlContent.content.style.backgroundColor = color;
    }

    this.SetTextColor = function(color)
    {
        this.htmlContent.text.firstChild.style.color = color;
    }
}

/*

    GROUP COLORING

*/

function SetGroupColors()
{
    console.log("Coloring Groups");
    let groups = GetTimeLineGroups();
    let groupData = timelineData.filter((datum, i) => isInt(datum[Columns.HEADLINE]));

    groupData.forEach((datum) =>
    {
        let matchingGroup = groups[datum[Columns.HEADLINE] - 1];
        matchingGroup.SetBackgroundColor(datum[Columns.BG_COL]);
        matchingGroup.SetTextColor(datum[Columns.TXT_COL]);
    });
}

function GetTimeLineGroups()
{
    return timeline._timenav._groups
        .map( (g, i) => new Group(g._el.message, g._el.container));
}

function Group(l, b)
{
    this.labelHtml = l;
    this.backgroundHtml = b;

    this.SetBackgroundColor = function(color)
    {
        this.backgroundHtml.style.backgroundColor = color;
    }

    this.SetTextColor = function(color)
    {
        this.labelHtml.style.color = color;
    }
}

/*

    HELPER FUNCTIONS

*/

// Returns true when the given value is an integer.
function isInt(value) 
{
    var x;
    if (isNaN(value)) 
    {
      return false;
    }
    x = parseFloat(value);
    return (x | 0) === x;
}