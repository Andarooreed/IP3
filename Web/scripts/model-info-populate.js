$('input[name="select"]').on('change', function() {
    $(".middle-box").show();
    $(".prediction-outcome").hide();
    $("#model-title").text($(this).val());
    $("#model-modal-input-name-delete").val($(this).val());
    $("#model-modal-input-name-run").val($(this).val());
    $("#model-description").text("You selected something");

    // Decode PHP array

    // PARSE OUT THE SHIT FROM THE JSON_ENCODED THING AND SET THE 3 BOXES TO THE IMAGE ELEMENT BASED ON MODEL ID

    // var images = JSON.parse($("#model_image_array"));
    var models = JSON.parse($("#model_image_array").text());
    var target_model_id = $(this).attr('id');

    $("#user_model_img_1").attr("src", models[target_model_id][0]);
    $("#user_model_img_2").attr("src", models[target_model_id][1]);
    $("#user_model_img_3").attr("src", models[target_model_id][2]);

});


if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}