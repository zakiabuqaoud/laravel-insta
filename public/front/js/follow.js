
$('#follow-actions').on('click', '[data-follow-action]', function(e) {
    e.preventDefault();
    
    $.ajax({
        url: $(this).data('follow-action'),
        method: "post",
        data: {
            following_id: $(this).data('id'),
            _token: csrfToken
        }
    }).done(function(response) {
        if (response.unfollow) {
            $('#follow-actions').html(`<a href="#" title="" class="flww" data-follow-action="/unfollow" data-id="${response.id}"><i class="la la-minus"></i> Unfollow</a>`)
        } else {
            $('#follow-actions').html(`<a href="#" title="" class="flww" data-follow-action="/follow" data-id="${response.id}"><i class="la la-plus"></i> Follow</a>`)
        }
    });
})

$('[data-like-id]').click(function(e) {
    e.preventDefault();
    $.post($(this).attr('href'), {
        likeable_id: $(this).data('like-id'),
        likeable_type: $(this).data('like-type'),
        _token: csrfToken
    }, function(response) {
        alert(response.message);
    })
})