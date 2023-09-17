$(document).ready(function () {
    $('.deleteBtn').click(function (e) {
        e.preventDefault();

        const goodId = $(this).attr('id');
        console.log(goodId)

        if (confirm('Wanna delete this item')) {
            $.ajax({
                url: "/good/delete/" + goodId,
                method: "DELETE",
                success: function (_) {
                    $("#row" + goodId).remove()
                },
                error: function (error) {
                    alert(error)
                }
            })
        }
    })
});