$('input[name="select"]').on('change', function() {
    $(".middle-box").show();
    $(".prediction-outcome").hide();
    $("#model-title").text($(this).val());
    $("#model-modal-input-name-delete").val($(this).val());
    $("#model-modal-input-name-run").val($(this).val());

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

$(".display-models").hover(
    function() {
        var $infobox = $(".information"); // caching $(this)
        $infobox.data('defaultText', $infobox.text());
        $infobox.text("These are the models present on your account");
    },
    function() {
        var $infobox = $(".information"); // caching $(this)
        $infobox.text($infobox.data('defaultText'));
    }
);

$("#create-model-btn").hover(
    function() {
        var $infobox = $(".information"); // caching $(this)
        $infobox.data('defaultText', $infobox.text());
        $infobox.text("Click here to train your own model!");
    },
    function() {
        var $infobox = $(".information"); // caching $(this)
        $infobox.text($infobox.data('defaultText'));
    }
);

$(".content-image-placeholder").hover(
    function() {
        var $infobox = $(".information"); // caching $(this)
        $infobox.data('defaultText', $infobox.text());
        $infobox.text("These images represent a few photos contained within your model");
    },
    function() {
        var $infobox = $(".information"); // caching $(this)
        $infobox.text($infobox.data('defaultText'));
    }
);

$("#run-model-btn").hover(
    function() {
        var $infobox = $(".information"); // caching $(this)
        $infobox.data('defaultText', $infobox.text());
        $infobox.text("Click here to run your model. This will allow you to upload an image and run it through our machine learning sytem! It will present you with a percentage output of how similar your image is to the item the model has been trained on");
    },
    function() {
        var $infobox = $(".information"); // caching $(this)
        $infobox.text($infobox.data('defaultText'));
    }
);

$("#delete-model-btn").hover(
    function() {
        var $infobox = $(".information"); // caching $(this)
        $infobox.data('defaultText', $infobox.text());
        $infobox.text("Want rid of your model? Click here to delete it. Be warned though, deleted models are not recoverable.");
    },
    function() {
        var $infobox = $(".information"); // caching $(this)
        $infobox.text($infobox.data('defaultText'));
    }
);