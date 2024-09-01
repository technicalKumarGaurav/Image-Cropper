<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 11 Image Upload with Crop and Preview Tutorial</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Cropper.js CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        #cropping-modal img {
            max-width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Laravel 11 Image Upload with Crop and Preview Tutorial</h1>
        <form id="upload-form" action="{{ url('upload-image') }}" method="post" enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="image" class="form-label">Choose Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <!-- Preview Section -->
            <div class="mb-3">
                <img id="preview" src="#" alt="Preview" style="display: none; max-width: 100%; margin-top: 10px;">
            </div>

            <button type="submit" class="btn btn-primary">Upload Image</button>
        </form>
    </div>

    <!-- Modal for Image Cropping -->
    <div class="modal fade" id="cropping-modal" tabindex="-1" aria-labelledby="croppingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="croppingModalLabel">Crop Your Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="cropper-image" style="max-width: 100%;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="crop-button" class="btn btn-primary">Crop & Preview</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Cropper.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script>
        $(document).ready(function() {
            var cropper;
            var croppedCanvas;
            var croppedImage;

            $('#image').change(function(event) {
                var files = event.target.files;
                if (files && files.length > 0) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#cropper-image').attr('src', e.target.result);
                        $('#cropping-modal').modal('show');
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            $('#cropping-modal').on('shown.bs.modal', function() {
                cropper = new Cropper(document.getElementById('cropper-image'), {
                    aspectRatio: 1,
                    viewMode: 2,
                    autoCropArea: 1,
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            });

            $('#crop-button').click(function() {
                croppedCanvas = cropper.getCroppedCanvas();
                croppedImage = croppedCanvas.toDataURL('image/png');
                $('#preview').attr('src', croppedImage).show();
                $('#cropping-modal').modal('hide');
            });

            $('#upload-form').submit(function(event) {
                event.preventDefault();

                if (cropper) {
                    croppedCanvas.toBlob(function(blob) {
                        var formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('image', blob);

                        $.ajax({
                            url: '{{ url("upload-image") }}',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                alert('Image uploaded successfully!');
                            },
                            error: function(xhr, status, error) {
                                alert('Image upload failed!');
                                console.error(xhr);
                            }
                        });
                    });
                } else {
                    alert('Please select an image and crop it before uploading.');
                }
            });
        });
    </script>
</body>

</html>
