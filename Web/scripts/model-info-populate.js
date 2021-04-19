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
        $infobox.text("Click here to train your own model! You will need to provide a model name that should represent what the model will be trained to recognise. Then either upload your own photo set, or you can select one of 5 options that make the system automatically download an image set of the amount you have selected. This uses the name you have given the model to search Google for the images. Training a model takes time so go make yourself a cup of coffee (or 10) while you wait. Once the model has completed training, it will appear in the list to the left.");
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
        $infobox.text("Using a large range of images helps train the model to recognise that object in the future" + 
                        "(if you’d only seen one cup in your entire life you’d have trouble identifying them too!)" +
                        " If you don’t think you have enough images of your own, don’t worry, our image-downloading" +
                        " bot can find extra images for you online! (you can even choose how many photos you want it to add.)"
        );
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
        $infobox.text("Click here to test your model! Choose an image to test with and the model will compare " + 
                        "it to the image set you trained it with. Then it will return an analysis of how similar" + 
                        " your test image is to the object it’s trained to recognise."
        );
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