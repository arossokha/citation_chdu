$(document).ready(function() {
    $('.faqQuestion').live('click', function() {
        $(this).next().slideToggle();
    });
    $('.reset-filter-articles').click(function(event) {
        $(this).parents('form').find('input').not('.button').val('');
        $('#article-grid').children('.keys').attr('title', '/article?ajax=article-grid');
        $('#article-grid').yiiGridView('update');
        return false;
    });
    $('.reset-filter-authors').click(function(event) {
        $.post(document.location.href, {}, function(data) {
            html = $(data).find('.author-data').html();
            $('.author-data').html(html);
        });
    });
});