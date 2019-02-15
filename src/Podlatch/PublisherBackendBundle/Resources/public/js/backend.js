
$(function() {
    $("#edit-podcastepisode-form").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var modal = new tingle.modal({

        });
        modal.setContent('<progress id="edit-podcastepisode-form-progress" max="100" value="80"></progress>');

        modal.open();
        var formData = new FormData(this);

        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        console.log(percentComplete);
                        // instanciate new modal
                        document.getElementById("edit-podcastepisode-form-progress").value = percentComplete;
                        if (percentComplete === 100) {

                        }

                    }
                }, false);

                return xhr;
            },
            type: "POST",
            url: $(this).attr('action'),
            data: formData, // serializes the form's elements.
            processData: false, // add this here
            contentType: false,
            cache: false,
            success: function(data)
            {
                document.open();
                document.write(data);
                document.close();
            }
        });

    });
});
