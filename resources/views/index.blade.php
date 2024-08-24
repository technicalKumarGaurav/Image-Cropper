<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Compressor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">PDF Compressor</h1>
        <form>
            <div class="form-group">
                <label for="file">Select a PDF file:</label>
                <input type="file" id="file" name="file" accept=".pdf">
            </div>
            <div class="form-group">
                <label for="compression-level">Compression level:</label>
                <select id="compression-level" name="compression-level">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Compress PDF</button>
        </form>
        <div class="alert alert-success" id="success-alert" style="display: none;">
            <strong>Success!</strong> Your PDF has been compressed successfully.
            <a href="#" id="download-link">Download compressed PDF</a>
        </div>
        <div class="alert alert-danger" id="error-alert" style="display: none;">
            <strong>Error!</strong> An error occurred while compressing your PDF.
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('form').submit(function(event) {
                event.preventDefault();
                var file = $('#file')[0].files[0];
                var compressionLevel = $('#compression-level').val();
                // Call your PDF compression API or function here
                // For demonstration purposes, we'll just simulate a successful compression
                setTimeout(function() {
                    $('#success-alert').show();
                    $('#download-link').attr('href', 'path/to/compressed/pdf');
                }, 2000);
            });
        });
    </script>
</body>
</html>