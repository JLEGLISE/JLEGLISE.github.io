
const Columns = 
{
    BG_COL : 18,
    TXT_COL : 19,
    HEADLINE : 9
}

function Start() 
{
    let markers = GetTimelineMarkers();

    timelineData.forEach(markerData => 
    {
        marker = markers.filter((m, i) => m.headline === markerData[Columns.HEADLINE])[0];
        if (marker != undefined)
        {
            marker.htmlContent.content.style.backgroundColor = markerData[Columns.BG_COL];
            marker.htmlContent.text.firstChild.style.color = markerData[Columns.TXT_COL];
        }
        
    });
}


function GetTimelineMarkers()
{
    return timeline._timenav._markers
        .map((m,i) => new Marker(m._el, m.data.text.headline));
        //.filter((m, i) => query.indexOf(m.headline) != -1);
}

function Marker(el, h)
{
    this.htmlContent = el;
    this.headline = h;
}