<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Board Portal</title>
</head>
<body>
    <div id='viewer' style='width: 100vw; height: 100vh; margin: 0 auto;'></div>
    <script src='/lib/webviewer.min.js'></script>
    <script>
        WebViewer({
            path: '/lib',
            licenseKey: 'Insert commercial license key here after purchase',
            initialDoc: "{{ $url }}",
        }, document.getElementById('viewer'))
        .then(function(instance) {
            var docViewer = instance.docViewer;
            var annotManager = instance.annotManager;
            docViewer.on('documentLoaded', function() {
            // call methods relating to the loaded document
            });
        });
    </script>

</body>
</html>