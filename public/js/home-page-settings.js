$(function() {
    attachListenerPreviewPicture();
    attachAddServicesListener();
    attachEditServiceModalListener();
    attachUpdateServiceBtnListener();
    tinymce.init({
        selector: 'textarea#description',
        // other configuration options
      });

      tinymce.init({
        selector: 'textarea#editDescription',
        // other configuration options
      });
});


const attachListenerPreviewPicture=()=> {
    $(document).on('change', '#home1', function (event) {
        previewFile(this,'viewHome1');
    });

    $(document).on('change', '#home2', function (event) {
        previewFile(this,'viewHome2');
    });

    $(document).on('change', '#home3', function (event) {
        previewFile(this,'viewHome3');
    });

    $(document).on('change', '#image_input', function (event) {
        previewFile(this,'image_input1');
    });

    $(document).on('change', '#home4', function (event) {
        previewFile(this,'viewHome4');
    });

    $(document).on('change', '#home5', function (event) {
        previewFile(this,'viewHome5');
    });
}

const attachAddServicesListener=()=> {
    $(document).on('click', '#addServicesBtn', function() {

        let formData = new FormData();
        let title = $('#title').val();
        let image = $('#image_input')[0].files[0];
        let description = tinymce.get("description").getContent();
        if(title == '' || description == '' || image.length <= 0) {
            alert('Please fill up all required fields');
            return;
        }

        formData.append('image', image);
        formData.append('title', title);
        formData.append('description', description);

        $.ajax({
            type: "POST",
            url: '/admin/homepage/settings/services',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
        }).done(function (response) {
            if(response.status) {
                    alert('Successfully created!');
                    location.reload();
            }else{
                    alert(response.message);
            }
        }).fail(function(response) {
            switch (response.status) {
                case 422:
                    alert(response.responseJSON.message);
                break;
            }
        });
    });
}

const attachEditServiceModalListener=()=> {
    $(document).on('click', '.editServiceModalBtn', function() {
        let serviceObj = $(this).data('service');
        $('#editServiceId').val(serviceObj.id);
        $('#viewEditImage').attr('src', `/storage/${serviceObj.image_url}`);
        $('#editTitle').val(serviceObj.title);
        tinymce.get("editDescription").setContent(serviceObj.description);
    });
}

const attachUpdateServiceBtnListener =()=> {
    $(document).on('click', '#editServiceBtn', function() {
        let formData = new FormData();
        let serviceId = $('#editServiceId').val();
        let title = $('#editTitle').val();
        let description = tinymce.get("editDescription").getContent();
        let image = $('#editImage')[0].files[0];

        if(title == '' || description == '') {
            alert('Please fill up all required fields');
            return;
        }

        if(image) {
            formData.append('image', image);
        }

        formData.append('title', title);
        formData.append('description', description);

        $.ajax({
            type: "POST",
            url: `/admin/homepage/settings/services/${serviceId}`,
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
        }).done(function (response) {
            if(response.status) {
                alert('Successfully updated!');
                location.reload();
            }else{
                    alert(response.message);
            }
        }).fail(function(response) {
            switch (response.status) {
                case 422:
                    alert(response.responseJSON.message);
                break;
            }
        });
    });
}

/**
 *  Preview Photo
 *
 * @param {file} file = file uploaded
 * @param {string} dom = id of field where the picture display/preview
 */
const previewFile = (file,dom) => {
    if (file.files && file.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#'+dom).attr('src', e.target.result);
        $('#'+dom).hide();
        $('#'+dom).fadeIn(650);
      }
      reader.readAsDataURL(file.files[0]);
    }
  }
