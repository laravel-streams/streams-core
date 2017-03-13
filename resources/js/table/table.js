$(function () {

    // Focus on the first filter input.
    $('#filters').find('input:visible').first().focus();
      
    var
        topBar = document.getElementById('topbar'),
        topBarHeight = topBar.offsetHeight,
        table = document.querySelector('table.table'),
        tableWidth = table.offsetWidth,
        tableTop = table.offsetParent.offsetTop,
        thead = table.children.item(0),
        tbody = table.children.item(1),
        getTableColsSizes = function () {
            var output = [];
            tbody.children.item(0).childNodes.forEach(function (el) {
                if (el.tagName === 'TD') {
                    output.push(el.offsetWidth);
                }
            });
            return output;
        },
        tableColsSizes = getTableColsSizes(),
        scrollTop;
    
    thead.style.backgroundColor = '#fff';
    thead.style.width = tableWidth + 'px';

    window.addEventListener('scroll', function (event) {
        var idx = 0;
        scrollTop = event.target.body.scrollTop;

        thead.children.item(0).childNodes.forEach(function (el) {
            if (el.tagName === 'TH') {
                el.width = tableColsSizes[idx] + 'px';
                idx++;
            }
        });

        if (scrollTop > tableTop - topBarHeight) {
            thead.style.position = 'fixed';
            thead.style.top = topBarHeight + 'px';
            table.style.marginTop = thead.offsetHeight + 'px';
        } else {
            thead.style.position = 'relative';
            thead.style.top = '0px';
            table.style.marginTop = '0';
        }
    });
});
