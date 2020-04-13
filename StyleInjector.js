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

function PostProcessMarkers() 
{
    console.log("Post-Processing Markers");
    if (timelineData.length < 1) return;
    
    let markers = GetTimelineMarkers();
    
    timelineData.forEach(markerData => 
    {
        if (markerData.length - 1 < Columns.TXT_COL) return;
        let marker = markers.filter((m, i) => m.headline === markerData[Columns.HEADLINE])[0];
        if (marker != undefined)
        {
            if (isInt(marker.guid.substr(1)))
            {
                marker.Hide();
                return;
            }
            marker.SetBackgroundColor(markerData[Columns.BG_COL]);
            marker.SetTextColor(markerData[Columns.TXT_COL]);
        }
        
    });
}


function GetTimelineMarkers()
{
    return timeline._timenav._markers
        .map((m,i) => new Marker(m._el, m.data.text.headline, m.data.unique_id));
}

function Marker(el, h, id)
{
    this.htmlContent = el;
    this.headline = h;
    this.guid = id;

    this.SetBackgroundColor = function(color)
    {
        this.htmlContent.content.style.backgroundColor = color;
    }

    this.SetTextColor = function(color)
    {
        this.htmlContent.text.firstChild.style.color = color;
    }

    this.Hide = function()
    {
        this.htmlContent.container.style.display = 'none';
        console.log(this.guid + " was removed.");
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