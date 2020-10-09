<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Board Portal</title>
    <script src='/lib/webviewer.min.js'></script>
    <script src="{{ asset('js/manifest.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id='viewer' style='width: 100vw; height: 100vh; margin: 0 auto;'></div>
    <script>
        var viewerElement = document.getElementById('viewer');
        WebViewer({
            path: '/lib',
            l: 'demo:h_martoliya@ongc.co.in:75b57e3d01b1a88d02ba51aa6f5dd35310830fc307b1c812f0',
        }, viewerElement)
        .then(function(viewerInstance) {
            viewerInstance.loadDocument("/viewer/{{ $portal }}/{{ $id }}/{{ $document }}", {
                filename: 'app.pdf'
            });

            viewerInstance.disableElement('menuButton');
            viewerInstance.disableElement('freeHandToolGroupButton');

            docViewer = viewerInstance.docViewer;
            annotManager = docViewer.getAnnotationManager();

            docViewer.on('documentLoaded', () => {
                axios.get("/annotate/{{ $portal }}/{{ $agenda->id }}/{{ $document }}")
                .then(function(res){
                    if( res.data != '404' ) {
                        var xfdfString  = res.data;
                        console.log(xfdfString);
                        var annotations = annotManager.importAnnotations(xfdfString);
                        // annotManager.drawAnnotationsFromList(annotations);
                    }
                })
            });

            viewerInstance.setHeaderItems(function(header) {
                header.push({
                type: 'actionButton',
                img: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>',
                onClick: function() {
                    // Save annotations when button is clicked
                    var xfdfString = annotManager.exportAnnotations();

                    axios.post("/annotate/{{ $portal }}/{{ $agenda->id }}/{{ $document }}" , {
                        body: xfdfString
                    })
                    .then(function(res){
                        console.log(res);
                        swal("Succesfully Saved!", "Annotations are saved privately", "success");
                    });
                }
                });
            });

            viewerInstance.setHeaderItems(function(header) {
                header.push({
                    type: 'actionButton',
                    img: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>',
                    onClick: function() {
                        window.location.href = "/watermark/{{ $portal }}/{{ $agenda->id }}/{{ $document }}";
                    }
                });
            }); 

        });
    </script>

</body>
</html>