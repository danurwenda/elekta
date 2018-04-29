$(function () {
    function getArrow(diff) {
        if (diff > 0) {
            return ['fa-arrow-up', 'green'];
        } else if (diff < 0) {
            return ['fa-arrow-down', 'red'];
        } else {
            return ['fa-arrows-alt-v', 'black'];
        }
    }
    // khof total
    var content = $('#khof-total'),
            totalkhoftoday = youtubekhof[0] + twitterkhof[0] + facebookkhof[0] + mediakhof[0] + gpluskhof[0],
            totalkhofyesterday = youtubekhof[1] + twitterkhof[1] + facebookkhof[1] + mediakhof[1] + gpluskhof[1],
            totalkhofdiff = totalkhoftoday - totalkhofyesterday,
            arrow = getArrow(totalkhofdiff);
    content.find('.info-box-number').html(totalkhoftoday);
    content.find('i').addClass(arrow[0]).css('color', arrow[1]);
    content.find('.diff').html(totalkhofdiff);
    // khof youtube
    var content = $('#khof-yt'),
            totalkhoftoday = youtubekhof[0],
            totalkhofyesterday = youtubekhof[1],
            totalkhofdiff = totalkhoftoday - totalkhofyesterday,
            arrow = getArrow(totalkhofdiff);
    content.find('.info-box-number').html(totalkhoftoday);
    content.find('i').addClass(arrow[0]).css('color', arrow[1]);
    content.find('.diff').html(totalkhofdiff);
    // khof twitter
    var content = $('#khof-tw'),
            totalkhoftoday = twitterkhof[0],
            totalkhofyesterday = twitterkhof[1],
            totalkhofdiff = totalkhoftoday - totalkhofyesterday,
            arrow = getArrow(totalkhofdiff);
    content.find('.info-box-number').html(totalkhoftoday);
    content.find('i').addClass(arrow[0]).css('color', arrow[1]);
    content.find('.diff').html(totalkhofdiff);
    // khof media
    var content = $('#khof-media'),
            totalkhoftoday = mediakhof[0],
            totalkhofyesterday = mediakhof[1],
            totalkhofdiff = totalkhoftoday - totalkhofyesterday,
            arrow = getArrow(totalkhofdiff);
    content.find('.info-box-number').html(totalkhoftoday);
    content.find('i').addClass(arrow[0]).css('color', arrow[1]);
    content.find('.diff').html(totalkhofdiff);
    // khof total
    var content = $('#khof-total'),
            totalkhoftoday = youtubekhof[0] + twitterkhof[0] + facebookkhof[0] + mediakhof[0] + gpluskhof[0],
            totalkhofyesterday = youtubekhof[1] + twitterkhof[1] + facebookkhof[1] + mediakhof[1] + gpluskhof[1],
            totalkhofdiff = totalkhoftoday - totalkhofyesterday,
            arrow = getArrow(totalkhofdiff);
    content.find('.info-box-number').html(totalkhoftoday);
    content.find('i').addClass(arrow[0]).css('color', arrow[1]);
    content.find('.diff').html(totalkhofdiff);
    // khof youtube
    var content = $('#khof-yt'),
            totalkhoftoday = youtubekhof[0],
            totalkhofyesterday = youtubekhof[1],
            totalkhofdiff = totalkhoftoday - totalkhofyesterday,
            arrow = getArrow(totalkhofdiff);
    content.find('.info-box-number').html(totalkhoftoday);
    content.find('i').addClass(arrow[0]).css('color', arrow[1]);
    content.find('.diff').html(totalkhofdiff);
    // khof twitter
    var content = $('#khof-tw'),
            totalkhoftoday = twitterkhof[0],
            totalkhofyesterday = twitterkhof[1],
            totalkhofdiff = totalkhoftoday - totalkhofyesterday,
            arrow = getArrow(totalkhofdiff);
    content.find('.info-box-number').html(totalkhoftoday);
    content.find('i').addClass(arrow[0]).css('color', arrow[1]);
    content.find('.diff').html(totalkhofdiff);
    // khof media
    var content = $('#khof-media'),
            totalkhoftoday = mediakhof[0],
            totalkhofyesterday = mediakhof[1],
            totalkhofdiff = totalkhoftoday - totalkhofyesterday,
            arrow = getArrow(totalkhofdiff);
    content.find('.info-box-number').html(totalkhoftoday);
    content.find('i').addClass(arrow[0]).css('color', arrow[1]);
    content.find('.diff').html(totalkhofdiff);
    // ipul total
    var content = $('#ipul-total'),
            totalipultoday = youtubeipul[0] + twitteripul[0] + facebookipul[0] + mediaipul[0] + gplusipul[0],
            totalipulyesterday = youtubeipul[1] + twitteripul[1] + facebookipul[1] + mediaipul[1] + gplusipul[1],
            totalipuldiff = totalipultoday - totalipulyesterday,
            arrow = getArrow(totalipuldiff);
    content.find('.info-box-number').html(totalipultoday);
    content.find('i').addClass(arrow[0]).css('color', arrow[1]);
    content.find('.diff').html(totalipuldiff);
    // ipul youtube
    var content = $('#ipul-yt'),
            totalipultoday = youtubeipul[0],
            totalipulyesterday = youtubeipul[1],
            totalipuldiff = totalipultoday - totalipulyesterday,
            arrow = getArrow(totalipuldiff);
    content.find('.info-box-number').html(totalipultoday);
    content.find('i').addClass(arrow[0]).css('color', arrow[1]);
    content.find('.diff').html(totalipuldiff);
    // ipul twitter
    var content = $('#ipul-tw'),
            totalipultoday = twitteripul[0],
            totalipulyesterday = twitteripul[1],
            totalipuldiff = totalipultoday - totalipulyesterday,
            arrow = getArrow(totalipuldiff);
    content.find('.info-box-number').html(totalipultoday);
    content.find('i').addClass(arrow[0]).css('color', arrow[1]);
    content.find('.diff').html(totalipuldiff);
    // ipul media
    var content = $('#ipul-media'),
            totalipultoday = mediaipul[0],
            totalipulyesterday = mediaipul[1],
            totalipuldiff = totalipultoday - totalipulyesterday,
            arrow = getArrow(totalipuldiff);
    content.find('.info-box-number').html(totalipultoday);
    content.find('i').addClass(arrow[0]).css('color', arrow[1]);
    content.find('.diff').html(totalipuldiff);
});