$(function() {
    attachListenerPreviewPicture();
    attachEditPersonalInfoBtn();
    attachEditAccountBtn();
    attachNotificationBtn();
});

const attachListenerPreviewPicture=()=> {
    $(document).on('change', '#photo', function (event) {
        previewFile(this,'viewPhoto');
    });
}

const attachEditPersonalInfoBtn=()=> {
    $(document).on('click', '#editPersonalInfoBtn', function(e) {
        e.preventDefault();
        $('.personalInfoField').attr('disabled', false);
    });
}

const attachEditAccountBtn=()=> {
    $(document).on('click', '#editAccount', function(e) {
        e.preventDefault();
        $('.accountField').attr('disabled', false);
    });
}

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

  const attachNotificationBtn=()=> {
    $(document).on('click', '#notificationBtn', function() {
        let count = $('.notif-count').data('count');

        if(count > 0) {
            $.ajax({
                type: "POST",
                url: '/patient/update-notification',
                dataType: "json",
                contentType: "application/json",
                mimeType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            }).done(function (response) {
                if(response.status) {
                    $('.notif-count').text(0);
                }
            })
        }
    });
}
