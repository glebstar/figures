let currentGroup = null;
let cookieCurrentGroup = $.cookie('currentGroup');
if (cookieCurrentGroup && results.length) {
    currentGroup = cookieCurrentGroup;
}

let currentFigure = null;
let currentSize = null;
let currentColor = null;

$(document).ready(function(){
    initAcc();

    $('#newGroupButton').click(function (){
        $.post('/?action=newGroup', {name: $('#newGroupInput').val()}, function (data){
            if (data.status === 'error') {
                alert(data.message);
                return false;
            }

            currentGroup = data.newId;
            groupsCoord.push({
                id: data.newId,
                x: 50,
                y: 50
            });
            $('#accGroups').append('<div class="accordion-item"><h2 class="accordion-header" data-group-n="' + currentGroup + '"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' + currentGroup + '" aria-expanded="false" aria-controls="collapse' + currentGroup + '">' + $('#newGroupInput').val() + '</button></h2><div id="collapse' + currentGroup + '" class="accordion-collapse collapse" data-bs-parent="#accGroups"><div class="accordion-body"><canvas id="canvas-' + currentGroup + '" width="800" height="400"></canvas></div></div></div>');
            $('#newGroupInput').val('');
            initAcc();
        }, 'json');
    });

    $('#newFigureButton').click(function (){
        $.post('/?action=newFigure', {group: currentGroup, figure: currentFigure, size: currentSize, color: currentColor}, function (data){
            if (data.status === 'error') {
                alert(data.message);
                return false;
            }

            drawFigure(currentGroup, currentFigure, currentSize, currentColor);
        }, 'json');
    });

    $('#figures .btn').click(function (){
        $('#figures .btn').removeClass('active');
        $(this).addClass('active');
        currentFigure = $(this).data('figure-id');
    });

    currentSize = $("#sizeInput").val();
    currentColor = $("#colorInput").val();

    $("#sizeInput").change(function(){
        currentSize = $(this).val();
    });

    $("#colorInput").change(function(){
        currentColor = $(this).val();
    });

    results.forEach(function (obj){
        drawFigure(obj.group, obj.figure, obj.size, obj.color);
    });
});

function initAcc() {
    $('.accordion-header').click(function (){
        currentGroup = $(this).data('group-n');
        $.cookie('currentGroup', currentGroup, { expires: 30 });
    });

    if (currentGroup) {
        $('.accordion-collapse').removeClass('show');
        $('#collapse' + currentGroup).addClass('show');
        $.cookie('currentGroup', currentGroup, { expires: 30 });
    }
}

function drawFigure(currGroup, currFig, currSize, currColor) {
    let groupCoord = null;

    for (i = 0; i < groupsCoord.length; i++) {
        if (currGroup == groupsCoord[i].id) {
            groupCoord = groupsCoord[i];
        }
    }

    if (!groupCoord) {
        return false;
    }

    switch (currFig) {
        case 1:
            $('#canvas-' + currGroup).drawPolygon({
                fillStyle: currColor,
                x: groupCoord.x, y: groupCoord.y,
                radius: currSize,
                sides: 3
            });
            break;
        case 2:
            $('#canvas-' + currGroup).drawArc({
                fillStyle: currColor,
                x: groupCoord.x, y: groupCoord.y,
                radius: currSize
            });
            break;
        case 3:
            $('#canvas-' + currGroup).drawRect({
                fillStyle: currColor,
                x: groupCoord.x, y: groupCoord.y,
                width: currSize * 2,
                height: currSize * 2
            });
            break;
        default:
            break;
    }

    groupCoord.x = parseFloat(groupCoord.x) + (parseFloat(currentSize)*2) + 50;
    if (groupCoord.x >= 800 - (currentSize*2)) {
        groupCoord.x = 50;
        groupCoord.y = parseFloat(groupCoord.y) + (parseFloat(currentSize)*2) + 50;
    }
}
