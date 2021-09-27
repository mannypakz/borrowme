function showReview(event) {
    let formData = new FormData();
    const orderId = event.target.getAttribute('data');
    const token = document.getElementById('show_review').getElementsByTagName('input')._token.value;
    const request = new XMLHttpRequest();
    formData.append('_token', token);
    formData.append('order_id', orderId);
    request.open('POST', '/item/ajax_get_reviews');
    request.send(formData);

    request.onload = () => {

        if (request.status === 200) {
            const result = JSON.parse(request.responseText);

            for (let i = 0; i < result.length; i++) {
                let stars = '';
                const txt = result[i].feedback.substring(0, 15);

                for (let j = 0; j < result[i].stars; j++) {
                    stars += '<i class="fas fa-star"></i>';
                }

                $(".review-body").append("<div>"+ "<span>"+txt+"</span>"+ "<span>"+stars+"</span>"+ "</div>");
            }

            $('#show_review').modal('show');

        } else {
            alert('Error showing review comments');
        }
    }

}

function provideReview(event) {
    const field = document.getElementsByName('order_id')[0];
    const orderId = event.target.getAttribute('data');
    field.value = orderId;
    $('#review_modal').modal('show');
}

$("#rating").rating({
    "click": (e) => {
        $("input[name=stars]").val(e.stars);
    }
});


$("#sort, #filter").on("change", () => {
    redirect();
});

$(window).on('load', () => {
    // executes when complete page is fully loaded, including all frames, objects and images
    $("select#filter option:selected").prepend('Filter: ');
    $("select#sort option:selected").prepend('Sort by: ');
});

$("select#filter").click(() => {
    const update_filter = $("select#filter option:selected").text().replace('Filter: ', ' ');
    $("select#filter option:selected").text(update_filter);
});

$("select#sort").click(() => {
    const update_sort = $("select#sort option:selected").text().replace('Sort by: ', ' ');
    $("select#sort option:selected").text(update_sort);
});

function redirect() {
    const f = $("#filter").val();
    const s = $("#sort").val();
    window.location.href = 'https://my.borrowme.com/orders/history?filter=' + f + '&sort=' + s;
}
