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
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Laravel 11 Image Upload with Crop and Preview Tutorial</h1>
        <form id="upload-form" enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="image" class="form-label">Choose Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>

            <!-- Preview -->
            <div class="mb-3">
                <img id="preview" src="#" alt="Preview" style="display: none; max-width: 100%; margin-top: 10px;">
            </div>

            <button type="submit" class="btn btn-primary">Upload Image</button>
        </form>
    </div>

    <!-- Cropper Modal -->
    <div class="modal fade" id="cropping-modal" tabindex="-1" aria-labelledby="cropping-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropping-modal-label">Crop Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="cropper-image" style="max-width: 100%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="crop-button" class="btn btn-primary">Crop</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Cropper.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <!-- JavaScript Logic -->
    <script>
        $(document).ready(function() {
            var cropper;
            var croppedCanvas;

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
                    autoCropArea: 1
                });
            }).on('hidden.bs.modal', function() {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            });

            $('#crop-button').click(function() {
                if (cropper) {
                    croppedCanvas = cropper.getCroppedCanvas();
                    if (croppedCanvas) {
                        var croppedImage = croppedCanvas.toDataURL('image/png');
                        $('#preview').attr('src', croppedImage).show();
                        $('#cropping-modal').modal('hide');
                    } else {
                        alert("Failed to create a cropped canvas.");
                    }
                } else {
                    alert("Cropper is not initialized.");
                }
            });

            $('#upload-form').submit(function(event) {
                event.preventDefault();

                if (croppedCanvas) {
                    croppedCanvas.toBlob(function(blob) {
                        var formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('image', blob, 'cropped.png');

                        $.ajax({
                            url: '{{ route("upload.image") }}',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                alert(response.success || 'Image uploaded successfully!');
                            },
                            error: function(xhr, status, error) {
                                alert('Image upload failed!');
                                console.error(xhr);
                            }
                        });
                    }, 'image/png');
                } else {
                    alert('Please select an image and crop it before uploading.');
                    console.error('No cropped image available for upload.');
                }
            });
        });
    </script>
</body>
</html>
